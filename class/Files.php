<?php

declare(strict_types=1);


namespace XoopsModules\Wgwfhdiaries;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * WFH Diaries module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgwfhdiaries
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         wedega - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgwfhdiaries;

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
		$helper = \XoopsModules\Wgwfhdiaries\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(_AM_WGWFHDIARIES_FILE_ADD) : \sprintf(_AM_WGWFHDIARIES_FILE_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table items
		$itemsHandler = $helper->getHandler('Items');
		$fileItemidSelect = new \XoopsFormSelect(_AM_WGWFHDIARIES_FILE_ITEMID, 'file_itemid', $this->getVar('file_itemid'));
		$fileItemidSelect->addOptionArray($itemsHandler->getList());
		$form->addElement($fileItemidSelect, true);
		// Form Text fileDesc
		$form->addElement(new \XoopsFormText(_AM_WGWFHDIARIES_FILE_DESC, 'file_desc', 50, 255, $this->getVar('file_desc')));
		// Form File: Upload fileName
		$fileName = $this->isNew() ? '' : $this->getVar('file_name');
		if ($permissionUpload) {
			$fileUploadTray = new \XoopsFormElementTray(_AM_WGWFHDIARIES_FILE_NAME, '<br>');
			$fileDirectory = '/uploads/wgwfhdiaries/files/files';
			if (!$this->isNew()) {
				$fileUploadTray->addElement(new \XoopsFormLabel(\sprintf(_AM_WGWFHDIARIES_FILE_NAME_UPLOADS, ".{$fileDirectory}/"), $fileName));
			}
			$maxsize = $helper->getConfig('maxsize_file');
			$fileUploadTray->addElement(new \XoopsFormFile('', 'file_name', $maxsize));
			$fileUploadTray->addElement(new \XoopsFormLabel(_AM_WGWFHDIARIES_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . _AM_WGWFHDIARIES_FORM_UPLOAD_SIZE_MB));
			$form->addElement($fileUploadTray);
		} else {
			$form->addElement(new \XoopsFormHidden('file_name', $fileName));
		}
		// Form Text Date Select fileDatecreated
		$fileDatecreated = $this->isNew() ?: $this->getVar('file_datecreated');
		$form->addElement(new \XoopsFormDateTime(_AM_WGWFHDIARIES_FILE_DATECREATED, 'file_datecreated', '', $fileDatecreated));
		// Form Select User fileSubmitter
		$form->addElement(new \XoopsFormSelectUser(_AM_WGWFHDIARIES_FILE_SUBMITTER, 'file_submitter', false, $this->getVar('file_submitter')));
		// To Save
		$form->addElement(new \XoopsFormHidden('op', 'save'));
		$form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
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
		$helper  = \XoopsModules\Wgwfhdiaries\Helper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('file_id');
		$itemsHandler = $helper->getHandler('Items');
		$itemsObj = $itemsHandler->get($this->getVar('file_itemid'));
		$ret['itemid']      = $itemsObj->getVar('item_submitter');
		$ret['desc']        = $this->getVar('file_desc');
		$ret['name']        = $this->getVar('file_name');
		$ret['datecreated'] = \formatTimestamp($this->getVar('file_datecreated'), 'm');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('file_submitter'));
		return $ret;
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
