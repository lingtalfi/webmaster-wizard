<?php

require_once __DIR__ . "/../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('saveFromRemoteDestructive', function (PhpManager $o, Config $c) {


        $cmd = $o->replaceTags("ssh {sshString} 'mysqldump --add-drop-database -u{remoteDbUser} -p{remoteDbPass} --databases {remoteDb}' > \"{&tmpFile}\"");

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("ssh {sshString} 'mysqldump --add-drop-database -u{remoteDbUser} -pXXX --databases {remoteDb}' > \"{&tmpFile}\"");
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });







