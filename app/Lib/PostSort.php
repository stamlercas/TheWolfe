<?php

namespace App\Lib\PostSort;

class PostSort {
    
    protected $epoch;
    
    public function __construct() {
        $this->epoch = date(strtotime('1970-1-1'));
    }
    
    private function epochSeconds($date)
    {
        $td = $date - $this->epoch;
        return $td;
    }
    
    private function score($ups, $downs)
    {
        return $ups - $downs;
    }
    
    public function hot($ups, $downs, $date)
    {
        $s = $this->score($ups, $downs);
        $order = log10( max( abs($s), 1));
        if ($s > 0) {
            $sign = 1;
        } else if ($s < 0) {
            $sign = -1;
        } else {
            $sign = 0;
        }
        $seconds = $this->epochSeconds($date) - 1134028003;
        return round( $sign * $order + $seconds / 45000, 7 );
    }
    
    
    
}