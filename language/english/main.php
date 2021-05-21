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

include_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGDIARIES_INDEX', 'Overview wgDiaries');
\define('_MA_WGDIARIES_TITLE', 'wgDiaries');
\define('_MA_WGDIARIES_DESC', 'Simple module for a diary for work from home');
\define('_MA_WGDIARIES_INDEX_DESC', "Welcome to the homepage of your new module wgDiaries!<br>
As you can see, you have created a page with a list of links at the top to navigate between the pages of your module. This description is only visible on the homepage of this module, the other pages you will see the content you created when you built this module with the module ModuleBuilder, and after creating new content in admin of this module. In order to expand this module with other resources, just add the code you need to extend the functionality of the same. The files are grouped by type, from the header to the footer to see how divided the source code.<br><br>If you see this message, it is because you have not created content for this module. Once you have created any type of content, you will not see this message.<br><br>If you liked the module ModuleBuilder and thanks to the long process for giving the opportunity to the new module to be created in a moment, consider making a donation to keep the module ModuleBuilder and make a donation using this button <a href='http://www.txmodxoops.org/modules/xdonations/index.php' title='Donation To Txmod Xoops'><img src='https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif' alt='Button Donations' /></a><br>Thanks!<br><br>Use the link below to go to the admin and create content.");
\define('_MA_WGDIARIES_NO_PDF_LIBRARY', 'Libraries TCPDF not there yet, upload them in root/Frameworks');
\define('_MA_WGDIARIES_NO', 'No');
\define('_MA_WGDIARIES_DETAILS', 'Show details');
\define('_MA_WGDIARIES_BROKEN', 'Notify broken');
// ---------------- Contents ----------------
// General/forms
\define('_MA_WGDIARIES_FORM_OK', 'Successfully saved');
\define('_MA_WGDIARIES_FORM_DELETE_OK', 'Successfully deleted');
\define('_MA_WGDIARIES_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGDIARIES_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGDIARIES_FORM_UPLOAD', 'Upload file');
\define('_MA_WGDIARIES_FORM_UPLOAD_NEW', 'Upload new file: ');
\define('_MA_WGDIARIES_FORM_UPLOAD_SIZE', 'Max file size: ');
\define('_MA_WGDIARIES_FORM_UPLOAD_SIZE_MB', 'MB');
\define('_MA_WGDIARIES_FORM_UPLOAD_IMG_WIDTH', 'Max image width: ');
\define('_MA_WGDIARIES_FORM_UPLOAD_IMG_HEIGHT', 'Max image height: ');
\define('_MA_WGDIARIES_FORM_IMAGE_PATH', 'Files in %s :');
\define('_MA_WGDIARIES_FORM_ACTION', 'Action');
\define('_MA_WGDIARIES_FORM_EDIT', 'Modification');
\define('_MA_WGDIARIES_FORM_DELETE', 'Clear');
\define('_MA_WGDIARIES_INVALID_PARAM', "Invalid parameter");
\define('_MA_WGDIARIES_FORM_ERROR', 'Error when processing data');
\define('_MA_WGDIARIES_FORM_ERROR_DELETE_GU', 'Error when deleting data of group users');
// Item
\define('_MA_WGDIARIES_ITEM', 'Item');
\define('_MA_WGDIARIES_ITEM_ADD', 'Add Items');
\define('_MA_WGDIARIES_ITEM_EDIT', 'Edit Items');
\define('_MA_WGDIARIES_ITEM_DELETE', 'Delete Items');
\define('_MA_WGDIARIES_ITEMS', 'Items');
\define('_MA_WGDIARIES_ITEMS_LIST', 'List of Items');
\define('_MA_WGDIARIES_ITEMS_LISTMY', 'List of my items');
\define('_MA_WGDIARIES_ITEMS_LISTGROUP', 'List of my items and of my group');
\define('_MA_WGDIARIES_ITEMS_TITLE', 'Items title');
\define('_MA_WGDIARIES_ITEMS_DESC', 'Items description');
\define('_MA_WGDIARIES_ITEM_CAPTION', 'Item No. %s (%s, from %s to %s)');
// Caption of Item
\define('_MA_WGDIARIES_ITEM_ID', 'Id');
\define('_MA_WGDIARIES_ITEM_GROUPID', 'Group');
\define('_MA_WGDIARIES_ITEM_REMARKS', 'Remarks');
\define('_MA_WGDIARIES_ITEM_DATEFROM', 'Datefrom');
\define('_MA_WGDIARIES_ITEM_DATETO', 'Dateto');
\define('_MA_WGDIARIES_ITEM_DATECREATED', 'Datecreated');
\define('_MA_WGDIARIES_ITEM_SUBMITTER', 'Submitter');
\define('_MA_WGDIARIES_ITEM_NBFILES', 'Files');
\define('_MA_WGDIARIES_ITEM_COMMENTS', 'Comments');
\define('_MA_WGDIARIES_ITEM_SAVEADDFILES', 'Submit and add files');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES', 'Upload files');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES_BTN', 'Add new upload field');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES_MAX', 'Maximum number of allowed upload fields reached');
// File
\define('_MA_WGDIARIES_FILE', 'File');
\define('_MA_WGDIARIES_FILE_ADD', 'Add File');
\define('_MA_WGDIARIES_FILE_EDIT', 'Edit File');
\define('_MA_WGDIARIES_FILE_DELETE', 'Delete File');
\define('_MA_WGDIARIES_FILES', 'Files');
\define('_MA_WGDIARIES_FILES_LIST', 'List of Files');
\define('_MA_WGDIARIES_FILES_TITLE', 'Files title');
\define('_MA_WGDIARIES_FILES_DESC', 'Files description');
// Caption of File
\define('_MA_WGDIARIES_FILE_ID', 'Id');
\define('_MA_WGDIARIES_FILE_ITEMID', 'Itemid');
\define('_MA_WGDIARIES_FILE_DESC', 'Desc');
\define('_MA_WGDIARIES_FILE_NAME', 'Name');
\define('_MA_WGDIARIES_FILE_DATECREATED', 'Datecreated');
\define('_MA_WGDIARIES_FILE_SUBMITTER', 'Submitter');
// Group
\define('_MA_WGDIARIES_GROUP', 'Group');
\define('_MA_WGDIARIES_GROUP_ADD', 'Add Groups');
\define('_MA_WGDIARIES_GROUP_EDIT', 'Edit Groups');
\define('_MA_WGDIARIES_GROUP_DELETE', 'Delete Groups');
\define('_MA_WGDIARIES_GROUPS', 'Groups');
\define('_MA_WGDIARIES_GROUPS_LIST', 'List of Groups');
\define('_MA_WGDIARIES_GROUPS_TITLE', 'Groups title');
\define('_MA_WGDIARIES_GROUPS_DESC', 'Groups description');
// Caption of Group
\define('_MA_WGDIARIES_GROUP_ID', 'Id');
\define('_MA_WGDIARIES_GROUP_NAME', 'Name');
\define('_MA_WGDIARIES_GROUP_LOGO', 'Logo');
\define('_MA_WGDIARIES_GROUP_LOGO_UPLOADS', 'Logo in %s :');
\define('_MA_WGDIARIES_GROUP_ONLINE', 'Online');
\define('_MA_WGDIARIES_GROUP_DATECREATED', 'Datecreated');
\define('_MA_WGDIARIES_GROUP_SUBMITTER', 'Submitter');
// Groupuser
\define('_MA_WGDIARIES_GROUPUSERS', 'Groupuser');
\define('_MA_WGDIARIES_GROUPUSERS_EDIT', 'Edit Groupusers');
\define('_MA_WGDIARIES_GROUPUSERS_DELETE', 'Delete Groupusers');
\define('_MA_WGDIARIES_GROUPUSERS_LINKED', 'Users linked to this group');

// Caption of Groupuser
\define('_MA_WGDIARIES_GROUPUSER_ID', 'Id');
\define('_MA_WGDIARIES_GROUPUSER_GROUPID', 'Groupid');
\define('_MA_WGDIARIES_GROUPUSER_UID', 'Uid');
\define('_MA_WGDIARIES_GROUPUSER_DATECREATED', 'Datecreated');
\define('_MA_WGDIARIES_GROUPUSER_SUBMITTER', 'Submitter');
\define('_MA_WGDIARIES_INDEX_THEREARE', 'There are %s Groupusers');
\define('_MA_WGDIARIES_INDEX_LATEST_LIST', 'Last wgDiaries');
// Submit
\define('_MA_WGDIARIES_SUBMIT', 'Submit');
// Admin link
\define('_MA_WGDIARIES_ADMIN', 'Admin');
// ---------------- End ----------------
