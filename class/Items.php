<?php

declare(strict_types=1);


namespace XoopsModules\Wgdiaries;

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

use XoopsModules\Wgdiaries;
use XoopsGroup;

\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Items
 */
class Items extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('item_id', \XOBJ_DTYPE_INT);
        $this->initVar('item_groupid', \XOBJ_DTYPE_INT);
        $this->initVar('item_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_remarks', \XOBJ_DTYPE_OTHER);
        $this->initVar('item_datefrom', \XOBJ_DTYPE_INT);
        $this->initVar('item_dateto', \XOBJ_DTYPE_INT);
        $this->initVar('item_catid', \XOBJ_DTYPE_INT);
        $this->initVar('item_tags', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_logo', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('item_comments', \XOBJ_DTYPE_INT);
        $this->initVar('item_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('item_submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdItems()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @param int  $itemDate
     * @return \XoopsThemeForm
     */
    public function getFormItems($action = false, $itemDate = 0)
    {
        $helper = \XoopsModules\Wgdiaries\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        $uid = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0;

        // Title
        $title = $this->isNew() ? \sprintf(\_MA_WGDIARIES_ITEM_ADD) : \sprintf(\_MA_WGDIARIES_ITEM_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table groups
        if ($helper->getConfig('use_groups')) {
            $itemGroup = $this->isNew() ? 0 : $this->getVar('item_groupid');
            $groupOptions = [];
            $memberHandler   = \xoops_getHandler('member');
            $userGroups = $memberHandler->getGroupList();
            foreach ($userGroups as $group_id => $group_name) {
                $groupOptions[$group_id] = $group_name;
            }
            if (\count($groupOptions) > 1) {
                $itemGroupSelect = new \XoopsFormSelect(\_MA_WGDIARIES_ITEM_GROUPID, 'item_groupid', $itemGroup);
                $itemGroupSelect->addOptionArray($groupOptions);
                $form->addElement($itemGroupSelect);
            } elseif (\count($groupOptions) > 0) {
                $form->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_ITEM_GROUPID, \array_values($groupOptions)[0]));
                $form->addElement(new \XoopsFormHidden('item_groupid', \array_key_first($groupOptions)));
            } else {
                $form->addElement(new \XoopsFormHidden('item_groupid', 0));
            }
        } else {
            $form->addElement(new \XoopsFormHidden('item_groupid', 0));
        }
        // Form Text itemName
        $form->addElement(new \XoopsFormText(\_MA_WGDIARIES_ITEM_NAME, 'item_name', 50, 255, $this->getVar('item_name')));
        // Form Editor DhtmlTextArea itemRemarks
        $editorConfigs = [];
        if ($isAdmin) {
            $editor = $helper->getConfig('editor_admin');
        } else {
            $editor = $helper->getConfig('editor_user');
        }
        $editorConfigs['name'] = 'item_remarks';
        $editorConfigs['value'] = $this->getVar('item_remarks', 'e');
        $editorConfigs['rows'] = 5;
        $editorConfigs['cols'] = 40;
        $editorConfigs['width'] = '100%';
        $editorConfigs['height'] = '400px';
        $editorConfigs['editor'] = $editor;
        $form->addElement(new \XoopsFormEditor(\_MA_WGDIARIES_ITEM_REMARKS, 'item_remarks', $editorConfigs));
        // Form Text Date Select itemDatefrom / itemDateto
        if ($itemDate > 0) {
            $itemDatefrom = $itemDate;
            $itemDateto   = $itemDate;
        } else {
            $itemDatefrom = $this->isNew() ? \time() : $this->getVar('item_datefrom');
            $itemDateto = $this->isNew() ? \time() : $this->getVar('item_dateto');
        }
        $form->addElement(new \XoopsFormDateTime(\_MA_WGDIARIES_ITEM_DATEFROM, 'item_datefrom', '', $itemDatefrom), true);
        $form->addElement(new \XoopsFormDateTime(\_MA_WGDIARIES_ITEM_DATETO, 'item_dateto', '', $itemDateto), true);
        // Form Table categories
        $categoriesHandler = $helper->getHandler('Categories');
        $crCategories = new \CriteriaCompo();
        $crCategories->add(new \Criteria('cat_online', 1));
        $crCategories->setSort('cat_weight');
        $crCategories->setOrder('ASC');
        $itemCatidSelect = new \XoopsFormSelect(\_MA_WGDIARIES_ITEM_CATID, 'item_catid', $this->getVar('item_catid'));
        $itemCatidSelect->addOption('0', ' ');
        $itemCatidSelect->addOptionArray($categoriesHandler->getList($crCategories));
        $form->addElement($itemCatidSelect);
        // Form Text itemTags
        $form->addElement(new \XoopsFormText(\_MA_WGDIARIES_ITEM_TAGS, 'item_tags', 50, 255, $this->getVar('item_tags')));
        // Form Image itemLogo
        // Form Image itemLogo: Select Uploaded Image
        $getItemLogo = $this->getVar('item_logo');
        $itemLogo = $getItemLogo ?: 'blank.gif';
        $imageDirectory = '/uploads/wgdiaries/items/logos';
        $imageTray = new \XoopsFormElementTray(\_MA_WGDIARIES_ITEM_LOGO, '<br>');
        $imageSelect = new \XoopsFormSelect(\sprintf(\_MA_WGDIARIES_ITEM_LOGO_UPLOADS, ".{$imageDirectory}/"), 'item_logo', $itemLogo, 5);
        $imageArray = \XoopsLists::getImgListAsArray( \XOOPS_ROOT_PATH . $imageDirectory );
        foreach ($imageArray as $image1) {
            $imageSelect->addOption((string)($image1), $image1);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"imglabel_item_logo\", \"item_logo\", \"" . $imageDirectory . '", "", "' . \XOOPS_URL . "\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . \XOOPS_URL . '/' . $imageDirectory . '/' . $itemLogo . "' id='imglabel_item_logo' alt='' style='max-width:100px'>"));
        // Form Image itemLogo: Upload new image
        $maxsize = $helper->getConfig('maxsize_image');
        $imageTray->addElement(new \XoopsFormFile('<br>' . \_MA_WGDIARIES_FORM_UPLOAD_NEW, 'item_logo', $maxsize));
        $imageTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . \_MA_WGDIARIES_FORM_UPLOAD_SIZE_MB));
        $imageTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_IMG_WIDTH, $helper->getConfig('maxwidth_image') . ' px'));
        $imageTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_IMG_HEIGHT, $helper->getConfig('maxheight_image') . ' px'));
        $form->addElement($imageTray);
        // Form File: Upload File
        $fileUploadTray = new \XoopsFormElementTray(\_MA_WGDIARIES_ITEM_UPLOADFILES, '<br><br>');
        $maxsize = $helper->getConfig('maxsize_file');
        $fileUploadTray->addElement(new \XoopsFormFile('', 'item_file0', $maxsize));
        $fileUploadTray->addElement(new \XoopsFormLabel('', '<a class="add_more btn btn-primary" href="#">' . \_MA_WGDIARIES_ITEM_UPLOADFILES_BTN . '</a>'));
        $form->addElement($fileUploadTray);
        $form->addElement(new \XoopsFormLabel('', \_MA_WGDIARIES_FORM_UPLOAD_SIZE . ($maxsize / 1048576) . ' '  . \_MA_WGDIARIES_FORM_UPLOAD_SIZE_MB));
        // Form Text itemComments
        $itemComments = $this->getVar('item_comments');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormText(\_MA_WGDIARIES_ITEM_COMMENTS, 'item_comments', 50, 255, $itemComments));
        } else {
            $form->addElement(new \XoopsFormHidden('item_comments', $itemComments));
            $form->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_ITEM_COMMENTS, $itemComments));
        }
        // Form Text Date Select itemDatecreated
        $itemDatecreated = $this->isNew() ? \time() : $this->getVar('item_datecreated');
        // Form Select User itemSubmitter
        $itemSubmitter = $this->isNew() ? $uid : $this->getVar('item_submitter');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGDIARIES_ITEM_DATECREATED, 'item_datecreated', '', $itemDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGDIARIES_ITEM_SUBMITTER, 'item_submitter', false, $itemSubmitter));
        } else {
            $form->addElement(new \XoopsFormHidden('item_datecreated', $itemDatecreated));
            $form->addElement(new \XoopsFormHidden('item_submitter', $itemSubmitter));
        }
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesItems($keys = null, $format = null, $maxDepth = null)
    {
        $helper  = \XoopsModules\Wgdiaries\Helper::getInstance();
        $filesHandler = $helper->getHandler('Files');
        $utility = new \XoopsModules\Wgdiaries\Utility();
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']            = $this->getVar('item_id');
        // Get groups
        $memberHandler = \xoops_getHandler('member');
        $xoopsGroups  = $memberHandler->getGroupList();
        $ret['groupname']     = $xoopsGroups[$this->getVar('item_groupid')];
        $ret['name']          = $this->getVar('item_name');
        $ret['remarks']       = $this->getVar('item_remarks', 'e');
        $editorMaxchar = $helper->getConfig('editor_maxchar');
        $ret['remarks_short'] = $utility::truncateHtml($ret['remarks'], $editorMaxchar);
        $ret['datefrom']      = \formatTimestamp($this->getVar('item_datefrom'), 'm');
        $ret['dateto']        = \formatTimestamp($this->getVar('item_dateto'), 'm');
        $categoriesHandler = $helper->getHandler('Categories');
        $categoriesObj = $categoriesHandler->get($this->getVar('item_catid'));
        $ret['catid']         = $this->getVar('item_catid');
        $ret['category']      = '';
        if (\is_object($categoriesObj)) {
            $ret['category'] = $categoriesObj->getVar('cat_name');
            $ret['catlogo']  = $categoriesObj->getVar('cat_logo');
        }
        $ret['tags']          = $this->getVar('item_tags');
        if ('blank.gif' === $this->getVar('item_logo') || 'blank.png' === $this->getVar('item_logo')) {
            $ret['logo'] = '';
        } else {
            $ret['logo']          = $this->getVar('item_logo');
        }
        $ret['comments']      = $this->getVar('item_comments');
        $ret['datecreated']   = \formatTimestamp($this->getVar('item_datecreated'), 's');
        $ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('item_submitter'), true);
        $crFiles = new \CriteriaCompo();
        $crFiles->add(new \Criteria('file_itemid', $this->getVar('item_id')));
        $ret['nbfiles'] = $filesHandler->getCount($crFiles);

        return $ret;

    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayItems()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }

    /**
     * Returns a string which shows basic info of item
     * @param string $target
     * @return string
     */
    public function getCaption($target = 'default')
    {
        switch ($target) {
            case 'default':
            default:
                $ret = \sprintf(\_MA_WGDIARIES_ITEM_CAPTION,
                    $this->getVar('item_id'),
                    \XoopsUser::getUnameFromId($this->getVar('item_submitter'), true),
                    \formatTimestamp($this->getVar('item_datefrom'), 'm'),
                    \formatTimestamp($this->getVar('item_dateto'), 'm')
                );
                break;
            case 'single':
                $ret = \sprintf(\_MA_WGDIARIES_ITEM_CAPTION_SINGLE,
                    \XoopsUser::getUnameFromId($this->getVar('item_submitter'), true),
                    $this->getVar('item_id'),
                    \formatTimestamp($this->getVar('item_datefrom'), 's'),
                );
                break;
        }

        return $ret;
    }
}
