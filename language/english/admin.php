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
// Save/Delete
\define('_AM_WGDIARIES_FORM_OK', 'Successfully saved');
\define('_AM_WGDIARIES_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_WGDIARIES_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGDIARIES_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Buttons
\define('_AM_WGDIARIES_ADD_ITEM', 'Add New Item');
\define('_AM_WGDIARIES_ADD_FILE', 'Add New File');
\define('_AM_WGDIARIES_ADD_GROUP', 'Add New Group');
\define('_AM_WGDIARIES_ADD_GROUPUSER', 'Add New Groupuser');
// Lists
\define('_AM_WGDIARIES_ITEMS_LIST', 'List of Items');
\define('_AM_WGDIARIES_FILES_LIST', 'List of Files');
\define('_AM_WGDIARIES_GROUPS_LIST', 'List of Groups');
\define('_AM_WGDIARIES_GROUPUSERS_LIST', 'List of Groupusers');
// ---------------- Admin Classes ----------------
// Item add/edit
\define('_AM_WGDIARIES_ITEM_ADD', 'Add Item');
\define('_AM_WGDIARIES_ITEM_EDIT', 'Edit Item');
// Elements of Item
\define('_AM_WGDIARIES_ITEM_ID', 'Id');
\define('_AM_WGDIARIES_ITEM_REMARKS', 'Remarks');
\define('_AM_WGDIARIES_ITEM_DATEFROM', 'Datefrom');
\define('_AM_WGDIARIES_ITEM_DATETO', 'Dateto');
\define('_AM_WGDIARIES_ITEM_DATECREATED', 'Datecreated');
\define('_AM_WGDIARIES_ITEM_SUBMITTER', 'Submitter');
// File add/edit
\define('_AM_WGDIARIES_FILE_ADD', 'Add File');
\define('_AM_WGDIARIES_FILE_EDIT', 'Edit File');
// Elements of File
\define('_AM_WGDIARIES_FILE_ID', 'Id');
\define('_AM_WGDIARIES_FILE_ITEMID', 'Items');
\define('_AM_WGDIARIES_FILE_DESC', 'Desc');
\define('_AM_WGDIARIES_FILE_NAME', 'Name');
\define('_AM_WGDIARIES_FILE_NAME_UPLOADS', 'Name in %s :');
\define('_AM_WGDIARIES_FILE_DATECREATED', 'Datecreated');
\define('_AM_WGDIARIES_FILE_SUBMITTER', 'Submitter');
// Group add/edit
\define('_AM_WGDIARIES_GROUP_ADD', 'Add Group');
\define('_AM_WGDIARIES_GROUP_EDIT', 'Edit Group');
// Elements of Group
\define('_AM_WGDIARIES_GROUP_ID', 'Id');
\define('_AM_WGDIARIES_GROUP_NAME', 'Name');
\define('_AM_WGDIARIES_GROUP_LOGO', 'Logo');
\define('_AM_WGDIARIES_GROUP_LOGO_UPLOADS', 'Logo in %s :');
\define('_AM_WGDIARIES_GROUP_ONLINE', 'Online');
\define('_AM_WGDIARIES_GROUP_DATECREATED', 'Datecreated');
\define('_AM_WGDIARIES_GROUP_SUBMITTER', 'Submitter');
// Groupuser add/edit
\define('_AM_WGDIARIES_GROUPUSER_ADD', 'Add Groupuser');
\define('_AM_WGDIARIES_GROUPUSER_EDIT', 'Edit Groupuser');
// Elements of Groupuser
\define('_AM_WGDIARIES_GROUPUSER_ID', 'Id');
\define('_AM_WGDIARIES_GROUPUSER_GROUPID', 'Groups');
\define('_AM_WGDIARIES_GROUPUSER_UID', 'Uid');
\define('_AM_WGDIARIES_GROUPUSER_DATECREATED', 'Datecreated');
\define('_AM_WGDIARIES_GROUPUSER_SUBMITTER', 'Submitter');
// General
\define('_AM_WGDIARIES_FORM_UPLOAD', 'Upload file');
\define('_AM_WGDIARIES_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_AM_WGDIARIES_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_AM_WGDIARIES_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_AM_WGDIARIES_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_AM_WGDIARIES_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_AM_WGDIARIES_FORM_IMAGE_PATH', 'Files in %s :');
\define('_AM_WGDIARIES_FORM_ACTION', 'Action');
\define('_AM_WGDIARIES_FORM_EDIT', 'Modification');
\define('_AM_WGDIARIES_FORM_DELETE', 'Clear');
// ---------------- Admin Permissions ----------------
// Permissions
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL', 'Permissions global');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_DESC', 'Permissions global to check type of.');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_4', 'Permissions global to approve');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_8', 'Permissions global to submit');
\define('_AM_WGDIARIES_PERMISSIONS_GLOBAL_16', 'Permissions global to view');
\define('_AM_WGDIARIES_PERMISSIONS_APPROVE', 'Permissions to approve');
\define('_AM_WGDIARIES_PERMISSIONS_APPROVE_DESC', 'Permissions to approve');
\define('_AM_WGDIARIES_PERMISSIONS_SUBMIT', 'Permissions to submit');
\define('_AM_WGDIARIES_PERMISSIONS_SUBMIT_DESC', 'Permissions to submit');
\define('_AM_WGDIARIES_PERMISSIONS_VIEW', 'Permissions to view');
\define('_AM_WGDIARIES_PERMISSIONS_VIEW_DESC', 'Permissions to view');
\define('_AM_WGDIARIES_NO_PERMISSIONS_SET', 'No permission set');
// ---------------- Admin Others ----------------
\define('_AM_WGDIARIES_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGDIARIES_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGDIARIES_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGDIARIES_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
