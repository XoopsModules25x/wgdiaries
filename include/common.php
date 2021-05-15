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
if (!\defined('XOOPS_ICONS32_PATH')) {
	\define('XOOPS_ICONS32_PATH', XOOPS_ROOT_PATH . '/Frameworks/moduleclasses/icons/32');
}
if (!\defined('XOOPS_ICONS32_URL')) {
	\define('XOOPS_ICONS32_URL', XOOPS_URL . '/Frameworks/moduleclasses/icons/32');
}
\define('WGWFHDIARIES_DIRNAME', 'wgwfhdiaries');
\define('WGWFHDIARIES_PATH', XOOPS_ROOT_PATH . '/modules/' . WGWFHDIARIES_DIRNAME);
\define('WGWFHDIARIES_URL', XOOPS_URL . '/modules/' . WGWFHDIARIES_DIRNAME);
\define('WGWFHDIARIES_ICONS_PATH', WGWFHDIARIES_PATH . '/assets/icons');
\define('WGWFHDIARIES_ICONS_URL', WGWFHDIARIES_URL . '/assets/icons');
\define('WGWFHDIARIES_IMAGE_PATH', WGWFHDIARIES_PATH . '/assets/images');
\define('WGWFHDIARIES_IMAGE_URL', WGWFHDIARIES_URL . '/assets/images');
\define('WGWFHDIARIES_UPLOAD_PATH', XOOPS_UPLOAD_PATH . '/' . WGWFHDIARIES_DIRNAME);
\define('WGWFHDIARIES_UPLOAD_URL', XOOPS_UPLOAD_URL . '/' . WGWFHDIARIES_DIRNAME);
\define('WGWFHDIARIES_UPLOAD_FILES_PATH', WGWFHDIARIES_UPLOAD_PATH . '/files');
\define('WGWFHDIARIES_UPLOAD_FILES_URL', WGWFHDIARIES_UPLOAD_URL . '/files');
\define('WGWFHDIARIES_UPLOAD_IMAGE_PATH', WGWFHDIARIES_UPLOAD_PATH . '/images');
\define('WGWFHDIARIES_UPLOAD_IMAGE_URL', WGWFHDIARIES_UPLOAD_URL . '/images');
\define('WGWFHDIARIES_UPLOAD_SHOTS_PATH', WGWFHDIARIES_UPLOAD_PATH . '/images/shots');
\define('WGWFHDIARIES_UPLOAD_SHOTS_URL', WGWFHDIARIES_UPLOAD_URL . '/images/shots');
\define('WGWFHDIARIES_ADMIN', WGWFHDIARIES_URL . '/admin/index.php');
$localLogo = WGWFHDIARIES_IMAGE_URL . '/wedega_logo.png';
// Module Information
$copyright = "<a href='https://xoops.wedega.com' title='XOOPS Project' target='_blank'><img src='" . $localLogo . "' alt='XOOPS Project' /></a>";
include_once XOOPS_ROOT_PATH . '/class/xoopsrequest.php';
include_once WGWFHDIARIES_PATH . '/include/functions.php';
