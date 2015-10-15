<?php


require_once __DIR__ . "/../phpManager.plugin/init.php";

/**
 * Expects 1 or 0,
 * default is 0.
 * 
 * If 0, no security: password should be displayed.
 * If 1, other commands should hide pass from the display.
 * 
 * 
 */
PhpManager::create()
    ->execute('secure', function (PhpManager $o) {
        $o->setConfigValue('secure', $_SERVER['BASH_MANAGER_CONFIG__VALUE']);
    });