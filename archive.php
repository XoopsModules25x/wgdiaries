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

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ARCHIVE];
// Paths
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_itemsurl', \WGDIARIES_UPLOAD_ITEMS_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_categoriesurl', \WGDIARIES_UPLOAD_CATEGORIES_URL);

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$sortBy = 'item_datefrom';
$orderBy = 'DESC';

switch ($op) {
    case 'list':
    default:
        //create list of months
        $arrMonth = [
            1 => \_MA_WGDIARIES_CAL_JANUARY,
            2 => \_MA_WGDIARIES_CAL_FEBRUARY,
            3 => \_MA_WGDIARIES_CAL_MARCH,
            4 => \_MA_WGDIARIES_CAL_APRIL,
            5 => \_MA_WGDIARIES_CAL_MAY,
            6 => \_MA_WGDIARIES_CAL_JUNE,
            7 => \_MA_WGDIARIES_CAL_JULY,
            8 => \_MA_WGDIARIES_CAL_AUGUST,
            9 => \_MA_WGDIARIES_CAL_SEPTEMBER,
            10 => \_MA_WGDIARIES_CAL_OCTOBER,
            11 => \_MA_WGDIARIES_CAL_NOVEMBER,
            12 => \_MA_WGDIARIES_CAL_DECEMBER
        ];
        $arrMonths = [];

        $arrCounterYears = [];
        // own items
        $items = $itemsHandler->getItems($uid, 0, 0, 1, \time(), false, false, 0,  0, $sortBy, $orderBy);
        if (\is_array($items)) {
            foreach ($items as $item) {
                $dayStart = \mktime(0, 0, 0, (int) date('n', $item['item_datefrom']), 1, (int) date('Y', $item['item_datefrom']));
                if (\array_key_exists($dayStart, $arrMonths)) {
                    $counter =  $arrMonths[$dayStart]['counter'] + 1;
                } else {
                    $counter = 1;
                }
                $year = date('Y', $dayStart);
                $arrMonths[$dayStart] = [
                    'timestamp' => $dayStart,
                    'year' => $year,
                    'string' => $arrMonth[\date('n', $dayStart)] . ' ' . $year,
                    'counter' => $counter
                ];

                //$arrMonths[$dayStart] = ['timestamp' => $dayStart, 'year' => $year, 'string' => date('F Y', $dayStart), 'counter' => $counter];
                //count by year
                if (\array_key_exists($year, $arrCounterYears)) {
                    $counterYear =  $arrCounterYears[$year]['counter'] + 1;
                } else {
                    $counterYear = 1;
                }
                $arrCounterYears[$year]['counter'] = $counterYear;
            }
        }

        if ($permissionsHandler->getPermItemsGroupView()) {
            // items of my groups
            $items = $itemsHandler->getItems($uid, 0, 0, 1, \time(), true, true, 0,  0, $sortBy, $orderBy);
            if (\is_array($items)) {
                foreach ($items as $item) {
                    $dayStart = \mktime(0, 0, 0, (int) date('n', $item['item_datefrom']), 1, (int) date('Y', $item['item_datefrom']));
                    if (\array_key_exists($dayStart, $arrMonths)) {
                        $counter =  $arrMonths[$dayStart]['counter'] + 1;
                    } else {
                        $counter = 1;
                    }
                    $year = date('Y', $dayStart);
                    $arrMonths[$dayStart] = [
                        'timestamp' => $dayStart,
                        'year' => $year,
                        'string' => $arrMonth[\date('n', $dayStart)] . ' ' . $year,
                        'counter' => $counter
                    ];
                    if (\array_key_exists($year, $arrCounterYears)) {
                        $counterYear =  $arrCounterYears[$year]['counter'] + 1;
                    } else {
                        $counterYear = 1;
                    }
                    $arrCounterYears[$year]['counter'] = $counterYear;
                }
            }
        }
        $monthsCount = \count($arrMonths);
        $arrYearMonth = [];
        if ($monthsCount > 0) {
            //group data by year
            $arrYearMonth = [];
            foreach ($arrMonths as $arrMonth) {
                $year = $arrMonth['year'];
                $arrYearMonth[$year]['counterYear'] = $arrCounterYears[$year]['counter'];
                $arrYearMonth[$year]['months'][] = $arrMonth;
            }
        }

        $GLOBALS['xoopsTpl']->assign('monthsCount', $monthsCount);
        $GLOBALS['xoopsTpl']->assign('arrYearMonth', $arrYearMonth);
        break;
    case 'listresult':
        $listDate   = Request::getInt('listdate', 0);
        $year       = (int) date('Y', $listDate);
        $month      = (int) date('n', $listDate);
        $lastday    = (int) date('t', \strtotime($month . '/1/' . $year));
        $filterFrom = \mktime(0, 0, 0, $month, 1, $year);
        $filterTo   = \mktime(23, 59, 59, $month, $lastday, $year);

        if ($permissionsHandler->getPermItemsGroupView()) {
            $itemsTotal = $itemsHandler->getItemsCount(0, $filterFrom, $filterTo, true, false, 0, 0);
            $items = $itemsHandler->getItems(0, $start, $limit, $filterFrom, $filterTo, true, false, 0, 0, $sortBy, $orderBy);
        } else {
            $itemsTotal = $itemsHandler->getItemsCount($uid, $filterFrom, $filterTo, false, false, 0, 0);
            $items = $itemsHandler->getItems($uid, $start, $limit, $filterFrom, $filterTo, false, false, 0, 0, $sortBy, $orderBy);
        }
        $GLOBALS['xoopsTpl']->assign('itemsCount', \count($items));
        $GLOBALS['xoopsTpl']->assign('items', $items);

        // Display Navigation
        if ($itemsTotal > $limit) {
            require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
            $pagenav = new \XoopsPageNav($itemsTotal, $limit, $start, 'start', 'op=listresult&amp;limit=' . $limit . '&amp;listdate=' . $listDate);
            $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
        }

        $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
        $GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
        $GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));
        break;
}


$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/index.php');
require __DIR__ . '/footer.php';
