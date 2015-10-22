<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('defaultImportDir', function (PhpManager $o) {
        $o->setConfigValue('defaultImportDir', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });




