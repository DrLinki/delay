<?php
class Delay{
    public int $years;
    public int $months;
    public int $months_total;
    public int $weeks;
    public int $weeks_total;
    public int $days;
    public int $days_total;
    public int $hours;
    public int $hours_total;
    public int $minutes;
    public int $minutes_total;
    public int $secondes;
    public int $secondes_total;

    public function __construct($duration = null){
        
        $this->years = 0;
        $this->months = 0;
        $this->weeks = 0;
        $this->days = 0;
        $this->hours = 0;
        $this->minutes = 0;
        $this->secondes = 0;

        if($duration != null){
            if(is_numeric($duration)){
                $this->setDuration(intval($duration));
            }else{
                $this->setDelay($duration);
            }
        }
    }

    public function setDuration($duration){
        $st = strtotime(0);
        $delay = $st + $duration;
        $this->secondes = date('s', $delay);
        $this->minutes = date('i', $delay);
        $this->hours = date('H', $delay);
        $this->days = date('d', $delay) - 1;
        $this->weeks = date('W', $delay) - 1;
        $this->months = date('m', $delay) - 1;
        $this->years = floor($duration / 31557600);
        $this->months_total = $this->years * 12 + $this->months;
        $this->weeks_total = floor($duration / 604800);
        $this->days_total = floor($duration / 86400);
        $this->hours_total = floor($duration /3600);
        $this->minutes_total = floor($duration /60);
        $this->secondes_total = $duration;
    }

    public function setDelay($delay){
        $times = explode(";", $delay);
        foreach($times as &$time){
            if(strtolower(substr($time, 0, 1)) == "y" && is_numeric(substr($time, 1)) && empty($this->years))
                $this->years = intval(substr($time, 1));
            elseif(strtolower(substr($time, 0, 1)) == "m" && is_numeric(substr($time, 1)) && empty($this->months))
                $this->months = intval(substr($time, 1));
            elseif(strtolower(substr($time, 0, 1)) == "w" && is_numeric(substr($time, 1)) && empty($this->weeks))
                $this->weeks = intval(substr($time, 1));
            elseif(strtolower(substr($time, 0, 1)) == "d" && is_numeric(substr($time, 1)) && empty($this->days))
                $this->days = intval(substr($time, 1));
            elseif(strtolower(substr($time, 0, 1)) == "h" && is_numeric(substr($time, 1)) && empty($this->hours))
                $this->hours = intval(substr($time, 1));
            elseif(strtolower(substr($time, 0, 1)) == "i" && is_numeric(substr($time, 1)) && empty($this->minutes))
                $this->minutes = intval(substr($time, 1));
            elseif(strtolower(substr($time, 0, 1)) == "s" && is_numeric(substr($time, 1)) && empty($this->secondes))
                $this->secondes = intval(substr($time, 1));
            else
                throw new ErrorException("The Delay format is not recognized");
        }
        $duration   = $this->secondes 
                    + $this->minutes * 60 
                    + $this->hours * 3600 
                    + $this->days * 86400 
                    + $this->weeks * (86400*7) 
                    + $this->months * 2629800 
                    + $this->years * 31557600;
        $this->setDuration($duration);
    }

    public function getDelay(){
        $delay = "";
        if(!empty($this->years))
            $delay.= ";Y".$this->years;
        if(!empty($this->months))
            $delay.= ";M".$this->months;
        if(!empty($this->days))
            $delay.= ";D".$this->days;
        if(!empty($this->hours))
            $delay.= ";H".$this->hours;
        if(!empty($this->minutes))
            $delay.= ";I".$this->minutes;
        if(!empty($this->secondes))
            $delay.= ";S".$this->secondes;
        return trim($delay, ";");
    }
    
    public function getTimeLeft(){
        $timeLeft = "";
        if(!empty($this->years))
            $timeLeft.= " ".$this->years." years ";
        if(!empty($this->months))
            $timeLeft.= " ".$this->months." months ";
        if(!empty($this->days))
            $timeLeft.= " ".$this->days." days ";
        if(!empty($this->hours))
            $timeLeft.= " ".$this->hours." hours ";
        if(!empty($this->minutes))
            $timeLeft.= " ".$this->minutes." minutes ";
        if(!empty($this->secondes))
            $timeLeft.= " ".$this->secondes." secondes ";
        $timeLeft = str_replace("  ", ", ", $timeLeft);
        return trim($timeLeft);
    }
}
?>