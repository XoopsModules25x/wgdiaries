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
// Request grp_id
$grpId = Request::getInt('grp_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wgdiaries_admin_groups.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groups.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_ADD_GROUP, 'groups.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$groupsCount = $groupsHandler->getCountGroups();
		$groupsAll = $groupsHandler->getAllGroups($start, $limit);
		$GLOBALS['xoopsTpl']->assign('groups_count', $groupsCount);
		$GLOBALS['xoopsTpl']->assign('wgdiaries_url', WGDIARIES_URL);
		$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);
		// Table view groups
		if ($groupsCount > 0) {
			foreach (\array_keys($groupsAll) as $i) {
				$group = $groupsAll[$i]->getValuesGroups();
				$GLOBALS['xoopsTpl']->append('groups_list', $group);
				unset($group);
			}
			// Display Navigation
			if ($groupsCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($groupsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGDIARIES_THEREARENT_GROUPS);
		}
		break;
	case 'new':
		$templateMain = 'wgdiaries_admin_groups.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groups.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_GROUPS_LIST, 'groups.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$groupsObj = $groupsHandler->create();
		$form = $groupsObj->getFormGroups();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('groups.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($grpId > 0) {
			$groupsObj = $groupsHandler->get($grpId);
		} else {
			$groupsObj = $groupsHandler->create();
		}
		// Set Vars
		$groupsObj->setVar('grp_name', Request::getString('grp_name', ''));
		// Set Var grp_logo
		include_once XOOPS_ROOT_PATH . '/class/uploader.php';
		$filename       = $_FILES['grp_logo']['name'];
		$imgMimetype    = $_FILES['grp_logo']['type'];
		$imgNameDef     = Request::getString('grp_name');
		$uploaderErrors = '';
		$uploader = new \XoopsMediaUploader(WGDIARIES_UPLOAD_IMAGE_PATH . '/',
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
			if ('' !== $uploaderErrors) {
				\redirect_header('groups.php?op=edit&grp_id=' . $grpId, 5, $uploaderErrors);
			} else {
				\redirect_header('groups.php?op=list', 2, _AM_WGDIARIES_FORM_OK);
			}
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $groupsObj->getHtmlErrors());
		$form = $groupsObj->getFormGroups();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wgdiaries_admin_groups.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groups.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_ADD_GROUP, 'groups.php?op=new', 'add');
		$adminObject->addItemButton(_AM_WGDIARIES_GROUPS_LIST, 'groups.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$groupsObj = $groupsHandler->get($grpId);
		$form = $groupsObj->getFormGroups();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgdiaries_admin_groups.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('groups.php'));
		$groupsObj = $groupsHandler->get($grpId);
		$grpName = $groupsObj->getVar('grp_name');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('groups.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($groupsHandler->delete($groupsObj)) {
				\redirect_header('groups.php', 3, _AM_WGDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $groupsObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'grp_id' => $grpId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_AM_WGDIARIES_FORM_SURE_DELETE, $groupsObj->getVar('grp_name')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
