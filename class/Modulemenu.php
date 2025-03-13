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
        $subcount      = 1;
        $pathname      = \XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/';
        $urlModule     = \XOOPS_URL . '/modules/' . $moduleDirName . '/';

        require_once $pathname . 'include/common.php';
        $helper = \XoopsModules\Wgfilemanager\Helper::getInstance();
        //load necessary language files from this module
        $helper->loadLanguage('modinfo');

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
            // Sub items
            $items[] = [
                'name' => \_MI_WGDIARIES_SMNAME2,
                'url'  => 'items.php',
            ];
            if ($permissionsHandler->getPermItemsGroupView()) {
                // Sub Submit
                $items[] = [
                    'name' => \_MI_WGDIARIES_SMNAME4,
                    'url'  => 'items.php?op=listgroup',
                ];
            }
            if ($permissionsHandler->getPermItemsSubmit()) {
                // Sub Submit
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
                // Sub Submit
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
        return $this->getMenuitemsDefault();
    }


}
