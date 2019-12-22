<?php

function e404(){
	require './404.php';
	exit();
}

function dd($vars){
	foreach($vars as $var)
	{
		echo '<pre>';
		print_r($var);
		echo '<pre>';
	}
	
}

function get_pdo():PDO{
	return  $pdo = new PDO('mysql:host=localhost;dbname=helpWork;charset=utf8','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
}

function h(?string $value):string{
	if($value===null){
		return '';
	}
	return htmlentities($value);

}

function render(string $view,$parameters=[]){
	extract($parameters);
	include "./views/{$view}.php";

}