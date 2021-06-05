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
use XoopsModules\Wgdiaries\SimpleCalendar;

require __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'wgdiaries_items.tpl';
require_once \XOOPS_ROOT_PATH . '/header.php';

if (!$permissionsHandler->getPermItemsSubmit() && !$permissionsHandler->getPermUserItemsView()) {
    \redirect_header('index.php?op=list', 3, \_NOPERM);
}

$op      = Request::getCmd('op', 'list');
$start   = Request::getInt('start', 0);
$limit   = Request::getInt('limit', $helper->getConfig('userpager'));
$itemId  = Request::getInt('item_id', 0);
$userId  = Request::getInt('userId', 0);
$sortBy  = Request::getString('sortBy', 'item_datefrom');
$orderBy = Request::getString('orderBy', 'DESC');

// Define Stylesheet
$GLOBALS['xoTheme']->addStylesheet($style, null);
// Paths
$GLOBALS['xoopsTpl']->assign('xoops_icons32_url', \XOOPS_ICONS32_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_url', \WGDIARIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_categoriesurl', \WGDIARIES_UPLOAD_CATEGORIES_URL);
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_itemsurl', \WGDIARIES_UPLOAD_ITEMS_URL);
$GLOBALS['xoopsTpl']->assign('redir', 'list');
// Keywords
$keywords = [];

$GLOBALS['xoopsTpl']->assign('showItem', $itemId > 0);

