<?php
require'src/Date/bootstrap.php';
require'views/header.php';
require 'src/Date/EventValidator.php';
require 'src/Date/Event.php';
require 'src/Date/Events.php';

if(isset($_SESSION['id'])){

$data=[];
$errors=[];
if($_SERVER['REQUEST_METHOD'] === 'POST'){/*verifie si  il y a bien un formulaire envoye en POST*/
	$data=$_POST;
	$errors=[];
	$validator=new Date\EventValidator();
	$errors=$validator->validates($_POST);
	if(empty($errors)){
		$events=new \Date\Events(get_pdo());
		$event=$events->hydrate(new \Date\Event(),$data,$_SESSION['id']);
		$events->create($event);
		header('Location:calendar.php?success=1');
		exit();
	}
}


?>


<br/><br/>
<div class="container">

	<?php if(!empty($errors)): ?>
	<div class="alert alert-danger">
		Merci de corriger vos erreurs
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