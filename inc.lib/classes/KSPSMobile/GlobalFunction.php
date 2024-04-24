<?php

class GlobalFunction
{
    public static function period_str($period)
    {
        $mn = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
        $mni = substr($period, 4);
        return @$mn[(int)$mni].' '.substr($period, 0, 4);
    }
    public static function translate_date($date)
    {
        $src1 = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $dst1 = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    
        $src2 = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        $dst2 = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
    
        $src3 = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $dst3 = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    
        $src4 = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        $dst4 = array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab');
        
        $date = str_replace($src1, $dst1, $date);
        $date = str_replace($src2, $dst2, $date);
        $date = str_replace($src3, $dst3, $date);
        $date = str_replace($src4, $dst4, $date);
        return $date;
    }
    public static function format_bilangan($amount)
    {
        return number_format($amount, 2, ",", ".");
    }
    
}