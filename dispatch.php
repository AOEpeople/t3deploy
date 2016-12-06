<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2016 AOE GmbH <dev@aoe.com>
*  All rights reserved
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

if (!TYPO3_REQUESTTYPE == 6) {
	die('Access denied: CLI only.');
}

require_once PATH_tx_t3deploy . 'classes/class.tx_t3deploy_dispatch.php';
echo \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_t3deploy_dispatch')->dispatch() . PHP_EOL;
