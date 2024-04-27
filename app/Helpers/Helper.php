<?php

namespace App\Helpers;

class Helper
{
    public static function generateRandomNumber($length = 10)
    {
        $numbers = '92365144780824147347918950891214735789123645789';
        $numbersLength = strlen($numbers);
        $randomNumbers = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumbers .= $numbers[rand(0, $numbersLength - 1)];
        }
        return $randomNumbers;
    }

    /**
     * @param string $words
     * @param string $type
     * 
     * $type should be either Capitalize | UPPER | lower
     * Converts slug words to normal
     */
    public static function convertToNormalWords(string $words, string $type = 'Capitalize')
    {
        $exludeSymbols = ['-', '_', '$', '.', '%', '&', '*'];
        foreach ($exludeSymbols as $symbol)
            $words = str_replace($symbol, ' ', $words);

        $type = strtolower($type);

        if ($type === 'capitalize')
            return ucwords($words);
        elseif ($type == 'upper')
            return strtoupper($words);
        elseif ($type == 'lower')
            return strtolower($words);

        return $words;
    }

    /**
     * date [ November, 4, 2023 ]  
     * time [ 8:03 Am ]
     * to  [ 2023-10-21 08:03:00 ]
     */
    public static function convertStringToDatetime($date, $time = "00:00")
    {
        $monthsInNumber = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $monthsInWord = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $datetime = $date;
        $datetime = explode(', ', $datetime);
        $datetime = $datetime[2] . '-' . $datetime[0] . '-' . $datetime[1];
        $datetime = str_replace($monthsInWord, $monthsInNumber, $datetime);
        $datetime = $datetime . ' ' . $time;

        return \Carbon\Carbon::parse($datetime)->format('Y-m-d H:i:s');
    }

    public static function linkify($text)
    {
        // Regular expression to match URLs
        $pattern = '/\b(?:https?|ftp):\/\/[-a-zA-Z0-9+&@#\/%?=~_|!:,.;]*[-a-zA-Z0-9+&@#\/%=~_|]/i';

        // Replace URLs with anchor tags
        $text = preg_replace($pattern, '<a href="$0" target="_blank">$0</a>', $text);

        return nl2br($text);
    }
}
