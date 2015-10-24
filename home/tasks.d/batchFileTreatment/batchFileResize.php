<?php

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('batchFileResize', function (PhpManager $o, Config $c) {

        $size = $o->getTaskValue();
        if ($size) {

            $extensions = 'jpg|jpeg|png|gif';
            $path = $c->tmpDir;

            // find -E tmp2 -iregex ".*\.(jPg|png)" -exec mogrify -resize 600x400 '{}' \;         
            $cmd = <<<EEE
find -E $path -iregex ".*\.($extensions)" -exec mogrify -resize $size '{}' \;
EEE;
            $o->log("Executing command $cmd");

            passthru($cmd);
        }
    });







