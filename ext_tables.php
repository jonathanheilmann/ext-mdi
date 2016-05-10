<?php
if (!defined('TYPO3_MODE'))
	die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Heilmann.' . $_EXTKEY,
		'Mdi',
		'Material design icons'
);

if (TYPO3_MODE === 'BE')
{
	$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
	
	if ($_extConfig['showBackendModule'])
	{
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

}

// Add icons (24dp)
$iconSets = array('action', 'alert', 'av', 'communication', 'content', 'device', 'editor', 'file', 'hardware', 'image', 'maps', 'navigation', 'notification', 'places', 'social', 'toggle', 'action16dp', 'content16dp', 'navigation16dp', 'toggle16dp');
foreach ($iconSets as $iconSet)
{
	$cssPath = 'Resources/Public/Sprites/' . $iconSet . '/stylesheet.css';
	$cssFileContents = file_get_contents(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . $cssPath);
	preg_match_all('/(\.?'.addcslashes('t3-icon-mdi_' . $iconSet, '-').'.*?)\s?\{/', $cssFileContents, $matches);
	$classList = $matches[1];
	$icons = array();
	foreach ($classList as $class) {
		$icons[] = str_replace('.t3-icon-', 'extensions-', $class);
	}

	\TYPO3\CMS\Backend\Sprite\SpriteManager::addIconSprite(
		$icons,
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($_EXTKEY) . $cssPath
	);
}
