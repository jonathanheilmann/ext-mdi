<?php
namespace Heilmann\Mdi\ViewHelpers;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Jonathan Heilmann <mail@jonathan-heilmann.de>
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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class IconViewHelper
 *
 * This is a backport of the TYPO3 CMS 6.2 LTS IconViewHelper to support SpriteIcons in newer TYPO3 CMS versions
 *
 * @package Heilmann\Mdi\ViewHelpers
 */
class IconViewHelper extends AbstractViewHelper
{

    /**
     * Initialize arguments
     *
     * @return void
     * @api
     */
    public function initializeArguments() {
        $this->registerArgument('additionalAttributes', 'array', 'Additional tag attributes. They will be added directly to the resulting HTML tag.', FALSE);
    }

    /**
     * Renders a linked icon as known from the TYPO3 backend.
     *
     * If the URI is left empty, the icon is rendered without link.
     *
     * @param string $uri The target URI for the link. If you want to execute JavaScript here, prefix the URI with "javascript:". Leave empty to render just an icon.
     * @param string $icon Icon to be used.
     * @param string $title Title attribute of the icon construct
     * @return string The rendered icon with or without link
     */
    public function render($uri = '', $icon = 'actions-document-close', $title = '') {
        $style = 'display: inline-block; position: relative; vertical-align: middle; background-repeat: no-repeat; margin-right: 2px; overflow: hidden;';
        $icon = \TYPO3\CMS\Backend\Utility\IconUtility::getSpriteIcon($icon, array('title' => $title, 'style' => $style));
        $icon = str_replace('t3-icon ', '', $icon);
        if (empty($uri)) {
            return $icon;
        } else {
            $additionalAttributes = '';
            if ($this->hasArgument('additionalAttributes') && is_array($this->arguments['additionalAttributes'])) {
                foreach ($this->arguments['additionalAttributes'] as $argumentKey => $argumentValue) {
                    $additionalAttributes .= ' ' . $argumentKey . '="' . htmlspecialchars($argumentValue) . '"';
                }
            }
            return '<a href="' . $uri . '"' . $additionalAttributes . '>' . $icon . '</a>';
        }
    }
}