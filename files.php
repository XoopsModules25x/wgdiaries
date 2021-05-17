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
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_files.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$fileId = Request::getInt('file_id', 0);

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
$GLOBALS['xoopsTpl']->assign('showItem', $fileId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_FILES_LIST];
		$crFiles = new \CriteriaCompo();
		if ($fileId > 0) {
			$crFiles->add(new \Criteria('file_id', $fileId));
		}
		$filesCount = $filesHandler->getCount($crFiles);
		$GLOBALS['xoopsTpl']->assign('filesCount', $filesCount);
		$crFiles->setStart($start);
		$crFiles->setLimit($limit);
		$filesAll = $filesHandler->getAll($crFiles);
		if ($filesCount > 0) {
			$files = [];
			$fileItemid = '';
			// Get All Files
			foreach (\array_keys($filesAll) as $i) {
				$files[$i] = $filesAll[$i]->getValuesFiles();
				$fileItemid = $filesAll[$i]->getVar('file_itemid');
				$keywords[$i] = $fileItemid;
			}
			$GLOBALS['xoopsTpl']->assign('files', $files);
			unset($files);
			// Display Navigation
			if ($filesCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($filesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
			if ('show' == $op && '' != $fileItemid) {
				$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($fileItemid . ' - ' . $GLOBALS['xoopsModule']->getVar('name')));
			}
		}
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('files.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('files.php?op=list', 3, _NOPERM);
		}
		if ($fileId > 0) {
			$filesObj = $filesHandler->get($fileId);
		} else {
			$filesObj = $filesHandler->create();
		}
		$filesObj->setVar('file_itemid', Request::getInt('file_itemid', 0));
		$filesObj->setVar('file_desc', Request::getString('file_desc', ''));
		// Set Var file_name
		include_once XOOPS_ROOT_PATH . '/class/uploader.php';
		$filename       = $_FILES['file_name']['name'];
		$imgNameDef     = Request::getString('file_itemid');
		$uploader = new \XoopsMediaUploader(WGDIARIES_UPLOAD_FILES_PATH . '/files/', 
													$helper->getConfig('mimetypes_file'), 
													$helper->getConfig('maxsize_file'), null, null);
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			$extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);
			$imgName = \str_replace(' ', '', $imgNameDef) . '.' . $extension;
			$uploader->setPrefix($imgName);
			$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
			if (!$uploader->upload()) {
				$errors = $uploader->getErrors();
			} else {
				$filesObj->setVar('file_name', $uploader->getSavedFileName());
			}
		} else {
			if ($filename > '') {
				$uploaderErrors = $uploader->getErrors();
			}
			$filesObj->setVar('file_name', Request::getString('file_name'));
		}
		$fileDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('file_datecreated'));
		$filesObj->setVar('file_datecreated', $fileDatecreatedObj->getTimestamp());
		$filesObj->setVar('file_submitter', Request::getInt('file_submitter', 0));
		// Insert Data
		if ($filesHandler->insert($filesObj)) {
			// redirect after insert
			if ('' !== $uploaderErrors) {
				\redirect_header('files.php?op=edit&file_id=' . $newFileId, 5, $uploaderErrors);
			} else {
				\redirect_header('files.php?op=list', 2, _MA_WGDIARIES_FORM_OK);
			}
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'new':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_FILE_ADD];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('files.php?op=list', 3, _NOPERM);
		}
		// Form Create
		$filesObj = $filesHandler->create();
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_FILE_EDIT];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('files.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $fileId) {
			\redirect_header('files.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		// Get Form
		$filesObj = $filesHandler->get($fileId);
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_FILE_DELETE];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('files.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $fileId) {
			\redirect_header('files.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		$filesObj = $filesHandler->get($fileId);
		$fileItemid = $filesObj->getVar('file_itemid');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('files.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($filesHandler->delete($filesObj)) {
				\redirect_header('files.php', 3, _MA_WGDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'file_id' => $fileId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_MA_WGDIARIES_FORM_SURE_DELETE, $filesObj->getVar('file_itemid')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgdiariesMetaDescription(_MA_WGDIARIES_FILES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/files.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);

require __DIR__ . '/footer.php';
