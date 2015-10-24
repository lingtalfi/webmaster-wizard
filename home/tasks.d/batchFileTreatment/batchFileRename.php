<?php

use Ornella\OrnellaTagNotationUtil;

require_once __DIR__ . "/../../phpManager.plugin/init.php";

/**
 *
 * This is a basic rename task.
 *
 * Task value: pattern
 * It uses Ornella Tag Notation: https://github.com/lingtalfi/ornella/blob/master/ornella-tag-notation.md
 * The possible identifiers are:
 *
 *      - fileName:
 *                  the file name as defined here:
 *                  https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.fileName.eng.md
 *      - ext:
 *                  the file extension
 *
 * This task ignores hidden files (entries which base name starts with dot).
 *
 */


function safe($string, $char)
{
    return preg_replace('[^a-zA-Z0-9_]', $char, $string);
}

PhpManager::create()
    ->execute('batchFileRename', function (PhpManager $o, Config $c) {

        $pattern = $o->getTaskValue();
        if ($pattern) {

            $path = $c->tmpDir;
            $ornella = OrnellaTagNotationUtil::create();


            foreach (
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST) as $item
            ) {
                /**
                 * @var \SplFileInfo $item
                 */
                if ($item->isFile()) {

                    if ('.' !== substr($item->getBasename(), 0, 1)) {

                        $fileName = pathinfo($item)['filename'];
                        $ext = $item->getExtension();
                        $dir = dirname($item);


                        // assuming that each tag is only used once in the pattern
                        if (false !== ($baseName = $ornella->parse($pattern, [
                                'fileName' => $fileName,
                                'ext' => $ext,
                            ]))
                        ) {

                            $newPath = $dir . '/' . $baseName;
                            $oldPath = $item->getRealPath();
                            if ($oldPath !== $newPath) {
                                $o->log("Renaming $oldPath to $newPath");
                                rename($oldPath, $newPath);
                            }
                            else {
                                $o->log("$oldPath is unchanged");
                            }
                        }
                        else {
                            foreach ($ornella->getErrors() as $error) {
                                $o->log("OrnellaTagNotation(e): $error");
                            }
                        }
                    }
                }
            }
        }
    });







