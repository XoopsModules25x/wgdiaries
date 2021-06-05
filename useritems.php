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

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_useritems.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

if (!$permissionsHandler->getPermUserItemsGroupView()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

$op      = Request::getCmd('op', 'listusers');
$start   = Request::getInt('start', 0);
$limit   = Request::getInt('limit', $helper->getConfig('userpager'));
$itemId  = Request::getInt('item_id', 0);
$sortBy  = Request::getString('sortBy', 'item_datefrom');
$orderBy = Request::getString('orderBy', 'DESC');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_categoriesurl', \WGDIARIES_UPLOAD_CATEGORIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_itemsurl', \WGDIARIES_UPLOAD_ITEMS_URL);
$GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));

switch ($op) {
    case 'listusers':
    default:
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEMS_LISTGROUP];

        $userlist = [];
        $uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $memberHandler = \xoops_getHandler('member');
        $xoopsGroups = $memberHandler->getGroupsByUser($uid);

        foreach ($xoopsGroups as $groupid) {
            $users = $memberHandler->getUsersByGroup($groupid);
            foreach ($users as $user) {
                $crItems = new CriteriaCompo();
                $crItems->setSort('item_datefrom');
                $crItems->setOrder('DESC');
                $crItems->add(new \Criteria('item_submitter', $user));
                $itemsCount = $itemsHandler->getCount($crItems);
                if ($itemsCount > 0) {
                    $userObj = new \XoopsUser($user);
                    $avatar = '';
                    if ('avatars/blank.gif' != $userObj->user_avatar()) {
                        $avatar = $userObj->user_avatar();
                    }
                    $userGroups = $memberHandler->getGroupsByUser($user);
                    $groups = [];
                    foreach ($userGroups as $userGroup) {
                        $groupObj = $memberHandler->getGroup($userGroup);;
                        $groups[$userGroup]['name'] = $groupObj->getVar('name');
                    }
                    $userlist[$user] = [
                        'uid' => $user,
                        'name' => \XoopsUser::getUnameFromId($user, true),
                        'user_avatar' => $avatar,
                        'groups' => $groups,
                        'itemsCount' => $itemsCount]
                    ;
                }
                unset($crItems);
            }
        }

        //var_dump($userlist);
        if ($permissionsHandler->getPermUserItemsGroupView()) {
            $GLOBALS['xoopsTpl']->assign('useritemsTitle', _MA_WGDIARIES_USERLIST_ALL);
        } else {
            $GLOBALS['xoopsTpl']->assign('useritemsTitle', _MA_WGDIARIES_USERLIST_GROUP);
        }

        $GLOBALS['xoopsTpl']->assign('userlist', $userlist);

        break;

}

// Description
wgdiariesMetaDescription(\_MA_WGDIARIES_ITEMS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/items.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', \WGDIARIES_UPLOAD_URL);

// View comments
require_once \XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
