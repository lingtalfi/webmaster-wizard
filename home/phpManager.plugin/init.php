<?php



ini_set("date.timezone", "Europe/Paris");

require_once "_bb_autoload/autoload.php";


require_once __DIR__ . "/PhpManager.php";
require_once __DIR__ . "/Config.php";
require_once __DIR__ . "/Tool.php";



//define("MYSQL_PREFIX", "");
define("MYSQL_PREFIX_DISTANT", "");
define("MYSQL_PREFIX", "/Applications/MAMP/Library/bin/"); // use this line for local MAMP

