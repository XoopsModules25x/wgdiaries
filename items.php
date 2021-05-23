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
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_items.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$op      = Request::getCmd('op', 'list');
$start   = Request::getInt('start', 0);
$limit   = Request::getInt('limit', $helper->getConfig('userpager'));
$itemId  = Request::getInt('item_id', 0);

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', WGDIARIES_URL);
// Keywords
$keywords = [];
// Breadcrumbs
$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_INDEX, 'link' => 'index.php'];

$GLOBALS['xoopsTpl']->assign('showItem', $itemId > 0);

switch ($op) {
	case 'show':
	case 'list':
    case 'listown':
	default:
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_ITEMS_LIST];

        if ('show' == $op) {
            $GLOBALS['xoopsTpl']->assign('itemsTitle', \_MA_WGDIARIES_ITEM_DETAILS);
        } else {
            $GLOBALS['xoopsTpl']->assign('itemsTitle', \_MA_WGDIARIES_ITEMS_LISTMY);
        }
        $uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
		$crItems = new \CriteriaCompo();
		if ($itemId > 0) {
			$crItems->add(new \Criteria('item_id', $itemId));
		}
        $crItems->add(new \Criteria('item_submitter', $uid));
		$itemsCount = $itemsHandler->getCount($crItems);
		$GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
		if ($itemsCount > 0) {
            $crItems->setStart($start);
            $crItems->setLimit($limit);
            $itemsAll = $itemsHandler->getAll($crItems);

            $GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
			$items = [];
			$itemSubmitter = '';
            $itemCaption  = '';
			// Get All Items
			foreach (\array_keys($itemsAll) as $i) {
				$item = $itemsAll[$i]->getValuesItems();
                $itemSubmitter = $item['item_submitter'];
                $itemCaption   = $itemsAll[$i]->getCaption('single');
                // Permissions
                $item['permEdit'] = $permissionsHandler->getPermItemsEdit($itemSubmitter);
                if ('show' == $op) {
                    $crFiles = new \CriteriaCompo();
                    $crFiles->add(new \Criteria('file_itemid', $i));
                    $filesCount = $filesHandler->getCount($crFiles);
                    if ($filesCount > 0) {
                        $crFiles->setStart($start);
                        $crFiles->setLimit($limit);
                        $filesAll = $filesHandler->getAll($crFiles);
                        $files = [];
                        // Get All Files
                        foreach (\array_keys($filesAll) as $j) {
                            $files[$j] = $filesAll[$j]->getValuesFiles();
                        }
                        $item['files'] = $files;
                        $item['moreFiles'] = ($filesCount > $limit);
                    }
                }
                $items[$i] = $item;
			}
			$GLOBALS['xoopsTpl']->assign('items', $items);
			unset($items);
			// Display Navigation
			if ($itemsCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
			$GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
			$GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
			$GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
			$GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
            $GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
            if (1 == $itemsCount) {
                $GLOBALS['xoopsTpl']->assign('permItemsComment', $permissionsHandler->getPermItemsComEdit($itemSubmitter));
            }
			if ('show' == $op && '' != $itemSubmitter) {
				$GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $itemCaption);
			}
		}
		break;
    case 'listgroup':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_ITEMS_LIST];

        $uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;
        $crItems = new \CriteriaCompo();
        $crItems->add(new \Criteria('item_submitter', $uid, '<>'));
        $memberHandler = \xoops_getHandler('member');
        $xoopsGroups = $memberHandler->getGroupList();
        $myGroups = array_keys($xoopsGroups);
        $crItems->add(new \Criteria('item_groupid', "(" . implode(',', $myGroups) . ")", 'IN'));
        $itemsCount = $itemsHandler->getCount($crItems);
        $GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
        $crItems->setStart($start);
        $crItems->setLimit($limit);
        $itemsAll = $itemsHandler->getAll($crItems);
        if ($itemsCount > 0) {
            $GLOBALS['xoopsTpl']->assign('itemsTitle', \_MA_WGDIARIES_ITEMS_LISTGROUP);
            $GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
            $items = [];
            $itemSubmitter = '';
            // Get All Items
            foreach (\array_keys($itemsAll) as $i) {
                $item = $itemsAll[$i]->getValuesItems();
                $itemSubmitter = $item['item_submitter'];
                // Permissions
                $item['permEdit'] = $permissionsHandler->getPermItemsEdit($itemSubmitter);
                if ($permissionsHandler->getPermItemsView($itemSubmitter)) {
                    $items[$i] = $item;
                }
            }
            $GLOBALS['xoopsTpl']->assign('items', $items);
            unset($items);
            // Display Navigation
            if ($itemsCount > $limit) {
                include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
            $GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
            $GLOBALS['xoopsTpl']->assign('divideby', $helper->getConfig('divideby'));
            $GLOBALS['xoopsTpl']->assign('numb_col', $helper->getConfig('numb_col'));
            $GLOBALS['xoopsTpl']->assign('useGroups', $helper->getConfig('use_groups'));
            $GLOBALS['xoopsTpl']->assign('listGroup', true);
            if (1 == $itemsCount) {
                $GLOBALS['xoopsTpl']->assign('permItemsComment', $permissionsHandler->getPermItemsComEdit($itemSubmitter));
            }
            if ('show' == $op && '' != $itemSubmitter) {
                $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', \strip_tags($itemSubmitter . ' - ' . $GLOBALS['xoopsModule']->getVar('name')));
            }
        }
        break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('items.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('items.php?op=list', 3, _NOPERM);
		}
		if ($itemId > 0) {
			$itemsObj = $itemsHandler->get($itemId);
		} else {
			$itemsObj = $itemsHandler->create();
		}
        $itemsObj->setVar('item_groupid', Request::getInt('item_groupid', 0));
		$itemsObj->setVar('item_remarks', Request::getText('item_remarks', ''));
		$itemDatefromArr = Request::getArray('item_datefrom');
		$itemDatefromObj = \DateTime::createFromFormat(_SHORTDATESTRING, $itemDatefromArr['date']);
		$itemDatefromObj->setTime(0, 0, 0);
		$itemDatefrom = $itemDatefromObj->getTimestamp() + (int)$itemDatefromArr['time'];
		$itemsObj->setVar('item_datefrom', $itemDatefrom);
		$itemDatetoArr = Request::getArray('item_dateto');
		$itemDatetoObj = \DateTime::createFromFormat(_SHORTDATESTRING, $itemDatetoArr['date']);
		$itemDatetoObj->setTime(0, 0, 0);
		$itemDateto = $itemDatetoObj->getTimestamp() + (int)$itemDatetoArr['time'];
		$itemsObj->setVar('item_dateto', $itemDateto);
		$itemsObj->setVar('item_comments', Request::getInt('item_comments', 0));
		$itemDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('item_datecreated'));
		$itemsObj->setVar('item_datecreated', $itemDatecreatedObj->getTimestamp());
		$itemsObj->setVar('item_submitter', Request::getInt('item_submitter', 0));
		// Insert Data
		if ($itemsHandler->insert($itemsObj)) {
            $newItemId = $itemId > 0 ? $itemId : $itemsObj->getNewInsertedIdItems();

            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploaderFiles  = [];
            $uploaderErrors = [];
            for ($i = 0; $i <= $helper->getConfig('max_fileuploads'); $i++) {
                //upload of single file
                $filename     = $_FILES['item_file' . $i]['name'];
                $fileMimetype = $_FILES['item_file' . $i]['type'];
                $imgNameDef   = $filename; //TODO: add field for description
                $uploader = new \XoopsMediaUploader(WGDIARIES_UPLOAD_FILES_PATH . '/',
                    $helper->getConfig('mimetypes_file'),
                    $helper->getConfig('maxsize_file'), null, null);
                if ($uploader->fetchMedia($_POST['xoops_upload_file'][$i])) {
                    $extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);
                    $imgName = \str_replace(' ', '', $imgNameDef) . '.' . $extension;
                    $uploader->setPrefix($imgName);
                    $uploader->fetchMedia($_POST['xoops_upload_file'][$i]);
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
                $fileDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('item_datecreated'));
                $filesObj->setVar('file_datecreated', $fileDatecreatedObj->getTimestamp());
                $filesObj->setVar('file_submitter', Request::getInt('item_submitter', 0));
                if (!$filesHandler->insert($filesObj)) {
                    $uploaderErrors[] = $filesObj->getErrors();
                }
            }
            // redirect after insert
            if (0 == \count($uploaderErrors)) {
                \redirect_header('items.php?op=show&amp;item_id=' . $newItemId, 2, _MA_WGDIARIES_FORM_OK);
            }
		}
		// Get Form Error
		$GLOBALS['xoopsTpl']->assign('error', implode('<br>', $uploaderErrors));
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'new':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_ITEM_ADD];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('items.php?op=list', 3, _NOPERM);
		}
        $GLOBALS['xoopsTpl']->assign('maxfileuploads', $helper->getConfig('max_fileuploads'));
		// Form Create
		$itemsObj = $itemsHandler->create();
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_ITEM_EDIT];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('items.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $itemId) {
			\redirect_header('items.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
        $GLOBALS['xoopsTpl']->assign('maxfileuploads', $helper->getConfig('max_fileuploads'));
		// Get Form
		$itemsObj = $itemsHandler->get($itemId);
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		// Breadcrumbs
		$xoBreadcrumbs[] = ['title' => _MA_WGDIARIES_ITEM_DELETE];
		// Check permissions
		if (!$permissionsHandler->getPermGlobalSubmit()) {
			\redirect_header('items.php?op=list', 3, _NOPERM);
		}
		// Check params
		if (0 == $itemId) {
			\redirect_header('items.php?op=list', 3, _MA_WGDIARIES_INVALID_PARAM);
		}
		$itemsObj = $itemsHandler->get($itemId);
		$itemSubmitter = $itemsObj->getVar('item_submitter');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('items.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($itemsHandler->delete($itemsObj)) {
                $crFiles = new \CriteriaCompo();
                $crFiles->add(new \Criteria('file_itemid', $itemId));
                $nbfiles = $filesHandler->getCount($crFiles);
			    if ($filesHandler->getCount($crFiles) > 0) {
                    $filesAll = $filesHandler->getAll($crFiles);
                    // Get and delete all related files
                    foreach (\array_keys($filesAll) as $i) {
                        $fileName = WGDIARIES_UPLOAD_FILES_PATH . '/' . $filesAll[$i]->getVar('file_name');
                        if (\file_exists($fileName)) {
                            \unlink($fileName);
                        }
                    }
                    // Delete data
                    $filesHandler->deleteAll($crFiles);
                }
			    // delete comments
                $commentHandler = \xoops_getHandler('comment');
                $critComments   = new CriteriaCompo(new Criteria('com_modid', $helper::getMid()));
                $critComments->add(new Criteria('com_itemid', $itemId));
                $commentHandler->deleteAll($critComments);

				\redirect_header('items.php', 3, _MA_WGDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'item_id' => $itemId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_MA_WGDIARIES_FORM_SURE_DELETE, $itemsObj->getCaption()));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgdiariesMetaDescription(_MA_WGDIARIES_ITEMS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', WGDIARIES_URL.'/items.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);

// View comments
require_once XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
