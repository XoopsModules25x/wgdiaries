<?php

declare(strict_types=1);

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

include_once __DIR__ . '/common.php';
include_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGDIARIES_STATISTICS', 'Statistics');
// There are
\define('_AM_WGDIARIES_THEREARE_ITEMS', "There are <span class='bold'>%s</span> items in the database");
\define('_AM_WGDIARIES_THEREARE_FILES', "There are <span class='bold'>%s</span> files in the database");
\define('_AM_WGDIARIES_THEREARE_GROUPS', "There are <span class='bold'>%s</span> groups in the database");
\define('_AM_WGDIARIES_THEREARE_GROUPUSERS', "There are <span class='bold'>%s</span> groupusers in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGDIARIES_THEREARENT_ITEMS', "There aren't items");
\define('_AM_WGDIARIES_THEREARENT_FILES', "There aren't files");
\define('_AM_WGDIARIES_THEREARENT_GROUPS', "There aren't groups");
\define('_AM_WGDIARIES_THEREARENT_GROUPUSERS', "There aren't groupusers");
// Buttons
\define('_AM_WGDIARIES_ADD_ITEM', 'Add New Item');
\define('_AM_WGDIARIES_ADD_FILE', 'Add New File');
\define('_AM_WGDIARIES_ADD_GROUP', 'Add New Group');
\define('_AM_WGDIARIES_ADD_GROUPUSER', 'Add New Groupuser');
// Lists
\define('_AM_WGDIARIES_LIST_ITEMS', 'List of Items');
\define('_AM_WGDIARIES_LIST_FILES', 'List of Files');
\define('_AM_WGDIARIES_LIST_GROUPS', 'List of Groups');
\define('_AM_WGDIARIES_LIST_GROUPUSERS', 'List of Groupusers');
// ---------------- Admin Classes ----------------
// Groupuser add/edit
\define('_AM_WGDIARIES_GROUPUSER_ADD', 'Add Groupuser');
\define('_AM_WGDIARIES_GROUPUSER_EDIT', 'Edit Groupuser');
// Elements of Groupuser
\define('_AM_WGDIARIES_GROUPUSER_ID', 'Id');
\define('_AM_WGDIARIES_GROUPUSER_GROUPID', 'Groups/Projects');
\define('_AM_WGDIARIES_GROUPUSER_UID', 'User');
\define('_AM_WGDIARIES_GROUPUSER_DATECREATED', 'Datecreated');
\define('_AM_WGDIARIES_GROUPUSER_SUBMITTER', 'Submitter');

// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL', 'Permissions global');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_DESC', 'Permissions global to check type of.');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_SUBMIT', 'Permissions global to submit');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_EDIT', 'Permissions global to edit');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_VIEW', 'Permissions global to view');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_SUBMIT', 'Permissions to submit items');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_GROUP_EDIT', 'Permissions to edit items of group');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_GROUP_VIEW', 'Permissions to view items of group');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_OWN_EDIT', 'Permissions to edit own items');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_OWN_VIEW', 'Permissions to view own items');
\define('_AM_WGDIARIES_PERMISSIONS_ITEMS_COMEDIT', 'Permissions to view and edit comments for items');
\define('_AM_WGDIARIES_PERMISSIONS_GROUPS_EDIT', 'Permissions to edit groups and users');
\define('_AM_WGDIARIES_PERMISSIONS_GROUPS_VIEW', 'Permissions to view groups and users');
\define('_AM_WGDIARIES_NO_PERMISSIONS_SET', 'No permission set');
// ---------------- Admin Others ----------------
\define('_AM_WGDIARIES_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGDIARIES_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGDIARIES_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGDIARIES_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
