<?php
require 'src/Date/bootstrap.php';
require 'src/Date/Events.php';
require 'src/Date/Event.php';
require 'src/Date/EventValidator.php';
require 'views/header.php';


$pdo=get_pdo();
$events = new Date\Events($pdo);
$errors=[];

$res = $pdo->prepare('SELECT * FROM events WHERE id = ?');
$res->execute(array($_GET['id']));
$fin = $res->fetch();

$res2 = $pdo->prepare('SELECT * FROM members WHERE id = ?');
$res2->execute(array($fin['id_members_ex']));
$fin2 = $res2->fetch();

$res3 = $pdo->prepare('SELECT * FROM info_members_no_pro WHERE id_members = ?');
$res3->execute(array($fin['id_members_ex']));
$fin3 = $res3->fetch();

$res4 = $pdo->prepare('SELECT * FROM members WHERE id = ?');
$res4->execute(array($fin['id_members']));
$fin4 = $res4->fetch();

if(!isset($_GET['id'])){
	e404();
}
try{
	$event = $events->find($_GET['id']);
	} catch (\Exception $e){
	e404();	}



$data=[
	'name'=>$event->getName(),
	'date'=>$event->getStart()->format('Y-m-d'),
	'start'=>$event->getStart()->format('H:i'),
	'end'=>$event->getEnd()->format('H:i'),
	'description'=>$event->getDescription()//permet de preparer les champs deja ecrit
];

if($_SERVER['REQUEST_METHOD'] === 'POST'){/*verifie si  il y a bien un formulaire envoye en PST*/
	$header="MIME-Version: 1.0\r\n";
    $header.='From:"tribalup.com"<support@Tribalup.com>'."\n";
    $header.='Content-Type:text/html; charset="utf-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $name=$fin['name'];
	$date=$fin['start'];
	
	$data=$_POST;
	$errors=[];
	$validator =new Date\EventValidator();
	$errors=$validator->validates($_POST);
	if(empty($errors)){
		if($_SESSION['id']==$fin2['id'])	{
			mail($fin4['email'], "Event udapted - Tribalup.com", "The event $name of $date was udapted by the student,please connect to www.tribalup.com to see the changes",$header);
		}else{
			mail($fin2['email'], "Event udapted - Tribalup.com", "The event $name of $date was udapted by the professional,please connect to www.tribalup.com to see the changes",$header);
		}
		$events->hydrate2($event,$data,$_SESSION['id']);
		$events->update($event);
	 if($_SESSION['id']==$fin2['id'])	{	
		header('Location:calendar_student.php');
	}else{
		header('Location:calendar.php?success=1');
	}
		exit();
	}
	
}



?>
<br/><br/>
<div class="container">
<?php if($_SESSION['id']==$fin2['id'])	{	?>
		<h1>Edit the event <small><?= $event->getName(); ?></small></h1>
		<form action="" method="post" class="form">
				<?php render('calendar/form',['data'=>$data,'errors'=>$errors]);//on envoie les donnees ecrites et les erreurs ?>
					<div class="form-group">
						<button class="btn btn-primary">Edit the event</button>
					</div>
			</form>
			
<?php } else { ?>

	<h1>Edit the event <small><?= $event->getName(); ?></small> from <small><?= $fin2['username'] ?> <?= $fin2['userFname'] ?> </small>
	<a type="button" class="btn btn-primary" href="affichage_profil_student.php?id=<?php echo $fin['id_members_ex']?>&prenom=<?php echo $fin2['userFname']?>&nom=<?php echo $fin2['username']?>&situation=<?php echo $fin3['situation']?>">see this profil</a></h1>
<p>For contact with <?= $fin2['username'] ?> <?= $fin2['userFname'] ?> : <?= $fin2['email'] ?></p>

	<form action="" method="post" class="form">
		<?php render('calendar/form',['data'=>$data,'errors'=>$errors]);//on envoie les donnees ecrites et les erreurs ?>
			<div class="form-group">
				<button class="btn btn-primary">Edit the event</button>
				<a href="calendar.php?id=<?=$_GET['id']?>" name="sup" class="btn btn-outline-info">Delete the event</a>
			</div>
	</form>
<?php } ?>



</div>

<?php require 'views/footer.php'; ?>