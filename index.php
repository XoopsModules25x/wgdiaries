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
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_index.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';
// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_INDEX];
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', WGDIARIES_URL);

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
// own items
$crItems = new \CriteriaCompo();
$crItems->add(new \Criteria('item_submitter', $uid));
$itemsCount = $itemsHandler->getCount($crItems);
$GLOBALS['xoopsTpl']->assign('itemsOwnCount', $itemsCount);
$count = 1;
if ($itemsCount > 0) {
	$start = Request::getInt('start', 0);
	$limit = Request::getInt('limit', $helper->getConfig('userpager'));
    $crItems->setStart($start);
    $crItems->setLimit($limit);
    $itemsAll = $itemsHandler->getAll($crItems);
	// Get All Items
	$items = [];
	foreach (\array_keys($itemsAll) as $i) {
		$item = $itemsAll[$i]->getValuesItems();
		$items[$count] = $item;
        $count++;
	}
	$GLOBALS['xoopsTpl']->assign('itemsown', $items);
	unset($items);
}
unset($crItems);

if ($permissionsHandler->getPermItemsGroupView()) {
// items of my groups
    $crItems = new \CriteriaCompo();
    $crItems->add(new \Criteria('item_submitter', $uid, '<>'));
    $memberHandler = \xoops_getHandler('member');
    $xoopsGroups = $memberHandler->getGroupList();
    $myGroups = array_keys($xoopsGroups);
    $crItems->add(new \Criteria('item_groupid', "(" . implode(',', $myGroups) . ")", 'IN'));
    $itemsCount = $itemsHandler->getCount($crItems);
    $GLOBALS['xoopsTpl']->assign('itemsGroupCount', $itemsCount);
    $count = 1;
    if ($itemsCount > 0) {
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('userpager'));
        $crItems->setStart($start);
        $crItems->setLimit($limit);
        $itemsAll = $itemsHandler->getAll($crItems);
        // Get All Items
        $items = [];
        foreach (\array_keys($itemsAll) as $i) {
            $item = $itemsAll[$i]->getValuesItems();
            $items[$count] = $item;
            $count++;
        }
        $GLOBALS['xoopsTpl']->assign('itemsgroup', $items);
        unset($items);
    }
    unset($crItems);
}

$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
$GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
$GLOBALS['xoopsTpl']->assign('indexHeader', $helper->getConfig('index_header'));
// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);
// Description
wgdiariesMetaDescription(_MA_WGDIARIES_INDEX_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/index.php');
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);
require __DIR__ . '/footer.php';
