<?php


/*
 * LingTalfi 2015-10-14
 * 
 */

class Tool
{

    private static $colors = [
        'black' => '0;30',
        'dark_gray' => '1;30',
        'blue' => '0;34',
        'light_blue' => '1;34',
        'green' => '0;32',
        'light_green' => '1;32',
        'cyan' => '0;36',
        'light_cyan' => '1;36',
        'red' => '0;31',
        'light_red' => '1;31',
        'purple' => '0;35',
        'light_purple' => '1;35',
        'brown' => '0;33',
        'yellow' => '1;33',
        'light_gray' => '0;37',
        'white' => '1;37',
    ];

    private static $bgColors = [
        'black' => '40',
        'red' => '41',
        'green' => '42',
        'yellow' => '43',
        'blue' => '44',
        'magenta' => '45',
        'cyan' => '46',
        'light_gray' => '47',
    ];


    /**
     * Nomenclature from
     * https://github.com/lingtalfi/ConventionGuy/blob/master/nomenclature.stringCases.eng.md
     */
    public static function camelCase2Constant($str)
    {
        if (is_string($str)) {
            $str = preg_replace('!([a-z]+)([^a-z])!', '$1' . '_' . '$2', $str);
            $str = preg_replace('!([0-9]+)([^0-9])!', '$1' . '_' . '$2', $str);
            $str = strtoupper($str);
        }
        else {
            throw new \InvalidArgumentException(sprintf("string argument must be of type string, %s given", gettype($str)));
        }
        return $str;
    }


    public static function dqEscape($path)
    {
        return str_replace('"', '\"', $path);
    }


    /**
     * replace the following tags:
     *
     * - {date}: the dateStamp
     * - {datetime}: the datetimeStamp
     *
     * dateStamp and datetimeStamp are defined in
     * https://github.com/lingtalfi/ConventionGuy/blob/master/convention.fileNames.eng.md#stamped-file
     *
     */
    public static function replaceTimeStamps($str)
    {
        $str = str_replace([
            '{datetime}',
            '{date}',
        ], [
            date('Y-m-d__H-i-s'),
            date('Y-m-d'),
        ], $str);
        return $str;
    }


    public static function color($s, $foregroundColor = null, $backgroundColor = null)
    {
        if (null !== $foregroundColor || null !== $backgroundColor) {
            $colorCode = '';
            if (null !== $foregroundColor) {
                $colorCode .= "\033[" . self::$colors[$foregroundColor] . "m";
            }
            if (null !== $backgroundColor) {
                $colorCode .= "\033[" . self::$bgColors[$backgroundColor] . "m";
            }
            $s = $colorCode . $s . "\033[0m";
        }
        return $s;
    }
}


