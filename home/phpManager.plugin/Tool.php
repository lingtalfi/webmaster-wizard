<?php


/*
 * LingTalfi 2015-10-14
 * 
 */

class Tool
{


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


    public static function  dqEscape($path)
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
}


