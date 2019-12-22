<?php
namespace App;

class Validator{

	private $data;
	protected $errors=[];

	public function validates(array $data){
		$this->errors=[];
		$this->data=$data;
		
	}

	public function validate(string $field,string $method, ...$parameters){
		if(!isset($this->data[$field])){/*verifie si par exemple le champ name existe*/
			$this->errors[$field] = "Le champs $field n'est pas rempli";/*remplir dans le tableau error une erreur pour le champs en particulier(name par exemple)*/
		} else {
			call_user_func([$this, $method], $field, ...$parameters);/*il va alors appeller la fonction recu dans la variable methode(minLength) avec les parametres fields...*/
		}
	}

	public function minLength(string $field,int $length):bool{
		if(mb_strlen($this->data[$field]) < $length)
		{
			$this->errors[$field]="The field need to have more of $length caracteres";
			return false;
		}
		return true;
	}

	public function date(string $field):bool{
		if(\DateTime::createFromFormat('Y-m-d',$this->data[$field])===false){
			$this->errors[$field]="La date ne semble pas valide";
			return false;
		}
		return true;
	}

	public function time(string $field):bool{
		if(\DateTime::createFromFormat('H:i',$this->data[$field])===false){
			$this->errors[$field]="Le temps ne semble pas valide";
			return false;
		}
		return true;
	}

	public function beforeTime(string $startfield,string $endField):bool
	{
		if($this->time($startfield) && $this->time($endField)){
			$start=\DateTime::createFromFormat('H:i',$this->data[$startfield]);
			$end=\DateTime::createFromFormat('H:i',$this->data[$endField]);

			if($start->getTimestamp() > $end->getTimestamp()){
				$this->errors[$startfield]="Time need to be less of the end time";
				return false;
			}
			return true;
		}
		return false;


	}

	public function beforeDate(string $field):bool
	{
			$end= date('Y-m-d');
			$start=\DateTime::createFromFormat('Y-m-d',$this->data[$field]);
			$now=\DateTime::createFromFormat('Y-m-d',$end);
			if($start->getTimestamp() < $now->getTimestamp()){
				$this->errors[$field]="Date need to be more of the actual date";
				return false;
			}
			return true;
		



	}



}