<?php
global $EM_CONF,$_EXTKEY;

$EM_CONF[$_EXTKEY] = array(
	'title' => 't3deploy TYPO3 dispatcher',
	'description' => '',
	'category' => 'be',
	'author' => 'AOE GmbH',
	'author_email' => 'dev@aoe.com',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'createDirs' => '',
	'modify_tables' => '',
	'lockType' => '',
	'author_company' => '',
	'version' => '1.0.0',
	'constraints' => array(
		'depends' => array(
			'typo3'=>'4.2.0-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => '',
);
