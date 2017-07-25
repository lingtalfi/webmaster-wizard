<?php



require_once __DIR__ . "/../../phpManager.plugin/init.php";



PhpManager::create()
    ->execute('applyToLocal', function (PhpManager $o, Config $c) {


        $command = MYSQL_PREFIX . "mysql";

        $cmd = $o->replaceTags("$command -u{localDbUser} -p{localDbPass} {localDb} < \"{&tmpFile}\"");

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("$command -u{localDbUser} -pXXX {localDb} < \"{&tmpFile}\"");
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });




