<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('defaultExportDir', function (PhpManager $o) {
        $o->setConfigValue('defaultExportDir', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });




