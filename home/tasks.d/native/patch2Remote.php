<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";




PhpManager::create()
    ->execute('patch2Remote', function (PhpManager $o, Config $c) {


        $cmd = $o->replaceTags("ssh {sshString} 'mysql -u{remoteDbUser} -p{remoteDbPass} {remoteDb}' < \"{&sqlPatchLoc}\"");

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("ssh {sshString} 'mysql -u{remoteDbUser} -pXXX {remoteDb}' < \"{&sqlPatchLoc}\"");
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });




