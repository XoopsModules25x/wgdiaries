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
use XoopsModules\Wgdiaries\ {
    Constants,
    SimpleCalendar,
    Filterhandler
};

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_calendar.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

if (!$permissionsHandler->getPermCalPageView()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

//default params
$year     = (int) date('Y');
$month    = (int) date('n');
$lastday  = (int) date('t', \strtotime($month . '/1/' . $year));
$dayStart = mktime(0, 0, 0, $month, 1, $year);
$dayEnd   = mktime(23, 59, 59, $month, $lastday, $year);

//request
$op            = Request::getCmd('op', 'list');
$filterFrom    = Request::getInt('filterFrom', 0);
$filterTo      = Request::getInt('filterTo', 0);
$filterByOwner = Request::getInt('filterByOwner', Constants::FILTERBY_OWN);
$filterGroup   = Request::getInt('filterGroup', 0);
$filterCat     = Request::getInt('filterCat', 0);
$filterSort    = 'item_datefrom-ASC';
if (0 == $filterFrom) {
    $filterFrom = $dayStart;
    $filterTo   = $dayEnd;
}

$filterFromPrevM = mktime(0, 0, 0, (int)date('n', $filterFrom - 1), 1, (int)date('Y', $filterFrom - 1));
$filterToPrevM = $filterFrom - 1;
$filterFromNextM = $filterTo + 1;
$filterToNextM =  mktime(23, 59, 59, (int)date('n', $filterFromNextM), (int)date('t', $filterFromNextM), (int)date('Y', $filterFromNextM));

$filterFromPrevY = mktime(0, 0, 0, (int)date('n', $filterFrom), 1, (int)date('Y', $filterFrom) - 1);
$filterToPrevY = mktime(23, 59, 59, (int)date('n', $filterTo), (int)date('t', $filterTo), (int)date('Y', $filterTo) - 1);
$filterFromNextY = mktime(0, 0, 0, (int)date('n', $filterFrom), 1, (int)date('Y', $filterFrom) + 1);
$filterToNextY =  mktime(23, 59, 59, (int)date('n', $filterTo), (int)date('t', $filterTo), (int)date('Y', $filterTo) + 1);

/*calendar nav bar*/
$GLOBALS['xoopsTpl']->assign('monthNav', date('F', $filterFrom));
$GLOBALS['xoopsTpl']->assign('yearNav', date('Y', $filterFrom));
$GLOBALS['xoopsTpl']->assign('filterFromPrevM', $filterFromPrevM);
$GLOBALS['xoopsTpl']->assign('filterToPrevM', $filterToPrevM);
$GLOBALS['xoopsTpl']->assign('filterFromNextM', $filterFromNextM);
$GLOBALS['xoopsTpl']->assign('filterToNextM', $filterToNextM);
$GLOBALS['xoopsTpl']->assign('filterFromPrevY', $filterFromPrevY);
$GLOBALS['xoopsTpl']->assign('filterToPrevY', $filterToPrevY);
$GLOBALS['xoopsTpl']->assign('filterFromNextY', $filterFromNextY);
$GLOBALS['xoopsTpl']->assign('filterToNextY', $filterToNextY);
$otherParams = "op=filter&amp;filterByOwner=$filterByOwner&amp;filterGroup=$filterGroup";
$GLOBALS['xoopsTpl']->assign('otherParams', $otherParams);

if (Constants::FILTERBY_OWN === $filterByOwner) {
    $op = 'filterOwn';
} else if (Constants::FILTERBY_GROUP === $filterByOwner) {
    $op = 'filterGroup';
} else {
    $op = 'list';
}

[$sortBy, $orderBy] = \explode('-', $filterSort);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_CALENDAR_ITEMS];
// Paths
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_icons_url_16', \WGDIARIES_ICONS_URL . '/16/');

