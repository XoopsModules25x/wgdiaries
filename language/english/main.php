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

require_once __DIR__ . '/admin.php';

// ---------------- Main ----------------
\define('_MA_WGDIARIES_INDEX', 'Overview wgDiaries');
\define('_MA_WGDIARIES_TITLE', 'wgDiaries');
\define('_MA_WGDIARIES_DESC', 'Simple module for a diary for work from home');
\define('_MA_WGDIARIES_INDEX_DESC', 'Welcome to the homepage of your new module wgDiaries!<br>This description is only visible on the homepage of this module.');
\define('_MA_WGDIARIES_NO', 'No');
\define('_MA_WGDIARIES_DETAILS', 'Show details');
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
\define('_MA_WGDIARIES_INVALID_PARAM', 'Invalid parameter');
\define('_MA_WGDIARIES_FORM_ERROR', 'Error when processing data');
// Index
\define('_MA_WGDIARIES_INDEX_ITEMS_OWN', 'My last items');
\define('_MA_WGDIARIES_INDEX_ITEMS_GROUP', 'Last items of my groups');
\define('_MA_WGDIARIES_INDEX_ITEMS_GROUPOTHER', 'Last items of other users of my groups');
// Item
\define('_MA_WGDIARIES_ITEM', 'Item');
\define('_MA_WGDIARIES_ITEM_ADD', 'Add Item');
\define('_MA_WGDIARIES_ITEM_EDIT', 'Edit Item');
\define('_MA_WGDIARIES_ITEM_DELETE', 'Delete Item');
\define('_MA_WGDIARIES_ITEM_DETAILS', 'Details of Item');
\define('_MA_WGDIARIES_ITEM_GOBACK', 'Go back to item');
\define('_MA_WGDIARIES_ITEM_GOBACK_LIST', 'Go back to item list');
\define('_MA_WGDIARIES_ITEMS', 'Items');
\define('_MA_WGDIARIES_ITEMS_LIST', 'List of Items');
\define('_MA_WGDIARIES_ITEMS_LISTMY', 'List of my items');
\define('_MA_WGDIARIES_ITEMS_LISTGROUP', 'List of items of my group');
\define('_MA_WGDIARIES_ITEMS_LISTUSER', 'List of Items of %s');
\define('_MA_WGDIARIES_ITEMS_DESC', 'Items description');
\define('_MA_WGDIARIES_ITEM_CAPTION', 'Item No. %s (%s, from %s to %s)');
\define('_MA_WGDIARIES_ITEM_CAPTION_SINGLE', '%s - Item No. %s - %s)');
// Caption of Item
\define('_MA_WGDIARIES_ITEM_ID', 'Id');
\define('_MA_WGDIARIES_ITEM_GROUPID', 'Group');
\define('_MA_WGDIARIES_ITEM_NAME', 'Name');
\define('_MA_WGDIARIES_ITEM_REMARKS', 'Remarks');
\define('_MA_WGDIARIES_ITEM_DATEFROM', 'Date from');
\define('_MA_WGDIARIES_ITEM_DATETO', 'Date to');
\define('_MA_WGDIARIES_ITEM_CATID', 'Category');
\define('_MA_WGDIARIES_ITEM_TAGS', 'Tags');
\define('_MA_WGDIARIES_ITEM_DATECREATED', 'Date created');
\define('_MA_WGDIARIES_ITEM_SUBMITTER', 'Submitter');
\define('_MA_WGDIARIES_ITEM_NBFILES', 'Files');
\define('_MA_WGDIARIES_ITEM_COMMENTS', 'Comments');
\define('_MA_WGDIARIES_ITEM_SAVEADDFILES', 'Submit and add files');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES', 'Upload files');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES_BTN', 'Add new upload field');
\define('_MA_WGDIARIES_ITEM_UPLOADFILES_MAX', 'Maximum number of allowed upload fields reached');
\define('_MA_WGDIARIES_ITEM_LOGO', 'Logo');
\define('_MA_WGDIARIES_ITEM_LOGO_UPLOADS', 'Logo in %s :');
// File
\define('_MA_WGDIARIES_FILE', 'File');
\define('_MA_WGDIARIES_FILE_ADD', 'Add File');
\define('_MA_WGDIARIES_FILE_EDIT', 'Edit File');
\define('_MA_WGDIARIES_FILE_DELETE', 'Delete File');
\define('_MA_WGDIARIES_FILE_OPEN', 'Open File');
\define('_MA_WGDIARIES_FILES', 'Files');
\define('_MA_WGDIARIES_FILES_LIST', 'List of Files');
\define('_MA_WGDIARIES_FILES_DESC', 'Files description');
\define('_MA_WGDIARIES_FILES_NODATA', 'There are no files available for this item');
// Caption of File
\define('_MA_WGDIARIES_FILE_ID', 'Id');
\define('_MA_WGDIARIES_FILE_ITEMID', 'Itemid');
\define('_MA_WGDIARIES_FILE_DESC', 'Desc');
\define('_MA_WGDIARIES_FILE_NAME', 'Name');
\define('_MA_WGDIARIES_FILE_MIMETYPE', 'Mimetype');
\define('_MA_WGDIARIES_FILE_DATECREATED', 'Date created');
\define('_MA_WGDIARIES_FILE_SUBMITTER', 'Submitter');
\define('_MA_WGDIARIES_FILE_UPLOAD', 'Upload new file');
// Statistics
\define('_MA_WGDIARIES_STATISTICS', 'Statistics');
\define('_MA_WGDIARIES_STATISTICS_MY_YEAR', 'Statistics of my items of selected year');
\define('_MA_WGDIARIES_STATISTICS_MY_MONTH', 'Statistics of my items of selected month');
\define('_MA_WGDIARIES_STATISTICS_GROUP_YEAR', 'Statistics of my groups of selected year');
\define('_MA_WGDIARIES_STATISTICS_GROUP_MONTH', 'Statistics of my groups of selected month');
\define('_MA_WGDIARIES_STATISTICS_USER_YEAR', 'Statistics per user of my groups of selected year');
\define('_MA_WGDIARIES_STATISTICS_USER_MONTH', 'Statistics per user of my groups of selected month');
\define('_MA_WGDIARIES_STATS_PERIOD', 'Period');
\define('_MA_WGDIARIES_STATS_PERIOD_FROMTO', 'From %s to %s');
\define('_MA_WGDIARIES_STATS_ITEMS_NB', 'Number of items');
\define('_MA_WGDIARIES_STATS_DAYSHOURS', '%s hours total (%s days and %s hours)');
\define('_MA_WGDIARIES_STATS_DAYSHOURSMINUTES', '%s hours total (%a days, %h hours, %i minutes)');
\define('_MA_WGDIARIES_STATS_HOURS', 'Hours');
\define('_MA_WGDIARIES_STATS_USER', 'User');
\define('_MA_WGDIARIES_STATS_SELECT_YEAR', 'Statistic for year: ');
\define('_MA_WGDIARIES_STATS_SELECT_MONTH', 'Statistic for month: ');
// Categorie
\define('_MA_WGDIARIES_CATLOGO', 'Categorie Logo');
// calendar
\define('_MA_WGDIARIES_CALENDAR_ITEMS', 'Items Calendar');
\define('_MA_WGDIARIES_CALENDAR_EDITITEM', 'Edit Item');
\define('_MA_WGDIARIES_CALENDAR_ADDITEM', 'Add Item');
//navbar
\define('_MA_WGDIARIES_CAL_PREVMONTH', 'Previous Month');
\define('_MA_WGDIARIES_CAL_NEXTMONTH', 'Next Month');
\define('_MA_WGDIARIES_CAL_PREVYEAR', 'Previous Year');
\define('_MA_WGDIARIES_CAL_NEXTYEAR', 'Next Year');
//days
\define('_MA_WGDIARIES_CAL_MIN_SUNDAY', 'Su');
\define('_MA_WGDIARIES_CAL_MIN_MONDAY', 'Mo');
\define('_MA_WGDIARIES_CAL_MIN_TUESDAY', 'Tu');
\define('_MA_WGDIARIES_CAL_MIN_WEDNESDAY', 'We');
\define('_MA_WGDIARIES_CAL_MIN_THURSDAY', 'Th');
\define('_MA_WGDIARIES_CAL_MIN_FRIDAY', 'Fr');
\define('_MA_WGDIARIES_CAL_MIN_SATURDAY', 'Sa');
\define('_MA_WGDIARIES_CAL_SUNDAY', 'Sunday');
\define('_MA_WGDIARIES_CAL_MONDAY', 'Monday');
\define('_MA_WGDIARIES_CAL_TUESDAY', 'Tuesday');
\define('_MA_WGDIARIES_CAL_WEDNESDAY', 'Wednesday');
\define('_MA_WGDIARIES_CAL_THURSDAY', 'Thursday');
\define('_MA_WGDIARIES_CAL_FRIDAY', 'Friday');
\define('_MA_WGDIARIES_CAL_SATURDAY', 'Saturday');
\define('_MA_WGDIARIES_CAL_JANUARY', 'January');
\define('_MA_WGDIARIES_CAL_FEBRUARY', 'February');
\define('_MA_WGDIARIES_CAL_MARCH', 'March');
\define('_MA_WGDIARIES_CAL_APRIL', 'April');
\define('_MA_WGDIARIES_CAL_MAY', 'May');
\define('_MA_WGDIARIES_CAL_JUNE', 'June');
\define('_MA_WGDIARIES_CAL_JULY', 'July');
\define('_MA_WGDIARIES_CAL_AUGUST', 'August');
\define('_MA_WGDIARIES_CAL_SEPTEMBER', 'September');
\define('_MA_WGDIARIES_CAL_OCTOBER', 'October');
\define('_MA_WGDIARIES_CAL_NOVEMBER', 'November');
\define('_MA_WGDIARIES_CAL_DECEMBER', 'December');
// Filter
\define('_MA_WGDIARIES_FILTER_APPLY', 'Apply filter');
\define('_MA_WGDIARIES_FILTER_RESULT', 'Result of applied filter');
\define('_MA_WGDIARIES_FILTER_NODATA', 'No data found');
\define('_MA_WGDIARIES_FILTERBY_PERIOD', 'Filter by period');
\define('_MA_WGDIARIES_FILTER_PERIODFROM', 'From');
\define('_MA_WGDIARIES_FILTER_PERIODTO', 'To');
\define('_MA_WGDIARIES_FILTERBY_OWNER', 'Filter by owners');
\define('_MA_WGDIARIES_FILTERBY_OWN', 'Only own items');
\define('_MA_WGDIARIES_FILTERBY_GROUP', 'All items of the group');
\define('_MA_WGDIARIES_FILTER_TYPEALL', 'All');
\define('_MA_WGDIARIES_FILTER_LIMIT', 'Number of lines');
\define('_MA_WGDIARIES_FILTER_LIMIT_EXCEED', 'The number of lines in the result list are less then available items for choosen filter');
// ---------------- Activate ----------------
\define('_MA_WGDIARIES_ACTIVE', 'Activated (click to deactivate)');
\define('_MA_WGDIARIES_NONACTIVE', 'Deactivated (click to activate)');
// Outputs
\define('_MA_WGDIARIES_OUTPUTS', 'Outputs');
// Archive
\define('_MA_WGDIARIES_ARCHIVE', 'Archive');
\define('_MA_WGDIARIES_ARCHIVE_TITLE', 'Archive of wgDiary');
// User list
\define('_MA_WGDIARIES_USERLIST_GROUP', 'List of all users with items of my groups');
\define('_MA_WGDIARIES_USERLIST_GROUPS', 'Groups');
\define('_MA_WGDIARIES_USERLIST_NB_ITEMS', 'Number of items');
// General
\define('_MA_WGDIARIES_SUBMIT', 'Submit');
\define('_MA_WGDIARIES_PRINT_LIST', 'Print list');
\define('_MA_WGDIARIES_PRINT_ITEM', 'Print item');
\define('_MA_WGDIARIES_SORT', 'Sort result');
\define('_MA_WGDIARIES_SORT_DATEFROM_ASC', 'Sort by date from ascending');
\define('_MA_WGDIARIES_SORT_DATEFROM_DESC', 'Sort by date from descending');
\define('_MA_WGDIARIES_SORT_DATECREATED_ASC', 'Sort by date created ascending');
\define('_MA_WGDIARIES_SORT_DATECREATED_DESC', 'Sort by date created descending');

// Admin link
\define('_MA_WGDIARIES_ADMIN', 'Admin');
// ---------------- End ----------------
