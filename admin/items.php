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
		$adminObject->addItemButton(_AM_WGDIARIES_ADD_ITEM, 'items.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$itemsCount = $itemsHandler->getCountItems();
		$itemsAll = $itemsHandler->getAllItems($start, $limit);
		$GLOBALS['xoopsTpl']->assign('items_count', $itemsCount);
		$GLOBALS['xoopsTpl']->assign('wgdiaries_url', WGDIARIES_URL);
		$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', WGDIARIES_UPLOAD_URL);
		// Table view items
		if ($itemsCount > 0) {
			foreach (\array_keys($itemsAll) as $i) {
				$item = $itemsAll[$i]->getValuesItems();
				$GLOBALS['xoopsTpl']->append('items_list', $item);
				unset($item);
			}
			// Display Navigation
			if ($itemsCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGDIARIES_THEREARENT_ITEMS);
		}
		break;
	case 'new':
		$templateMain = 'wgdiaries_admin_items.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('items.php'));
		$adminObject->addItemButton(_AM_WGDIARIES_ITEMS_LIST, 'items.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$itemsObj = $itemsHandler->create();
		$form = $itemsObj->getFormItems();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
    case 'save_add':
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
            // redirect after insert
            if ('save_add' == $op) {
                \redirect_header('files.php?op=new&amp;item_id=' . $newItemId, 2, _MA_WGDIARIES_FORM_OK);
            } else {
                \redirect_header('items.php?op=list#itemId_' . $newItemId, 2, _MA_WGDIARIES_FORM_OK);
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
		$adminObject->addItemButton(_AM_WGDIARIES_ADD_ITEM, 'items.php?op=new', 'add');
		$adminObject->addItemButton(_AM_WGDIARIES_ITEMS_LIST, 'items.php', 'list');
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
		$itemSubmitter = $itemsObj->getVar('item_submitter');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('items.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($itemsHandler->delete($itemsObj)) {
				\redirect_header('items.php', 3, _AM_WGDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'item_id' => $itemId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_AM_WGDIARIES_FORM_SURE_DELETE, $itemsObj->getVar('item_submitter')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
