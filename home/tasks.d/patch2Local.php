<?php



require_once __DIR__ . "/../phpManager.plugin/init.php";



PhpManager::create()
    ->execute('patch2local', function (PhpManager $o, Config $c) {


        $cmd = $o->replaceTags("mysql -u{localDbUser} -p{localDbPass} {localDb} < \"{&sqlPatchLoc}\"");

        if ('1' === $c->secure) {
            $displayCmd = $o->replaceTags("mysql -u{localDbUser} -pXXX {localDb} < \"{&sqlPatchLoc}\"");
        }
        else {
            $displayCmd = $cmd;
        }
        $o->log("executing command: $displayCmd");
        passthru($cmd);
    });




