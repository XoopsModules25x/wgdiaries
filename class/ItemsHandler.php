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
 * WFH Diaries module for xoops
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
 * Class Object Handler Items
 */
class ItemsHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param \XoopsDatabase $db
	 */
	public function __construct(\XoopsDatabase $db)
	{
		parent::__construct($db, 'wgdiaries_items', Items::class, 'item_id', 'item_submitter');
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
	 * Get Count Items in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	public function getCountItems($start = 0, $limit = 0, $sort = 'item_id ASC, item_submitter', $order = 'ASC')
	{
		$crCountItems = new \CriteriaCompo();
		$crCountItems = $this->getItemsCriteria($crCountItems, $start, $limit, $sort, $order);
		return $this->getCount($crCountItems);
	}

	/**
	 * Get All Items in the database
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return array
	 */
	public function getAllItems($start = 0, $limit = 0, $sort = 'item_id ASC, item_submitter', $order = 'ASC')
	{
		$crAllItems = new \CriteriaCompo();
		$crAllItems = $this->getItemsCriteria($crAllItems, $start, $limit, $sort, $order);
		return $this->getAll($crAllItems);
	}

	/**
	 * Get Criteria Items
	 * @param        $crItems
	 * @param int    $start
	 * @param int    $limit
	 * @param string $sort
	 * @param string $order
	 * @return int
	 */
	private function getItemsCriteria($crItems, $start, $limit, $sort, $order)
	{
		$crItems->setStart($start);
		$crItems->setLimit($limit);
		$crItems->setSort($sort);
		$crItems->setOrder($order);
		return $crItems;
	}
}