switch ($op) {
    case 'show':
    case 'list':
    case 'listuser':
    case 'listown':
    default:
        // Breadcrumbs
        if ('show' === $op) {
            $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEM_DETAILS];
        } else {
            $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEMS_LISTMY];
        }
        $itemsCalendar = false;
        if ('listuser' !== $op) {
            $itemsCalendar = (bool)$helper->getConfig('items_calendar');
        }
        $GLOBALS['xoopsTpl']->assign('itemsCalendar', $itemsCalendar);
        if ($itemsCalendar) {
            $GLOBALS['xoTheme']->addStylesheet(\WGDIARIES_URL . '/class/SimpleCalendar/css/SimpleCalendarMini.css', null);
            $calendar = new SimpleCalendar\SimpleCalendarMini();
            $calendar->setDate(\time());
            $calendar->setStartOfWeek(\_MA_WGDIARIES_CAL_MONDAY);
            $calendar->setWeekDayNames([
                \_MA_WGDIARIES_CAL_MIN_SUNDAY,
                \_MA_WGDIARIES_CAL_MIN_MONDAY,
                \_MA_WGDIARIES_CAL_MIN_TUESDAY,
                \_MA_WGDIARIES_CAL_MIN_WEDNESDAY,
                \_MA_WGDIARIES_CAL_MIN_THURSDAY,
                \_MA_WGDIARIES_CAL_MIN_FRIDAY,
                \_MA_WGDIARIES_CAL_MIN_SATURDAY]);
        }
        switch ($op) {
            case 'list':
            default:
                $GLOBALS['xoopsTpl']->assign('itemsTitle', \_MA_WGDIARIES_ITEMS_LISTMY);
                break;
            case 'show':
                $GLOBALS['xoopsTpl']->assign('itemsTitle', \_MA_WGDIARIES_ITEM_DETAILS);
                //add stylesheets for print output
                $GLOBALS['xoopsTpl']->assign('wgdiaries_css_print_1', \WGDIARIES_CSS_URL . '/style.css');
                break;
            case 'listuser':
                $GLOBALS['xoopsTpl']->assign('itemsTitle', sprintf(\_MA_WGDIARIES_ITEMS_LISTUSER, \XoopsUser::getUnameFromId($userId, true)));
                break;
        }
        $uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : -1;
        $crItems = new \CriteriaCompo();
        if ($itemId > 0) {
            $crItems->add(new \Criteria('item_id', $itemId));
        }
        $crItems->setSort($sortBy);
        $crItems->setOrder($orderBy);
        if ($userId > 0) {
            $crItems->add(new \Criteria('item_submitter', $userId));
        } else {
            $crItems->add(new \Criteria('item_submitter', $uid));
        }
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
                if ($itemsCalendar) {
                    $calendar->addDailyHtml($items[$i]['item_name'], $items[$i]['item_datefrom'], $items[$i]['item_dateto']);
                }
            }
            $GLOBALS['xoopsTpl']->assign('items', $items);

            if (\count($items) > 0 && $itemsCalendar) {
                $GLOBALS['xoopsTpl']->assign('items_calendar', $calendar->render());
            }

            unset($items);

            // Display Navigation
            if ($itemsCount > $limit) {
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;sortBy=' . $sortBy . '&amp;orderBy=' . $orderBy);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
            $GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
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
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEMS_LISTGROUP];

        $uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : -1;
        $crItems = new \CriteriaCompo();
        $crItems->add(new \Criteria('item_submitter', $uid, '<>'));
        $memberHandler = \xoops_getHandler('member');
        $xoopsGroups = $memberHandler->getGroupList();
        $myGroups = \array_keys($xoopsGroups);
        $crItems->add(new \Criteria('item_groupid', '(' . \implode(',', $myGroups) . ')', 'IN'));
        $itemsCount = $itemsHandler->getCount($crItems);
        $GLOBALS['xoopsTpl']->assign('itemsCount', $itemsCount);
        $crItems->setStart($start);
        $crItems->setLimit($limit);
        $crItems->setSort('item_id');
        $crItems->setOrder('DESC');
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
                require_once \XOOPS_ROOT_PATH . '/class/pagenav.php';
                $pagenav = new \XoopsPageNav($itemsCount, $limit, $start, 'start', 'op=list&amp;limit=' . $limit . '&amp;sortBy=' . $sortBy . '&amp;orderBy=' . $orderBy);
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            $GLOBALS['xoopsTpl']->assign('table_type', $helper->getConfig('table_type'));
            $GLOBALS['xoopsTpl']->assign('panel_type', $helper->getConfig('panel_type'));
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
        if (!$permissionsHandler->getPermItemSubmit()) {
            \redirect_header('items.php?op=list', 3, \_NOPERM);
        }
        if ($itemId > 0) {
            $itemsObj = $itemsHandler->get($itemId);
        } else {
            $itemsObj = $itemsHandler->create();
        }
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
        // Get Form Error
        $GLOBALS['xoopsTpl']->assign('error', \implode('<br>', $uploaderErrors));
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'new':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEM_ADD];
        // Check permissions
        if (!$permissionsHandler->getPermItemSubmit()) {
            \redirect_header('items.php?op=list', 3, \_NOPERM);
        }
        $GLOBALS['xoopsTpl']->assign('maxfileuploads', $helper->getConfig('max_fileuploads'));
        // Form Create
        $itemsObj = $itemsHandler->create();
        $itemDate  = Request::getInt('itemDate', 0);
        $form = $itemsObj->getFormItems(false, $itemDate);
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'edit':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEM_EDIT];
        // Check params
        if (0 == $itemId) {
            \redirect_header('items.php?op=list', 3, \_MA_WGDIARIES_INVALID_PARAM);
        }
        $GLOBALS['xoopsTpl']->assign('maxfileuploads', $helper->getConfig('max_fileuploads'));
        // Get Form
        $itemsObj = $itemsHandler->get($itemId);
        $itemSubmitter = $itemsObj->getVar('item_submitter');
        // Check permissions
        if (!$permissionsHandler->getPermItemsEdit($itemSubmitter)) {
            \redirect_header('items.php?op=list', 3, \_NOPERM);
        }
        $form = $itemsObj->getFormItems();
        $GLOBALS['xoopsTpl']->assign('form', $form->render());
        break;
    case 'delete':
        // Breadcrumbs
        $xoBreadcrumbs[] = ['title' => \_MA_WGDIARIES_ITEM_DELETE];
        // Check params
        if (0 == $itemId) {
            \redirect_header('items.php?op=list', 3, \_MA_WGDIARIES_INVALID_PARAM);
        }
        $itemsObj = $itemsHandler->get($itemId);
        $itemSubmitter = $itemsObj->getVar('item_submitter');
        // Check permissions
        if (!$permissionsHandler->getPermItemsEdit($itemSubmitter)) {
            \redirect_header('items.php?op=list', 3, \_NOPERM);
        }
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
                        $fileName = \WGDIARIES_UPLOAD_FILES_PATH . '/' . $filesAll[$i]->getVar('file_name');
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

                \redirect_header('items.php', 3, \_MA_WGDIARIES_FORM_DELETE_OK);
            } else {
                $GLOBALS['xoopsTpl']->assign('error', $itemsObj->getHtmlErrors());
            }
        } else {
            $xoopsconfirm = new Common\XoopsConfirm(
                ['ok' => 1, 'item_id' => $itemId, 'op' => 'delete'],
                $_SERVER['REQUEST_URI'],
                \sprintf(\_MA_WGDIARIES_FORM_SURE_DELETE, $itemsObj->getCaption()));
            $form = $xoopsconfirm->getFormXoopsConfirm();
            $GLOBALS['xoopsTpl']->assign('form', $form->render());
        }
        break;
}

// Keywords
wgdiariesMetaKeywords($helper->getConfig('keywords') . ', ' . \implode(',', $keywords));
unset($keywords);

// Description
wgdiariesMetaDescription(\_MA_WGDIARIES_ITEMS_DESC);
$GLOBALS['xoopsTpl']->assign('xoops_mpageurl', \WGDIARIES_URL.'/items.php');
$GLOBALS['xoopsTpl']->assign('wgdiaries_upload_url', \WGDIARIES_UPLOAD_URL);

// View comments
require_once \XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
