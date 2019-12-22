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

		$pdo->prepare('UPDATE members SET reset_token = ?,reset_at = now() WHERE id=?')->execute([$reset_token, $user->id]);

		$_SESSION['flash']['success'] = 'Les instructions du rappel du mot de passe vous ont ete envoyees par email';

		mail($_POST['email'], "# est votre code de recuperation de compte Helpwork", "Nous avons reçu une demande de réinitialisation de votre mot de passe Helpwork.Merci de cliquer sur ce lien \n\nhttp://localhost/newlife/reset.php?id=[$user->id]&token=$reset_token");

		header('Location: connexion.php');

		exit();

	}else{

		$_SESSION['flash']['danger'] = 'Aucun compte ne correspond a cette email';

	}


}

?>