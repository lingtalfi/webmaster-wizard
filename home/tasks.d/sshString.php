<?php

require_once __DIR__ . "/../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('sshString', function (PhpManager $o) {
        $o->setConfigValue('sshString', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });







