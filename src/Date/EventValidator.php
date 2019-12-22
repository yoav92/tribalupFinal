<?php
namespace Date;
require 'src/App/Validator.php';


use \App\Validator;

class EventValidator extends Validator{

		public function validates(array $data){

			parent::validates($data);
			$this->validate('name','minLength',2);/*je veux que le champ name est une largeur minimal de 3 caracteres */
			$this->validate('date','date');
			$this->validate('start','beforeTime','end');
			$this->validate('date','beforeDate');
			return $this->errors;
		}
}

