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
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_groupusers.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$guId = Request::getInt('gu_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', WGDIARIES_URL);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_INDEX, 'link' => 'index.php'];
// Permissions
$permEdit = $permissionsHandler->getPermGlobalSubmit();
$GLOBALS['xoopsTpl']->assign('permEdit', $permEdit);
$GLOBALS['xoopsTpl']->assign('showItem', $guId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPUSERS_LIST];
		$crGroupusers = new \CriteriaCompo();
		if ($guId > 0) {
			$crGroupusers->add(new \Criteria('gu_id', $guId));
		}
		$groupusersCount = $groupusersHandler->getCount($crGroupusers);
		$GLOBALS['xoopsTpl']->assign('groupusersCount', $groupusersCount);
		$crGroupusers->setStart($start);
		$crGroupusers->setLimit($limit);
		$groupusersAll = $groupusersHandler->getAll($crGroupusers);
		if ($groupusersCount > 0) {
			$groupusers = [];
			$guGroupid = '';
			// Get All Groupusers
			foreach (\array_keys($groupusersAll) as $i) {
				$groupusers[$i] = $groupusersAll[$i]->getValuesGroupusers();
				$guGroupid = $groupusersAll[$i]->getVar('gu_groupid');
				$keywords[$i] = $guGroupid;
			}
			$GLOBALS['xoopsTpl']->assign('groupusers', $groupusers);
			unset($groupusers);
			// Display Navigation
			if ($groupusersCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($groupusersCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
			if ('show' == $op && '' != $guGroupid) {
				$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($guGroupid . ' - ' . $GLOBALS['xoopsModule']->getVar('name')));
			}
		}
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('groupusers.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groupusers.php?op=list', 3, _NOPERM);
		}
		if ($guId > 0) {
			$groupusersObj = $groupusersHandler->get($guId);
		} else {
			$groupusersObj = $groupusersHandler->create();
		}
		$groupusersObj->setVar('gu_groupid', Request::getInt('gu_groupid', 0));
		$groupusersObj->setVar('gu_uid', Request::getInt('gu_uid', 0));
		$groupuserDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('gu_datecreated'));
		$groupusersObj->setVar('gu_datecreated', $groupuserDatecreatedObj->getTimestamp());
		$groupusersObj->setVar('gu_submitter', Request::getInt('gu_submitter', 0));
		// Insert Data
		if ($groupusersHandler->insert($groupusersObj)) {
			$grouppermHandler = \xoops_getHandler('groupperm');
			$mid = $GLOBALS['xoopsModule']->getVar('mid');
			// Permission to view_groupusers
			$grouppermHandler->deleteByModule($mid, 'wgdiaries_view_groupusers', $newGuId);
			if (isset($_POST['groups_view_groupusers'])) {
				foreach ($_POST['groups_view_groupusers'] as $onegroupId) {
					$grouppermHandler->addRight('wgdiaries_view_groupusers', $newGuId, $onegroupId, $mid);
				}
			}
			// Permission to submit_groupusers
			$grouppermHandler->deleteByModule($mid, 'wgdiaries_submit_groupusers', $newGuId);
			if (isset($_POST['groups_submit_groupusers'])) {
				foreach ($_POST['groups_submit_groupusers'] as $onegroupId) {
					$grouppermHandler->addRight('wgdiaries_submit_groupusers', $newGuId, $onegroupId, $mid);
				}
			}
			// Permission to approve_groupusers
			$grouppermHandler->deleteByModule($mid, 'wgdiaries_approve_groupusers', $newGuId);
			if (isset($_POST['groups_approve_groupusers'])) {
				foreach ($_POST['groups_approve_groupusers'] as $onegroupId) {
					$grouppermHandler->addRight('wgdiaries_approve_groupusers', $newGuId, $onegroupId, $mid);
				}
			}
			// redirect after insert
			\redirect_header('groupusers.php', 2, _MA_WGDIARIES_FORM_OK);
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $groupusersObj->getHtmlErrors());
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'new':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPUSER_ADD];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groupusers.php?op=list', 3, _NOPERM);
		}
		// Form Create
		$groupusersObj = $groupusersHandler->create();
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPUSER_EDIT];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groupusers.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $guId) {
			\redirect_header('groupusers.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		// Get Form
		$groupusersObj = $groupusersHandler->get($guId);
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPUSER_DELETE];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groupusers.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $guId) {
			\redirect_header('groupusers.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
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

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgdiariesMetaDescription(_MA_WGDIARIES_GROUPUSERS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/groupusers.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);

require __DIR__ . '/footer.php';
