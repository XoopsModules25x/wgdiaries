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

// Template Index
$templateMain = 'wgdiaries_admin_permissions.tpl';
$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('permissions.php'));

$op = Request::getCmd('op', 'global');

// Get Form
require_once \XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
\xoops_load('XoopsFormLoader');
switch ($op) {
    case 'global':
    default:
    $formTitle = \_AM_WGDIARIES_PERMISSIONS_GLOBAL;
    $permName = 'wgdiaries_ac';
    $permDesc = \_AM_WGDIARIES_PERMISSIONS_GLOBAL_DESC;
    $globalPerms = [
            Constants::PERM_GLOBAL_SUBMIT => \_AM_WGDIARIES_PERMISSIONS_GLOBAL_SUBMIT,
            Constants::PERM_GLOBAL_EDIT => \_AM_WGDIARIES_PERMISSIONS_GLOBAL_EDIT,
            Constants::PERM_GLOBAL_VIEW => \_AM_WGDIARIES_PERMISSIONS_GLOBAL_VIEW,
            Constants::PERM_ITEMS_GROUP_EDIT => \_AM_WGDIARIES_PERMISSIONS_ITEMS_GROUP_EDIT,
            Constants::PERM_ITEMS_GROUP_VIEW => \_AM_WGDIARIES_PERMISSIONS_ITEMS_GROUP_VIEW,
            Constants::PERM_ITEMS_SUBMIT => \_AM_WGDIARIES_PERMISSIONS_ITEMS_SUBMIT,
            Constants::PERM_ITEMS_OWN_EDIT => \_AM_WGDIARIES_PERMISSIONS_ITEMS_OWN_EDIT,
            Constants::PERM_ITEMS_OWN_VIEW => \_AM_WGDIARIES_PERMISSIONS_ITEMS_OWN_VIEW,
            Constants::PERM_GROUPS_EDIT => \_AM_WGDIARIES_PERMISSIONS_GROUPS_EDIT,
            Constants::PERM_GROUPS_VIEW => \_AM_WGDIARIES_PERMISSIONS_GROUPS_VIEW,
            Constants::PERM_ITEMS_COMEDIT => \_AM_WGDIARIES_PERMISSIONS_ITEMS_COMEDIT,
            Constants::PERM_CALPAGE_VIEW => \_AM_WGDIARIES_PERMISSIONS_CALPAGE_VIEW,
            Constants::PERM_OUTPUTS_VIEW => \_AM_WGDIARIES_PERMISSIONS_OUTPUTS_VIEW,
            Constants::PERM_STATISTICS_VIEW => \_AM_WGDIARIES_PERMISSIONS_STATISTICS_VIEW,
            Constants::PERM_USERITEMS_GROUP_VIEW => \_AM_WGDIARIES_PERMISSIONS_USERITEMS_GROUP_VIEW,
            Constants::PERM_USERITEMS_ALL_VIEW => \_AM_WGDIARIES_PERMISSIONS_USERITEMS_ALL_VIEW,
        ];
    break;
}
$moduleId = $xoopsModule->getVar('mid');
$permform = new \XoopsGroupPermForm($formTitle, $moduleId, $permName, $permDesc, 'admin/permissions.php');
$permFound = false;
if ('global' === $op) {
    foreach ($globalPerms as $gPermId => $gPermName) {
        $permform->addItem($gPermId, $gPermName);
    }
    $GLOBALS['xoopsTpl']->assign('form', $permform->render());
    $permFound = true;
}


unset($permform);
if (true !== $permFound) {
    \redirect_header('permissions.php', 3, \_AM_WGDIARIES_NO_PERMISSIONS_SET);
    exit();
}
require __DIR__ . '/footer.php';
