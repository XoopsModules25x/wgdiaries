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
if (Request::hasVar('save_add')) {
    $op ='save_add';
}
$fileId = Request::getInt('file_id');
$itemId = Request::getInt('item_id');

switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgdiaries_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_ADD_FILE, 'files.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $filesCount = $filesHandler->getCountFiles();
        $filesAll = $filesHandler->getAllFiles($start, $limit);
        $GLOBALS['xoopsTpl']->assign('files_count', $filesCount);
        $GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
        $GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', \WGDIARIES_UPLOAD_URL);
        // Table view files
        if ($filesCount > 0) {
            foreach (\array_keys($filesAll) as $i) {
                $file = $filesAll[$i]->getValuesFiles();
                $GLOBALS['xoopsTpl']->append('files_list', $file);
                unset($file);
            }
            // Display Navigation
            if ($filesCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($filesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGDIARIES_THEREARENT_FILES);
        }
        break;
    case 'new':
        $templateMain = 'wgdiaries_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_LIST_FILES, 'files.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $filesObj = $filesHandler->create();
        $form = $filesObj->getFormFiles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
    case 'save_add':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('files.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($fileId > 0) {
            $filesObj = $filesHandler->get($fileId);
        } else {
            $filesObj = $filesHandler->create();
        }
        // Set Vars
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
                $imgName = \preg_replace("/[^a-zA-Z0-9]+/", "_", $name) . '_';
                $uploader->setPrefix($imgName);
                $uploader->fetchMedia($_POST['xoops_upload_file'][0]);
                if (!$uploader->upload()) {
                    $errors = $uploader->getErrors();
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
            if ('' !== $uploaderErrors) {
                \redirect_header('files.php?op=edit&file_id=' . $fileId, 5, $uploaderErrors);
            } else {
                if ('save_add' == $op) {
                    \redirect_header('files.php?op=new&amp;item_id=' . $itemId, 2, \_MA_WGDIARIES_FORM_OK);
                } else {
                    \redirect_header('files.php?op=list#itemId_' . $itemId, 2, \_MA_WGDIARIES_FORM_OK);
                }
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
        $form = $filesObj->getFormFiles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgdiaries_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_ADD_FILE, 'files.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGDIARIES_LIST_FILES, 'files.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $filesObj = $filesHandler->get($fileId);
        $form = $filesObj->getFormFiles();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgdiaries_admin_files.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
        $filesObj = $filesHandler->get($fileId);
        $fileItemid = $filesObj->getVar('file_itemid');
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('files.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($filesHandler->delete($filesObj)) {
                \redirect_header('files.php', 3, \_MA_WGDIARIES_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'file_id' => $fileId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGDIARIES_FORM_SURE_DELETE, $filesObj->getVar('file_itemid')));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
