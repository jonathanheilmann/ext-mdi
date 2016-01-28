<?php
namespace Heilmann\Mdi\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Jonathan Heilmann <mail@jonathan-heilmann.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Class MdiController
 * @package Heilmann\Mdo\Controller
 */
class MdiController extends ActionController {

    /**
     * action list
     *
     */
    public function listAction() {
        $allIcons = $GLOBALS['TBE_STYLES']['spriteIconApi']['iconsAvailable'];
        $icons = array();
        foreach ($allIcons as $value) {
            if (strpos($value, 'extensions-mdi_') === 0) {
                $valueParts = explode('-', $value);
                $icons[str_replace('mdi_', '', $valueParts[1])][] = $value;
            }
        }
        $this->view->assign('icons', $icons);
    }
}