<?php

namespace XoopsModules\Wgdiaries;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Goffy - XOOPS Development Team
 */
//\defined('\XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Modulemenu
 */
class Modulemenu
{

    /** function to create an array for XOOPS main menu
     *
     * @return array
     */
    public function getMenuitemsDefault()
    {

        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgfilemanager\Helper::getInstance();
        //load necessary language files from this module
        $helper->loadLanguage('modinfo');

        $items = [];
        $currdirname  = isset($GLOBALS['xoopsModule']) && \is_object($GLOBALS['xoopsModule']) ? $GLOBALS['xoopsModule']->getVar('dirname') : 'system';
        if ($currdirname == $moduleDirName) {
            require_once \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/include/common.php';
            $helper = Helper::getInstance();
            $permissionsHandler = $helper->getHandler('Permissions');

            $items = [];
            $items[] = [
                'name' => \_MI_WGDIARIES_SMNAME1,
                'url'  => 'index.php',
            ];
            $items[] = [
                'name' => \_MI_WGDIARIES_SMNAME2,
                'url'  => 'items.php',
            ];
            if ($permissionsHandler->getPermItemsGroupView()) {
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME4,
                    'url'  => 'items.php?op=listgroup',
                ];
            }
            if ($permissionsHandler->getPermItemsSubmit()) {
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME3,
                    'url'  => 'items.php?op=new',
                ];
            }
            if ($permissionsHandler->getPermCalPageView()) {
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME7,
                    'url' => 'calendar.php',
                ];
            }
            if ($permissionsHandler->getPermStatisticsView()) {
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME5,
                    'url' => 'statistics.php',
                ];
            }
            if ($permissionsHandler->getPermOutputsView()) {
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME6,
                    'url' => 'outputs.php',
                ];
            }
            if ($permissionsHandler->getPermItemsSubmit()) {
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME8,
                    'url'  => 'archive.php',
                ];
            }
            if ($permissionsHandler->getPermUserItemsView()) {
                // Sub Submit
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME9,
                    'url'  => 'useritems.php',
                ];
            }
        }

        return $items;
    }


    /** function to create a list of sublinks
     *
     * @return array
     */
    public function getMenuitemsSbadmin5()
    {
        $moduleDirName = \basename(\dirname(__DIR__));
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';
        $urlModule     = \XOOPS_URL . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgdiaries\Helper::getInstance();

        //load necessary language files from this module
/*        $helper->loadLanguage('common');
        $helper->loadLanguage('main');*/
        $helper->loadLanguage('modinfo');

        // start creation of link list as array
        $permissionsHandler = $helper->getHandler('Permissions');

        $requestUri = $_SERVER['REQUEST_URI'];
        /*read navbar items related to perms of current user*/
        $nav_items1 = [];
        $nav_items1[] = [
            'highlight' => \strpos($requestUri, $moduleDirName . '/index.php') > 0,
            'url' => $urlModule . 'index.php',
            'icon' => '<i class="fa fa-tachometer fa-fw fa-lg"></i>',
            'name' => \_MI_WGDIARIES_SMNAME1,
            'sublinks' => []
        ];
        // Sub items
        $nav_items1[] = [
            'highlight' => \strpos($requestUri, $moduleDirName . '/items.php') > 0 && 0 === \strpos($requestUri, $moduleDirName . '/items.php?op='),
            'url' => $urlModule . 'items.php',
            'icon' => '<i class="fa fa-list-alt fa-fw fa-lg"></i>',
            'name' => \_MI_WGDIARIES_SMNAME2,
            'sublinks' => []
        ];
        if ($permissionsHandler->getPermItemsGroupView()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/items.php?op=listgroup') > 0,
                'url' => $urlModule . 'items.php?op=listgroup',
                'icon' => '<i class="fa fa-group fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME4,
                'sublinks' => []
            ];
        }
        if ($permissionsHandler->getPermItemsSubmit()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/items.php?op=new.php') > 0,
                'url' => $urlModule . 'items.php?op=new.php',
                'icon' => '<i class="fa fa-edit fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME3,
                'sublinks' => []
            ];
        }
        if ($permissionsHandler->getPermCalPageView()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/calendar.php') > 0,
                'url' => $urlModule . 'calendar.php',
                'icon' => '<i class="fa fa-calendar fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME7,
                'sublinks' => []
            ];
        }
        if ($permissionsHandler->getPermStatisticsView()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/statistics.php') > 0,
                'url' => $urlModule . 'statistics.php',
                'icon' => '<i class="fa fa-bar-chart-o fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME5,
                'sublinks' => []
            ];
        }
        if ($permissionsHandler->getPermOutputsView()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/outputs.php') > 0,
                'url' => $urlModule . 'outputs.php',
                'icon' => '<i class="fa fa-download fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME6,
                'sublinks' => []
            ];
        }
        if ($permissionsHandler->getPermItemsSubmit()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/archive.php') > 0,
                'url' => $urlModule . 'archive.php',
                'icon' => '<i class="fa fa-folder-o fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME8,
                'sublinks' => []
            ];
        }
        if ($permissionsHandler->getPermUserItemsView()) {
            $nav_items1[] = [
                'highlight' => \strpos($requestUri, $moduleDirName . '/useritems.php') > 0,
                'url' => $urlModule . 'useritems.php',
                'icon' => '<i class="fa fa-user fa-fw fa-lg"></i>',
                'name' => \_MI_WGDIARIES_SMNAME9,
                'sublinks' => []
            ];
        }

        return $nav_items1;
    }


}
