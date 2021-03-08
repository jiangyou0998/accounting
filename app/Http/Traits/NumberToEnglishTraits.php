<?php

namespace App\Http\Traits;

trait NumberToEnglishTraits
{
    function money_to_english($num)
    {
        $num = round($num , 2);

        //整數位
        $integer = (int)floor($num);
        //小數位
        $decimal = (round(($num - $integer) , 2) * 100);

        $integer_en = $this->number_to_word($integer);
        $decimal_en = $this->number_to_word($decimal);

        if($decimal == 0){
            $english = 'HKD '.$integer_en.' DOLLARS';
        }else{
            $english = 'HKD '.$integer_en.' DOLLARS AND '.$decimal_en.' CENTS';
        }

        //轉為大寫字母
        $english = strtoupper($english);

        return $english;

    }

    //https://segmentfault.com/a/1190000021908658
    function number_to_word($num = '')
    {
        $num = ( string )($num);
        if (( int )($num) && ctype_digit($num)) {
            $words = array();
            $num = str_replace(array(',', ' '), '', trim($num));
            $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');
            $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred');
            $list3 = array('', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion');
            $num_length = strlen($num);
            $levels = ( int )(($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);
            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = ( int )($num_part / 100);
//                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred'  . ' ' : '');
                $tens = ( int )($num_part % 100);
                $singles = '';
                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = ( int )($tens / 10);
                    $singles = ( int )($num_part % 10);
                    $tens = ($singles == 0) ? ' ' . $list2[$tens] . ' ' : ' ' . $list2[$tens] . '-' ;
//                    $tens = ' ' . $list2[$tens] . ' ';
//                    $singles = ' ' . $list1[$singles] . ' ';
                    $singles = $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }

            $commas = count($words);

            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words = implode(', ', $words);

            //Some Finishing Touch
            //Replacing multiples of spaces with one space
            $words = trim(str_replace(' ,', ',', $this->trim_all(ucwords($words))), ', ');
            if ($commas) {
                $words = $this->str_replace_last(',', ' and', $words);
            }

            return $words;
        } else if (!(( int )$num)) {
            return 'Zero';
        }
        return '';
    }

    function trim_all($str, $what = NULL, $with = ' ')
    {
        if ($what === NULL) {
            //  Character      Decimal      Use
            //  "\0"            0           Null Character
            //  "\t"            9           Tab
            //  "\n"           10           New line
            //  "\x0B"         11           Vertical Tab
            //  "\r"           13           New Line in Mac
            //  " "            32           Space

            $what = "\\x00-\\x20";    //all white-spaces and control chars
        }

        return trim(preg_replace("/[" . $what . "]+/", $with, $str), $what);
    }

    function str_replace_last($search, $replace, $str)
    {
        if (($pos = strrpos($str, $search)) !== false) {
            $search_length = strlen($search);
            $str = substr_replace($str, $replace, $pos, $search_length);
        }
        return $str;
    }
}
