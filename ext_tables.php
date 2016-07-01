<?php
if (!defined('TYPO3_MODE'))
	die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
		'Heilmann.' . $_EXTKEY,
		'Mdi',
		'Material design icons'
);

$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

if (TYPO3_MODE === 'BE')
{

	if ($_extConfig['showBackendModule'])
	{
        // Fetch module icon depending on TYPO3 CMS branch
        $icon = version_compare(TYPO3_branch, '7.6', '>=') ? 'EXT:mdi/Resources/Public/MaterialDesignIcons/svg/android.svg' : 'EXT:mdi/Resources/Public/Icons/action/ic_android_black_18dp.png';

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
				'icon'   => $icon,
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
	foreach ($classList as $class)
		$icons[] = str_replace('.t3-icon-', 'extensions-', $class);

	\TYPO3\CMS\Backend\Sprite\SpriteManager::addIconSprite(
		$icons,
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath($_EXTKEY) . $cssPath
	);
}

// Register icons (Material Design Icons)
if (version_compare(TYPO3_branch, '7.6') >= 0)
{

    /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

    /**
     * Register SVG icons
     */
    $svgFolderPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/MaterialDesignIcons/svg/';
    $svgIcons = \TYPO3\CMS\Core\Utility\GeneralUtility::getFilesInDir($svgFolderPath, 'svg');

    foreach ($svgIcons as $svgIcon)
    {
        $iconName = str_replace('.svg', '', $svgIcon);
        $iconRegistry->registerIcon(
            'tx-mdi-'. $iconName,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => $svgFolderPath . $svgIcon]
        );
    }

    /**
     * Register "Material Design Icons" font
     */
    if ($_extConfig['loadFont'])
    {
        $cssFileContents = file_get_contents(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/MaterialDesignIcons/css/materialdesignicons.css');
        preg_match_all('/(\.?'.addcslashes('mdi-', '-').'.*?)\s?\{/', $cssFileContents, $matches);
        $classList = $matches[1];

        foreach ($classList as $class)
        {
            if (strpos($class, ':before'))
            {
                $iconName = str_replace(array('.mdi-', ':before'), '', $class);
                \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($iconName);

                $iconRegistry->registerIcon(
                    'tx-mdi-' . $iconName,
                    \Heilmann\Mdi\Imaging\IconProvider\MaterialDesignIconProvider::class,
                    [
                        'name'     => $iconName,
                        'spinning' => false
                    ]
                );
            }
        }

        $GLOBALS['TBE_STYLES']['skins'][$_EXTKEY] = array (
            'name' => $_EXTKEY,
            'stylesheetDirectories' => array(
                'css' => 'EXT:' . $_EXTKEY . '/Resources/Public/MaterialDesignIcons/css/'
            )
        );
    }
    
}
