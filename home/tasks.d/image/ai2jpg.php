<?php

use Bat\FileSystemTool;

require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('ai2jpg', function (PhpManager $o, Config $c) {

        $dir = trim($o->getTaskValue());
        if ('' !== $dir) {


            $files = scandir($dir);
            $escapedFiles = [];
            foreach ($files as $fileName) {
                if ('.' !== substr($fileName, 0, 1) && 'ai' === strtolower(FileSystemTool::getFileExtension($fileName))) {
                    $file = substr($fileName, 0, -2) . 'jpg';
                    $escapedFile = '"' . Tool::dqEscape($dir . '/' . $fileName) . '"';
                    $cmd = 'convert ' . $escapedFile . ' "' . Tool::dqEscape($dir . '/' . $file) . '"';
                    $o->log("executing command: " . $cmd);
                    exec($cmd);

                    $escapedFiles[] = $escapedFile;

                }
            }


            $cmd = 'montage -geometry +2+2 ' . implode(' ', $escapedFiles) . ' "' . Tool::dqEscape($dir . '/montage.jpg') . '"';
            $o->log("executing command: " . $cmd);
            exec($cmd);


            if ('Darwin' === PHP_OS) {
                $cmd = 'open "' . Tool::dqEscape($dir) . '"';
                $o->log("executing command: " . $cmd);
                passthru($cmd);
            }
        }
    });







