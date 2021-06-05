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
require_once \XOOPS_ROOT_PATH . '/header.php';

if (!$permissionsHandler->getPermItemsSubmit()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

$op    = Request::getCmd('op', 'list');
$start = Request::getInt('start', 0);
$limit = Request::getInt('limit', $helper->getConfig('userpager'));
$fileId = Request::getInt('file_id', 0);
$itemId = Request::getInt('item_id', 0);
$redir  = Request::getString('redir', '');
if (Request::hasVar('save_add')) {
    $op ='save_add';
}

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_uploadfileurl', \WGDIARIES_UPLOAD_FILES_URL . '/');
$GLOBALS['xoopsTpl']->assign('wgdiaries_fileiconurl', \WGDIARIES_ICONS_URL . '/files/');

// Keywords
$keywords = [];
// Permissions: user must have perm to edit item
$itemsObj = $itemsHandler->get($itemId);
$permEdit = $permissionsHandler->getPermItemsEdit($itemsObj->getVar('item_submitter'));
$GLOBALS['xoopsTpl']->assign('permEdit', $permEdit);
unset($itemsObj);
$GLOBALS['xoopsTpl']->assign('showItem', $fileId > 0);
$GLOBALS['xoopsTpl']->assign('itemId', $itemId);

switch ($op) {
    case 'show':
    case 'list':
    default:
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_FILES_LIST];
        $GLOBALS['xoopsTpl']->assign('showList', true);
        $crFiles = new \CriteriaCompo();
        if ($fileId > 0) {
            $crFiles->add(new \Criteria('file_id', $fileId));
        }
        $crFiles->add(new \Criteria('file_itemid', $itemId));
        $filesCount = $filesHandler->getCount($crFiles);
        $GLOBALS['xoopsTpl']->assign('filesCount', $filesCount);
        if ($filesCount > 0) {
            $crFiles->setStart($start);
            $crFiles->setLimit($limit);
            $filesAll = $filesHandler->getAll($crFiles);
            $files = [];
            $fileItemid = '';
            $itemCaption = '';
            // Get All Files
            foreach (\array_keys($filesAll) as $i) {
                $files[$i] = $filesAll[$i]->getValuesFiles();
                $fileItemid = $filesAll[$i]->getVar('file_itemid');
                $itemCaption = $files[$i]['caption'];
                $keywords[$i] = $itemCaption;
            }
            $GLOBALS['xoopsTpl']->assign('files', $files);
            $GLOBALS['xoopsTpl']->assign('itemCaption', $itemCaption);
            unset($files);
            // Display Navigation
            if ($filesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($filesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
            $GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
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
        if (!$permEdit) {
            \redirect_header('files.php?op=list', 3, \_NOPERM);
        }
        if ($fileId > 0) {
            $filesObj = $filesHandler->get($fileId);
        } else {
            $filesObj = $filesHandler->create();
        }
        $filesObj->setVar('file_itemid', Request::getInt('file_itemid', 0));
        $filesObj->setVar('file_desc', Request::getString('file_desc', ''));
        // Set Var file_name
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploaderErrors = '';
        $filename     = (string) $_FILES['file_name']['name'];
        if ( '' !== $filename) {
            //upload new file
            $fileMimetype = $_FILES['file_name']['type'];
            $imgNameDef = 'itemid_' . Request::getString('file_itemid');
            $uploader = new \XoopsMediaUploader(\WGDIARIES_UPLOAD_FILES_PATH . '/',
                $helper->getConfig('mimetypes_file'),
                $helper->getConfig('maxsize_file'), null, null);
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                $name = \substr($filename, 0, (\strlen ($filename)) - (\strlen (\strrchr($filename,'.'))));
                $imgName = \preg_replace('/[^a-zA-Z0-9]+/', '_', $name) . '_';
                $uploader->setPrefix($imgName);
                $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                if (!$uploader->upload()) {
                    $uploaderErrors = $uploader->getErrors();
                } else {
                    $filesObj->setVar('file_name', $uploader->getSavedFileName());
                    $filesObj->setVar('file_mimetype', $fileMimetype);
                }
            } else {
                if ($filename > '') {
                    $uploaderErrors = $uploader->getErrors();
                }
                $filesObj->setVar('file_name', Request::getString('file_name'));
            }
        }
        $fileDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('file_datecreated'));
        $filesObj->setVar('file_datecreated', $fileDatecreatedObj->getTimestamp());
        $filesObj->setVar('file_submitter', Request::getInt('file_submitter', 0));
        // Insert Data
        if ($filesHandler->insert($filesObj)) {
            $newFileId = $fileId > 0 ? $fileId : $filesObj->getNewInsertedIdFiles();
            // redirect after insert
            if ('' !== $uploaderErrors) {
                \redirect_header('files.php?op=edit&amp;file_id=' . $newFileId, 5, $uploaderErrors);
            } else {
                if ('save_add' == $op) {
                    \redirect_header('files.php?op=new&amp;item_id=' . $itemId, 2, \_MA_WGDIARIES_FORM_OK);
                } else {
                    \redirect_header('files.php?op=list&amp;item_id=' . $itemId, 2, \_MA_WGDIARIES_FORM_OK);
                }
            }
        }
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
        $form = $filesObj->getFormFiles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_FILE_ADD];
        // Check permissions
        if (!$permEdit) {
            \redirect_header('files.php?op=list', 3, \_NOPERM);
        }
        // Form Create
        $filesObj = $filesHandler->create();
        $filesObj->setVar('file_itemid', $itemId);
        $form = $filesObj->getFormFiles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_FILE_EDIT];
        // Check permissions
        if (!$permEdit) {
            \redirect_header('files.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 == $fileId) {
            \redirect_header('files.php?op=list', 3, \_MA_WGDIARIES_INVALID_PARAM);
        }
        // Get Form
        $filesObj = $filesHandler->get($fileId);
        $form = $filesObj->getFormFiles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_FILE_DELETE];
        // Check permissions
        if (!$permEdit) {
            \redirect_header('files.php?op=list', 3, \_NOPERM);
        }
        // Check params
        if (0 == $fileId) {
            \redirect_header('files.php?op=list', 3, \_MA_WGDIARIES_INVALID_PARAM);
        }
        $filesObj = $filesHandler->get($fileId);
        $fileItemid = $filesObj->getVar('file_itemid');
        $fileName = \WGDIARIES_UPLOAD_FILES_PATH . '/' . $filesObj->getVar('file_name');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('files.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($filesHandler->delete($filesObj)) {
                if (\file_exists($fileName)) {
                    \unlink($fileName);
                }
                \redirect_header('files.php?op=list&amp;item_id=' . $fileItemid, 3, \_MA_WGDIARIES_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'file_id' => $fileId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGDIARIES_FORM_SURE_DELETE, $filesObj->getVar('file_name')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgdiariesMetaDescription(\_MA_WGDIARIES_FILES_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/files.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', \WGDIARIES_UPLOAD_URL);

require __DIR__ . '/footer.php';
