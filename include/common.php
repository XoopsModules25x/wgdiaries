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
if (!\defined('XOOPS_ICONS32_PATH')) {
    \define('XOOPS_ICONS32_PATH', \XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
    \define('XOOPS_ICONS32_URL', \XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('WGDIARIES_DIRNAME', 'wgdiaries');
\define('WGDIARIES_PATH', \XOOPS_ROOT_PATH . '/modules/' . WGDIARIES_DIRNAME);
\define('WGDIARIES_URL', \XOOPS_URL . '/modules/' . WGDIARIES_DIRNAME);
\define('WGDIARIES_ICONS_PATH', WGDIARIES_PATH . '/assets/icons');
\define('WGDIARIES_ICONS_URL', WGDIARIES_URL . '/assets/icons');
\define('WGDIARIES_IMAGE_PATH', WGDIARIES_PATH . '/assets/images');
\define('WGDIARIES_IMAGE_URL', WGDIARIES_URL . '/assets/images');
\define('WGDIARIES_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . WGDIARIES_DIRNAME);
\define('WGDIARIES_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . WGDIARIES_DIRNAME);
\define('WGDIARIES_UPLOAD_FILES_PATH', WGDIARIES_UPLOAD_PATH . '/files');
\define('WGDIARIES_UPLOAD_FILES_URL', WGDIARIES_UPLOAD_URL . '/files');
\define('WGDIARIES_UPLOAD_IMAGE_PATH', WGDIARIES_UPLOAD_PATH . '/images');
\define('WGDIARIES_UPLOAD_IMAGE_URL', WGDIARIES_UPLOAD_URL . '/images');
\define('WGDIARIES_UPLOAD_SHOTS_PATH', WGDIARIES_UPLOAD_PATH . '/images/shots');
\define('WGDIARIES_UPLOAD_SHOTS_URL', WGDIARIES_UPLOAD_URL . '/images/shots');
\define('WGDIARIES_ADMIN', WGDIARIES_URL . '/admin/index.php');
$localLogo = WGDIARIES_IMAGE_URL . '/wedega_logo.png';
// Module Information
$copyright = "<a href='https://xoops.wedega.com' title='XOOPS Project' target='_blank'><img src='" . $localLogo . "' alt='XOOPS Project' /></a>";
include_once \XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
include_once WGDIARIES_PATH . '/include/functions.php';
