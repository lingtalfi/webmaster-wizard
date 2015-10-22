<?php

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('saveFromLocalDestructive', function (PhpManager $o, Config $c) {


        $cmd = $o->replaceTags("mysqldump --add-drop-database -u{localDbUser} -p{localDbPass} --databases {localDb} > \"{&tmpFile}\"");
        $cmd = Tool::replaceTimeStamps($cmd);

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("mysqldump --add-drop-database -u{localDbUser} -pXXX {localDb} --databases > \"{&tmpFile}\"");
            $displayCmd = Tool::replaceTimeStamps($displayCmd);
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });







