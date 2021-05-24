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
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_statistics.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_STATISTICS];

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$year       = Request::getInt('year', (int) date('Y'));
$month      = Request::getInt('month', (int) date('n'));
$lastday    = (int) date('t');
$yearStart  = mktime(0, 0, 0, 1, 1, $year);
$yearEnd    = mktime(23, 59, 59, 1, 1, $year) ;
$monthStart = mktime(0, 0, 0, $month, 1, $year);
$monthEnd   = mktime(23, 59, 59, $month, $lastday, $year);

/*
echo '<br>yearStart:'. date('Y-m-d H:i:s', $yearStart);
echo '<br>yearEnd:'. date('Y-m-d H:i:s', $yearEnd);
echo '<br>monthStart:'. date('Y-m-d H:i:s', $monthStart);
echo '<br>monthEnd:'. date('Y-m-d H:i:s', $monthEnd);
*/

// own items
// current year
$itemsOwn = [];
$items = $itemsHandler->getItems($uid, 0, 0, $yearStart, $yearEnd);
if (\is_array($items)) {
    $itemsOwn['year']['count'] = \count($items);
    $itemsOwn['year']['fromto'] = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $yearStart), date('Y-m-d H:i:s', $yearEnd));
    $diff = 0;
    foreach ($items as $item) {
        $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
    }
    $hoursTotal = round($diff / ( 60 * 60 ), 2);
    $daysTotal = round($hoursTotal / 24, 0);
    if ($daysTotal > 0) {
        $itemsOwnHours =  \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
    } else {
        $itemsOwnHours = $hoursTotal;
    }

    $itemsOwn['year']['hours'] = $itemsOwnHours;
}
// current month
$items = $itemsHandler->getItems($uid, 0, 0, $monthStart, $monthEnd);
if (\is_array($items)) {
    $itemsOwn['month']['count'] = \count($items);
    $itemsOwn['month']['fromto'] = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $monthStart), date('Y-m-d H:i:s', $monthEnd));
    $diff = 0;
    foreach ($items as $item) {
        $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
    }
    $hoursTotal = round($diff / ( 60 * 60 ), 2);
    $daysTotal = round($hoursTotal / 24, 0);
    if ($daysTotal > 0) {
        $itemsOwnHours =  \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
    } else {
        $itemsOwnHours = $hoursTotal;
    }

    $itemsOwn['month']['hours'] = $itemsOwnHours;
}
$GLOBALS['xoopsTpl']->assign('itemsOwn',$itemsOwn);

if ($permissionsHandler->getPermItemsGroupView()) {
// items of my group
// current year
    $itemsGroup = [];
    $items = $itemsHandler->getItems(0, 0, 0, $yearStart, $yearEnd, true);
    if (\is_array($items)) {
        $itemsGroup['year']['count'] = \count($items);
        $itemsGroup['year']['fromto'] = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $yearStart), date('Y-m-d H:i:s', $yearEnd));
        $diff = 0;
        foreach ($items as $item) {
            $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
        }
        $hoursTotal = round($diff / (60 * 60), 2);
        $daysTotal = round($hoursTotal / 24, 0);
        if ($daysTotal > 0) {
            $itemsGroupHours = \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
        } else {
            $itemsGroupHours = $hoursTotal;
        }

        $itemsGroup['year']['hours'] = $itemsGroupHours;
    }
// current month
    $items = $itemsHandler->getItems(0, 0, 0, $monthStart, $monthEnd, true);
    if (\is_array($items)) {
        $itemsGroup['month']['count'] = \count($items);
        $itemsGroup['month']['fromto'] = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $monthStart), date('Y-m-d H:i:s', $monthEnd));
        $diff = 0;
        foreach ($items as $item) {
            $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
        }
        $hoursTotal = round($diff / (60 * 60), 2);
        $daysTotal = round($hoursTotal / 24, 0);
        if ($daysTotal > 0) {
            $itemsGroupHours = \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
        } else {
            $itemsGroupHours = $hoursTotal;
        }

        $itemsGroup['month']['hours'] = $itemsGroupHours;
    }
    $GLOBALS['xoopsTpl']->assign('itemsGroup', $itemsGroup);
}


// Description
wgdiariesMetaDescription(_MA_WGDIARIES_STATISTICS);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);
require __DIR__ . '/footer.php';
