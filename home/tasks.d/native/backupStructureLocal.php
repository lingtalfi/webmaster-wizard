<?php

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('backupStructureLocal', function (PhpManager $o, Config $c) {

        
        $cmd = $o->replaceTags("mysqldump --no-data -u{localDbUser} -p{localDbPass} {localDb} > \"{&_value_}\"");
        $cmd = Tool::replaceTimeStamps($cmd);

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("mysqldump --no-data -u{localDbUser} -pXXX {localDb} > \"{&_value_}\"");
            $displayCmd = Tool::replaceTimeStamps($displayCmd);
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });







