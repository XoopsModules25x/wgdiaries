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
 * @author         wedega - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use XoopsModules\Wgdiaries\Helper;

require __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Information ------------------- /
$modversion = [
    'name'                => \_MI_WGDIARIES_NAME,
    'version'             => '1.3.4',
    'description'         => \_MI_WGDIARIES_DESC,
    'author'              => 'wedega',
    'author_mail'         => 'webmaster@wedega.com',
    'author_website_url'  => 'https://xoops.wedega.com',
    'author_website_name' => 'XOOPS Project',
    'credits'             => 'XOOPS Development Team',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'http://www.gnu.org/licenses/gpl-3.0.en.html',
    'help'                => 'page=help',
    'release_info'        => 'release_info',
    'release_file'        => \XOOPS_URL . '/modules/wgdiaries/docs/release_info file',
    'release_date'        => '2023/04/09', // format: yyyy/mm/dd
    'manual'              => 'link to manual file',
    'manual_file'         => \XOOPS_URL . '/modules/wgdiaries/docs/install.txt',
    'min_php'             => '8.0',
    'min_xoops'           => '2.5.11 Stable',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.6', 'mysqli' => '5.6'],
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => \basename(__DIR__),
    'dirmoduleadmin'      => 'Frameworks/moduleclasses/moduleadmin',
    'sysicons16'          => '../../Frameworks/moduleclasses/icons/16',
    'sysicons32'          => '../../Frameworks/moduleclasses/icons/32',
    'modicons16'          => 'assets/icons/16',
    'modicons32'          => 'assets/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    'release'             => '09/04/2023',
    'module_status'       => 'RC1',
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'hasMain'             => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    'onInstall'           => 'include/install.php',
    'onUninstall'         => 'include/uninstall.php',
    'onUpdate'            => 'include/update.php',
];
// ------------------- Templates ------------------- //
$modversion['templates'] = [
    // Admin templates
    ['file' => 'wgdiaries_admin_about.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_categories.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_clone.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_header.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_index.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_items.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_files.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_permissions.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
    // User templates
    ['file' => 'wgdiaries_archive.tpl', 'description' => ''],
    ['file' => 'wgdiaries_breadcrumbs.tpl', 'description' => ''],
    ['file' => 'wgdiaries_calendar.tpl', 'description' => ''],
    ['file' => 'wgdiaries_files.tpl', 'description' => ''],
    ['file' => 'wgdiaries_files_item.tpl', 'description' => ''],
    ['file' => 'wgdiaries_footer.tpl', 'description' => ''],
    ['file' => 'wgdiaries_header.tpl', 'description' => ''],
    ['file' => 'wgdiaries_index.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items_list.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items_item.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items_single.tpl', 'description' => ''],
    ['file' => 'wgdiaries_outputs.tpl', 'description' => ''],
    ['file' => 'wgdiaries_statistics.tpl', 'description' => ''],
    ['file' => 'wgdiaries_useritems.tpl', 'description' => ''],
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
    'wgdiaries_items',
    'wgdiaries_files',
    'wgdiaries_categories',
];
// ------------------- Comments ------------------- //
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'items.php';
$modversion['comments']['itemName'] = 'item_id';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback'] = [
    'approve' => 'wgdiariesCommentsApprove',
    'update'  => 'wgdiariesCommentsUpdate',
];
// ------------------- Menu ------------------- //
$currdirname  = isset($GLOBALS['xoopsModule']) && \is_object($GLOBALS['xoopsModule']) ? $GLOBALS['xoopsModule']->getVar('dirname') : 'system';
if ($currdirname == $moduleDirName) {
    $submenu = new \XoopsModules\Wgdiaries\Modulemenu;
    $menuItems = $submenu->getMenuitemsDefault();
    foreach ($menuItems as $key => $menuItem) {
        $modversion['sub'][$key]['name'] = $menuItem['name'];
        $modversion['sub'][$key]['url'] = $menuItem['url'];
    }
}
// -
// ------------------- Config ------------------- //
// Editor Admin
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'editor_admin',
    'title'       => '_MI_WGDIARIES_EDITOR_ADMIN',
    'description' => '_MI_WGDIARIES_EDITOR_ADMIN_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtml',
    'options'     => \array_flip($editorHandler->getList()),
];
// Editor User
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'editor_user',
    'title'       => '_MI_WGDIARIES_EDITOR_USER',
    'description' => '_MI_WGDIARIES_EDITOR_USER_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtml',
    'options'     => \array_flip($editorHandler->getList()),
];
// Editor : max characters admin area
$modversion['config'][] = [
    'name'        => 'editor_maxchar',
    'title'       => '_MI_WGDIARIES_EDITOR_MAXCHAR',
    'description' => '_MI_WGDIARIES_EDITOR_MAXCHAR_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 50,
];

