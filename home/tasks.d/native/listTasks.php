<?php


require_once __DIR__ . "/../../phpManager.plugin/init.php";


function __getDirContents($dir, &$results = array())
{
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        }
        else if ($value != "." && $value != "..") {
            __getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}


PhpManager::create()
    ->execute('listTasks', function (PhpManager $o, Config $c) {


        // check the alias in the user's directory
        $aliasFile = exec('ls ~/.bash_manager');
        $aliases = [];
        if (file_exists($aliasFile)) {
            $lines = file($aliasFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (false !== strpos($line, '=')) {
                    $aliases[] = $line;
                }
            }
        }


        $tasksDir = $o->getHome() . "/tasks.d";
        $configFile = $o->getHome() . "/config.d/" . $_SERVER['BASH_MANAGER_CONFIG__CONFIG_FILE'];

        $lines = file($configFile);
        $tasks = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (':' === substr($line, -1)) {
                $p = explode('(', $line, 2);
                $tasks[] = $p[0];
            }
        }


        $files = [];
        __getDirContents($tasksDir, $files);


        // compile the cats2Files array
        $cats2Files = [];
        foreach ($files as $f) {
            if (is_file($f)) {
                $file = basename($f);
                if ($file !== '.DS_Store') {

                    $rel = str_replace($tasksDir . '/', '', $f);
                    $p = explode('/', $rel);
                    array_pop($p);
                    if ($p) {
                        $cat = implode('/', $p);
                    }
                    else {
                        $cat = "none";
                    }


                    $fileWithoutExtension = explode('.', $file, 2)[0];
                    if (in_array($fileWithoutExtension, $tasks)) {
                        if (!array_key_exists($cat, $cats2Files)) {
                            $cats2Files[$cat] = [];
                        }


                        foreach ($aliases as $alias) {
                            if (false !== strpos($alias, ' ' . $fileWithoutExtension . ' ')) {
                                $file .= ' => ' . Tool::color($alias, 'red');
                                break;
                            }
                        }
                        $cats2Files[$cat][] = $file;
                    }

                }
            }
        }


        // display the cats2Files array
        foreach ($cats2Files as $cat => $files) {

            $o->log("");
//            $o->log("\033[0;34m" . $cat . "\033[0m");
            $o->log(Tool::color($cat, "blue"));
            $o->log("--------------------");
            foreach ($files as $file) {
                $o->log($file);
            }

        }


    });






