<?php 
session_start(); 
require_once 'php/functions.php';

if(!isset($_SESSION['id'])){
	$errors = array();
	
	if(isset($_POST['formconnexion']))
	{
	
		if(!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){

			require_once 'php/db.php';

			$req = $pdo->prepare('SELECT * FROM members WHERE email = ?/*OR tel = :tel AND confirmed_at IS NOT NULL*/');

			$req->execute(array($_POST['email']));

			$user = $req->fetch();

			if(password_verify($_POST['password'], $user['password'])){

					$_SESSION['id']= $user['id'];

					$_SESSION['userprenom'] = $user['userprenom'];

					$_SESSION['username'] = $user['username'];

					$_SESSION['auth'] = $user;

					$_SESSION['flash']['success'] = 'You are now connected';

					

					header("Location: account.php");

				  

					exit();

				
		}else{

		
			$errors['username'] = "incorrect username or password";


		}

		}else{

		
			$errors['username'] = "incorrect username or password";


		}
	}
}else{
	
      header('location: account.php');
}

 

   ?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tribalup</title>
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="design/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js" ></script>

  </head>
  <body>

<div class="premier">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<img src="design/icone/logo_tribalup" class="logo"  />	
		 <span style="font-weight:600;"><a class="navbar-brand" href="index.php">Triba<span style="color:green;">lU</span>p</a></span>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button> 

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			
			    <ul class="navbar-nav ml-auto ">
			      <li class="nav-item active">
			      <form method="POST" action="">
			        <a class="nav-link" href="#">
				        <label for="exampleInputEmail1" class="taille"><FONT color="black">Email address</FONT></label>
			            <input type="email" class="form-control taille2" name="email" id="mail" placeholder="">
			        </a>
			      </li>
			      <li class="nav-item active">
			        <a class="nav-link" href="#">
			        	<label for="exampleInputPassword1" class="taille"><FONT color="black">Password</FONT></label>
		    			<input type="password" class="form-control taille2" name="password" id="password" placeholder="">
		    			<a href="forget.php" class="oublier"><font color="grey">Forgot your account information ?</font></a>
		    		</a>
			        </a>
			      </li>
			      <li class="nav-item">
			        <a class="nav-link disabled" href="#">
			        <button type="submit" class="btn btn-outline-dark btn-sm autreee" id="envoi" name="formconnexion">connexion</button>
			        </a>
			      </li>
			    </ul>
			  </div>
		</form>
	</nav>

	<?php if(!empty($errors)): ?>

    <div class="alert alert-danger">

      <p>Connexion error</p>

      <ul>

        <?php foreach ($errors as $error): ?>

          <li><?= $error; ?></li>
        
        <?php endforeach; ?>

      </ul>

    </div>

    <?php endif; ?>
    <div class="container">

    <?php if(isset($_SESSION['flash'])): ?>

        <?php foreach($_SESSION['flash'] as $type => $message): ?>

          <div class="alert alert-danger">
            
            <?= $message; ?>

          </div>
        
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']); ?>

    <?php endif; ?>

 </div>

<div class="vertical-center"> 
	                     
	  <div class="container">
	    <div class="text-center"><span class="color text-center">FIND YOUR REAL VOCATION THROUGH INSPIRING STUDENTS</span></div>
	    <div class="text-center">
		    <a type="button" class="btn btn-success btn-lg auttre" href="inscription2.php">Looking for your vocation</a>
			<a type="button" class="btn btn-secondary btn-lg auttre" href="inscription.php">you're a passionate student </a>
		</div>
	  </div>
	</div>

</div>
</br>
<div class="deuxieme">
<div class="container-fluid">
	<div class="row">
	  <div class="col-2"></div>
	  <div class="col-8 text-center"><h2>A social network of a new kind</h2>
	<p class="autree">Tribalup is a collaborative platform that connects passionate professionals and people looking for guidance.
	</p>
	  </div>
	  <div class="col-2"></div>
	</div>

	<div class="autr row">
		<div class="col-2"></div>
		<div class="col-4"><strong class="title_med">Follow inspiring professionals in their daily lives and change their lives !</strong>
			<p class="autree">You dream of professional change or you are looking to start your career but you do not know where you are heading and especially how? On TribalUp, thousands of professionals share their journey, their feelings and their daily lives to help you find your calling.</p></br>
			<a type="button" class="btn btn-outline-dark btn-sm bout" href="inscription2.php">you are on the lookout for your vocation</a>
		</div>
		
		<div class="col-4"><img src="design/photo/einstein2.jpg" class="img-responsive img-thumbnail grandeur"/></div>
	
	</div>
  	


	<div class="autr row">
	    <div class="col-2"></div>
		<div class="col-4"><img src="design/photo/pro.jpg" class="img-responsive img-thumbnail grandeur"/></div>

		<div class="col-4"><strong class="title_med">You are a passionate professional, share your world</strong>
			<p class="autree">Build a showcase to help promote your profession or business. Open the doors of your world and become a source of inspiration.</p></br>
			<a type="button" class="btn btn-outline-dark btn-sm bout" href="inscription.php">Become a reference in your field</a>
		</div>
		
	</div>
		

  	<blockquote class="blockquote text-center autr">
  <p class="mb-0">Every vocation begins with admiration</p>
  <footer class="blockquote-footer"> <cite title="Source Title">Michel tournier</cite></footer>
</blockquote>
</div>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
	
		<div class=""><img src="design/icone/logo_tribalup" WIDTH=90 HEIGHT=80 /></div>
		
 </div>
 <!-- <li class="nav-item">
   <a class="nav-link color_face" href="#"><a href="https://www.facebook.com/TribalupInc"> Follow us <img src="icone/facebook" WIDTH=30 HEIGHT=30 /></a>
  </li>-->

		
		
		
</nav>


	

    
  </body>
</html>