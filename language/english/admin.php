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
 * WFH Diaries module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgwfhdiaries
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         wedega - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

include_once __DIR__ . '/common.php';
include_once __DIR__ . '/main.php';

// ---------------- Admin Index ----------------
\define('_AM_WGWFHDIARIES_STATISTICS', 'Statistics');
// There are
\define('_AM_WGWFHDIARIES_THEREARE_ITEMS', "There are <span class='bold'>%s</span> items in the database");
\define('_AM_WGWFHDIARIES_THEREARE_FILES', "There are <span class='bold'>%s</span> files in the database");
// ---------------- Admin Files ----------------
// There aren't
\define('_AM_WGWFHDIARIES_THEREARENT_ITEMS', "There aren't items");
\define('_AM_WGWFHDIARIES_THEREARENT_FILES', "There aren't files");
// Save/Delete
\define('_AM_WGWFHDIARIES_FORM_OK', 'Successfully saved');
\define('_AM_WGWFHDIARIES_FORM_DELETE_OK', 'Successfully deleted');
\define('_AM_WGWFHDIARIES_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_AM_WGWFHDIARIES_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
// Buttons
\define('_AM_WGWFHDIARIES_ADD_ITEM', 'Add New Item');
\define('_AM_WGWFHDIARIES_ADD_FILE', 'Add New File');
// Lists
\define('_AM_WGWFHDIARIES_ITEMS_LIST', 'List of Items');
\define('_AM_WGWFHDIARIES_FILES_LIST', 'List of Files');
// ---------------- Admin Classes ----------------
// Item add/edit
\define('_AM_WGWFHDIARIES_ITEM_ADD', 'Add Item');
\define('_AM_WGWFHDIARIES_ITEM_EDIT', 'Edit Item');
// Elements of Item
\define('_AM_WGWFHDIARIES_ITEM_ID', 'Id');
\define('_AM_WGWFHDIARIES_ITEM_REMARKS', 'Remarks');
\define('_AM_WGWFHDIARIES_ITEM_DATEFROM', 'Datefrom');
\define('_AM_WGWFHDIARIES_ITEM_DATETO', 'Dateto');
\define('_AM_WGWFHDIARIES_ITEM_DATECREATED', 'Datecreated');
\define('_AM_WGWFHDIARIES_ITEM_SUBMITTER', 'Submitter');
// File add/edit
\define('_AM_WGWFHDIARIES_FILE_ADD', 'Add File');
\define('_AM_WGWFHDIARIES_FILE_EDIT', 'Edit File');
// Elements of File
\define('_AM_WGWFHDIARIES_FILE_ID', 'Id');
\define('_AM_WGWFHDIARIES_FILE_ITEMID', 'Items');
\define('_AM_WGWFHDIARIES_FILE_DESC', 'Desc');
\define('_AM_WGWFHDIARIES_FILE_NAME', 'Name');
\define('_AM_WGWFHDIARIES_FILE_NAME_UPLOADS', 'Name in %s :');
\define('_AM_WGWFHDIARIES_FILE_DATECREATED', 'Datecreated');
\define('_AM_WGWFHDIARIES_FILE_SUBMITTER', 'Submitter');
// General
\define('_AM_WGWFHDIARIES_FORM_UPLOAD', 'Upload file');
\define('_AM_WGWFHDIARIES_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_AM_WGWFHDIARIES_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_AM_WGWFHDIARIES_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_AM_WGWFHDIARIES_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_AM_WGWFHDIARIES_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_AM_WGWFHDIARIES_FORM_IMAGE_PATH', 'Files in %s :');
\define('_AM_WGWFHDIARIES_FORM_ACTION', 'Action');
\define('_AM_WGWFHDIARIES_FORM_EDIT', 'Modification');
\define('_AM_WGWFHDIARIES_FORM_DELETE', 'Clear');
// ---------------- Admin Others ----------------
\define('_AM_WGWFHDIARIES_ABOUT_MAKE_DONATION', 'Submit');
\define('_AM_WGWFHDIARIES_SUPPORT_FORUM', 'Support Forum');
\define('_AM_WGWFHDIARIES_DONATION_AMOUNT', 'Donation Amount');
\define('_AM_WGWFHDIARIES_MAINTAINEDBY', ' is maintained by ');
// ---------------- End ----------------
