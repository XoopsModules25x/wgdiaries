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
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_itemsurl', WGDIARIES_UPLOAD_ITEMS_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_categoriesurl', WGDIARIES_UPLOAD_CATEGORIES_URL);

$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

$start = 0;
$limit = Request::getInt('limit', $helper->getConfig('indexpager'));

if ('datefrom' === $helper->getConfig('index_sort')) {
    $sortBy = 'item_datefrom';
} else {
    $sortBy = 'item_id';
}
$orderBy = 'DESC';

// own items
$items = $itemsHandler->getItems($uid, $start, $limit, 0, 0, false, false, 0,  0, $sortBy, $orderBy);
if (\is_array($items)) {
    $GLOBALS['xoopsTpl']->assign('itemsOwnCount', \count($items));
    $GLOBALS['xoopsTpl']->assign('itemsown', $items);
}

if ($permissionsHandler->getPermItemsGroupView()) {
    // items of my groups
    $items = $itemsHandler->getItems($uid, $start, $limit, 0, 0, true, true, 0,  0, $sortBy, $orderBy);
    if (\is_array($items)) {
        $GLOBALS['xoopsTpl']->assign('itemsGroupCount', \count($items));
        $GLOBALS['xoopsTpl']->assign('itemsgroup', $items);
    }
}

$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
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
