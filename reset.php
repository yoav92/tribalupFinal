<?php 

require_once 'php/functions.php';

if(isset($_GET['id']) && isset($_GET['token'])){

	require 'php/db.php';

	$req = $pdo->prepare('SELECT * FROM members WHERE id=? AND reset_token IS NOT NULL AND reset_token= ? AND reset_at > DATE_SUB(NOW(),INTERVAL 30 MINUTE)');

	$req->execute([$_GET['id'],$_GET['token']]);

	$user = $req -> fetch();

	if($user) {

		if(!empty($_POST)){
			var_dump($_POST);

			if(!empty($_POST['password'])){

				$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

				$pdo->prepare('UPDATE members SET password = ?,reset_at = NULL,reset_token = NULL')->execute([$password]);

				session_start(); 

				$_SESSION['flash']['success'] = "Congratulation! Your password has been changed";

				$_SESSION['auth'] = $user;

				header('Location:account.php');

				exit();
			}


		}

	} else {

		session_start();

		$_SESSION['flash']['error'] = "This token is not valid";

		header('Location:index.php');

		exit();
	}

}else{

	header('Location:index.php');

	exit();
}


?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Connect to Tribalup</title>
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="design/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" language="Javascript" src="js/jquery-3.2.1.js"></script>
	<script type="text/javascript" language="Javascript" src="js/func.js"></script>
	

  </head>
  <body>

  <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="design/icone/logo_tribalup" WIDTH=90 HEIGHT=80 />	
    Tribalup
  </a>
  
   
</nav>

<div class="autr">
<h5 class="text-center">Choose a new password</h5>

<form method="POST" action="">

	<div class="row">
		<div class="col-3"></div>
		<div class="col-6"><p>A strong password is a combination of letters and punctuation. It must be at least 6 characters long.</p></div>
		<div class="col-3"></div>
	</div>
	<div class="row">
		<div class="col-3"></div>
		<div class="col-6"><input class="form-control autreee pass" type="password" name="password" id="password" placeholder="new password" >
			<span class="error"></span>
			<span class="bar"></span></div>
		<div class="col-3"></div>
	</div>

	<div class="text-center autreee"><button type="submit" id="envoi" class="btn btn-secondary btn-lg">Continuer</button></div>
	

	
</form>
</div>

</body>
</html>