// Keywords
$modversion['config'][] = [
    'name'        => 'keywords',
    'title'       => '_MI_WGDIARIES_KEYWORDS',
    'description' => '_MI_WGDIARIES_KEYWORDS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'wgdiaries, items, files, groups, groupusers',
];
// create increment steps for file size
require_once __DIR__ . '/include/xoops_version.inc.php';
$iniPostMaxSize       = wgdiariesReturnBytes(\ini_get('post_max_size'));
$iniUploadMaxFileSize = wgdiariesReturnBytes(\ini_get('upload_max_filesize'));
$maxSize              = min($iniPostMaxSize, $iniUploadMaxFileSize);
if ($maxSize > 10000 * 1048576) {
    $increment = 500;
}
if ($maxSize <= 10000 * 1048576) {
    $increment = 200;
}
if ($maxSize <= 5000 * 1048576) {
    $increment = 100;
}
if ($maxSize <= 2500 * 1048576) {
    $increment = 50;
}
if ($maxSize <= 1000 * 1048576) {
    $increment = 10;
}
if ($maxSize <= 500 * 1048576) {
    $increment = 5;
}
if ($maxSize <= 100 * 1048576) {
    $increment = 2;
}
if ($maxSize <= 50 * 1048576) {
    $increment = 1;
}
if ($maxSize <= 25 * 1048576) {
    $increment = 0.5;
}
$optionMaxsize = [];
$i = $increment;
while ($i * 1048576 <= $maxSize) {
    $optionMaxsize[$i . ' ' . \_MI_WGDIARIES_SIZE_MB] = $i * 1048576;
    $i += $increment;
}
// Uploads : maxsize of file
$modversion['config'][] = [
    'name'        => 'maxsize_file',
    'title'       => '_MI_WGDIARIES_MAXSIZE_FILE',
    'description' => '_MI_WGDIARIES_MAXSIZE_FILE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3145728,
    'options'     => $optionMaxsize,
];
// Uploads : mimetypes of file
$modversion['config'][] = [
    'name'        => 'mimetypes_file',
    'title'       => '_MI_WGDIARIES_MIMETYPES_FILE',
    'description' => '_MI_WGDIARIES_MIMETYPES_FILE_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['application/pdf', 'application/zip', 'text/comma-separated-values', 'text/plain', 'image/gif', 'image/jpeg', 'image/png'],
    'options'     => ['gif' => 'image/gif','pjpeg' => 'image/pjpeg', 'jpeg' => 'image/jpeg','jpg' => 'image/jpg','jpe' => 'image/jpe', 'png' => 'image/png', 'pdf' => 'application/pdf','zip' => 'application/zip','csv' => 'text/comma-separated-values', 'txt' => 'text/plain', 'xml' => 'application/xml', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
];
// Upload: max number of files for upload
$modversion['config'][] = [
    'name'        => 'max_fileuploads',
    'title'       => '_MI_WGDIARIES_MAX_FILEUPLOADS',
    'description' => '_MI_WGDIARIES_MAX_FILEUPLOADS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
// Uploads : maxsize of image
$modversion['config'][] = [
    'name'        => 'maxsize_image',
    'title'       => '_MI_WGDIARIES_MAXSIZE_IMAGE',
    'description' => '_MI_WGDIARIES_MAXSIZE_IMAGE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3145728,
    'options'     => $optionMaxsize,
];
// Uploads : mimetypes of image
$modversion['config'][] = [
    'name'        => 'mimetypes_image',
    'title'       => '_MI_WGDIARIES_MIMETYPES_IMAGE',
    'description' => '_MI_WGDIARIES_MIMETYPES_IMAGE_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/png'],
    'options'     => ['bmp' => 'image/bmp','gif' => 'image/gif','pjpeg' => 'image/pjpeg', 'jpeg' => 'image/jpeg','jpg' => 'image/jpg','jpe' => 'image/jpe', 'png' => 'image/png'],
];
$modversion['config'][] = [
    'name'        => 'maxwidth_image',
    'title'       => '_MI_WGDIARIES_MAXWIDTH_IMAGE',
    'description' => '_MI_WGDIARIES_MAXWIDTH_IMAGE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 800,
];
$modversion['config'][] = [
    'name'        => 'maxheight_image',
    'title'       => '_MI_WGDIARIES_MAXHEIGHT_IMAGE',
    'description' => '_MI_WGDIARIES_MAXHEIGHT_IMAGE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 800,
];
// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '_MI_WGDIARIES_ADMIN_PAGER',
    'description' => '_MI_WGDIARIES_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 25,
];
// Index pager
$modversion['config'][] = [
    'name'        => 'indexpager',
    'title'       => '_MI_WGDIARIES_INDEX_PAGER',
    'description' => '_MI_WGDIARIES_INDEX_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 5,
];
// User pager
$modversion['config'][] = [
    'name'        => 'userpager',
    'title'       => '_MI_WGDIARIES_USER_PAGER',
    'description' => '_MI_WGDIARIES_USER_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
// Show items calendar
$modversion['config'][] = [
    'name'        => 'items_calendar',
    'title'       => '_MI_WGDIARIES_ITEMS_CALENDAR',
    'description' => '_MI_WGDIARIES_ITEMS_CALENDAR_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// First day of week in calendar
$modversion['config'][] = [
    'name'        => 'calendar_firstday',
    'title'       => '_MI_WGDIARIES_CALENDAR_FIRSTDAY',
    'description' => '_MI_WGDIARIES_CALENDAR_FIRSTDAY_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [\_MI_WGDIARIES_CAL_SUNDAY => 0,
                        \_MI_WGDIARIES_CAL_MONDAY => 1,
                        \_MI_WGDIARIES_CAL_TUESDAY => 2,
                        \_MI_WGDIARIES_CAL_WEDNESDAY => 3,
                        \_MI_WGDIARIES_CAL_THURSDAY => 4,
                        \_MI_WGDIARIES_CAL_FRIDAY => 5,
                        \_MI_WGDIARIES_CAL_SATURDAY => 6
                     ],
];
// Use group system
$modversion['config'][] = [
    'name'        => 'use_groups',
    'title'       => '_MI_WGDIARIES_USE_GROUPS',
    'description' => '_MI_WGDIARIES_USE_GROUPS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Text for index header
$modversion['config'][] = [
    'name'        => 'index_header',
    'title'       => '_MI_WGDIARIES_INDEXHEADER',
    'description' => '_MI_WGDIARIES_INDEXHEADER_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => \_MI_WGDIARIES_DESC,
];
// Sorting in index page
$modversion['config'][] = [
    'name'        => 'index_sort',
    'title'       => '_MI_WGDIARIES_INDEXSORT',
    'description' => '_MI_WGDIARIES_INDEXSORT_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'string',
    'default'     => 'activities',
    'options'     => [\_MI_WGDIARIES_INDEXSORT_ACT => 'activities', \_MI_WGDIARIES_INDEXSORT_DATEFROM => 'datefrom'],
];
// Use avatar on user items page
$modversion['config'][] = [
    'name'        => 'useritems_avatar',
    'title'       => '_MI_WGDIARIES_USERITEMS_AVATAR',
    'description' => '_MI_WGDIARIES_USERITEMS_AVATAR_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// show users without items on user items page
$modversion['config'][] = [
    'name'        => 'useritems_empty',
    'title'       => '_MI_WGDIARIES_USERITEMS_EMPTY',
    'description' => '_MI_WGDIARIES_USERITEMS_EMPTY_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Table type
$modversion['config'][] = [
    'name'        => 'table_type',
    'title'       => '_MI_WGDIARIES_TABLE_TYPE',
    'description' => '_MI_WGDIARIES_TABLE_TYPE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 'bordered',
    'options'     => ['bordered' => 'bordered', 'striped' => 'striped', 'hover' => 'hover', 'condensed' => 'condensed'],
];

// Paypal ID
$modversion['config'][] = [
    'name'        => 'donations',
    'title'       => '_MI_WGDIARIES_IDPAYPAL',
    'description' => '_MI_WGDIARIES_IDPAYPAL_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'textbox',
    'default'     => 'XYZ123',
];
// Show Breadcrumbs
$modversion['config'][] = [
    'name'        => 'show_breadcrumbs',
    'title'       => '_MI_WGDIARIES_SHOW_BREADCRUMBS',
    'description' => '_MI_WGDIARIES_SHOW_BREADCRUMBS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Advertise
$modversion['config'][] = [
    'name'        => 'advertise',
    'title'       => '_MI_WGDIARIES_ADVERTISE',
    'description' => '_MI_WGDIARIES_ADVERTISE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];
// Bookmarks
$modversion['config'][] = [
    'name'        => 'bookmarks',
    'title'       => '_MI_WGDIARIES_BOOKMARKS',
    'description' => '_MI_WGDIARIES_BOOKMARKS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// Show copyright
$modversion['config'][] = [
    'name'        => 'show_copyright',
    'title'       => '_MI_WGDIARIES_SHOWCOPYRIGHT',
    'description' => '_MI_WGDIARIES_SHOWCOPYRIGHT_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Make Sample button visible?
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Maintained by
$modversion['config'][] = [
    'name'        => 'maintainedby',
    'title'       => '_MI_WGDIARIES_MAINTAINEDBY',
    'description' => '_MI_WGDIARIES_MAINTAINEDBY_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'https://xoops.org/modules/newbb',
];
