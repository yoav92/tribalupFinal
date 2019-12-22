<?php 
session_start(); 

require_once 'php/functions.php';
if(isset($_POST['formconnexion']))
{
	$errors = array();
	if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){

		require_once 'php/db.php';
		

		$req = $pdo->prepare('SELECT * FROM members WHERE email = ? AND confirmed_at IS NOT NULL'); //check the email

		$req->execute(array($_POST['email']));

		$user = $req->fetch();

		if(password_verify($_POST['password'], $user['password'])){ //check the password

			$_SESSION['id']= $user['id'];//build the sessions variables
			
			$_SESSION['userprenom']= $user['userprenom'];

			$_SESSION['username'] = $user['username'];

			$_SESSION['auth'] = $user;

			$_SESSION['flash']['success'] = 'you are connected';

			header("Location: account.php?id=".$_SESSION['id']);//if there is no error,enter to the website

			exit();

		}else{

		
			$errors['username'] = "incorrect username or password";//error during connection


		}

	}else{

			$errors['username'] = 'Incorrect username or password';//error during connection

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
	
	<script src="js/bootstrap.min.js"></script>
	
  </head>
  <body>

  <nav class="navbar navbar-light bg-light">
  <a class="navbar-brand" href="index.php">
    <img src="design/icone/logo_tribalup" WIDTH=90 HEIGHT=80 />	
    Tribalup
  </a>
  <ul class="nav-item ">
          <a class="btn btn-outline-success" href="inscription.php">Sign in</a>
   </ul>
   
</nav>
<div class="container">

    <?php if(isset($_SESSION['flash'])): ?> <!--error message to display-->

        <?php foreach($_SESSION['flash'] as $type => $message): ?>

          <div class="alert alert-<?= $type; ?>">
            
            <?= $message; ?>

          </div>
        
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']); ?>

    <?php endif; ?>

 </div>
<?php if(!empty($errors)): ?> <!--error message to display-->


    <div class="alert alert-danger">

      <p>Connexion error</p>

      <ul>

        <?php foreach ($errors as $error): ?>

          <li><?= $error; ?></li>
        
        <?php endforeach; ?>

      </ul>

    </div>

    <?php endif; ?>


<div class="autr">
<h5 class="text-center">Connect to tribalup</h5>

<form method="POST" action="" ><!--form to be completed by the user-->
  <div class="container">
	<div class="row">
		<div class="col-3"></div>
	    <div class="col-6"><input class="form-control autreee" type="email" name="email" id="mail" placeholder="Email address" ></div>
	    <div class="col-3"></div>
	</div>
	<div class="row">
		<div class="col-3"></div>
		<div class="col-6"><input class="form-control autreee" type="password" name="password" id="password" placeholder="password" ></div>
		<div class="col-3"></div>
	</div>

	<div class="text-center autreee"><button type="submit" id="envoi" class="btn btn-secondary btn-lg" name="formconnexion">Connexion</button></div>
<br/>
	<div class="row">
		<div class="col-3"></div>
	    <div class="col-6"><a href="forget.php"><font color="green">Forgot your account information ?</font></a></div>
	    <div class="col-3"></div>
	</div>
  </div>
</form>
</div>

</body>
</html>


