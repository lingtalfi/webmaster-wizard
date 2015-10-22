<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()->execute('printEnv', function (PhpManager $o, Config $c) {
    $o->printConfigEnv();
});