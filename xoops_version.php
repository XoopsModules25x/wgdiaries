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

// 
$moduleDirName      = \basename(__DIR__);
$moduleDirNameUpper = \mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
	'name'                => _MI_WGWFHDIARIES_NAME,
	'version'             => 1.0,
	'description'         => _MI_WGWFHDIARIES_DESC,
	'author'              => 'wedega',
	'author_mail'         => 'webmaster@wedega.com',
	'author_website_url'  => 'https://xoops.wedega.com',
	'author_website_name' => 'XOOPS Project',
	'credits'             => 'XOOPS Development Team',
	'license'             => 'GPL 2.0 or later',
	'license_url'         => 'http://www.gnu.org/licenses/gpl-3.0.en.html',
	'help'                => 'page=help',
	'release_info'        => 'release_info',
	'release_file'        => XOOPS_URL . '/modules/wgwfhdiaries/docs/release_info file',
	'release_date'        => '2021/05/15',
	'manual'              => 'link to manual file',
	'manual_file'         => XOOPS_URL . '/modules/wgwfhdiaries/docs/install.txt',
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
	['file' => 'wgwfhdiaries_admin_about.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgwfhdiaries_admin_header.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgwfhdiaries_admin_index.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgwfhdiaries_admin_items.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgwfhdiaries_admin_files.tpl', 'description' => '', 'type' => 'admin'],
	['file' => 'wgwfhdiaries_admin_footer.tpl', 'description' => '', 'type' => 'admin'],
	// User templates
	['file' => 'wgwfhdiaries_header.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_index.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_items.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_items_list.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_items_item.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_files.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_files_list.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_files_item.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_breadcrumbs.tpl', 'description' => ''],
	['file' => 'wgwfhdiaries_footer.tpl', 'description' => ''],
];
// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables
$modversion['tables'] = [
	'wgwfhdiaries_items',
	'wgwfhdiaries_files',
];
// ------------------- Menu ------------------- //
$currdirname  = isset($GLOBALS['xoopsModule']) && \is_object($GLOBALS['xoopsModule']) ? $GLOBALS['xoopsModule']->getVar('dirname') : 'system';
if ($currdirname == $moduleDirName) {
	$modversion['sub'][] = [
		'name' => _MI_WGWFHDIARIES_SMNAME1,
		'url'  => 'index.php',
	];
	// Sub items
	$modversion['sub'][] = [
		'name' => _MI_WGWFHDIARIES_SMNAME2,
		'url'  => 'items.php',
	];
	// Sub Submit
	$modversion['sub'][] = [
		'name' => _MI_WGWFHDIARIES_SMNAME3,
		'url'  => 'items.php?op=new',
	];
	// Sub Submit
	$modversion['sub'][] = [
		'name' => _MI_WGWFHDIARIES_SMNAME5,
		'url'  => 'files.php?op=new',
	];
}
// ------------------- Config ------------------- //
// Editor Admin
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
	'name'        => 'editor_admin',
	'title'       => '_MI_WGWFHDIARIES_EDITOR_ADMIN',
	'description' => '_MI_WGWFHDIARIES_EDITOR_ADMIN_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'dhtml',
	'options'     => array_flip($editorHandler->getList()),
];
// Editor User
\xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
	'name'        => 'editor_user',
	'title'       => '_MI_WGWFHDIARIES_EDITOR_USER',
	'description' => '_MI_WGWFHDIARIES_EDITOR_USER_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'dhtml',
	'options'     => array_flip($editorHandler->getList()),
];
// Editor : max characters admin area
$modversion['config'][] = [
	'name'        => 'editor_maxchar',
	'title'       => '_MI_WGWFHDIARIES_EDITOR_MAXCHAR',
	'description' => '_MI_WGWFHDIARIES_EDITOR_MAXCHAR_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 50,
];
// Keywords
$modversion['config'][] = [
	'name'        => 'keywords',
	'title'       => '_MI_WGWFHDIARIES_KEYWORDS',
	'description' => '_MI_WGWFHDIARIES_KEYWORDS_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'text',
	'default'     => 'wgwfhdiaries, items, files',
];
// create increment steps for file size
include_once __DIR__ . '/include/xoops_version.inc.php';
$iniPostMaxSize       = wgwfhdiariesReturnBytes(\ini_get('post_max_size'));
$iniUploadMaxFileSize = wgwfhdiariesReturnBytes(\ini_get('upload_max_filesize'));
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
	$optionMaxsize[$i . ' ' . _MI_WGWFHDIARIES_SIZE_MB] = $i * 1048576;
	$i += $increment;
}
// Uploads : maxsize of file
$modversion['config'][] = [
	'name'        => 'maxsize_file',
	'title'       => '_MI_WGWFHDIARIES_MAXSIZE_FILE',
	'description' => '_MI_WGWFHDIARIES_MAXSIZE_FILE_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 3145728,
	'options'     => $optionMaxsize,
];
// Uploads : mimetypes of file
$modversion['config'][] = [
	'name'        => 'mimetypes_file',
	'title'       => '_MI_WGWFHDIARIES_MIMETYPES_FILE',
	'description' => '_MI_WGWFHDIARIES_MIMETYPES_FILE_DESC',
	'formtype'    => 'select_multi',
	'valuetype'   => 'array',
	'default'     => ['application/pdf', 'application/zip', 'text/comma-separated-values', 'text/plain', 'image/gif', 'image/jpeg', 'image/png'],
	'options'     => ['gif' => 'image/gif','pjpeg' => 'image/pjpeg', 'jpeg' => 'image/jpeg','jpg' => 'image/jpg','jpe' => 'image/jpe', 'png' => 'image/png', 'pdf' => 'application/pdf','zip' => 'application/zip','csv' => 'text/comma-separated-values', 'txt' => 'text/plain', 'xml' => 'application/xml', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
];
// Admin pager
$modversion['config'][] = [
	'name'        => 'adminpager',
	'title'       => '_MI_WGWFHDIARIES_ADMIN_PAGER',
	'description' => '_MI_WGWFHDIARIES_ADMIN_PAGER_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 10,
];
// User pager
$modversion['config'][] = [
	'name'        => 'userpager',
	'title'       => '_MI_WGWFHDIARIES_USER_PAGER',
	'description' => '_MI_WGWFHDIARIES_USER_PAGER_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'int',
	'default'     => 10,
];
// Number column
$modversion['config'][] = [
	'name'        => 'numb_col',
	'title'       => '_MI_WGWFHDIARIES_NUMB_COL',
	'description' => '_MI_WGWFHDIARIES_NUMB_COL_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 1,
	'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Divide by
$modversion['config'][] = [
	'name'        => 'divideby',
	'title'       => '_MI_WGWFHDIARIES_DIVIDEBY',
	'description' => '_MI_WGWFHDIARIES_DIVIDEBY_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 1,
	'options'     => [1 => '1', 2 => '2', 3 => '3', 4 => '4'],
];
// Table type
$modversion['config'][] = [
	'name'        => 'table_type',
	'title'       => '_MI_WGWFHDIARIES_TABLE_TYPE',
	'description' => '_MI_WGWFHDIARIES_DIVIDEBY_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'int',
	'default'     => 'bordered',
	'options'     => ['bordered' => 'bordered', 'striped' => 'striped', 'hover' => 'hover', 'condensed' => 'condensed'],
];
// Panel by
$modversion['config'][] = [
	'name'        => 'panel_type',
	'title'       => '_MI_WGWFHDIARIES_PANEL_TYPE',
	'description' => '_MI_WGWFHDIARIES_PANEL_TYPE_DESC',
	'formtype'    => 'select',
	'valuetype'   => 'text',
	'default'     => 'default',
	'options'     => ['default' => 'default', 'primary' => 'primary', 'success' => 'success', 'info' => 'info', 'warning' => 'warning', 'danger' => 'danger'],
];
// Paypal ID
$modversion['config'][] = [
	'name'        => 'donations',
	'title'       => '_MI_WGWFHDIARIES_IDPAYPAL',
	'description' => '_MI_WGWFHDIARIES_IDPAYPAL_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'textbox',
	'default'     => 'XYZ123',
];
// Show Breadcrumbs
$modversion['config'][] = [
	'name'        => 'show_breadcrumbs',
	'title'       => '_MI_WGWFHDIARIES_SHOW_BREADCRUMBS',
	'description' => '_MI_WGWFHDIARIES_SHOW_BREADCRUMBS_DESC',
	'formtype'    => 'yesno',
	'valuetype'   => 'int',
	'default'     => 1,
];
// Advertise
$modversion['config'][] = [
	'name'        => 'advertise',
	'title'       => '_MI_WGWFHDIARIES_ADVERTISE',
	'description' => '_MI_WGWFHDIARIES_ADVERTISE_DESC',
	'formtype'    => 'textarea',
	'valuetype'   => 'text',
	'default'     => '',
];
// Bookmarks
$modversion['config'][] = [
	'name'        => 'bookmarks',
	'title'       => '_MI_WGWFHDIARIES_BOOKMARKS',
	'description' => '_MI_WGWFHDIARIES_BOOKMARKS_DESC',
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
	'title'       => '_MI_WGWFHDIARIES_MAINTAINEDBY',
	'description' => '_MI_WGWFHDIARIES_MAINTAINEDBY_DESC',
	'formtype'    => 'textbox',
	'valuetype'   => 'text',
	'default'     => 'https://xoops.org/modules/newbb',
];
