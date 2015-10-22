<?php

use Bat\FileSystemTool;

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('batchFileExport', function (PhpManager $o, Config $c) {
        $dst = trim($o->getTaskValue());
        if ('' === $dst) {
            $dst = $c->defaultExportDir;
        }
        if ('' !== $dst) {
            $src = $c->tmpDir;
            if ('' !== $src) {

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







