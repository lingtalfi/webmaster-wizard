<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";




PhpManager::create()
    ->execute('applyToRemote', function (PhpManager $o, Config $c) {


        $command = MYSQL_PREFIX . "mysql";


        $cmd = $o->replaceTags("ssh {sshString} '$command -u{remoteDbUser} -p{remoteDbPass} {remoteDb}' < \"{&tmpFile}\"");

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("ssh {sshString} '$command -u{remoteDbUser} -pXXX {remoteDb}' < \"{&tmpFile}\"");
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });




