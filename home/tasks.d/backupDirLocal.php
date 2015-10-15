<?php

require_once __DIR__ . "/../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('backupDirLocal', function (PhpManager $o) {
        $o->setConfigValue('backupDirLocal', $o->getTaskValue());
    });