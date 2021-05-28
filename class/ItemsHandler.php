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
use XoopsModules\Wgdiaries\Constants;

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

    /**
 * @public function to get items for given params
 *
 * @param int  $uid         : select by/exclude given uid
 * @param int  $start
 * @param int  $limit
 * @param int  $from        : filter date created from (timestamp)
 * @param int  $to          : filter date created to (timestamp)
 * @param bool $mygroups    : show items of all groups of current user
 * @param bool $excludeuid  : exclude given uid from result
 * @return bool|array
 */
    public function getItems($uid = 0, $start = 0, $limit = 0, $from = 0, $to = 0, $mygroups = false, $excludeuid = false, $groupid = 0)
    {
        $helper  = Wgdiaries\Helper::getInstance();
        $itemsHandler = $helper->getHandler('Items');

        $crItems = new \CriteriaCompo();
        if ($uid <> 0) {
            if ($excludeuid) {
                $crItems->add(new \Criteria('item_submitter', $uid, '<>'));
            } else {
                $crItems->add(new \Criteria('item_submitter', $uid));
            }
        }
        if ($mygroups) {
            $memberHandler = \xoops_getHandler('member');
            $xoopsGroups = $memberHandler->getGroupList();
            $myGroups = array_keys($xoopsGroups);
            $crItems->add(new \Criteria('item_groupid', "(" . implode(',', $myGroups) . ")", 'IN'));
        }
        if ($groupid >  0) {
            $crItems->add(new \Criteria('item_groupid', $groupid));
        }
        if ($from >  0) {
            $crItems->add(new \Criteria('item_datefrom', $from, '>='));
            $crItems->add(new \Criteria('item_dateto', $to, '<='));
        }
        $crItems->setSort('item_id');
        $crItems->setOrder('DESC');
        $itemsCount = $itemsHandler->getCount($crItems);
        if ($itemsCount > 0) {
            if ($start > 0) {
                $crItems->setStart($start);
            }
            if ($limit > 0) {
                $crItems->setLimit($limit);
            }
            $itemsAll = $itemsHandler->getAll($crItems);
            // Get All Items
            $items = [];
            foreach (\array_keys($itemsAll) as $i) {
                $items[$i] = $itemsAll[$i]->getValuesItems();
            }

            return $items;
        }

        return false;
    }

    /**
     * @public function to get items for given params
     *
     * @param int  $uid         : select by/exclude given uid
     * @param int  $from        : filter date created from (timestamp)
     * @param int  $to          : filter date created to (timestamp)
     * @param bool $mygroups    : show items of all groups of current user
     * @param bool $excludeuid  : exclude given uid from result
     * @return int
     */
    public function getItemsCount($uid = 0, $from = 0, $to = 0, $mygroups = false, $excludeuid = false, $groupid = 0)
    {
        $helper  = Wgdiaries\Helper::getInstance();
        $itemsHandler = $helper->getHandler('Items');

        $crItems = new \CriteriaCompo();
        if ($uid <> 0) {
            if ($excludeuid) {
                $crItems->add(new \Criteria('item_submitter', $uid, '<>'));
            } else {
                $crItems->add(new \Criteria('item_submitter', $uid));
            }
        }
        if ($mygroups) {
            $memberHandler = \xoops_getHandler('member');
            $xoopsGroups = $memberHandler->getGroupList();
            $myGroups = array_keys($xoopsGroups);
            $crItems->add(new \Criteria('item_groupid', "(" . implode(',', $myGroups) . ")", 'IN'));
        }
        if ($groupid >  0) {
            $crItems->add(new \Criteria('item_groupid', $groupid));
        }
        if ($from >  0) {
            $crItems->add(new \Criteria('item_datefrom', $from, '>='));
            $crItems->add(new \Criteria('item_dateto', $to, '<='));
        }
        $crItems->setSort('item_id');
        $crItems->setOrder('DESC');

        return $itemsHandler->getCount($crItems);
    }

    /**
     * @public function to get form for filter items
     * @param $filterYear
     * @param $filterMonthFrom
     * @param $filterYearFrom
     * @param $filterMonthTo
     * @param $filterYearTo
     * @param $yearMin
     * @param $yearMax
     * @param string $op
     * @return FormInline
     */
    public static function getFormFilterItems($filterFrom, $filterTo, $start, $limit, $filterByOwner, $filterGroup)
    {

        $helper = Wgdiaries\Helper::getInstance();
        $permissionsHandler = $helper->getHandler('Permissions');

        $action = $_SERVER['REQUEST_URI'];

        // Title
        //$title = \_MA_WGSIMPLEACC_FILTERBY_YEAR;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsModules\Wgdiaries\FormInline('', 'formFilter', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgsa-form-inline"');

        // Filter period Tray
        $selectFromToTray = new \XoopsFormElementTray(\_MA_WGDIARIES_FILTERBY_PERIOD . ': ', '&nbsp;');
        // Filter Date From
        $selectFromToTray->addElement(new \XoopsFormTextDateSelect(\_MA_WGDIARIES_FILTER_PERIODFROM, 'filterFrom', '', $filterFrom));
        // Filter Date To
        $selectFromToTray->addElement(new \XoopsFormTextDateSelect(\_MA_WGDIARIES_FILTER_PERIODTO, 'filterTo', '', $filterTo));
        $form->addElement($selectFromToTray);

        // Filter Groups
        if ($permissionsHandler->getPermItemsGroupView()) {
            //linebreak
            $form->addElement(new \XoopsFormHidden('linebreak', ''));
            $selectOwnerTray = new \XoopsFormElementTray(\_MA_WGDIARIES_FILTERBY_OWNER . ': ', '&nbsp;');
            // Form Radio Type
            $typeRadioSelect = new \XoopsFormRadio('', 'filterByOwner', $filterByOwner);
            $typeRadioSelect->addOption(Constants::FILTERBY_OWN, \_MA_WGDIARIES_FILTERBY_OWN);
            $typeRadioSelect->addOption(Constants::FILTERBY_GROUP, \_MA_WGDIARIES_FILTERBY_GROUP);
            $selectOwnerTray->addElement($typeRadioSelect);
            // Get groups
            $memberHandler = \xoops_getHandler('member');
            $xoopsGroups  = $memberHandler->getGroupList();

            $filterGroupSelect = new \XoopsFormSelect('', 'filterGroup', $filterGroup);
            $filterGroupSelect->addOption(Constants::FILTER_TYPEALL, \_MA_WGDIARIES_FILTER_TYPEALL);
            foreach ($xoopsGroups as $key => $group) {
                $filterGroupSelect->addOption($key, $group);
            }

             //if no Transactions available for current year
            $selectOwnerTray->addElement($filterGroupSelect, true);
            $form->addElement($selectOwnerTray);
        } else {
            $form->addElement(new \XoopsFormHidden('filterOwner', Constants::FILTERBY_OWN));
        }

        $form->addElement(new \XoopsFormHidden('start', $start));
        // Form Text limit
        $form->addElement(new \XoopsFormText(\_AM_WGDIARIES_FILTER_LIMIT, 'limit', 50, 255, $limit));

        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        $btnApply = new \XoopsFormButton('', 'submit', \_MA_WGDIARIES_FILTER_APPLY, 'submit');
        $form->addElement($btnApply);
        //$form->addElement(new \XoopsFormHidden('displayfilter', 1));
        $form->addElement(new \XoopsFormHidden('start', 0));
        $form->addElement(new \XoopsFormHidden('op', 'filter'));
        return $form;

    }
}
