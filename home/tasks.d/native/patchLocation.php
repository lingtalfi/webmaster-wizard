<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('patchLocation', function (PhpManager $o) {
        $o->setConfigValue('patchLocation', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });




