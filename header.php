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
include dirname(__DIR__, 2) . '/mainfile.php';
require __DIR__ . '/include/common.php';
$moduleDirName = \basename(__DIR__);

// Get instance of module
$helper = \XoopsModules\Wgdiaries\Helper::getInstance();
$itemsHandler = $helper->getHandler('Items');
$filesHandler = $helper->getHandler('Files');
$permissionsHandler = $helper->getHandler('Permissions');

// Breadcrumbs
$xoBreadcrumbs = [];
if (isset($GLOBALS['xoopsModule']) && \is_object($GLOBALS['xoopsModule'])) {
    $xoBreadcrumbs[] = ['title' => $GLOBALS['xoopsModule']->getVar('name'), 'link' => \WGDIARIES_URL . '/'];
}

// 
$myts = MyTextSanitizer::getInstance();
// Default Css Style
$style = \WGDIARIES_URL . '/assets/css/style.css';
// Smarty Default
$sysPathIcon16 = $GLOBALS['xoopsModule']->getInfo('sysicons16');
$sysPathIcon32 = $GLOBALS['xoopsModule']->getInfo('sysicons32');
$pathModuleAdmin = $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin');
$modPathIcon16 = $GLOBALS['xoopsModule']->getInfo('modicons16');
$modPathIcon32 = $GLOBALS['xoopsModule']->getInfo('modicons16');
// Load Languages
\xoops_loadLanguage('main');
\xoops_loadLanguage('modinfo');
