<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
require_once(APPPATH.'config/report_constants'.EXT);
class Sidlib
{
	private static $WebColor = array(
                       "red"=>array('rgb' => array(231,80,90), 'web' => 'E7505A'), //#E7505A
                       "red-thunderbird"=>array('rgb' => array(217,30,24), 'web' => 'D91E18'), //#D91E18
                       "navy"=>array('rgb' => array(0,44,163), 'web' => '002CA3'), //#002CA3
                       "blue"=>array('rgb' => array(53,152,220), 'web' => '3598DC'), //3598DC
                       "blue-chambray"=>array('rgb' => array(44,62,80), 'web' => '2C3E50'),  //#2C3E50
                       "blue-light"=>array('rgb' => array(220,242,250), 'web' => 'DCF2FA'),  //#DCF2FA
                       "black"=>array('rgb' => array(50), 'web' => '323232'),                 //#323232 
                       "dark"=>array('rgb' => array(47,53,59), 'web' => '2F353B'),                 //#2F353B 
                       "white"=>array('rgb' => array(240), 'web' => 'F0F0F0'),                //#F0F0F0 
                       "green-sharp"=>array('rgb' => array(42, 180, 192), 'web' => '28B4C0'), //#28B4C0
                       "grey" => array('rgb' => array(150), 'web' => '969696'),                 //#969696
                       "grey-dark" => array('rgb' => array(169), 'web' => 'a9a9a9'),                //#a9a9a9
                       "grey-light" => array('rgb' => array(219), 'web' => 'DBDBDB'),                 //#DBDBDB
                       "yellow-light"=>array('rgb' => array(247, 231, 168), 'web' => 'F7E7A8') //#F7E7A8
                    ); 

    static function getAuthor() {
        return PIMPINAN;
    }

    public static function lineStyle($color=LINE_COLOR, $dash=0)
    {
        if (!array_key_exists($color, self::$WebColor)) $color = 'grey';
        return array('width' => .3, 'cap' => 'butt', 'join' => 'miter', 'dash' => $dash, 'color' => self::$WebColor[$color]['rgb']);
    }    

    public static function rgbColor($color=TEXT_COLOR)
    {
        if (array_key_exists($color, self::$WebColor)) {
            return self::$WebColor[$color]['rgb'];
        } else {
            return self::$WebColor['black']['rgb'];
        }
    }

    public static function webColor($color=TEXT_COLOR)
    {
        if (array_key_exists($color, self::$WebColor)) {
            return self::$WebColor[$color]['web'];
        } else {
            return self::$WebColor['black']['web'];
        }
    }
    
    function my_format($value) {
        if ($value == 0 || $value == '') {
            $hasil = 0;
        } else {
            $hasil = ($value < 0) ? '('.number_format(abs($value),0,'.',',').')' : number_format(abs($value),0,'.',',');    
        }
        
        return $hasil;
    }

    static function increment($val, $increment = 2)
    {
        for ($i = 1; $i <= $increment; $i++) {
            $val++;
        }

        return $val;
    }

    function SumObject($objectname, $keyvalue='') {
        $sum = array_sum(array_map(function($var) use ($keyvalue) {
                      return $var[$keyvalue];
                    }, $objectname));
        return $this->my_format($sum);
    }

    function StatusBookingName($statusbooking=0) {
        return STATUS_BOOKING[$statusbooking];
    }

    public static function array_change_key_ucword($array) {
        $key=array_keys($array);
        foreach($key as $ki)
        {
            $klower=ucwords($ki);
            $val=$array[$ki];
            if(is_array($val))
            {
                foreach($val as $kinner=>$vinner)
                {
                    
                    $tl=ucwords($kinner);
                    unset($val[$kinner]);
                    $val[$tl]=$vinner; 
                }
            }
            unset($array[$ki]);
            $array[$klower]=$val; 
        }
        return $array;
    }

    function setHeader_prn($parameter) {
        $source = base_url()."assets/pages/img/logo-harmony2.png";
        $html = 
        "
            <div class='page-logo'>
                <img alt='' src='{$source}' />
            </div>
            <div class='page-title'>
                <p class='company'>{$parameter->company}</p>
                <p class='address'>{$parameter->address}</p>
                <p class='address'>{$parameter->city}</p>
            </div>
            <br clear='all'/>
            <hr>";
        return $html;
        //</header>";
    }

    function terbilang($x, $style=3) {
                function kekata($x) {
                    $x = abs($x);
                    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
                    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
                    $temp = "";
                    if ($x <12) {
                        $temp = " ". $angka[$x];
                    } else if ($x <20) {
                        $temp = kekata($x - 10). " belas";
                    } else if ($x <100) {
                        $temp = kekata($x/10)." puluh". kekata($x % 10);
                    } else if ($x <200) {
                        $temp = " seratus" . kekata($x - 100);
                    } else if ($x <1000) {
                        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
                    } else if ($x <2000) {
                        $temp = " seribu" . kekata($x - 1000);
                    } else if ($x <1000000) {
                        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
                    } else if ($x <1000000000) {
                        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
                    } else if ($x <1000000000000) {
                        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
                    } else if ($x <1000000000000000) {
                        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
                    }     
                        return $temp;
                }

            if($x<0) {
                $hasil = "minus ". trim(kekata($x));
            } else {
                $hasil = trim(kekata($x));
            }     
            switch ($style) {
                case 1:
                    $hasil = strtoupper($hasil);
                    break;
                case 2:
                    $hasil = strtolower($hasil);
                    break;
                case 3:
                    $hasil = ucwords($hasil);
                    break;
                default:
                    $hasil = ucfirst($hasil);
                    break;
            }     
            return $hasil;
        }
}
?>