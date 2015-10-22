<?php


require_once __DIR__ . "/../../phpManager.plugin/init.php";


PhpManager::create()
    ->execute('localDbInfo', function (PhpManager $o, Config $c) {

        $v = $o->getTaskValue();
        if ('' !== $v) {
            $p = explode(':', $v, 3);

            if (3 === count($p)) {
                $pass = $p[2];

                // populating the CONFIG array with the local db, user and pass variables
                if ('1' === $c->secure) {
                    $pass = '(the given password)';
                }

                $o
                    ->setConfigValue('localDb', $p[0])
                    ->setConfigValue('localDbUser', $p[1])
                    ->setConfigValue('localDbPass', [$p[2], $pass]);

            }
            else {
                $o->warning("Invalid local db info notation, the following notation was expected: 'db:user:pass'");
            }
        }
    });




