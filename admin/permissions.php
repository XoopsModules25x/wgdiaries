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
$permTableForm = new \XoopsSimpleForm('', 'fselperm', 'permissions.php', 'post');
$formSelect = new \XoopsFormSelect('', 'op', $op);
$formSelect->setExtra('onchange="document.fselperm.submit()"');
$formSelect->addOption('global', _AM_WGDIARIES_PERMISSIONS_GLOBAL);
$formSelect->addOption('approve_items', _AM_WGDIARIES_PERMISSIONS_APPROVE . ' Items');
$formSelect->addOption('submit_items', _AM_WGDIARIES_PERMISSIONS_SUBMIT . ' Items');
$formSelect->addOption('view_items', _AM_WGDIARIES_PERMISSIONS_VIEW . ' Items');
$formSelect->addOption('approve_files', _AM_WGDIARIES_PERMISSIONS_APPROVE . ' Files');
$formSelect->addOption('submit_files', _AM_WGDIARIES_PERMISSIONS_SUBMIT . ' Files');
$formSelect->addOption('view_files', _AM_WGDIARIES_PERMISSIONS_VIEW . ' Files');
$permTableForm->addElement($formSelect);
$permTableForm->display();
switch ($op) {
	case 'global':
	default:
		$formTitle = _AM_WGDIARIES_PERMISSIONS_GLOBAL;
		$permName = 'wgdiaries_ac';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_GLOBAL_DESC;
		$globalPerms = array( '4' => _AM_WGDIARIES_PERMISSIONS_GLOBAL_4, '8' => _AM_WGDIARIES_PERMISSIONS_GLOBAL_8, '16' => _AM_WGDIARIES_PERMISSIONS_GLOBAL_16 );
		break;
	case 'approve_items':
		$formTitle = _AM_WGDIARIES_PERMISSIONS_APPROVE;
		$permName = 'wgdiaries_approve_items';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_APPROVE_DESC . ' Items';
		$handler = $helper->getHandler('items');
		break;
	case 'submit_items':
		$formTitle = _AM_WGDIARIES_PERMISSIONS_SUBMIT;
		$permName = 'wgdiaries_submit_items';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_SUBMIT_DESC . ' Items';
		$handler = $helper->getHandler('items');
		break;
	case 'view_items':
		$formTitle = _AM_WGDIARIES_PERMISSIONS_VIEW;
		$permName = 'wgdiaries_view_items';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_VIEW_DESC . ' Items';
		$handler = $helper->getHandler('items');
		break;
	case 'approve_files':
		$formTitle = _AM_WGDIARIES_PERMISSIONS_APPROVE;
		$permName = 'wgdiaries_approve_files';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_APPROVE_DESC . ' Files';
		$handler = $helper->getHandler('files');
		break;
	case 'submit_files':
		$formTitle = _AM_WGDIARIES_PERMISSIONS_SUBMIT;
		$permName = 'wgdiaries_submit_files';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_SUBMIT_DESC . ' Files';
		$handler = $helper->getHandler('files');
		break;
	case 'view_files':
		$formTitle = _AM_WGDIARIES_PERMISSIONS_VIEW;
		$permName = 'wgdiaries_view_files';
		$permDesc = _AM_WGDIARIES_PERMISSIONS_VIEW_DESC . ' Files';
		$handler = $helper->getHandler('files');
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
if ($op === 'approve_items' || $op === 'submit_items' || $op === 'view_items') {
	$itemsCount = $itemsHandler->getCountItems();
	if ($itemsCount > 0) {
		$itemsAll = $itemsHandler->getAllItems(0, 'item_submitter');
		foreach (\array_keys($itemsAll) as $i) {
			$permform->addItem($itemsAll[$i]->getVar('item_id'), $itemsAll[$i]->getVar('item_submitter'));
		}
		$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	}
	$permFound = true;
}
if ($op === 'approve_files' || $op === 'submit_files' || $op === 'view_files') {
	$filesCount = $filesHandler->getCountFiles();
	if ($filesCount > 0) {
		$filesAll = $filesHandler->getAllFiles(0, 'file_itemid');
		foreach (\array_keys($filesAll) as $i) {
			$permform->addItem($filesAll[$i]->getVar('file_id'), $filesAll[$i]->getVar('file_itemid'));
		}
		$GLOBALS['xoopsTpl']->assign('form', $permform->render());
	}
	$permFound = true;
}
unset($permform);
if (true !== $permFound) {
	\redirect_header('permissions.php', 3, _AM_WGDIARIES_NO_PERMISSIONS_SET);
	exit();
}
require __DIR__ . '/footer.php';
