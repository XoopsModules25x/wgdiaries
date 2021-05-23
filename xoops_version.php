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

// 
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
    'name'                => \_MI_WGDIARIES_NAME,
    'version'             => 1.02,
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
    'release_date'        => '2021/05/16',
    'manual'              => 'link to manual file',
    'manual_file'         => \XOOPS_URL . '/modules/wgdiaries/docs/install.txt',
    'min_php'             => '7.0',
    'min_xoops'           => '2.5.9',
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
    'release'             => '05/25/2020',
    'module_status'       => 'Beta 1',
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
    ['file' => 'wgdiaries_admin_clone.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_header.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_index.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_items.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_files.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_groups.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_permissions.tpl', 'description' => '', 'type' => 'admin'],
    ['file' => 'wgdiaries_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
    // User templates
    ['file' => 'wgdiaries_header.tpl', 'description' => ''],
    ['file' => 'wgdiaries_index.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items_list.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items_item.tpl', 'description' => ''],
    ['file' => 'wgdiaries_items_single.tpl', 'description' => ''],
    ['file' => 'wgdiaries_files.tpl', 'description' => ''],
    ['file' => 'wgdiaries_files_item.tpl', 'description' => ''],
    ['file' => 'wgdiaries_groups.tpl', 'description' => ''],
    ['file' => 'wgdiaries_groups_item.tpl', 'description' => ''],
    ['file' => 'wgdiaries_breadcrumbs.tpl', 'description' => ''],
    ['file' => 'wgdiaries_footer.tpl', 'description' => ''],
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
    'wgdiaries_items',
    'wgdiaries_files',
    'wgdiaries_groups',
    'wgdiaries_groupusers',
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
    require_once \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/include/common.php';
    /** @var \XoopsModules\Wgdiaries\Helper $helper */
    $helper = \XoopsModules\Wgdiaries\Helper::getInstance();
    $permissionsHandler = $helper->getHandler('Permissions');

    $modversion['sub'][] = [
        'name' => \_MI_WGDIARIES_SMNAME1,
        'url'  => 'index.php',
    ];
    // Sub items
    $modversion['sub'][] = [
        'name' => \_MI_WGDIARIES_SMNAME2,
        'url'  => 'items.php',
    ];
    if ($permissionsHandler->getPermItemsGroupView()) {
        // Sub Submit
        $modversion['sub'][] = [
            'name' => \_MI_WGDIARIES_SMNAME4,
            'url'  => 'items.php?op=listgroup',
        ];
    }
    if ($permissionsHandler->getPermItemsSubmit()) {
        // Sub Submit
        $modversion['sub'][] = [
            'name' => \_MI_WGDIARIES_SMNAME3,
            'url'  => 'items.php?op=new',
        ];
    }

    /*
    if ($permissionsHandler->getPermGroupsView() > 0) {
        // Sub list groups
        $modversion['sub'][] = [
            'name' => \_MI_WGDIARIES_SMNAME5,
            'url'  => 'groups.php?op=list',
        ];
    }
    if ($permissionsHandler->getPermGroupsEdit() > 0) {
        // Sub Submit group
        $modversion['sub'][] = [
            'name' => \_MI_WGDIARIES_SMNAME6,
            'url'  => 'groups.php?op=new',
        ];
    }
    */

}
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
include_once __DIR__ . '/include/xoops_version.inc.php';
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
// Admin pager
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => '_MI_WGDIARIES_ADMIN_PAGER',
    'description' => '_MI_WGDIARIES_ADMIN_PAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
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
// Use group system
$modversion['config'][] = [
    'name'        => 'use_groups',
    'title'       => '_MI_WGDIARIES_USE_GROUPS',
    'description' => '_MI_WGDIARIES_USE_GROUPS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
// Show module description
$modversion['config'][] = [
    'name'        => 'index_header',
    'title'       => '_MI_WGDIARIES_INDEXHEADER',
    'description' => '_MI_WGDIARIES_INDEXHEADER_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => \_MI_WGDIARIES_DESC,
];
// Number column
$modversion['config'][] = [
    'name'        => 'numb_col',
    'title'       => '_MI_WGDIARIES_NUMB_COL',
    'description' => '_MI_WGDIARIES_NUMB_COL_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Divide by
$modversion['config'][] = [
    'name'        => 'divideby',
    'title'       => '_MI_WGDIARIES_DIVIDEBY',
    'description' => '_MI_WGDIARIES_DIVIDEBY_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
    'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Table type
$modversion['config'][] = [
    'name'        => 'table_type',
    'title'       => '_MI_WGDIARIES_TABLE_TYPE',
    'description' => '_MI_WGDIARIES_DIVIDEBY_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 'bordered',
    'options'     => ['bordered' => 'bordered', 'striped' => 'striped', 'hover' => 'hover', 'condensed' => 'condensed'],
];
// Panel by
$modversion['config'][] = [
    'name'        => 'panel_type',
    'title'       => '_MI_WGDIARIES_PANEL_TYPE',
    'description' => '_MI_WGDIARIES_PANEL_TYPE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'default',
    'options'     => ['default' => 'default', 'primary' => 'primary', 'success' => 'success', 'info' => 'info', 'warning' => 'warning', 'danger' => 'danger'],
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
