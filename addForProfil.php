<?php
require 'src/Date/bootstrap.php';
require 'views/header.php';
require 'src/Date/EventValidator.php';
require 'src/Date/Event.php';
require 'src/Date/Events.php';

if(isset($_GET['id'])){

$id=$_GET['id'];
$age=$_GET['age'];
$prenom=$_GET['prenom'];
$nom=$_GET['nom'];
$ville=$_GET['ville'];

$data=[];
$errors=[];
if($_SERVER['REQUEST_METHOD'] === 'POST'){/*verifie si  il y a bien un formulaire envoye en POST*/
	$header="MIME-Version: 1.0\r\n";
    $header.='From:"tribalup.com"<support@Tribalup.com>'."\n";
    $header.='Content-Type:text/html; charset="utf-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $info1 = $pdo->prepare('SELECT email FROM members WHERE id = ?');
	$info1->execute(array($_SESSION['id']));
	$information1 = $info1->fetch();
	$info2 = $pdo->prepare('SELECT email FROM members WHERE id = ?');
	$info2->execute(array($_GET['id']));
	$information2 = $info2->fetch();
	
	
	$data=$_POST;
	$errors=[];
	$validator=new Date\EventValidator();
	$errors=$validator->validates($_POST);
	if(empty($errors)){
		mail($information1['email'], "New event - Tribalup.com", "You recoreded a new event! Please connect to www.tribalup.com ",$header);
		mail($information2['email'], "New event - Tribalup.com", "You have a new event! Please connect to www.tribalup.com ",$header);
		$events=new \Date\Events(get_pdo());
		$event=$events->hydrate(new \Date\Event(),$data,$id,$_SESSION['id']);
		$events->create($event);
		header("Location:affichage_profil.php?success=1&id=".$id."&prenom=".$prenom."&nom=".$nom."&age=".$age."&ville=".$ville);
		exit();
	}
}


?>


<br/><br/>
<div class="container">

	<?php if(!empty($errors)): ?>
	<div class="alert alert-danger">
		Thank you for correcting your mistakes
	</div>

<?php endif; ?>

	<h1>Add event</h1>
	
	<form action="" method="post" class="form">
		<?php render('/calendar/form',['data'=>$data,'errors'=>$errors]); ?>
			<div class="form-group">
				<button class="btn btn-primary">Add the event</button>
			</div>
	</form>
</div>

<?php require'views/footer.php'; }else{ header('location:connexion.php');}?> 