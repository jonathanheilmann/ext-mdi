<?php
namespace Heilmann\Mdi\Imaging\IconProvider;

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

use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconProviderInterface;

/**
 * Class MaterialDesignIconProvider
 * @package Heilmann\Mdi\Imaging\IconProvider
 */
class MaterialDesignIconProvider implements IconProviderInterface
{
    /**
     * @param Icon $icon
     * @param array $options
     */
    public function prepareIconMarkup(Icon $icon, array $options = array())
    {
        $icon->setMarkup($this->generateMarkup($icon, $options));
    }

    /**
     * @param Icon $icon
     * @param array $options
     * @return string
     */
    protected function generateMarkup(Icon $icon, array $options)
    {
        if (empty($options['name']))
            throw new \InvalidArgumentException('The option "name" is required and must not be empty', 1440754978);

        if (preg_match('/^[a-zA-Z0-9\\-]+$/', $options['name']) !== 1)
            throw new \InvalidArgumentException('The option "name" must only contain characters a-z, A-Z, 0-9 or -', 1440754979);

        return '<span class="icon-unify"><i class="mdi mdi-"' . htmlspecialchars($options['name']) . '"></i></span>';
    }
}