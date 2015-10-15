<?php


require_once __DIR__ . "/../phpManager.plugin/init.php";




PhpManager::create()
    ->execute('remoteDbInfo', function (PhpManager $o, Config $c) {

        $p = explode(':', $o->getTaskValue(), 3);

        if (3 === count($p)) {
            $pass = $p[2];

            // populating the CONFIG array with the local db, user and pass variables
            if ('1' === $c->secure) {
                $pass = '(the given password)';
            }

            $o
                ->setConfigValue('remoteDb', $p[0])
                ->setConfigValue('remoteDbUser', $p[1])
                ->setConfigValue('remoteDbPass', [$p[2], $pass]);

        }
        else {
            $o->warning("Invalid remote db info notation, the following notation was expected: 'db:user:pass'");
        }
    });






