<?php

/*
 * LingTalfi 2015-10-13
 */

class PhpManager
{

    /**
     * @var Config
     */
    private $config;

    public function __construct()
    {

        // prepare the Config object with previously set properties 
        $this->config = new Config();
        $props = get_object_vars($this->config);
        foreach ($props as $k => $v) {
            $bk = Tool::camelCase2Constant($k);
            $bk = 'BASH_MANAGER_CONFIG_' . $bk;
            if (array_key_exists($bk, $_SERVER)) {
                $this->config->$k = $_SERVER[$bk];
            }
        }
    }


    public static function create()
    {
        return new static();
    }


    public function log($m)
    {
        echo 'log:' . $m . PHP_EOL;
    }

    public function error($m)
    {
        echo 'error:' . $m . PHP_EOL;
    }

    public function warning($m)
    {
        echo 'warning:' . $m . PHP_EOL;
    }


    public function printConfigEnv()
    {
        foreach ($_SERVER as $k => $v) {
            if ('BASH_MANAGER_CONFIG' === substr($k, 0, 19)) {
                $this->log($k . ': ' . $v);
            }
        }
    }

    public function getTaskValue()
    {
        if (array_key_exists('BASH_MANAGER_CONFIG__VALUE', $_SERVER)) {
            return $_SERVER['BASH_MANAGER_CONFIG__VALUE'];
        }
        return "";
    }

    public function setConfigValue($k, $v)
    {
        $dv = $v;
        if (is_array($v)) {
            if (array_key_exists(0, $v) && array_key_exists(1, $v)) {
                list($v, $dv) = $v;
            }
            else {
                $this->fatal("setConfigValue: Invalid array value, an array with key 0 and 1 was expected");
            }
        }
        // populating the CONFIG array 
        $bk = Tool::camelCase2Constant($k);
        echo "log:populating CONFIG[${bk}]=" . $dv . PHP_EOL;
        echo "BASH_MANAGER_CONFIG_${bk}=" . $v . PHP_EOL;
        $this->config->$k = $v; // also update the config for the current script to use
        return $this;
    }


    public function replaceTags($str)
    {
        $props = get_object_vars($this->config);
        $props['_value_'] = $this->getTaskValue();
        $missing = [];
        $str = preg_replace_callback('!\{&?([a-zA-Z0-9_]+)\}!', function ($m) use ($props, &$missing) {
            if (array_key_exists($m[1], $props)) {
                if ('{&' === substr($m[0], 0, 2)) {
                    return Tool::dqEscape($props[$m[1]]);
                }
                return $props[$m[1]];
            }
            else {
                $missing[] = $m[1];
            }
        }, $str);
        if ($missing) {
            throw new \Exception("The following parameters are missing: " . implode(', ', $missing));
        }
        return $str;
    }

    public function execute($programName, callable $f)
    {
        echo 'startTask: ' . $programName . PHP_EOL;
        try {


            call_user_func($f, $this, $this->config);


        } catch (\Exception $e) {
            echo 'warning: ' . $e->getMessage() . ' in ' . $e->getFile() . ' line ' . $e->getLine() . PHP_EOL;
        }
        echo 'endTask: ' . $programName . PHP_EOL;
    }


    private function fatal($m)
    {
        throw new \Exception($m);
    }
}
