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
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_groups.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$grpId = Request::getInt('grp_id', 0);

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
$GLOBALS['xoopsTpl']->assign('showItem', $grpId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPS_LIST];
		$crGroups = new \CriteriaCompo();
		if ($grpId > 0) {
			$crGroups->add(new \Criteria('grp_id', $grpId));
		}
		$groupsCount = $groupsHandler->getCount($crGroups);
		$GLOBALS['xoopsTpl']->assign('groupsCount', $groupsCount);
		$crGroups->setStart($start);
		$crGroups->setLimit($limit);
		$groupsAll = $groupsHandler->getAll($crGroups);
		if ($groupsCount > 0) {
			$groups = [];
			$grpName = '';
			// Get All Groups
			foreach (\array_keys($groupsAll) as $i) {
				$groups[$i] = $groupsAll[$i]->getValuesGroups();
				$grpName = $groupsAll[$i]->getVar('grp_name');
				$keywords[$i] = $grpName;
			}
			$GLOBALS['xoopsTpl']->assign('groups', $groups);
			unset($groups);
			// Display Navigation
			if ($groupsCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($groupsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
			if ('show' == $op && '' != $grpName) {
				$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($grpName . ' - ' . $GLOBALS['xoopsModule']->getVar('name')));
			}
		}
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('groups.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groups.php?op=list', 3, _NOPERM);
		}
		if ($grpId > 0) {
			$groupsObj = $groupsHandler->get($grpId);
		} else {
			$groupsObj = $groupsHandler->create();
		}
		$groupsObj->setVar('grp_name', Request::getString('grp_name', ''));
		// Set Var grp_logo
		include_once XOOPS_ROOT_PATH . '/class/uploader.php';
		$filename       = $_FILES['grp_logo']['name'];
		$imgMimetype    = $_FILES['grp_logo']['type'];
		$imgNameDef     = Request::getString('grp_name');
		$uploaderErrors = '';
		$uploader = new \XoopsMediaUploader(WGDIARIES_UPLOAD_IMAGE_PATH . '/groups/',
													$helper->getConfig('mimetypes_image'), 
													$helper->getConfig('maxsize_image'), null, null);
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			$extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);
			$imgName = \str_replace(' ', '', $imgNameDef) . '.' . $extension;
			$uploader->setPrefix($imgName);
			$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
			if (!$uploader->upload()) {
				$uploaderErrors = $uploader->getErrors();
			} else {
				$savedFilename = $uploader->getSavedFileName();
				$maxwidth  = (int)$helper->getConfig('maxwidth_image');
				$maxheight = (int)$helper->getConfig('maxheight_image');
				if ($maxwidth > 0 && $maxheight > 0) {
					// Resize image
					$imgHandler                = new Wgdiaries\Common\Resizer();
					$imgHandler->sourceFile    = WGDIARIES_UPLOAD_IMAGE_PATH . '/groups/' . $savedFilename;
					$imgHandler->endFile       = WGDIARIES_UPLOAD_IMAGE_PATH . '/groups/' . $savedFilename;
					$imgHandler->imageMimetype = $imgMimetype;
					$imgHandler->maxWidth      = $maxwidth;
					$imgHandler->maxHeight     = $maxheight;
					$result                    = $imgHandler->resizeImage();
				}
				$groupsObj->setVar('grp_logo', $savedFilename);
			}
		} else {
			if ($filename > '') {
				$uploaderErrors = $uploader->getErrors();
			}
			$groupsObj->setVar('grp_logo', Request::getString('grp_logo'));
		}
		$groupsObj->setVar('grp_online', Request::getInt('grp_online', 0));
		$groupDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('grp_datecreated'));
		$groupsObj->setVar('grp_datecreated', $groupDatecreatedObj->getTimestamp());
		$groupsObj->setVar('grp_submitter', Request::getInt('grp_submitter', 0));
		// Insert Data
		if ($groupsHandler->insert($groupsObj)) {
			// redirect after insert
			if ('' !== $uploaderErrors) {
				\redirect_header('groups.php?op=edit&grp_id=' . $newGrpId, 5, $uploaderErrors);
			} else {
				\redirect_header('groups.php?op=list', 2, _MA_WGDIARIES_FORM_OK);
			}
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $groupsObj->getHtmlErrors());
		$form = $groupsObj->getFormGroups();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'new':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUP_ADD];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groups.php?op=list', 3, _NOPERM);
		}
		// Form Create
		$groupsObj = $groupsHandler->create();
		$form = $groupsObj->getFormGroups();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUP_EDIT];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groups.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $grpId) {
			\redirect_header('groups.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		// Get Form
		$groupsObj = $groupsHandler->get($grpId);
		$form = $groupsObj->getFormGroups();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUP_DELETE];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groups.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $grpId) {
			\redirect_header('groups.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		$groupsObj = $groupsHandler->get($grpId);
		$grpName = $groupsObj->getVar('grp_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('groups.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($groupsHandler->delete($groupsObj)) {
				\redirect_header('groups.php', 3, _MA_WGDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $groupsObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'grp_id' => $grpId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_MA_WGDIARIES_FORM_SURE_DELETE, $groupsObj->getVar('grp_name')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgdiariesMetaDescription(_MA_WGDIARIES_GROUPS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/groups.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);

require __DIR__ . '/footer.php';
