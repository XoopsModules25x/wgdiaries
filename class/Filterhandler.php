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
 * Class Object
 */
class Filterhandler
{
    /**
     * @var int
     */
    public $filterFrom = 0;
    /**
     * @var int
     */
    public $filterTo = 0;
    /**
     * @var int
     */
    public $start = 0;
    /**
     * @var int
     */
    public $limit = 0;
    /**
     * @var int
     */
    public $filterByOwner = 0;
    /**
     * @var int
     */
    public $filterGroup = 0;
    /**
     * @var mixed
     */
    public $filterCat = 0;
    /**
     * @var string
     */
    public $filterSort = '';
    /**
     * @var bool
     */
    public $showSort = true;
    /**
     * @var bool
     */
    public $showLimit = true;
    /**
     * @var bool
     */
    public $showPeriod = true;
    /**
     * @var int
     */
    public $filterYear = 0;
    /**
     * @var int
     */
    public $filterMonth = 0;

    /**
     * Constructor
     */
    public function __construct() { }

    /**
     * @public function to get form for filter items
     * @return FormInline
     */
    public function getFormFilterItems()
    {
        $helper             = Wgdiaries\Helper::getInstance();
        $permissionsHandler = $helper->getHandler('Permissions');

        $action = $_SERVER['REQUEST_URI'];

        // Title
        //$title = \_MA_WGSIMPLEACC_FILTERBY_YEAR;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsModules\Wgdiaries\FormInline('', 'formFilter', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgd-form-inline"');

        if ($this->showPeriod) {
            // Filter period Tray
            $selectFromToTray = new \XoopsFormElementTray(\_MA_WGDIARIES_FILTERBY_PERIOD . ': ', '&nbsp;');
            // Filter Date From
            $selectFromToTray->addElement(new \XoopsFormTextDateSelect(\_MA_WGDIARIES_FILTER_PERIODFROM, 'filterFrom', '', $this->filterFrom));
            // Filter Date To
            $selectFromToTray->addElement(new \XoopsFormTextDateSelect(\_MA_WGDIARIES_FILTER_PERIODTO, 'filterTo', '', $this->filterTo));
            $form->addElement($selectFromToTray);
        }

        // Filter Groups
        if ($permissionsHandler->getPermItemsGroupView()) {
            //linebreak
            $form->addElement(new \XoopsFormHidden('linebreak', ''));
            $selectOwnerTray = new \XoopsFormElementTray(\_MA_WGDIARIES_FILTERBY_OWNER . ': ', '&nbsp;');
            // Form Radio Type
            $typeRadioSelect = new \XoopsFormRadio('', 'filterByOwner', $this->filterByOwner);
            $typeRadioSelect->addOption(Constants::FILTERBY_OWN, \_MA_WGDIARIES_FILTERBY_OWN);
            $typeRadioSelect->addOption(Constants::FILTERBY_GROUP, \_MA_WGDIARIES_FILTERBY_GROUP);
            $selectOwnerTray->addElement($typeRadioSelect);
            // Get groups
            $memberHandler = \xoops_getHandler('member');
            $xoopsGroups   = $memberHandler->getGroupList();

            $filterGroupSelect = new \XoopsFormSelect('', 'filterGroup', $this->filterGroup);
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

        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        // Form Table categories
        $categoriesHandler = $helper->getHandler('Categories');
        $crCategories      = new \CriteriaCompo();
        $crCategories->add(new \Criteria('cat_online', 1));
        $crCategories->setSort('cat_weight');
        $crCategories->setOrder('ASC');
        $itemCatidSelect = new \XoopsFormSelect(\_MA_WGDIARIES_ITEM_CATID, 'filterCat', $this->filterCat);
        $itemCatidSelect->addOption(0, \_MA_WGDIARIES_FILTER_TYPEALL);
        $itemCatidSelect->addOptionArray($categoriesHandler->getList($crCategories));
        $form->addElement($itemCatidSelect);

        if ($this->showLimit) {
            //linebreak
            $form->addElement(new \XoopsFormHidden('linebreak', ''));
            $form->addElement(new \XoopsFormHidden('start', $this->start));
            // Form Text limit
            $form->addElement(new \XoopsFormText(\_MA_WGDIARIES_FILTER_LIMIT, 'limit', 50, 255, $this->limit));
        }

        if ($this->showSort) {
            //linebreak
            $form->addElement(new \XoopsFormHidden('linebreak', ''));
            $filterSortSelect = new \XoopsFormSelect(\_MA_WGDIARIES_SORT, 'filterSort', $this->filterSort);
            $filterSortSelect->addOption('item_datefrom-DESC', \_MA_WGDIARIES_SORT_DATEFROM_DESC);
            $filterSortSelect->addOption('item_datefrom-ASC', \_MA_WGDIARIES_SORT_DATEFROM_ASC);
            $filterSortSelect->addOption('item_datecreated-DESC', \_MA_WGDIARIES_SORT_DATECREATED_DESC);
            $filterSortSelect->addOption('item_datecreated-ASC', \_MA_WGDIARIES_SORT_DATECREATED_ASC);
            $form->addElement($filterSortSelect);
        } else {
            $form->addElement(new \XoopsFormHidden('filterSort', $this->filterSort));
        }

        //linebreak
        $form->addElement(new \XoopsFormHidden('linebreak', ''));
        $btnApply = new \XoopsFormButton('', 'submit', \_MA_WGDIARIES_FILTER_APPLY, 'submit');
        $form->addElement($btnApply);
        $form->addElement(new \XoopsFormHidden('op', 'filter'));

        return $form;
    }

    /**
     * @public function to get form for filter items
     * @return FormInline
     */
    public function getFormFilterStatistics()
    {
        $helper             = Wgdiaries\Helper::getInstance();
        $permissionsHandler = $helper->getHandler('Permissions');

        $action = $_SERVER['REQUEST_URI'];

        // Title
        //$title = \_MA_WGSIMPLEACC_FILTERBY_YEAR;
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsModules\Wgdiaries\FormInline('', 'formFilter', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $form->setExtra('class="wgd-form-inline"');

        // Filter Tray
        $selectFilterTray = new \XoopsFormElementTray('', '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
        // Filter year
        $currentYear = (int) date('Y');
        $firstYear = 2019;
        $formSelectYear = new \XoopsFormSelect(\_MA_WGDIARIES_STATS_SELECT_YEAR, 'year', $this->filterYear);
        for ($i = $firstYear; $i <= $currentYear; $i++) {
            $formSelectYear->addOption($i, $i);
        }
        $formSelectYear->setExtra("onchange='submit()'");
        $selectFilterTray->addElement($formSelectYear);
        // Filter month
        $formSelectMonth = new \XoopsFormSelect(\_MA_WGDIARIES_STATS_SELECT_MONTH, 'month', $this->filterMonth);
        $formSelectMonth->addOption(1, \_MA_WGDIARIES_CAL_JANUARY);
        $formSelectMonth->addOption(2, \_MA_WGDIARIES_CAL_FEBRUARY);
        $formSelectMonth->addOption(3, \_MA_WGDIARIES_CAL_MARCH);
        $formSelectMonth->addOption(4, \_MA_WGDIARIES_CAL_APRIL);
        $formSelectMonth->addOption(5, \_MA_WGDIARIES_CAL_MAY);
        $formSelectMonth->addOption(6, \_MA_WGDIARIES_CAL_JUNE);
        $formSelectMonth->addOption(7, \_MA_WGDIARIES_CAL_JULY);
        $formSelectMonth->addOption(8, \_MA_WGDIARIES_CAL_AUGUST);
        $formSelectMonth->addOption(9, \_MA_WGDIARIES_CAL_SEPTEMBER);
        $formSelectMonth->addOption(10, \_MA_WGDIARIES_CAL_OCTOBER);
        $formSelectMonth->addOption(11, \_MA_WGDIARIES_CAL_NOVEMBER);
        $formSelectMonth->addOption(12, \_MA_WGDIARIES_CAL_DECEMBER);
        $formSelectMonth->setExtra("onchange='submit();return true;'");
        $selectFilterTray->addElement($formSelectMonth);
        $form->addElement($selectFilterTray);
        //linebreak
        $form->addElement(new \XoopsFormHidden('op', 'filter'));

        return $form;
    }
}
