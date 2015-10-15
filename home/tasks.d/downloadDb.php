<?php

require_once __DIR__ . "/../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('downloadDb', function (PhpManager $o, Config $c) {


        $cmd = $o->replaceTags("ssh {sshString} 'mysqldump -u{remoteDbUser} -p{remoteDbPass} {remoteDb}' > \"{&_value_}\"");

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("ssh {sshString} 'mysqldump -u{remoteDbUser} -pXXX {remoteDb}' > \"{&_value_}\"");
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });







