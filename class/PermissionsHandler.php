<?php

declare(strict_types=1);


namespace XoopsModules\Wgdiaries;

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

use XoopsModules\Wgdiaries\Constants;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object PermissionsHandler
 */
class PermissionsHandler extends \XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
    }

    /**
     * @public function permGlobalSubmit
     * returns right for global submit
     *
     * @param null
     * @return bool
     */
    public function getPermGlobalSubmit()
    {
        global $xoopsUser, $xoopsModule;
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_GLOBAL_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }
        
        return false;
    }

    /**
     * @public function permGlobalEdit
     * returns right for global edit
     *
     * @param null
     * @return bool
     */
    public function getPermGlobalEdit()
    {
        global $xoopsUser, $xoopsModule;
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_GLOBAL_EDIT, $my_group_ids, $mid)) {
            return true;
        }
        
        return false;
    }

    /**
     * @public function permGlobalView
     * returns right for global view
     *
     * @param null
     * @return bool
     */
    public function getPermGlobalView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        
        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_GLOBAL_VIEW, $my_group_ids, $mid)) {
            return true;
        }
        
        return false;
    }

    /**
     * @public function getPermItemsSubmit
     * returns right to submit items
     * @return bool
     */
    public function getPermItemsSubmit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalSubmit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_ITEMS_SUBMIT, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermItemsGroupEdit
     * returns right to edit/delete items from group
     * @return bool
     */
    public function getPermItemsGroupEdit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalEdit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_ITEMS_GROUP_EDIT, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermItemsGroupView
     * returns right to view items from group
     * @return bool
     */
    public function getPermItemsGroupView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalView()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_ITEMS_GROUP_VIEW, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermItemsEdit
     * returns right to edit/delete items
     *  - User must have perm to submit
     *  - must be owner or user is in same group and have permission to edit group
     * @param $itemSubmitter
     * @return bool
     */
    public function getPermItemsEdit($itemSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalEdit()) {
            return true;
        }
        if ($this->getPermItemsGroupEdit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }

        if ($this->getPermItemsSubmit() && $currentuid == $itemSubmitter) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermItemsView
     * returns right to view items
     *  - must be owner or user is in same group and have permission to view group
     * @param $itemSubmitter
     * @return bool
     */
    public function getPermItemsView($itemSubmitter)
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalView()) {
            return true;
        }
        if ($this->getPermItemsGroupView()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }

        if ($currentuid == $itemSubmitter) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermGroupsEdit
     * returns right to edit groups and users
     * @return bool
     */
    public function getPermGroupsEdit()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalView()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_GROUPS_EDIT, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermGroupsView
     * returns right to view groups and users
     * @return bool
     */
    public function getPermGroupsView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGroupsEdit()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_GROUPS_VIEW, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermItemsComEdit
     * returns right for edit/view comments for item
     * @param $itemSubmitter
     * @return bool
     */
    public function getPermItemsComEdit($itemSubmitter)
    {
        global $xoopsUser, $xoopsModule;
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }
        if ($this->getPermItemsEdit($itemSubmitter) && $grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_ITEMS_COMEDIT, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermCalPageView
     * returns right to view calendar page
     * @return bool
     */
    public function getPermCalPageView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalView()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_CALPAGE_VIEW, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermOutputsView
     * returns right to view outputs page
     * @return bool
     */
    public function getPermOutputsView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalView()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_OUTPUTS_VIEW, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

    /**
     * @public function getPermStatisticsView
     * returns right to view statistics page
     * @return bool
     */
    public function getPermStatisticsView()
    {
        global $xoopsUser, $xoopsModule;

        if ($this->getPermGlobalView()) {
            return true;
        }
        $currentuid = 0;
        if (isset($xoopsUser) && \is_object($xoopsUser)) {
            if ($xoopsUser->isAdmin($xoopsModule->mid())) {
                return true;
            }
            $currentuid = $xoopsUser->uid();
        }
        $grouppermHandler = \xoops_getHandler('groupperm');
        $mid = $xoopsModule->mid();
        $memberHandler = \xoops_getHandler('member');
        if (0 == $currentuid) {
            $my_group_ids = [\XOOPS_GROUP_ANONYMOUS];
        } else {
            $my_group_ids = $memberHandler->getGroupsByUser($currentuid);;
        }

        if ($grouppermHandler->checkRight('wgdiaries_ac', Constants::PERM_STATISTICS_VIEW, $my_group_ids, $mid)) {
            return true;
        }

        return false;
    }

}
