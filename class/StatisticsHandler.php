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

use XoopsModules\Wgdiaries\Constants;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object StatisticsHandler
 */
class StatisticsHandler extends \XoopsPersistableObjectHandler
{
	/**
	 * Constructor
	 *
	 * @param null
	 */
	public function __construct()
	{
	}

	/**
	 * @public function to get items for given params
	 * @param     $from
     * @param     $to
     * @param int $groupId
     * @param int $uid
	 * @return bool|array
	 */
	public function getStatisticItems($from, $to, $mygroups = false, $uid = 0 )
	{
        $helper  = \XoopsModules\Wgdiaries\Helper::getInstance();
        $itemsHandler = $helper->getHandler('Items');

		return false;
	}

}
