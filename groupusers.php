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
$GLOBALS['xoopsTpl']->assign('showItem', $guId > 0);

switch ($op) {
	case 'show':
	case 'list':
	default:

	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('groupusers.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('groupusers.php?op=list', 3, _NOPERM);
		}

        // delete existing links
        $groupusersHandler = $helper->getHandler('Groupusers');
        $crGroupusers = new \CriteriaCompo();
        $crGroupusers->add(new \Criteria('gu_groupid', $grpId));
        if (!$groupusersHandler->deleteAll($crGroupusers)) {
            \redirect_header('groups.php', 3, _MA_WGDIARIES_FORM_ERROR_DELETE);
        }
        // add selected uids
        $guUids = Request::getArray('gu_uids');
        $guDatecreated = Request::getInt('gu_datecreated');
        $guSubmitter = Request::getInt('gu_submitter');
        $success = 0;
        $errors = 0;
        foreach ($guUids as $guUid) {
            $groupusersObj = $groupusersHandler->create();
            $groupusersObj->setVar('gu_groupid', $grpId);
            $groupusersObj->setVar('gu_uid', $guUid);
            $groupuserDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('gu_datecreated'));
            $groupusersObj->setVar('gu_datecreated', $guDatecreated);
            $groupusersObj->setVar('gu_submitter', $guSubmitter);
            // Insert Data
            if ($groupusersHandler->insert($groupusersObj)) {
                $success++;
            } else {
                $errors++;
            }
            unset($groupusersObj);
        }
        // redirect after insert
        \redirect_header('groups.php', 2, _MA_WGDIARIES_FORM_OK);
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', $groupusersObj->getHtmlErrors());
		$form = $groupusersObj->getFormGroupusers();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;

	case 'edit':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPUSERS_EDIT];
		// Check permissions
		if (!$permissionsHandler->getPermGroupsEdit()) {
			\redirect_header('groupusers.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $grpId) {
			\redirect_header('groupusers.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		// Get Form
        $form = $groupusersHandler->getFormSelectGroupusers($grpId);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_GROUPUSERS_DELETE];
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
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/groupusers.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);

require __DIR__ . '/footer.php';
