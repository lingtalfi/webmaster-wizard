<?php

use Bat\FileSystemTool;

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('batchFileImport', function (PhpManager $o, Config $c) {
        $src = trim($o->getTaskValue());
        if ('' === $src) {
            $src = $c->defaultImportDir;
        }
        if ('' !== $src) {
            $dst = $c->tmpDir;
            if ('' !== $dst) {
                
                $o->log("Copying $src to $dst");
                
                $errors = [];
                FileSystemTool::copyDir($src, $dst, false, $errors);
                if ($errors) {
                    $o->warning("The following errors have occurred while copying $src to $dst:");
                    foreach ($errors as $err) {
                        $o->warning($err);
                    }
                }
            }
            else {
                $o->warning("The tmpDir is not defined");
            }
        }
    });







