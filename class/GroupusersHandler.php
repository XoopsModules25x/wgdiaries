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


/**
 * Class Object Handler Groupusers
 */
class GroupusersHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgdiaries_groupusers', Groupusers::class, 'gu_id', 'gu_groupid');
	}

	/**
	 * @param bool $isNew
	 *
	 * @return object
	 */
	public function create($isNew = true)
	{
		return parent::create($isNew);
	}

	/**
	 * retrieve a field
	 *
	 * @param int $i field id
	 * @param null fields
	 * @return mixed reference to the {@link Get} object
	 */
	public function get($i = null, $fields = null)
	{
		return parent::get($i, $fields);
	}

	/**
	 * get inserted id
	 *
	 * @param null
	 * @return int reference to the {@link Get} object
	 */
	public function getInsertId()
	{
		return $this->db->getInsertId();
	}

	/**
	 * Get Count Groupusers in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountGroupusers($start = 0, $limit = 0, $sort = 'gu_id ASC, gu_groupid', $order = 'ASC')
	{
		$crCountGroupusers = new \CriteriaCompo();
		$crCountGroupusers = $this->getGroupusersCriteria($crCountGroupusers, $start, $limit, $sort, $order);
		return $this->getCount($crCountGroupusers);
	}

	/**
	 * Get All Groupusers in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllGroupusers($start = 0, $limit = 0, $sort = 'gu_id ASC, gu_groupid', $order = 'ASC')
	{
		$crAllGroupusers = new \CriteriaCompo();
		$crAllGroupusers = $this->getGroupusersCriteria($crAllGroupusers, $start, $limit, $sort, $order);
		return $this->getAll($crAllGroupusers);
	}

	/**
	 * Get Criteria Groupusers
	 * @param        $crGroupusers
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getGroupusersCriteria($crGroupusers, $start, $limit, $sort, $order)
	{
		$crGroupusers->setStart($start);
		$crGroupusers->setLimit($limit);
		$crGroupusers->setSort($sort);
		$crGroupusers->setOrder($order);
		return $crGroupusers;
	}

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormSelectGroupusers($grpId, $action = false)
    {
        $helper = \XoopsModules\Wgdiaries\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        //$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm(\_MA_WGDIARIES_GROUPUSERS_EDIT, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Table groups
        $groupsHandler = $helper->getHandler('Groups');
        $groupsObj = $groupsHandler->get($grpId);
        $form->addElement(new \XoopsFormlabel(_AM_WGDIARIES_GROUPUSER_GROUPID, $groupsObj->getVar('grp_name')));
        $form->addElement(new \XoopsFormHidden('grp_id', $grpId));
        // Form Select User guUid
        $guUids = [];
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
        $form->addElement($guUidSelect);
        // Form Text Date Select guDatecreated
        $guDatecreated = time();
        // Form Select User guSubmitter
        $guSubmitter = $GLOBALS['xoopsUser']->uid();
        $form->addElement(new \XoopsFormHidden('gu_datecreated', $guDatecreated));
        $form->addElement(new \XoopsFormHidden('gu_submitter', $guSubmitter));

        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', _SUBMIT, 'submit', '', false));
        return $form;
    }
}
