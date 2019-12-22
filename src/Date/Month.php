<?php 
namespace App\Date;

class Month{
	public $days=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
	private $months=['January','February','March','April','May','June','July','August','September','October','November','December'];
	public $month;
	public $year;

	/*
	$month le mois commence de 1 a 12

	*/

	public function __construct(?int $month=null,?int $year=null)
	{
		if($month === null || $month<1 || $month>12)
		{
			$month=intval(date('m'));/*la fonction date retourne la date actuelle en string,intval permet de convertir en int*/

		}
		if($year === null )
		{
			$year=intval(date('Y'));

		}
		
		$this->month=$month;
		$this->year=$year;

	}

	public function getStartingDay(): \DateTime{/*renvoie le premier jour du mois */
		return new \DateTime("{$this->year}-{$this->month}-01");
	}

	/*
	permet de retourner le mois en string
	*/
	public function toString():string{
		return $this->months[$this->month-1].' '.$this->year;

	}

	/*renvoie le nombre de semaine dans le mois*/

	public function getWeeks():int{
		$start = $this->getStartingDay();//recevoir le premier jour du mois
		$end = (clone $start)->modify('+ 1 month - 1 day');//recevoir le dernier jour du mois
		$startWeek = intval($start->format('W'));//change en int,format W-->week
		$endWeek = intval($end->format('W'));
		if($endWeek===1)
		{
			$endWeek=intval((clone $end)->modify('-7 days')->format('W'))+1;
		}
		
		$weeks = $endWeek - $startWeek+1;/*W-->le nombre de semaine*/		
	    if($weeks<0){	    	
	    	$weeks=intval($end->format('W'));
	    }
	    return $weeks;

	}

	/*est ce que le jour est dans le mois en cours*/
	public function withinMonth(\Datetime $date):bool{
		return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');

	}
	/*renvoie le mois suivant*/
	public function nextMonth():Month{
		$month=	$this->month+1;
		$year=$this->year;
		if($month>12){
			$month=1;
			$year+=1;
		}
		return new Month($month,$year);
	}
	/*renvoie le mois precedant */
	public function previousMonth():Month{
		$month=	$this->month-1;
		$year=$this->year;
		if($month<1){
			$month=12;
			$year-=1;
		}
		return new Month($month,$year);
	}


}