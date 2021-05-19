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
use XoopsModules\Wgdiaries\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request gu_id
$guId = Request::getInt('gu_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wgdiaries_admin_groupusers.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groupusers.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_ADD_GROUPUSER, 'groupusers.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$groupusersCount = $groupusersHandler->getCountGroupusers();
		$groupusersAll = $groupusersHandler->getAllGroupusers($start, $limit);
		$GLOBALS['xoopsTpl']->assign('groupusers_count', $groupusersCount);
		$GLOBALS['xoopsTpl']->assign('wgdiaries_url', WGDIARIES_URL);
		$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);
		// Table view groupusers
		if ($groupusersCount > 0) {
			foreach (\array_keys($groupusersAll) as $i) {
				$groupuser = $groupusersAll[$i]->getValuesGroupusers();
				$GLOBALS['xoopsTpl']->append('groupusers_list', $groupuser);
				unset($groupuser);
			}
			// Display Navigation
			if ($groupusersCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($groupusersCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGDIARIES_THEREARENT_GROUPUSERS);
		}
		break;
	case 'new':
		$templateMain = 'wgdiaries_admin_groupusers.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groupusers.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_LIST_GROUPUSERS, 'groupusers.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$groupusersObj = $groupusersHandler->create();
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('groupusers.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($guId > 0) {
			$groupusersObj = $groupusersHandler->get($guId);
		} else {
			$groupusersObj = $groupusersHandler->create();
		}
		// Set Vars
		$groupusersObj->setVar('gu_groupid', Request::getInt('gu_groupid', 0));
		$groupusersObj->setVar('gu_uid', Request::getInt('gu_uid', 0));
		$groupuserDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('gu_datecreated'));
		$groupusersObj->setVar('gu_datecreated', $groupuserDatecreatedObj->getTimestamp());
		$groupusersObj->setVar('gu_submitter', Request::getInt('gu_submitter', 0));
		// Insert Data
		if ($groupusersHandler->insert($groupusersObj)) {
			\redirect_header('groupusers.php?op=list', 2, _MA_WGDIARIES_FORM_OK);
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $groupusersObj->getHtmlErrors());
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wgdiaries_admin_groupusers.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groupusers.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_ADD_GROUPUSER, 'groupusers.php?op=new', 'add');
		$adminObject->addItemButton(_AM_WGDIARIES_LIST_GROUPUSERS, 'groupusers.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$groupusersObj = $groupusersHandler->get($guId);
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgdiaries_admin_groupusers.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groupusers.php'));
		$groupusersObj = $groupusersHandler->get($guId);
		$guGroupid = $groupusersObj->getVar('gu_groupid');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('groupusers.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($groupusersHandler->delete($groupusersObj)) {
				\redirect_header('groupusers.php', 3, _MA_WGDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $groupusersObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'gu_id' => $guId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_MA_WGDIARIES_FORM_SURE_DELETE, $groupusersObj->getVar('gu_groupid')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
