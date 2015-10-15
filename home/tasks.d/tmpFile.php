<?php



require_once __DIR__ . "/../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('tmpFile', function (PhpManager $o) {
        $o->setConfigValue('tmpFile', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });




