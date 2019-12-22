<?php

$user_id = $_GET['id'];

$token = $_GET['token'];

require 'php/header.php';

require 'php/db.php';

$req = $pdo->prepare('SELECT * FROM members WHERE id=?');

$req->execute([$user_id]);

$user = $req->fetch();

//session_start();

if($user && $user['confirmation_token'] == $token ) {


	$confirm = $pdo->prepare('UPDATE members SET confirmation_token = NULL,confirmed_at = NOW() WHERE id = ?');

	$confirm->execute(array($user_id));

	$_SESSION['flash']['success'] = 'Your account has been validated' ;

	$_SESSION['id'] = $user_id;

	

	header('Location: connexion.php');
	
	

}else if($user && $user['confirmation_token'] == NULL){


	$_SESSION['flash']['danger']="This token is no valid";

	$_SESSION['id'] = $user_id;

	header('Location: connexion.php');
}