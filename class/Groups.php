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
 * Class Object Groups
 */
class Groups extends \XoopsObject
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
		$this->initVar('grp_id', XOBJ_DTYPE_INT);
		$this->initVar('grp_name', XOBJ_DTYPE_TXTBOX);
		$this->initVar('grp_logo', XOBJ_DTYPE_TXTBOX);
		$this->initVar('grp_online', XOBJ_DTYPE_INT);
		$this->initVar('grp_datecreated', XOBJ_DTYPE_INT);
		$this->initVar('grp_submitter', XOBJ_DTYPE_INT);
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
	public function getNewInsertedIdGroups()
	{
		$newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
		return $newInsertedId;
	}

	/**
	 * @public function getForm
	 * @param bool $action
	 * @return \XoopsThemeForm
	 */
	public function getFormGroups($action = false)
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
		$title = $this->isNew() ? \sprintf(_MA_WGDIARIES_GROUP_ADD) : \sprintf(_MA_WGDIARIES_GROUP_EDIT);
		// Get Theme Form
		\xoops_load('XoopsFormLoader');
		$form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		// Form Text grpName
		$form->addElement(new \XoopsFormText(_MA_WGDIARIES_GROUP_NAME, 'grp_name', 50, 255, $this->getVar('grp_name')), true);
        // Form Select User
        $guUids = [];
        $grpId = $this->isNew() ? 0 : $this->getVar('grp_id');
        $groupusersHandler = $helper->getHandler('Groupusers');
        $crGroupusers = new \CriteriaCompo();
        $crGroupusers->add(new \Criteria('gu_groupid', $grpId));
        $groupusersAll = $groupusersHandler->getAll($crGroupusers);
        foreach (\array_keys($groupusersAll) as $i) {
            $guUids[$groupusersAll[$i]->getVar('gu_uid')] = $groupusersAll[$i]->getVar('gu_uid');
        }
        $guUidSelect = new \XoopsFormSelect(_MA_WGDIARIES_GROUPUSERS_LINKED, 'gu_uids', $guUids, 5, true);
        $user_handler = xoops_getHandler('user');
        $crUsers = new \CriteriaCompo();
        $crUsers->setSort('uname');
        $crUsers->setOrder('ASC');
        $guUidSelect->addOptionArray($user_handler->getList($crUsers));
        $form->addElement($guUidSelect, true);

		// Form Image grpLogo
		// Form Image grpLogo: Select Uploaded Image 
		$getGrpLogo = $this->getVar('grp_logo');
		$grpLogo = $getGrpLogo ?: 'blank.gif';
		$imageDirectory = '/uploads/wgdiaries/images/groups';
		$imageTray = new \XoopsFormElementTray(_MA_WGDIARIES_GROUP_LOGO, '<br>');
		$imageSelect = new \XoopsFormSelect(\sprintf(_MA_WGDIARIES_GROUP_LOGO_UPLOADS, ".{$imageDirectory}/"), 'grp_logo', $grpLogo, 5);
		$imageArray = \XoopsLists::getImgListAsArray( XOOPS_ROOT_PATH . $imageDirectory );
		foreach ($imageArray as $image1) {
			$imageSelect->addOption((string)($image1), $image1);
		}
		$imageSelect->setExtra("onchange='showImgSelected(\"imglabel_grp_logo\", \"grp_logo\", \"" . $imageDirectory . '", "", "' . XOOPS_URL . "\")'");
		$imageTray->addElement($imageSelect, false);
		$imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $imageDirectory . '/' . $grpLogo . "' id='imglabel_grp_logo' alt='' style='max-width:100px' />"));
		// Form Image grpLogo: Upload new image
		if ($permissionUpload) {
			$maxsize = $helper->getConfig('maxsize_image');
			$imageTray->addElement(new \XoopsFormFile('<br>' . _MA_WGDIARIES_FORM_UPLOAD_NEW, 'grp_logo', $maxsize));
			$imageTray->addElement(new \XoopsFormLabel(_MA_WGDIARIES_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . _MA_WGDIARIES_FORM_UPLOAD_SIZE_MB));
			$imageTray->addElement(new \XoopsFormLabel(_MA_WGDIARIES_FORM_UPLOAD_IMG_WIDTH, $helper->getConfig('maxwidth_image') . ' px'));
			$imageTray->addElement(new \XoopsFormLabel(_MA_WGDIARIES_FORM_UPLOAD_IMG_HEIGHT, $helper->getConfig('maxheight_image') . ' px'));
		} else {
			$imageTray->addElement(new \XoopsFormHidden('grp_logo', $grpLogo));
		}
		$form->addElement($imageTray);
		// Form Radio Yes/No grpOnline
		$grpOnline = $this->isNew() ?: $this->getVar('grp_online');
		$form->addElement(new \XoopsFormRadioYN(_MA_WGDIARIES_GROUP_ONLINE, 'grp_online', $grpOnline));
		// Form Text Date Select grpDatecreated
		$grpDatecreated = $this->isNew() ? time() : $this->getVar('grp_datecreated');
        // Form Select User grpSubmitter
        $grpSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('grp_submitter');
        if ($isAdmin) {
            $form->addElement(new \XoopsFormTextDateSelect(_MA_WGDIARIES_GROUP_DATECREATED, 'grp_datecreated', '', $grpDatecreated));
            $form->addElement(new \XoopsFormSelectUser(_MA_WGDIARIES_GROUP_SUBMITTER, 'grp_submitter', false, $grpSubmitter));
        } else {
            $form->addElement(new \XoopsFormHidden('grp_datecreated', $grpDatecreated));
            $form->addElement(new \XoopsFormHidden('grp_submitter', $grpSubmitter));
        }

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
	public function getValuesGroups($keys = null, $format = null, $maxDepth = null)
	{
		$ret = $this->getValues($keys, $format, $maxDepth);
		$ret['id']          = $this->getVar('grp_id');
		$ret['name']        = $this->getVar('grp_name');
		$ret['logo']        = $this->getVar('grp_logo');
		$ret['online']      = (int)$this->getVar('grp_online') > 0 ? _YES : _NO;
		$ret['datecreated'] = \formatTimestamp($this->getVar('grp_datecreated'), 's');
		$ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('grp_submitter'));
		return $ret;
	}

	/**
	 * Returns an array representation of the object
	 *
	 * @return array
	 */
	public function toArrayGroups()
	{
		$ret = [];
		$vars = $this->getVars();
		foreach (\array_keys($vars) as $var) {
			$ret[$var] = $this->getVar('"{$var}"');
		}
		return $ret;
	}
}
