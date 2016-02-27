<?php


require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('openHome', function (PhpManager $o, Config $c) {

        
        $path = __DIR__ . "/../../";
        
        $displayCmd = 'open "'. Tool::dqEscape($path) .'"';
        $o->log("executing command: $displayCmd");
        passthru($displayCmd);
    });






