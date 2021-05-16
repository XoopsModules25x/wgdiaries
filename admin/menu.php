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

$dirname       = \basename(\dirname(__DIR__));
$moduleHandler = \xoops_getHandler('module');
$xoopsModule   = XoopsModule::getByDirname($dirname);
$moduleInfo    = $moduleHandler->get($xoopsModule->getVar('mid'));
$sysPathIcon32 = $moduleInfo->getInfo('sysicons32');

$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU1,
	'link' => 'admin/index.php',
	'icon' => $sysPathIcon32.'/dashboard.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU2,
	'link' => 'admin/items.php',
	'icon' => 'assets/icons/32/event.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU3,
	'link' => 'admin/files.php',
	'icon' => 'assets/icons/32/fileshare.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU4,
	'link' => 'admin/groups.php',
	'icon' => 'assets/icons/32/users.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU5,
	'link' => 'admin/groupusers.php',
	'icon' => 'assets/icons/32/user-icon.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU6,
	'link' => 'admin/permissions.php',
	'icon' => $sysPathIcon32.'/permissions.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ADMENU7,
	'link' => 'admin/feedback.php',
	'icon' => $sysPathIcon32.'/mail_foward.png',
];
$adminmenu[] = [
	'title' => _MI_WGDIARIES_ABOUT,
	'link' => 'admin/about.php',
	'icon' => $sysPathIcon32.'/about.png',
];
