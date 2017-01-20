<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 't3deploy TYPO3 dispatcher',
    'description' => 'TYPO3 dispatcher for database related operations',
    'category' => 'be',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'AOE GmbH',
    'author_email' => 'dev@aoe.com',
    'version' => '1.1.1',
    'constraints' => array(
        'depends' => array(
            'typo3'=>'6.2.0-7.6.99',
        ),
        'conflicts' => array(),
        'suggests' => array(),
    )
);
