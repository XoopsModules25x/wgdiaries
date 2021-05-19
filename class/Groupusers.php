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
 * Class Object Groupusers
 */
class Groupusers extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('gu_id', XOBJ_DTYPE_INT);
		$this->initVar('gu_groupid', XOBJ_DTYPE_INT);
		$this->initVar('gu_uid', XOBJ_DTYPE_INT);
		$this->initVar('gu_datecreated', XOBJ_DTYPE_INT);
		$this->initVar('gu_submitter', XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdGroupusers()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormGroupusers($action = false)
	{
		$helper = \XoopsModules\Wgdiaries\Helper::getInstance();
		if (!$action) {
			$action = $_SERVER['REQUEST_URI'];
		}
		$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
		// Title
		$title = $this->isNew() ? \sprintf(_AM_WGDIARIES_GROUPUSER_ADD) : \sprintf(_AM_WGDIARIES_GROUPUSER_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Table groups
		$groupsHandler = $helper->getHandler('Groups');
		$guGroupidSelect = new \XoopsFormSelect(_AM_WGDIARIES_GROUPUSER_GROUPID, 'gu_groupid', $this->getVar('gu_groupid'));
		$guGroupidSelect->addOptionArray($groupsHandler->getList());
		$form->addElement($guGroupidSelect, true);
		// Form Select User guUid
		$guUid = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('gu_uid');
		$form->addElement(new \XoopsFormSelectUser(_AM_WGDIARIES_GROUPUSER_UID, 'gu_uid', false, $guUid), true);
		// Form Text Date Select guDatecreated
		$guDatecreated = $this->isNew() ? time() : $this->getVar('gu_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(_AM_WGDIARIES_GROUPUSER_DATECREATED, 'gu_datecreated', '', $guDatecreated));
		// Form Select User guSubmitter
		$guSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('gu_submitter');
		$form->addElement(new \XoopsFormSelectUser(_AM_WGDIARIES_GROUPUSER_SUBMITTER, 'gu_submitter', false, $guSubmitter));
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
	public function getValuesGroupusers($keys = null, $format = null, $maxDepth = null)
	{
		$helper  = \XoopsModules\Wgdiaries\Helper::getInstance();
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('gu_id');
		$groupsHandler = $helper->getHandler('Groups');
		$groupsObj = $groupsHandler->get($this->getVar('gu_groupid'));
		$ret['groupid']     = $groupsObj->getVar('grp_name');
        $ret['uid']         = $this->getVar('gu_uid');
		$ret['username']    = \XoopsUser::getUnameFromId($this->getVar('gu_uid'), true);
		$ret['datecreated'] = \formatTimestamp($this->getVar('gu_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('gu_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayGroupusers()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
