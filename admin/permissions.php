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
include_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';
\xoops_load('XoopsFormLoader');
switch ($op) {
	case 'global':
	default:
		$formTitle = _AM_WGDIARIES_PERMISSIONS_GLOBAL;
		$permName = 'wgdiaries_ac';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_GLOBAL_DESC;
		$globalPerms = array( '4' => _AM_WGDIARIES_PERMISSIONS_GLOBAL_4, '8' => _AM_WGDIARIES_PERMISSIONS_GLOBAL_8, '16' => _AM_WGDIARIES_PERMISSIONS_GLOBAL_16 );
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
	\redirect_header('permissions.php', 3, _AM_WGDIARIES_NO_PERMISSIONS_SET);
	exit();
}
require __DIR__ . '/footer.php';
