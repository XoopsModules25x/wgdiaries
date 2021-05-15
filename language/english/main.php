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

include_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGWFHDIARIES_INDEX', 'Overview WFH Diaries');
\define('_MA_WGWFHDIARIES_TITLE', 'WFH Diaries');
\define('_MA_WGWFHDIARIES_DESC', 'Simple module for a diary for work from home');
\define('_MA_WGWFHDIARIES_INDEX_DESC', "Welcome to the homepage of your new module WFH Diaries!<br>
As you can see, you have created a page with a list of links at the top to navigate between the pages of your module. This description is only visible on the homepage of this module, the other pages you will see the content you created when you built this module with the module ModuleBuilder, and after creating new content in admin of this module. In order to expand this module with other resources, just add the code you need to extend the functionality of the same. The files are grouped by type, from the header to the footer to see how divided the source code.<br><br>If you see this message, it is because you have not created content for this module. Once you have created any type of content, you will not see this message.<br><br>If you liked the module ModuleBuilder and thanks to the long process for giving the opportunity to the new module to be created in a moment, consider making a donation to keep the module ModuleBuilder and make a donation using this button <a href='http://www.txmodxoops.org/modules/xdonations/index.php' title='Donation To Txmod Xoops'><img src='https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif' alt='Button Donations' /></a><br>Thanks!<br><br>Use the link below to go to the admin and create content.");
\define('_MA_WGWFHDIARIES_NO_PDF_LIBRARY', 'Libraries TCPDF not there yet, upload them in root/Frameworks');
\define('_MA_WGWFHDIARIES_NO', 'No');
\define('_MA_WGWFHDIARIES_DETAILS', 'Show details');
\define('_MA_WGWFHDIARIES_BROKEN', 'Notify broken');
// ---------------- Contents ----------------
// Item
\define('_MA_WGWFHDIARIES_ITEM', 'Item');
\define('_MA_WGWFHDIARIES_ITEM_ADD', 'Add Items');
\define('_MA_WGWFHDIARIES_ITEM_EDIT', 'Edit Items');
\define('_MA_WGWFHDIARIES_ITEM_DELETE', 'Delete Items');
\define('_MA_WGWFHDIARIES_ITEMS', 'Items');
\define('_MA_WGWFHDIARIES_ITEMS_LIST', 'List of Items');
\define('_MA_WGWFHDIARIES_ITEMS_TITLE', 'Items title');
\define('_MA_WGWFHDIARIES_ITEMS_DESC', 'Items description');
// Caption of Item
\define('_MA_WGWFHDIARIES_ITEM_ID', 'Id');
\define('_MA_WGWFHDIARIES_ITEM_REMARKS', 'Remarks');
\define('_MA_WGWFHDIARIES_ITEM_DATEFROM', 'Datefrom');
\define('_MA_WGWFHDIARIES_ITEM_DATETO', 'Dateto');
\define('_MA_WGWFHDIARIES_ITEM_DATECREATED', 'Datecreated');
\define('_MA_WGWFHDIARIES_ITEM_SUBMITTER', 'Submitter');
// File
\define('_MA_WGWFHDIARIES_FILE', 'File');
\define('_MA_WGWFHDIARIES_FILE_ADD', 'Add Files');
\define('_MA_WGWFHDIARIES_FILE_EDIT', 'Edit Files');
\define('_MA_WGWFHDIARIES_FILE_DELETE', 'Delete Files');
\define('_MA_WGWFHDIARIES_FILES', 'Files');
\define('_MA_WGWFHDIARIES_FILES_LIST', 'List of Files');
\define('_MA_WGWFHDIARIES_FILES_TITLE', 'Files title');
\define('_MA_WGWFHDIARIES_FILES_DESC', 'Files description');
// Caption of File
\define('_MA_WGWFHDIARIES_FILE_ID', 'Id');
\define('_MA_WGWFHDIARIES_FILE_ITEMID', 'Itemid');
\define('_MA_WGWFHDIARIES_FILE_DESC', 'Desc');
\define('_MA_WGWFHDIARIES_FILE_NAME', 'Name');
\define('_MA_WGWFHDIARIES_FILE_DATECREATED', 'Datecreated');
\define('_MA_WGWFHDIARIES_FILE_SUBMITTER', 'Submitter');
\define('_MA_WGWFHDIARIES_INDEX_THEREARE', 'There are %s Files');
\define('_MA_WGWFHDIARIES_INDEX_LATEST_LIST', 'Last WFH Diaries');
// Submit
\define('_MA_WGWFHDIARIES_SUBMIT', 'Submit');
// Form
\define('_MA_WGWFHDIARIES_FORM_OK', 'Successfully saved');
\define('_MA_WGWFHDIARIES_FORM_DELETE_OK', 'Successfully deleted');
\define('_MA_WGWFHDIARIES_FORM_SURE_DELETE', "Are you sure to delete: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGWFHDIARIES_FORM_SURE_RENEW', "Are you sure to update: <b><span style='color : Red;'>%s </span></b>");
\define('_MA_WGWFHDIARIES_INVALID_PARAM', "Invalid parameter");
// Admin link
\define('_MA_WGWFHDIARIES_ADMIN', 'Admin');
// ---------------- End ----------------
