<?php

declare(strict_types=1);


namespace XoopsModules\Wgdiaries;

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

use XoopsModules\Wgdiaries;

\defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class Object Categories
 */
class Categories extends \XoopsObject
{
    /**
     * Constructor
     *
     * @param null
     */
    public function __construct()
    {
        $this->initVar('cat_id', \XOBJ_DTYPE_INT);
        $this->initVar('cat_name', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_logo', \XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_online', \XOBJ_DTYPE_INT);
        $this->initVar('cat_weight', \XOBJ_DTYPE_INT);
        $this->initVar('cat_datecreated', \XOBJ_DTYPE_INT);
        $this->initVar('cat_submitter', \XOBJ_DTYPE_INT);
    }

    /**
     * @static function &getInstance
     *
     * @param null
     */
    public static function getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new self();
        }
    }

    /**
     * The new inserted $Id
     * @return inserted id
     */
    public function getNewInsertedIdCategories()
    {
        $newInsertedId = $GLOBALS['xoopsDB']->getInsertId();
        return $newInsertedId;
    }

    /**
     * @public function getForm
     * @param bool $action
     * @return \XoopsThemeForm
     */
    public function getFormCategories($action = false)
    {
        $helper = \XoopsModules\Wgdiaries\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        //$isAdmin = $GLOBALS['xoopsUser']->isAdmin($GLOBALS['xoopsModule']->mid());
        // Title
        $title = $this->isNew() ? \sprintf(\_AM_WGDIARIES_CATEGORY_ADD) : \sprintf(\_AM_WGDIARIES_CATEGORY_EDIT);
        // Get Theme Form
        \xoops_load('XoopsFormLoader');
        $form = new \XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        // Form Text catName
        $form->addElement(new \XoopsFormText(\_AM_WGDIARIES_CATEGORY_NAME, 'cat_name', 50, 255, $this->getVar('cat_name')), true);
        // Form Image catLogo
        // Form Image catLogo: Select Uploaded Image 
        $getCatLogo = $this->getVar('cat_logo');
        $catLogo = $getCatLogo ?: 'blank.gif';
        $imageDirectory = '/uploads/wgdiaries/categories';
        $imageTray = new \XoopsFormElementTray(\_AM_WGDIARIES_CATEGORY_LOGO, '<br>');
        $imageSelect = new \XoopsFormSelect(\sprintf(\_AM_WGDIARIES_CATEGORY_LOGO_UPLOADS, ".{$imageDirectory}/"), 'cat_logo', $catLogo, 5);
        $imageArray = \XoopsLists::getImgListAsArray( \XOOPS_ROOT_PATH . $imageDirectory );
        foreach ($imageArray as $image1) {
            $imageSelect->addOption((string)($image1), $image1);
        }
        $imageSelect->setExtra("onchange='showImgSelected(\"imglabel_cat_logo\", \"cat_logo\", \"" . $imageDirectory . '", "", "' . \XOOPS_URL . "\")'");
        $imageTray->addElement($imageSelect, false);
        $imageTray->addElement(new \XoopsFormLabel('', "<br><img src='" . \XOOPS_URL . '/' . $imageDirectory . '/' . $catLogo . "' id='imglabel_cat_logo' alt='' style='max-width:100px' />"));
        // Form Image catLogo: Upload new image
        $maxsize = $helper->getConfig('maxsize_image');
        $imageTray->addElement(new \XoopsFormFile('<br>' . \_MA_WGDIARIES_FORM_UPLOAD_NEW, 'cat_logo', $maxsize));
        $imageTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_SIZE, ($maxsize / 1048576) . ' '  . \_MA_WGDIARIES_FORM_UPLOAD_SIZE_MB));
        $imageTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_IMG_WIDTH, $helper->getConfig('maxwidth_image') . ' px'));
        $imageTray->addElement(new \XoopsFormLabel(\_MA_WGDIARIES_FORM_UPLOAD_IMG_HEIGHT, $helper->getConfig('maxheight_image') . ' px'));
        $form->addElement($imageTray);
        // Form Radio Yes/No catOnline
        $catOnline = $this->isNew() ? 0 : $this->getVar('cat_online');
        $form->addElement(new \XoopsFormRadioYN(\_AM_WGDIARIES_CATEGORY_ONLINE, 'cat_online', $catOnline));
        // Form Text catWeight
        $form->addElement(new \XoopsFormText(\_AM_WGDIARIES_CATEGORY_WEIGHT, 'cat_weight', 50, 255, $this->getVar('cat_weight')));
        // Form Text Date Select catDatecreated
        $catDatecreated = $this->isNew() ? time() : $this->getVar('cat_datecreated');
        $form->addElement(new \XoopsFormTextDateSelect(\_AM_WGDIARIES_CATEGORY_DATECREATED, 'cat_datecreated', '', $catDatecreated));
        // Form Select User catSubmitter
        $catSubmitter = $this->isNew() ? $GLOBALS['xoopsUser']->uid() : $this->getVar('cat_submitter');
        $form->addElement(new \XoopsFormSelectUser(\_AM_WGDIARIES_CATEGORY_SUBMITTER, 'cat_submitter', false, $catSubmitter));
        // To Save
        $form->addElement(new \XoopsFormHidden('op', 'save'));
        $form->addElement(new \XoopsFormButtonTray('', \_SUBMIT, 'submit', '', false));
        return $form;
    }

    /**
     * Get Values
     * @param null $keys
     * @param null $format
     * @param null $maxDepth
     * @return array
     */
    public function getValuesCategories($keys = null, $format = null, $maxDepth = null)
    {
        $ret = $this->getValues($keys, $format, $maxDepth);
        $ret['id']          = $this->getVar('cat_id');
        $ret['name']        = $this->getVar('cat_name');
        $ret['logo']        = $this->getVar('cat_logo');
        $ret['online']      = (int)$this->getVar('cata_online') > 0 ? _YES : _NO;
        $ret['weight']      = $this->getVar('cat_weight');
        $ret['datecreated'] = \formatTimestamp($this->getVar('cat_datecreated'), 's');
        $ret['submitter']   = \XoopsUser::getUnameFromId($this->getVar('cat_submitter'), true);
        return $ret;
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    public function toArrayCategories()
    {
        $ret = [];
        $vars = $this->getVars();
        foreach (\array_keys($vars) as $var) {
            $ret[$var] = $this->getVar('"{$var}"');
        }
        return $ret;
    }
}
