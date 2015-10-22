<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('tmpDir', function (PhpManager $o) {
        $o->setConfigValue('tmpDir', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });




