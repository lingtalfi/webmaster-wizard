<?php

require_once __DIR__ . "/../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('saveFromLocal', function (PhpManager $o, Config $c) {


        $cmd = $o->replaceTags("mysqldump -u{localDbUser} -p{localDbPass} {localDb} > \"{&tmpFile}\"");
        $cmd = Tool::replaceTimeStamps($cmd);

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("mysqldump -u{localDbUser} -pXXX {localDb} > \"{&tmpFile}\"");
            $displayCmd = Tool::replaceTimeStamps($displayCmd);
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });







