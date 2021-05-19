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

/**
 * Interface  Constants
 */
interface Constants
{
    // Constants for tables
    const TABLE_ITEMS = 0;
    const TABLE_FILES = 1;
    const TABLE_GROUPS = 2;
    const TABLE_GROUPUSERS = 3;

    // Constants for status
    public const STATUS_NONE      = 0;
    public const STATUS_OFFLINE   = 1;
    public const STATUS_SUBMITTED = 2;
    public const STATUS_APPROVED  = 3;
    public const STATUS_BROKEN    = 4;

    // Constants for permissions
    public const PERM_GLOBAL_NONE      = 0;
    public const PERM_GLOBAL_SUBMIT    = 1;
    public const PERM_GLOBAL_EDIT      = 2;
    public const PERM_GLOBAL_VIEW      = 3;
    public const PERM_ITEMS_SUBMIT     = 4;
    public const PERM_ITEMS_GROUP_EDIT = 5;
    public const PERM_ITEMS_GROUP_VIEW = 6;
    public const PERM_ITEMS_OWN_EDIT   = 7;
    public const PERM_ITEMS_OWN_VIEW   = 8;
    public const PERM_GROUPS_EDIT      = 9;
    public const PERM_GROUPS_VIEW      = 10;

}
