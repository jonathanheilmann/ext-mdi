<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		$_EXTKEY,
		'Mdi',
		'Material design icons'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
			'Heilmann.' . $_EXTKEY,
			'tools',     // Make module a submodule of 'user'
			'mdi',    // Submodule key
			'',                        // Position
			array(
					'Mdi' => 'list'
			),
			array(
					'access' => 'user,group',
					'icon'   => 'EXT:mdi/Resources/Public/Icons/action/ic_android_black_18dp.png',
					'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mdi.xlf',
			)
	);
}

// Add icons (24dp)
addIconSpriteForIconSet($_EXTKEY, 'action');
addIconSpriteForIconSet($_EXTKEY, 'alert');
addIconSpriteForIconSet($_EXTKEY, 'av');
addIconSpriteForIconSet($_EXTKEY, 'communication');
addIconSpriteForIconSet($_EXTKEY, 'content');
addIconSpriteForIconSet($_EXTKEY, 'device');
addIconSpriteForIconSet($_EXTKEY, 'editor');
addIconSpriteForIconSet($_EXTKEY, 'file');
addIconSpriteForIconSet($_EXTKEY, 'hardware');
addIconSpriteForIconSet($_EXTKEY, 'image');
addIconSpriteForIconSet($_EXTKEY, 'maps');
addIconSpriteForIconSet($_EXTKEY, 'navigation');
addIconSpriteForIconSet($_EXTKEY, 'notification');
addIconSpriteForIconSet($_EXTKEY, 'places');
addIconSpriteForIconSet($_EXTKEY, 'social');
addIconSpriteForIconSet($_EXTKEY, 'toggle');

// Add icons (16dp)
addIconSpriteForIconSet($_EXTKEY, 'action16dp');
addIconSpriteForIconSet($_EXTKEY, 'content16dp');
addIconSpriteForIconSet($_EXTKEY, 'navigation16dp');
addIconSpriteForIconSet($_EXTKEY, 'toggle16dp');

/**
 *
 *
 * @param $iconSet
 */
function addIconSpriteForIconSet($extKey, $iconSet) {
	$cssPath = 'Resources/Public/Sprites/' . $iconSet . '/stylesheet.css';
	$cssFileContents = file_get_contents(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extKey) . $cssPath);
	preg_match_all('/(\.?'.addcslashes('t3-icon-mdi_' . $iconSet, '-').'.*?)\s?\{/', $cssFileContents, $matches);
	$classList = $matches[1];
	$icons = array();
	foreach ($classList as $class) {
		$icons[] = str_replace('.t3-icon-', 'extensions-', $class);
	}

	\TYPO3\CMS\Backend\Sprite\SpriteManager::addIconSprite(
			$icons,
			\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($extKey) . $cssPath
	);
}
