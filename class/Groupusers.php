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
		// Permissions for uploader
		$grouppermHandler = \xoops_getHandler('groupperm');
		$groups = \is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : XOOPS_GROUP_ANONYMOUS;
		$permissionUpload = $grouppermHandler->checkRight('upload_groups', 32, $groups, $GLOBALS['xoopsModule']->getVar('mid')) ? true : false;
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
		$form->addElement(new \XoopsFormSelectUser(_AM_WGDIARIES_GROUPUSER_UID, 'gu_uid', false, $this->getVar('gu_uid')), true);
		// Form Text Date Select guDatecreated
		$guDatecreated = $this->isNew() ? 0 : $this->getVar('gu_datecreated');
		$form->addElement(new \XoopsFormTextDateSelect(_AM_WGDIARIES_GROUPUSER_DATECREATED, 'gu_datecreated', '', $guDatecreated));
		// Form Select User guSubmitter
		$form->addElement(new \XoopsFormSelectUser(_AM_WGDIARIES_GROUPUSER_SUBMITTER, 'gu_submitter', false, $this->getVar('gu_submitter')));
		// Permissions
		$memberHandler = \xoops_getHandler('member');
		$groupList = $memberHandler->getGroupList();
		$grouppermHandler = \xoops_getHandler('groupperm');
		$fullList[] = \array_keys($groupList);
		if (!$this->isNew()) {
			$groupsIdsApprove = $grouppermHandler->getGroupIds('wgdiaries_approve_groupusers', $this->getVar('gu_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsApprove[] = \array_values($groupsIdsApprove);
			$groupsCanApproveCheckbox = new \XoopsFormCheckBox(_AM_WGDIARIES_PERMISSIONS_APPROVE, 'groups_approve_groupusers[]', $groupsIdsApprove);
			$groupsIdsSubmit = $grouppermHandler->getGroupIds('wgdiaries_submit_groupusers', $this->getVar('gu_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsSubmit[] = \array_values($groupsIdsSubmit);
			$groupsCanSubmitCheckbox = new \XoopsFormCheckBox(_AM_WGDIARIES_PERMISSIONS_SUBMIT, 'groups_submit_groupusers[]', $groupsIdsSubmit);
			$groupsIdsView = $grouppermHandler->getGroupIds('wgdiaries_view_groupusers', $this->getVar('gu_id'), $GLOBALS['xoopsModule']->getVar('mid'));
			$groupsIdsView[] = \array_values($groupsIdsView);
			$groupsCanViewCheckbox = new \XoopsFormCheckBox(_AM_WGDIARIES_PERMISSIONS_VIEW, 'groups_view_groupusers[]', $groupsIdsView);
		} else {
			$groupsCanApproveCheckbox = new \XoopsFormCheckBox(_AM_WGDIARIES_PERMISSIONS_APPROVE, 'groups_approve_groupusers[]', $fullList);
			$groupsCanSubmitCheckbox = new \XoopsFormCheckBox(_AM_WGDIARIES_PERMISSIONS_SUBMIT, 'groups_submit_groupusers[]', $fullList);
			$groupsCanViewCheckbox = new \XoopsFormCheckBox(_AM_WGDIARIES_PERMISSIONS_VIEW, 'groups_view_groupusers[]', $fullList);
		}
		// To Approve
		$groupsCanApproveCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanApproveCheckbox);
		// To Submit
		$groupsCanSubmitCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanSubmitCheckbox);
		// To View
		$groupsCanViewCheckbox->addOptionArray($groupList);
		$form->addElement($groupsCanViewCheckbox);
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
		$ret['uid']         = \XoopsUser::getUnameFromId($this->getVar('gu_uid'));
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
