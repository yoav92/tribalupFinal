<?php
require 'views/header.php';

if(isset($_POST['form'])){
	$prendre=$pdo->prepare('SELECT * FROM events WHERE id = ?');
	$prendre->execute([$_GET['id']]);
	$dem = $prendre->fetch();

	$prendre2=$pdo->prepare('SELECT email FROM members WHERE id = ?');
	$prendre2->execute([$dem['id_members']]);
	$dem2 = $prendre2->fetch();


	$header="MIME-Version: 1.0\r\n";
    $header.='From:"tribalup.com"<support@Tribalup.com>'."\n";
    $header.='Content-Type:text/html; charset="utf-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $name=$dem['name'];
	$date=date('F j, Y, g:i a',strtotime($dem['start']));
		
    mail($dem2['email'], "Event deleted - Tribalup.com", "the event $name of $date was deleted by the user",$header);


	$confirm = $pdo->prepare('DELETE FROM events WHERE id = ?');
	$confirm->execute([$_GET['id']]);
	header("Location: calendar_student.php");
	}
?>

<div class="text-center"><h1>Your futurs appointments</h1></div>
<br/>
<?php
$affichage = $pdo->prepare('SELECT * FROM events WHERE id_members_ex = ?');
$affichage->execute(array($_SESSION['id']));
while($donnee = $affichage->fetch()){

	$affichage2 = $pdo->prepare('SELECT * FROM members WHERE id = ?');
	$affichage2->execute(array($donnee['id_members']));
	$donneee = $affichage2->fetch();

	$affichage3 = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
	$affichage3->execute(array($donnee['id_members']));
	$donneeee = $affichage3->fetch();

	if($donnee['start']>date("Y-m-d H:i:s")){
?>

	<p>The appointment <a href="edit_event.php?id=<?= $donnee['id'];?>"><?php echo $donnee['name']; ?></a> with  <a  href="affichage_profil.php?id=<?=$donnee['id_members']?>&prenom=<?=$donneee['userFname']?>&nom=<?=$donneee['username']?>&age=<?=$donneeee['age']?>&ville=<?=$donneeee['city']?>"><?php echo $donneee['username']; ?> <?php echo $donneee['userFname']; ?></a> on <?php echo date('F j, Y, g:i a',strtotime($donnee['start'])); ?>  <form method="POST" action="calendar_student.php?id=<?=$donnee['id']?>"><button type="submit" name="form" class="btn btn-outline-danger btn-sm">Delete the event</button></form><br/></p> 

 

<?php
}

}
 