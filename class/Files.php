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

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Files
 */
class Files extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('file_id', XOBJ_DTYPE_INT);
		$this->initVar('file_itemid', XOBJ_DTYPE_INT);
		$this->initVar('file_desc', XOBJ_DTYPE_TXTBOX);
		$this->initVar('file_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('file_mimetype', XOBJ_DTYPE_TXTBOX);
		$this->initVar('file_datecreated', XOBJ_DTYPE_INT);
		$this->initVar('file_submitter', XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdFiles()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormFiles($action = false)
	{
		$helper = \XoopsModules\Wgdiaries\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Permissions for uploader
		$grouppermHandler = \xoops_getHandler('groupperm');
		$groups = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$permissionUpload = $grouppermHandler->checkRight('upload_groups', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
		// Title
		$title = $this->isNew() ? \sprintf(\_MA_WGDIARIES_FILE_ADD) : \sprintf(\_MA_WGDIARIES_FILE_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table items
        if ($isAdmin) {
            $itemsHandler = $helper->getHandler('Items');
            $fileItemidSelect = new \XoopsFormSelect(\_MA_WGDIARIES_FILE_ITEMID, 'file_itemid', $this->getVar('file_itemid'));
            $crItems = new \CriteriaCompo();
            $itemsAll = $itemsHandler->getAll($crItems);
            foreach (\array_keys($itemsAll) as $i) {
                $fileItemidSelect->addOption($itemsAll[$i]->getVar('item_id'), $itemsAll[$i]->getCaption());
            }
            $form->addElement($fileItemidSelect, true);
            $form->addElement(new \XoopsFormHidden('item_id', $this->getVar('file_itemid')));
        } else {
            $form->addElement(new \XoopsFormHidden('item_id', $this->getVar('file_itemid')));
        }

		// Form Text fileDesc
		$form->addElement(new \XoopsFormText(\_MA_WGDIARIES_FILE_DESC, 'file_desc', 50, 255, $this->getVar('file_desc')));
		// Form File: Upload fileName
        if ($this->isNew()) {
            $fileName = '';
        } else {
            $fileName = $this->getVar('file_name');
            $form->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FILE_NAME, $fileName));
        }
        $form->addElement(new \XoopsFormHidden('file_name_old', $fileName));
		if ($permissionUpload) {
			$fileUploadTray = new \XoopsFormElementTray(\_MA_WGDIARIES_FILE_UPLOAD, '<br>');
			$fileDirectory = '/uploads/wgdiaries/files';
			$maxsize = $helper->getConfig('maxsize_file');
			$fileUploadTray->addElement(new \XoopsFormFile('', 'file_name', $maxsize));
			$fileUploadTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . _MA_WGDIARIES_FORM_UPLOAD_SIZE_MB));
			$form->addElement($fileUploadTray);
		}
        $form->addElement(new \XoopsFormText(\_MA_WGDIARIES_FILE_MIMETYPE, 'file_mimetype', 50, 255, $this->getVar('file_mimetype')));
		// Form Text Date Select fileDatecreated
		$fileDatecreated = $this->isNew() ? time() : $this->getVar('file_datecreated');
		// Form Select User fileSubmitter
		$fileSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('file_submitter');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormTextDateSelect(\_MA_WGDIARIES_FILE_DATECREATED, 'file_datecreated', '', $fileDatecreated));
            $form->addElement(new \XoopsFormSelectUser(\_MA_WGDIARIES_FILE_SUBMITTER, 'file_submitter', false, $fileSubmitter));
        } else {
            $form->addElement(new \XoopsFormHidden('file_datecreated', $fileDatecreated));
            $form->addElement(new \XoopsFormHidden('file_submitter', $fileSubmitter));
        }
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
        $buttonTray = new \XoopsFormElementTray('', '&nbsp;');
        $buttonTray->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        $btnAddFile = new \XoopsFormButton('', 'save_add', \_MA_WGDIARIES_ITEM_SAVEADDFILES, 'submit');
        $btnAddFile->setExtra('class="btn btn-primary"');
        $buttonTray->addElement($btnAddFile);
        $form->addElement($buttonTray);

        return $form;
	}

	/**
	 * Get Values
	 * @param null $keys
	 * @param null $format
	 * @param null $maxDepth
	 * @return array
	 */
	public function getValuesFiles($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgdiaries\Helper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('file_id');
		$itemsHandler = $helper->getHandler('Items');
		$itemsObj = $itemsHandler->get($this->getVar('file_itemid'));
        $ret['itemid']  = 0;
        $ret['caption'] = '';
		if (\is_object($itemsObj)) {
            $ret['itemid']      = $itemsObj->getVar('item_submitter');
            $ret['caption']      = $itemsObj->getCaption();
        }
		$ret['desc']        = $this->getVar('file_desc');
		$ret['name']        = $this->getVar('file_name');
        $ret['mimetype']    = $this->getVar('file_mimetype');
        $ret['isimage']     = $this->is_image($this->getVar('file_mimetype'));
        $ret['icon']        = $this->get_icon($this->getVar('file_name'));
		$ret['datecreated'] = \formatTimestamp($this->getVar('file_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('file_submitter'));
		return $ret;
	}

    private function is_image($mimetype)
    {
        $ret = in_array($mimetype, ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/bmp']);

        return $ret;
    }

    private function get_icon($fileName)
    {
        $path = WGDIARIES_ICONS_PATH . '/files/';
        $path_parts = pathinfo($path . $fileName);
        $extension = $path_parts['extension'];
        $icon = $extension . '.png';
        if (\file_exists($path . $icon)) {
            return $icon;
        }

        return '_blank.png';
    }

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayFiles()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
