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
use XoopsModules\Wgdiaries\Constants;

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_archive.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

$op = Request::getCmd('op', 'list');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ARCHIVE];
// Paths
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_categoriesurl', \WGDIARIES_UPLOAD_CATEGORIES_URL);

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$start = 0;
$limit = Request::getInt('limit', $helper->getConfig('indexpager'));
$sortBy = 'item_datefrom';
$orderBy = 'DESC';

switch ($op) {
    case 'list':
    default:
        //create list of months
        $arrMonths = [];
        // own items
        $items = $itemsHandler->getItems($uid, 0, 0, 1, \time(), false, false, 0,  0, $sortBy, $orderBy);
        if (\is_array($items)) {
            foreach ($items as $item) {
                $dayStart = mktime(0, 0, 0, (int) date('n', $item['item_datefrom']), 1, (int) date('Y', $item['item_datefrom']));
                $arrMonths[$dayStart] = ['timestamp' => $dayStart, 'string' => date('F Y', $dayStart)];
            }
        }

        if ($permissionsHandler->getPermItemsGroupView()) {
            // items of my groups
            $items = $itemsHandler->getItems($uid, 0, 0, 1, \time(), true, true, 0,  0, $sortBy, $orderBy);
            if (\is_array($items)) {
                foreach ($items as $item) {
                    $dayStart = mktime(0, 0, 0, (int) date('n', $item['item_datefrom']), 1, (int) date('Y', $item['item_datefrom']));
                    $arrMonths[$dayStart] = ['timestamp' => $dayStart, 'string' => date('F Y', $dayStart)];
                }
            }
        }
        $GLOBALS['xoopsTpl']->assign('monthsCount', \count($arrMonths));
        $GLOBALS['xoopsTpl']->assign('arrMonths', $arrMonths);
        break;
    case 'listresult':
        $listDate   = Request::getInt('listdate', 0);
        $year       = (int) date('Y', $listDate);
        $month      = (int) date('n', $listDate);
        $lastday    = (int) date('t', \strtotime($month . '/1/' . $year));
        $filterFrom = mktime(0, 0, 0, $month, 1, $year);
        $filterTo   = mktime(23, 59, 59, $month, $lastday, $year);

        if ($permissionsHandler->getPermItemsGroupView()) {
            $items = $itemsHandler->getItems(0, 0, 0, $filterFrom, $filterTo, true, false, 0, 0, $sortBy, $orderBy);
        } else {
            $items = $itemsHandler->getItems($uid, 0, 0, $filterFrom, $filterTo, false, false, 0, 0, $sortBy, $orderBy);
        }
        $GLOBALS['xoopsTpl']->assign('itemsCount', \count($items));
        $GLOBALS['xoopsTpl']->assign('items', $items);

        $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
        $GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
        $GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));
        break;
}


$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/index.php');
require __DIR__ . '/footer.php';
