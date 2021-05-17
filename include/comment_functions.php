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

/**
 * CommentsUpdate
 *
 * @param mixed  $itemId
 * @param mixed  $itemNumb
 * @return bool
 */
function wgdiariesCommentsUpdate($itemId, $itemNumb)
{
    // Get instance of module
    $helper = \XoopsModules\Wgdiaries\Helper::getInstance();
    $itemsHandler = $helper->getHandler('Items');
    $itemsObj = $itemsHandler->get((int)$itemId);
    $itemsObj->setVar('item_comments', (int)$itemNumb);
    if ($itemsHandler->insert($itemsObj)) {
        return true;
    }

    return false;
}

/**
 * CommentsApprove
 *
 * @param mixed $comment
 * @return bool
 */
function wgdiariesCommentsApprove(&$comment)
{
    // Notification event
    // Get instance of module
    /*
    $helper = \XoopsModules\Wgdiaries\Helper::getInstance();
    $groupusersHandler = $helper->getHandler('Groupusers');
    $guId = $comment->getVar('com_itemid');
    $groupusersObj = $groupusersHandler->get($guId);
    $guGroupid = $groupusersObj->getVar('gu_groupid');

    $tags = [];
    $tags['ITEM_NAME'] = $guGroupid;
    $tags['ITEM_URL']  = \XOOPS_URL . '/modules/wgdiaries/groupusers.php?op=show&gu_id=' . $guId;
    $notificationHandler = \xoops_getHandler('notification');
    // Event modify notification
    $notificationHandler->triggerEvent('global', 0, 'global_comment', $tags);
    $notificationHandler->triggerEvent('groupusers', $guId, 'groupuser_comment', $tags);
    */
    return true;

}
