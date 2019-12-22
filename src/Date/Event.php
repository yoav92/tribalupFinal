<?php
	
namespace Date; 

class Event{


	private $id;

	private $name;

	private $description;

	private $start;

	private $end;

	private $id_members;

	private $id_members_ex;

	public function getId():int{
		return $this->id;
	}

	public function getName():string{
		return $this->name;
	}

	public function getId_members_ex():int{
		return $this->id_members_ex;
	}

	public function getDescription():string{
		return $this->description;
	}

	public function getStart():\Datetime{
		return new \Datetime($this->start);
	}

	public function getEnd():\Datetime{
		return new \Datetime($this->end);
	}

	public function getId_members():int{
		return $this->id_members;
	}

	public function setName(string $name){//Les setters permettent de s'assurrer des donnees qui rentrent
		$this->name=$name;
	}

	public function setId_members_ex(string $id_members_ex){//Les setters permettent de s'assurrer des donnees qui rentrent
		$this->id_members_ex=$id_members_ex;
	}

	public function setDescription(string $decription){
		$this->description=$decription;
	}

	public function setStart(string $start){
		$this->start=$start;
	}

	public function setEnd(string $end){
		$this->end=$end;
	}

	public function setId_members(int $id_members){
		$this->id_members=$id_members;
	}
	



	
}