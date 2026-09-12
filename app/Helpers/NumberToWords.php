<?php

namespace App\Helpers;

class NumberToWords
{
    public static function convert($number)
    {
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        return ucfirst($f->format($number));
    }
}
