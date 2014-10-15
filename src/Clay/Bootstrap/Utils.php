<?php

namespace Bootstrap;

class Utils
{
    public static function checkRoles($userRole, &$allowedRoles)
    {
        return ! isset ($allowedRoles)
        or ($allowedRoles === $userRole
            or in_array($userRole, $allowedRoles));
    }

    public static function isDotSyntax($text)
    {
        return preg_match('@^([a-z0-9\/_-]+)(\.[a-z0-9_-]+)+$@', $text);
    }

    /**
     * Convert camel cases, underscore and hyphen separated strings into a human format
     */
    public static function title($string)
    {
        $stringr = $string[0].preg_replace("@[_-]|([A-Z])@", " $1", substr($string, 1));

        return ucfirst(strtolower($stringr));
    }

    /**
     * Convert a string (a title or name) to a SLUG to be used as part of an URL
     */
    public static function slugify($string)
    {
        // transliterate
        if (function_exists('iconv')) {
            $string = iconv('utf-8', 'ascii//TRANSLIT', $string);
        }

        // lowercase
        $string = strtolower($string);

        $string = preg_replace('/[^a-z0-9-]+/', '-', $string);
        $string = preg_replace('@\-+@', '-', $string);
        $string = trim($string, '-');

        return $string;
    }

    public static function linkify($text)
    {
        return preg_replace('@(http://[a-z0-9_./?=&-]+)@i', '<a href="$1" target="_blank">$1</a>', $text." ");
    }

    /**
     * Cuts a string but without leaving incomplete words and adding a $end string if necessary
     */
    public static function resume($value, $length, $end = '...')
    {
        if ($value != null) {
            $value = strip_tags($value);
            $value = preg_replace('/(\s+)/', ' ', $value);
            $long = strlen($value);

        if ($long > $length) {
            $pos = strrpos($value, ' ', $length - $long);

            if ($pos) {
                $value = substr($value, 0, $pos);
            } else {
                $value = substr($value, 0, $length);
            }

            return $value . $end;
        }

        return $value;
    } else {
            return "";
        }
    }

}
