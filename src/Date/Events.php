<?php 
namespace Date;

class Events{
	/*recupere les evenements entre 2 dates*/
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo=$pdo;
	}

	public function getEventsBetween(\DateTime $start,\DateTime $end,int $id):array{
		$sql="SELECT * FROM events WHERE start BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' AND id_members=$id";
		$statement=$this->pdo->query($sql);
		$results=$statement->fetchAll();
		return $results;

	}
	/*recupere les evenements entre 2 dates indexe par jour*/
	public function getEventsBetweenByDay(\DateTime $start,\DateTime $end,int $id):array{
		$events=$this->getEventsBetween($start,$end,$id);
		
		$days=[];
		foreach($events as $event){
			$date=explode(' ',$event['start'])[0];
			if(!isset($days[$date])){
				$days[$date]=[$event];

			}else{
				$days[$date][]=$event;
			}
		}
		return $days;

	}
	/*recupere un evenement*/
	public function find(int $id):Event{
		
		$statement = $this->pdo->query("SELECT * FROM events WHERE id=$id LIMIT 1");
		$statement->setFetchMode(\PDO::FETCH_CLASS,\Date\Event::class);
		$result=$statement->fetch();
		if($result === false)
		{
			throw new \Exception('No result');
		}
		return $result;
	}
	//mettre les donnees de la data dans les objets
	public function hydrate(Event $event,array $data,int $id_members,int $id_members_ex){
		$event->setName($data['name']);
		$event->setDescription($data['description']);
		$event->setStart(\DateTime::createFromFormat('Y-m-d H:i',$data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
		$event->setEnd(\DateTime::createFromFormat('Y-m-d H:i',$data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
		$event->setId_members($id_members);
		$event->setId_members_ex($id_members_ex);
		return $event;
	}
	//mettre a jour les donnees de la data dans les objets
	public function hydrate2(Event $event,array $data,int $id_members){
		$event->setName($data['name']);
		$event->setDescription($data['description']);
		$event->setStart(\DateTime::createFromFormat('Y-m-d H:i',$data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
		$event->setEnd(\DateTime::createFromFormat('Y-m-d H:i',$data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
		$event->setId_members($id_members);
		return $event;
	}

	public function create(Event $event):bool{//creer un evenemnt au niveau de la base de donnees
		$statement=$this->pdo->prepare('INSERT INTO events (name,description,start,end,id_members,id_members_ex) VALUES(?,?,?,?,?,?)');
		return $statement->execute([
			$event->getName(),
			$event->getDescription(),
			$event->getStart()->format('Y-m-d H:i:s'),
			$event->getEnd()->format('Y-m-d H:i:s'),
			$event->getId_members(),
			$event->getId_members_ex(),
		]);
	}

	public function update(Event $event):bool{//mis a jour de l'evenement au niveau de la base de donnees
		$statement=$this->pdo->prepare('UPDATE events SET name=?,description=?,start=?,end=?,id_members_ex=? WHERE id=?');
		return $statement->execute([
			$event->getName(),
			$event->getDescription(),
			$event->getStart()->format('Y-m-d H:i:s'),
			$event->getEnd()->format('Y-m-d H:i:s'),
			$event->getId_members_ex(),
			$event->getId()

		]);
	}
}