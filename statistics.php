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

if (!$permissionsHandler->getPermStatisticsView()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_STATISTICS];

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$year       = Request::getInt('year', (int) date('Y'));
$month      = Request::getInt('month', (int) date('n'));
$lastday    = (int) date('t');
$yearStart  = mktime(0, 0, 0, 1, 1, $year);
$yearEnd    = mktime(23, 59, 59, 12, 31, $year) ;
$monthStart = mktime(0, 0, 0, $month, 1, $year);
$monthEnd   = mktime(23, 59, 59, $month, $lastday, $year);

/*
echo '<br>yearStart:'. date('Y-m-d H:i:s', $yearStart);
echo '<br>yearEnd:'. date('Y-m-d H:i:s', $yearEnd);
echo '<br>monthStart:'. date('Y-m-d H:i:s', $monthStart);
echo '<br>monthEnd:'. date('Y-m-d H:i:s', $monthEnd);
*/

if ($uid > 0) {
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
        $hoursTotal = round($diff / (60 * 60), 2);
        $daysTotal = (int)($hoursTotal / 24);
        if ($daysTotal > 0) {
            $itemsOwnHours = \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
        } else {
            $itemsOwnHours = $hoursTotal;
        }

        $itemsOwn['year']['hours'] = $itemsOwnHours;
    }
    unset($items);
    // current month
    $items = $itemsHandler->getItems($uid, 0, 0, $monthStart, $monthEnd);
    if (\is_array($items)) {
        $itemsOwn['month']['count'] = \count($items);
        $itemsOwn['month']['fromto'] = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $monthStart), date('Y-m-d H:i:s', $monthEnd));
        $diff = 0;
        foreach ($items as $item) {
            $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
        }
        $hoursTotal = round($diff / (60 * 60), 2);
        $daysTotal = (int)($hoursTotal / 24);
        if ($daysTotal > 0) {
            $itemsOwnHours = \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
        } else {
            $itemsOwnHours = $hoursTotal;
        }

        $itemsOwn['month']['hours'] = $itemsOwnHours;
    }
    unset($items);
    $GLOBALS['xoopsTpl']->assign('itemsOwn', $itemsOwn);
}

if ($permissionsHandler->getPermItemsGroupView()) {
// items of my group
// current year
    $itemsGroup = [];
    $items = $itemsHandler->getItems(0, 0, 0, $yearStart, $yearEnd, true);
    if (\is_array($items)) {
        $itemsGroup['year']['count'] = \count($items);
        $fromto = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $yearStart), date('Y-m-d H:i:s', $yearEnd));
        $itemsGroup['year']['fromto'] = $fromto;
        $diff = 0;
        $diffusers = [];
        foreach ($items as $item) {
            $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
            $key = $item['item_submitter'];
            if (\array_key_exists($key, $diffusers)) {
                $diffusers[$key]['count']++;
                $diffusers[$key]['diff'] += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
            } else {
                $diffusers[$key]['name'] = $item['submitter'];
                $diffusers[$key]['count'] = 1;
                $diffusers[$key]['diff'] = ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
            }
        }
        $hoursTotal = round($diff / (60 * 60), 2);
        $daysTotal = (int)($hoursTotal / 24);
        if ($daysTotal > 0) {
            $itemsGroupHours = \sprintf(_MA_WGDIARIES_STATS_DAYSHOURS, $hoursTotal, $daysTotal, $hoursTotal - ($daysTotal * 24));
        } else {
            $itemsGroupHours = $hoursTotal;
        }
        foreach ($diffusers as $key => $diffuser) {
            $result = createDaysHoursMinutes($diffuser['diff']);
            $diffusers[$key]['hours'] = $result['hours'];
            $diffusers[$key]['days'] = $result['days'];
            $diffusers[$key]['hoursdesc'] = $result['hoursdesc'];
        }

        $itemsGroup['year']['hours'] = $itemsGroupHours;
        $itemsGroup['year']['users'] = $diffusers;
    }
    unset($items);
    // current month
    $items = $itemsHandler->getItems(0, 0, 0, $monthStart, $monthEnd, true);
    if (\is_array($items)) {
        $itemsGroup['month']['count'] = \count($items);
        $itemsGroup['month']['fromto'] = \sprintf(_MA_WGDIARIES_STATS_PERIOD_FROMTO, date('Y-m-d H:i:s', $monthStart), date('Y-m-d H:i:s', $monthEnd));
        $diff = 0;
        $diffusers = [];
        foreach ($items as $item) {
            $diff += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
            $key = $item['item_submitter'];
            if (\array_key_exists($key, $diffusers)) {
                $diffusers[$key]['count']++;
                $diffusers[$key]['diff'] += ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
            } else {
                $diffusers[$key]['name'] = $item['submitter'];
                $diffusers[$key]['count'] = 1;
                $diffusers[$key]['diff'] = ((int)$item['item_dateto'] - (int)$item['item_datefrom']);
            }
        }
        foreach ($diffusers as $key => $diffuser) {
            $result = createDaysHoursMinutes($diffuser['diff']);
            $diffusers[$key]['hours'] = $result['hours'];
            $diffusers[$key]['days'] = $result['days'];
            $diffusers[$key]['hoursdesc'] = $result['hoursdesc'];
        }

        $itemsGroup['month']['hours'] = $itemsGroupHours;
        $itemsGroup['month']['users'] = $diffusers;
    }
    unset($items);
    $GLOBALS['xoopsTpl']->assign('itemsGroup', $itemsGroup);
}


// Description
wgdiariesMetaDescription(_MA_WGDIARIES_STATISTICS);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);
require __DIR__ . '/footer.php';

/**
 * @public function to get params of seconds
 * @param $seconds
 * @return array
 */
function createDaysHoursMinutes($seconds) {

    $ret = [];
    $hoursTotal = round($seconds / (60 * 60), 2);
    $ret['hours'] = $hoursTotal;
    $daysTotal = (int)($hoursTotal / 24);
    $ret['days'] = $daysTotal;
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    $formatText = \str_replace('%s', (string)$hoursTotal, _MA_WGDIARIES_STATS_DAYSHOURSMINUTES);
    $ret['hoursdesc'] = $dtF->diff($dtT)->format($formatText);

    return $ret;
}