$GLOBALS['xoTheme']->addStylesheet(\WGDIARIES_URL . '/class/SimpleCalendar/css/SimpleCalendar.css', null);
$calendar = new SimpleCalendar\SimpleCalendar();
$calendar->setStartOfWeek($helper->getConfig('calendar_firstday'));
$calendar->setWeekDayNames([
    \_MA_WGDIARIES_CAL_MIN_SUNDAY,
    \_MA_WGDIARIES_CAL_MIN_MONDAY,
    \_MA_WGDIARIES_CAL_MIN_TUESDAY,
    \_MA_WGDIARIES_CAL_MIN_WEDNESDAY,
    \_MA_WGDIARIES_CAL_MIN_THURSDAY,
    \_MA_WGDIARIES_CAL_MIN_FRIDAY,
    \_MA_WGDIARIES_CAL_MIN_SATURDAY ]);

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$filterHandler = new Filterhandler();
$filterHandler->filterByOwner = $filterByOwner;
$filterHandler->filterGroup = $filterGroup;
$filterHandler->filterCat = $filterCat;
$filterHandler->filterSort = $filterSort;
$filterHandler->showLimit = false;
$filterHandler->showSort = false;
$filterHandler->showPeriod = false;

$formFilter = $filterHandler->getFormFilterItems();
$GLOBALS['xoopsTpl']->assign('formFilter', $formFilter->render());

$filtered = false;
$items = [];
switch ($op) {
    case 'list':
    default:
        break;
    case 'filterOwn':
        $GLOBALS['xoopsTpl']->assign('resultTitle', \_MA_WGDIARIES_FILTER_RESULT);
        if ($uid > 0) {
            $items = $itemsHandler->getItems($uid, 0, 0, $filterFrom, $filterTo, false, false, 0, $filterCat, $sortBy, $orderBy);
        }
        $filtered = true;
        break;
    case 'filterGroup':
        $GLOBALS['xoopsTpl']->assign('resultTitle', \_MA_WGDIARIES_FILTER_RESULT);
        if ($permissionsHandler->getPermItemsGroupView()) {
            if (Constants::FILTER_TYPEALL == $filterGroup) {
                $items = $itemsHandler->getItems(0, 0, 0, $filterFrom, $filterTo, true, false, 0, $filterCat, $sortBy, $orderBy);
            } else {
                $items = $itemsHandler->getItems(0, 0, 0, $filterFrom, $filterTo, false, false, $filterGroup, $filterCat, $sortBy, $orderBy);
            }
        }
        $filtered = true;
        break;
}

$itemsCount = \count($items);
if ($itemsCount > 0) {
    $calendar->setDate($filterFrom);
    $GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
    foreach($items as $item) {
        $itemLink = '<a href="items.php?op=show&amp;item_id=' . $item['id'] .'">';
        if ($item['catlogo']) {
            $itemLink .= '<img class="wgd-cal-catlogo" src="' . \WGDIARIES_UPLOAD_CATEGORIES_URL . '/' . $item['catlogo'] .'" alt="' . \_MA_WGDIARIES_CATLOGO .'" title="' . \_MA_WGDIARIES_CATLOGO .'">';
        }
        $itemLink .= '<span class="wgd-cal-eventtext">';
        if (Constants::FILTERBY_GROUP === $filterByOwner) {
            $itemLink .= $item['item_name'] . ' (' .$item['submitter'] . ')';
        } else {
            $itemLink .= $item['item_name'];
        }
        $itemLink .= '</span><i class="fa fa-edit wgd-cal-icon pull-right" title="' . \_MA_WGDIARIES_CALENDAR_EDITITEM . '"></i></a>';
        $calendar->addDailyHtml($itemLink, $item['item_datefrom'], $item['item_dateto']);
    }
}
$calendar->setPermSubmit($permissionsHandler->getPermItemsSubmit());
$GLOBALS['xoopsTpl']->assign('items_calendar', $calendar->render());

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wgdiariesMetaDescription(\_MA_WGDIARIES_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/index.php');

require __DIR__ . '/footer.php';
