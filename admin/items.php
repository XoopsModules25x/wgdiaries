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
// Request item_id
$itemId = Request::getInt('item_id');
switch ($op) {
    case 'list':
    default:
        // Define Stylesheet
        $GLOBALS['xoTheme']->addStylesheet($style, null);
        $GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', $helper->getConfig('adminpager'));
        $templateMain = 'wgdiaries_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_ADD_ITEM, 'items.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        $itemsCount = $itemsHandler->getCountItems();
        $itemsAll = $itemsHandler->getAllItems($start, $limit);
        $GLOBALS['xoopsTpl']->assign('items_count', $itemsCount);
        $GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
        $GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', \WGDIARIES_UPLOAD_URL);
        $GLOBALS['xoopsTpl']->assign('wgdiaries_upload_itemsurl', \WGDIARIES_UPLOAD_ITEMS_URL);
        // Table view items
        if ($itemsCount > 0) {
            foreach (\array_keys($itemsAll) as $i) {
                $item = $itemsAll[$i]->getValuesItems();
                $GLOBALS['xoopsTpl']->append('items_list', $item);
                unset($item);
            }
            // Display Navigation
            if ($itemsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
        } else {
            $GLOBALS['xoopsTpl']->assign('error', \_AM_WGDIARIES_THEREARENT_ITEMS);
        }
        break;
    case 'new':
        $templateMain = 'wgdiaries_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_LIST_ITEMS, 'items.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $itemsObj = $itemsHandler->create();
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'clone':
        $templateMain = 'wgdiaries_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_LIST_ITEMS, 'items.php', 'list');
        $adminObject->addItemButton(\_AM_WGDIARIES_ADD_ITEM, 'items.php?op=new', 'add');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Form Create
        $itemIdsource = Request::getInt('item_id_source');
        $itemsObjSource = $itemsHandler->get($itemIdsource);
        $itemsObj = $itemsObjSource->xoopsClone();
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'save':
        // Security Check
        if (!$GLOBALS['xoopsSecurity']->check()) {
            \redirect_header('items.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if ($itemId > 0) {
            $itemsObj = $itemsHandler->get($itemId);
        } else {
            $itemsObj = $itemsHandler->create();
        }
        // Set Vars
        $itemsObj->setVar('item_groupid', Request::getInt('item_groupid', 0));
        $itemsObj->setVar('item_name', Request::getString('item_name', ''));
        $itemsObj->setVar('item_remarks', Request::getText('item_remarks', ''));
        $itemDatefromArr = Request::getArray('item_datefrom');
        $itemDatefromObj = \DateTime::createFromFormat(\_SHORTDATESTRING, $itemDatefromArr['date']);
        $itemDatefromObj->setTime(0, 0, 0);
        $itemDatefrom = $itemDatefromObj->getTimestamp() + (int)$itemDatefromArr['time'];
        $itemsObj->setVar('item_datefrom', $itemDatefrom);
        $itemDatetoArr = Request::getArray('item_dateto');
        $itemDatetoObj = \DateTime::createFromFormat(\_SHORTDATESTRING, $itemDatetoArr['date']);
        $itemDatetoObj->setTime(0, 0, 0);
        $itemDateto = $itemDatetoObj->getTimestamp() + (int)$itemDatetoArr['time'];
        $itemsObj->setVar('item_dateto', $itemDateto);
        $itemsObj->setVar('item_catid', Request::getInt('item_catid', 0));
        $itemsObj->setVar('item_tags', Request::getString('item_tags', ''));
        // Set Var item_logo
        require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
        $filename       = $_FILES['item_logo']['name'];
        $imgMimetype    = $_FILES['item_logo']['type'];
        $uploaderErrors = '';
        $uploader = new \XoopsMediaUploader(\WGDIARIES_UPLOAD_ITEMS_PATH . '/logos/',
            $helper->getConfig('mimetypes_image'),
            $helper->getConfig('maxsize_image'), null, null);
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            $name = \substr($filename, 0, (\strlen ($filename)) - (\strlen (\strrchr($filename,'.'))));
            $imgName = \preg_replace('/[^a-zA-Z0-9]+/', '_', $name) . '_';
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
                    $imgHandler->sourceFile    = \WGDIARIES_UPLOAD_ITEMS_PATH . '/logos/' . $savedFilename;
                    $imgHandler->endFile       = \WGDIARIES_UPLOAD_ITEMS_PATH . '/logos/' . $savedFilename;
                    $imgHandler->imageMimetype = $imgMimetype;
                    $imgHandler->maxWidth      = $maxwidth;
                    $imgHandler->maxHeight     = $maxheight;
                    $result                    = $imgHandler->resizeImage();
                }
                $itemsObj->setVar('item_logo', $savedFilename);
            }
        } else {
            if ($filename > '') {
                $uploaderErrors = $uploader->getErrors();
            }
            $itemsObj->setVar('item_logo', Request::getString('item_logo'));
        }
        $itemsObj->setVar('item_comments', Request::getInt('item_comments', 0));
        $itemDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('item_datecreated'));
        $itemsObj->setVar('item_datecreated', $itemDatecreatedObj->getTimestamp());
        $itemsObj->setVar('item_submitter', Request::getInt('item_submitter', 0));
        // Insert Data
        if ($itemsHandler->insert($itemsObj)) {
            $newItemId = $itemId > 0 ? $itemId : $itemsObj->getNewInsertedIdItems();
            require_once \XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaderFiles  = [];
            $uploaderErrors = [];
            for ($i = 0; $i <= $helper->getConfig('max_fileuploads'); $i++) {
                //upload of single file
                $filename     = $_FILES['item_file' . $i]['name'];
                $fileMimetype = $_FILES['item_file' . $i]['type'];
                $uploader = new \XoopsMediaUploader(\WGDIARIES_UPLOAD_FILES_PATH . '/',
                    $helper->getConfig('mimetypes_file'),
                    $helper->getConfig('maxsize_file'), null, null);
                if ($uploader->fetchMedia($_POST['xoops_upload_file'][$i + 1])) {
                    $name = \substr($filename, 0, (\strlen ($filename)) - (\strlen (\strrchr($filename,'.'))));
                    $imgName = \preg_replace('/[^a-zA-Z0-9]+/', '_', $name) . '_';
                    $uploader->setPrefix($imgName);
                    $uploader->fetchMedia($_POST['xoops_upload_file'][$i + 1]);
                    if (!$uploader->upload()) {
                        $uploaderErrors[] = $uploader->getErrors();
                    } else {
                        $uploaderFiles[] = ['name' => $uploader->getSavedFileName(), 'type'=> $fileMimetype];
                    }
                } else {
                    if ($filename > '') {
                        $uploaderErrors[] = $uploader->getErrors();
                    } else {
                        break; // no more files - exit loop
                    }
                }
            }
            foreach ($uploaderFiles as $file) {
                $filesObj = $filesHandler->create();
                $filesObj->setVar('file_itemid', $newItemId);
                //TODO: add additional field for name in form
                $filesObj->setVar('file_desc', Request::getString('file_desc', ''));
                $filesObj->setVar('file_name', $file['name']);
                $filesObj->setVar('file_mimetype', $file['type']);
                $fileDatecreatedObj = \DateTime::createFromFormat(\_SHORTDATESTRING, Request::getString('item_datecreated'));
                $filesObj->setVar('file_datecreated', $fileDatecreatedObj->getTimestamp());
                $filesObj->setVar('file_submitter', Request::getInt('item_submitter', 0));
                if (!$filesHandler->insert($filesObj)) {
                    $uploaderErrors[] = $filesObj->getErrors();
                }
            }
            // redirect after insert
            if (0 == \count($uploaderErrors)) {
                \redirect_header('items.php?op=show&amp;item_id=' . $newItemId, 2, \_MA_WGDIARIES_FORM_OK);
            }
        }
        // Get Form
        $GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        $templateMain = 'wgdiaries_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $adminObject->addItemButton(\_AM_WGDIARIES_ADD_ITEM, 'items.php?op=new', 'add');
        $adminObject->addItemButton(\_AM_WGDIARIES_LIST_ITEMS, 'items.php', 'list');
        $GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
        // Get Form
        $itemsObj = $itemsHandler->get($itemId);
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        $templateMain = 'wgdiaries_admin_items.tpl';
        $GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
        $itemsObj = $itemsHandler->get($itemId);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                \redirect_header('items.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($itemsHandler->delete($itemsObj)) {
                \redirect_header('items.php', 3, \_MA_WGDIARIES_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
            }
        } else {
            $customConfirm = new Common\Confirm(
                ['ok' => 1, 'item_id' => $itemId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGDIARIES_FORM_SURE_DELETE, $itemsObj->getVar('item_name')));
            $form = $customConfirm->getFormConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}
require __DIR__ . '/footer.php';
