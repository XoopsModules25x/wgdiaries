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
		$this->initVar('item_id', XOBJ_DTYPE_INT);
		$this->initVar('item_remarks', XOBJ_DTYPE_OTHER);
		$this->initVar('item_datefrom', XOBJ_DTYPE_INT);
		$this->initVar('item_dateto', XOBJ_DTYPE_INT);
		$this->initVar('item_datecreated', XOBJ_DTYPE_INT);
		$this->initVar('item_submitter', XOBJ_DTYPE_INT);
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
	 * @return \XoopsThemeForm
	 */
	public function getFormItems($action = false)
	{
		$helper = \XoopsModules\Wgwfhdiaries\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(_AM_WGWFHDIARIES_ITEM_ADD) : \sprintf(_AM_WGWFHDIARIES_ITEM_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
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
		$form->addElement(new \XoopsFormEditor(_AM_WGWFHDIARIES_ITEM_REMARKS, 'item_remarks', $editorConfigs));
		// Form Text Date Select itemDatefrom
		$itemDatefrom = $this->isNew() ?: $this->getVar('item_datefrom');
		$form->addElement(new \XoopsFormDateTime(_AM_WGWFHDIARIES_ITEM_DATEFROM, 'item_datefrom', '', $itemDatefrom), true);
		// Form Text Date Select itemDateto
		$itemDateto = $this->isNew() ?: $this->getVar('item_dateto');
		$form->addElement(new \XoopsFormDateTime(_AM_WGWFHDIARIES_ITEM_DATETO, 'item_dateto', '', $itemDateto), true);
		// Form Text Date Select itemDatecreated
		$itemDatecreated = $this->isNew() ?: $this->getVar('item_datecreated');
		$form->addElement(new \XoopsFormDateTime(_AM_WGWFHDIARIES_ITEM_DATECREATED, 'item_datecreated', '', $itemDatecreated));
		// Form Select User itemSubmitter
		$form->addElement(new \XoopsFormSelectUser(_AM_WGWFHDIARIES_ITEM_SUBMITTER, 'item_submitter', false, $this->getVar('item_submitter')));
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
	public function getValuesItems($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgwfhdiaries\Helper::getInstance();
		$utility = new \XoopsModules\Wgwfhdiaries\Utility();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']            = $this->getVar('item_id');
		$ret['remarks']       = $this->getVar('item_remarks', 'e');
		$editorMaxchar = $helper->getConfig('editor_maxchar');
		$ret['remarks_short'] = $utility::truncateHtml($ret['remarks'], $editorMaxchar);
		$ret['datefrom']      = \formatTimestamp($this->getVar('item_datefrom'), 'm');
		$ret['dateto']        = \formatTimestamp($this->getVar('item_dateto'), 'm');
		$ret['datecreated']   = \formatTimestamp($this->getVar('item_datecreated'), 'm');
		$ret['submitter']     = \XoopsUser::getUnameFromId($this->getVar('item_submitter'));
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
}
