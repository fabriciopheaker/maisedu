<?php

class Date{
    private $time;
    const FORMATS = 
    [
        'D' => [
            'Mon'   =>  'Seg',
            'Tue'   =>  'Terç',
            'Wed'   =>  'Qua',
            'Thu'   =>  'Qui',
            'Fri'   =>  'Sex',
            'Sat'   =>  'Sáb',
            'Sun'   =>  'Dom'
        ],
        'l' => [
            'Monday'     => 'Segunda',
            'Tuesday'    => 'Terça',
            'Wednesday'  => 'Quarta',
            'Thursday'   => 'Quinta',
            'Friday'     => 'Sexta',
            'Saturday'   => 'Sábado',
            'Sunday'     => 'Domingo'
        ],
        'F' =>[ 
            "January"   =>  "Janeiro",
            "February"  =>  "Fevereiro",
            "March"     =>  "Março",
            "April"     =>  "Abril",
            "May"       =>  "Maio",
            "June"      =>  "Junho",
            "July"      =>  "Julho",
            "August"    =>  "Agosto",
            "September" =>  "Setembro",
            "October"   =>  "Outubro",
            "November"  =>  "Novembro",
            "December"  =>  "Dezembro",
        ],
        'M' => [
            "Jan"  =>  "Jan",
            "Feb"  =>  "Fev",
            "Mar"  =>  "Mar",
            "Apr"  =>  "Abr",
            "May"  =>  "Mai",
            "Jun"  =>  "Jun",
            "Jul"  =>  "Jul",
            "Aug"  =>  "Ago",
            "Sep"  =>  "Set",
            "Oct"  =>  "Out",
            "Nov"  =>  "Nov",
            "Dec"  =>  "Dez",
        ]



    ];
    public function __construct($time = null){
        $this->time = isset($time)?$time:time();
    }


    public function getDate($format="d/m/Y"){
        $mask = str_split($format,1);
        $date = Date($format,$this->time);
        foreach($mask as $item){
            if(array_key_exists($item,self::FORMATS)){
                $date = $this->replace($item,$date);
            }
        }
        
        return $date;
    }

    private function replace($format,$date){
        $search = date($format,$this->time);
        return str_replace($search,self::FORMATS[$format][$search],$date);
    }
}

for($x=-7; $x<5; $x++){
    echo (new Date(time()+86400*30*$x))->getDate('"M"=>"",')."<br/>";
}
