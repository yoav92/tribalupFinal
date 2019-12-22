<?php 

session_start(); 

require_once 'php/functions.php';

if(!empty($_POST) && !empty($_POST['email'])){

	require_once 'php/db.php';

	$req = $pdo->prepare('SELECT * FROM members WHERE email = :email /*OR tel = :tel*/ AND confirmed_at IS NOT NULL');

	$req->execute(['email' => $_POST['email']]);

	$user = $req->fetch();

	if($user){

		$reset_token = str_random(60);

		$pdo->prepare('UPDATE members SET reset_token = ?,reset_at = now() WHERE id=?')->execute([$reset_token, $user['id']]);

		$_SESSION['flash']['success'] = 'The instructions for the password reminder have been sent to you by email';

		$id=$user['id'];

		mail($_POST['email'], "Your Tribalup account recovery code", "We have received a request to reset your Tribalup password. Please click on this link \n\nhttp://localhost/newlife/reset.php?id=$id&token=$reset_token");

		header('Location: connexion.php');

		exit();

	}else{

		$_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette email';

	}


}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Connect to TribalUp</title>
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="design/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" ></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" language="Javascript" src="js/func.js"></script>
	<script type="text/javascript" language="Javascript" src="js/jquery-3.2.1.js"></script>
  </head>
  <body>

  <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="index.php">
    <img src="design/icone/logo_tribalup" WIDTH=50 HEIGHT=50/> Tribalup
  </a>
  <ul class="nav-item ">
          <a  class="btn btn-outline-success" href="inscription.php">Sign in</a>
   </ul>
   
</nav>

<div class="autr">
 <h5 class="text-center">Find your account</h5>

<form action="" method="POST">
	<div class="container">
		<div class="row">
			<div class="col-3"></div>
		    <div class="col-6"><p>Please enter your e-mail address to find your account.</p></div>
		    <div class="col-3"></div>
		</div>
		<div class="row">
			<div class="col-3"></div>
		    <div class="col-6"><input class="form-control autree" type="email" name="email" id="mail" placeholder="Mail adress" ></div>
		    <div class="col-3"></div>
		</div>
</div><br/>
		<div class="text-center"><button type="submit" id="envoi" class="btn btn-secondary btn-lg">Find</button></div>
</form>
</div>

</body>
</html>


