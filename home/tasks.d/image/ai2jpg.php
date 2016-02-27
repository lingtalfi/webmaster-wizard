<?php

use Bat\FileSystemTool;

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('ai2jpg', function (PhpManager $o, Config $c) {

        $dir = trim($o->getTaskValue());
        if ('' !== $dir) {


            $files = scandir($dir);
            foreach ($files as $fileName) {
                if ('.' !== substr($fileName, 0, 1) && 'ai' === strtolower(FileSystemTool::getFileExtension($fileName))) {
                    $file = substr($fileName, 0, -2) . 'jpg';
                    $cmd = 'convert "' . Tool::dqEscape($dir . '/' . $fileName) . '" "' . Tool::dqEscape($dir . '/' . $file) . '"';
                    $o->log("executing command: " . $cmd);
                    exec($cmd);
                }
            }


            if ('Darwin' === PHP_OS) {
                $cmd = 'open "' . Tool::dqEscape($dir) . '"';
                $o->log("executing command: " . $cmd);
                passthru($cmd);
            }
        }
    });







