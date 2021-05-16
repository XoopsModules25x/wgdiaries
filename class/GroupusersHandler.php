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
}
