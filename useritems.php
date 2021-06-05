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

if (!$permissionsHandler->getPermUserItemsView()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

$op     = Request::getCmd('op', 'listusers');
$itemId = Request::getInt('item_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));

// Breadcrumbs
$xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEMS_LISTGROUP];

$userlist = [];
$uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : -1;
$memberHandler = \xoops_getHandler('member');
$xoopsGroups = $memberHandler->getGroupsByUser($uid);

foreach ($xoopsGroups as $groupid) {
    $users = $memberHandler->getUsersByGroup($groupid);
    foreach ($users as $user) {
        if ($permissionsHandler->getPermItemsGroupView() || $uid == $user) {
            $crItems = new CriteriaCompo();
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
                    'itemsCount' => $itemsCount];
            }
            unset($crItems);
        }
    }
}

$GLOBALS['xoopsTpl']->assign('userlist', $userlist);

// Description
wgdiariesMetaDescription(\_MA_WGDIARIES_ITEMS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/items.php');

require __DIR__ . '/footer.php';
