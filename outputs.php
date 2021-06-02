<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * wgDiaries module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgdiaries
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         wedega - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgdiaries;
use XoopsModules\Wgdiaries\{
    Constants,
    Filterhandler
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_outputs.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

if (!$permissionsHandler->getPermOutputsView()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

$year     = (int) date('Y');
$month    = (int) date('n');
$lastday  = (int) date('t', \strtotime($month . '/1/' . $year));
$dayStart = mktime(0, 0, 0, $month, 1, $year);
$dayEnd   = mktime(23, 59, 59, $month, $lastday, $year);

$op            = Request::getCmd('op', 'list');
$start         = Request::getInt('start', 0);
$limit         = Request::getInt('limit', $helper->getConfig('userpager'));
$filterByOwner = Request::getInt('filterByOwner', Constants::FILTERBY_OWN);
$filterGroup   = Request::getInt('filterGroup', 0);
$filterCat     = Request::getInt('filterCat', 0);
$filterSort    = Request::getString('filterSort', 'item_datefrom-DESC');
if ('filter' == $op) {
    $dateObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('filterFrom'));
    $dateString = $dateObj->format('Y-m-d 00:00:00');
    $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
    $filterFrom = $dateObj->getTimestamp();
    unset($dateObj);
    $dateObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('filterTo'));
    $dateString = $dateObj->format('Y-m-d 23:59:59');
    $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $dateString);
    $filterTo = $dateObj->getTimestamp();
    unset($dateObj);
} else {
    $filterFrom = $dayStart;
    $filterTo   = $dayEnd;
}

if ('filter' === $op) {
    if (Constants::FILTERBY_OWN === $filterByOwner) {
        $op = 'filterOwn';
    } else if (Constants::FILTERBY_GROUP === $filterByOwner) {
        $op = 'filterGroup';
    } else {
        $op = 'list';
    }
}
list($sortBy, $orderBy) = \explode('-', $filterSort);
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_OUTPUTS];
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_itemsurl', \WGDIARIES_UPLOAD_ITEMS_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_categoriesurl', \WGDIARIES_UPLOAD_CATEGORIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_icons_url_16', \WGDIARIES_ICONS_URL . '/16/');
//add stylesheets for print output
$GLOBALS['xoopsTpl']->assign('wgdiaries_css_print_1', \WGDIARIES_CSS_URL . '/style.css');


$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$filterHandler = new Filterhandler();
$filterHandler->filterFrom = $filterFrom;
$filterHandler->filterTo = $filterTo;
$filterHandler->start = $start;
$filterHandler->limit = $limit;
$filterHandler->filterByOwner = $filterByOwner;
$filterHandler->filterGroup = $filterGroup;
$filterHandler->filterCat = $filterCat;
$filterHandler->filterSort = $filterSort;

$formFilter = $filterHandler->getFormFilterItems();
$GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());

$filtered = false;
$items = [];
switch ($op) {
    case 'list':
    default:
        break;
        echo 'list';
    case 'filterOwn':
        $GLOBALS['xoopsTpl']->assign('resultTitle', \_MA_WGDIARIES_FILTER_RESULT);
        if ($uid > 0) {
            $itemsTotal = $itemsHandler->getItemsCount($uid, $start, $limit, $filterFrom, $filterTo, false, false, 0, $filterCat);
            $items = $itemsHandler->getItems($uid, $start, $limit, $filterFrom, $filterTo, false, false, 0, $filterCat, $sortBy, $orderBy);
        }
        $filtered = true;
        break;
    case 'filterGroup':
        $GLOBALS['xoopsTpl']->assign('resultTitle', \_MA_WGDIARIES_FILTER_RESULT);
        if ($permissionsHandler->getPermItemsGroupView()) {
            if (Constants::FILTER_TYPEALL == $filterGroup) {
                $itemsTotal = $itemsHandler->getItemsCount(0, $start, $limit, $filterFrom, $filterTo, true, false, 0, $filterCat);
                $items = $itemsHandler->getItems(0, $start, $limit, $filterFrom, $filterTo, true, false, 0, $filterCat, $sortBy, $orderBy);
            } else {
                $itemsTotal = $itemsHandler->getItemsCount(0, $start, $limit, $filterFrom, $filterTo, false, false, $filterGroup, $filterCat);
                $items = $itemsHandler->getItems(0, $start, $limit, $filterFrom, $filterTo, false, false, $filterGroup, $filterCat, $sortBy, $orderBy);
            }
        }
        $filtered = true;
        break;
}
if ($filtered) {
    $itemsCount = \count($items);
    if ($itemsCount > 0) {
        $GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
        $GLOBALS['xoopsTpl']->assign('items', $items);
        if ($itemsTotal > $itemsCount) {
            $GLOBALS['xoopsTpl']->assign('filterResult', \_MA_WGDIARIES_FILTER_LIMIT_EXCEED);
        }
    } else {
        $GLOBALS['xoopsTpl']->assign('filterResult', \_MA_WGDIARIES_FILTER_NODATA);
    }
}

$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
$GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wgdiariesMetaDescription(\_MA_WGDIARIES_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/index.php');

require __DIR__ . '/footer.php';
