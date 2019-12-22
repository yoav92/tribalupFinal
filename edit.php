<?php 
session_start();
require_once 'php/db.php';
require_once 'php/functions.php';

$dem = $pdo->prepare('SELECT punchline FROM info_members_pro WHERE id_members = ?');
$dem->execute(array($_SESSION['id']));
$demarage = $dem->fetch();


if($demarage['punchline'])
{
  
  header("Location: profil.php");
}


if(isset($_SESSION['id']) ){
   if(isset($_POST['formIns'])){

       $errors = array();

       if(empty($_POST['punch'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['future'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['help1']) OR empty($_POST['help2']) OR empty($_POST['help3']) OR empty($_POST['help4']) OR empty($_POST['help5']) ){

        $errors['username'] = "all fields are not filled";
      }
      if($_POST['age']<'0' OR $_POST['age']>'130'){

        $errors['username'] = "Problem with your age";

      } 
      if(empty($_POST['age'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['city'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['profile'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['story'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['level'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['fields'])){

        $errors['username'] = "all fields are not filled";

      } 
      if(empty($_POST['Name_establishment'])){

        $errors['username'] = "all fields are not filled";

      } 
      
      if(empty($_POST['defaultCheck1']) AND empty($_POST['defaultCheck2']) AND empty($_POST['defaultCheck3']) AND empty($_POST['defaultCheck4'])){

        $errors['username'] = "all fields are not filled";

      } 

      $req1 = $pdo->prepare('SELECT id FROM info_members_pro WHERE id_members = ?');

      $req1 ->execute([$_SESSION['id']]);

      $verif = $req1->fetch();

      if($verif AND empty($errors)){

      $confirm = $pdo->prepare('UPDATE info_members_pro SET punchline = ?, future_job = ?,story=?,level=?,fields=?,establishment=?,profile=?, top1 = ? , top2 = ?,top3 = ?,top4 = ?,top5 = ?,age = ?,city = ?,way=?, way2=?, way3=?, way4=? WHERE id_members = ?');

      $confirm->execute([$_POST['punch'] ,$_POST['future'] ,$_POST['story'] ,$_POST['level'] ,$_POST['fields'] ,$_POST['Name_establishment'] ,$_POST['profile'] ,$_POST['help1'],$_POST['help2'],$_POST['help3'],$_POST['help4'],$_POST['help5'],$_POST['age'], $_POST['city'],$_POST['defaultCheck1'],$_POST['defaultCheck2'],$_POST['defaultCheck3'],$_POST['defaultCheck4']]);
      $reponse = $pdo->prepare('SELECT id FROM info_members WHERE id_members=?');

      $reponse ->execute([$_SESSION['id']]);

      while ($donnees = $reponse->fetch())
      {
        $_SESSION['id_info']=$donnees['id'] ;
      }

      header("Location: profil.php"); 
    
      } else if(empty($errors)) {
      
    

      addInfo($_SESSION['id'],$_POST['punch'] ,$_POST['future'] ,$_POST['story'] ,$_POST['level'] ,$_POST['fields'] ,$_POST['Name_establishment'] ,$_POST['profile'] ,$_POST['help1'],$_POST['help2'],$_POST['help3'],$_POST['help4'],$_POST['help5'],$_POST['age'], $_POST['city'],$_POST['defaultCheck1'],$_POST['defaultCheck2'],$_POST['defaultCheck3'],$_POST['defaultCheck4']);

      $reponse = $pdo->prepare('SELECT id FROM info_members_pro WHERE id_members=?');

      $reponse ->execute([$_SESSION['id']]);

      while ($donnees = $reponse->fetch())
      {
        $_SESSION['id_info']=$donnees['id'] ;
      }
      
      header("Location: connexion.php");

    }
  }



}else{

      header('location: connexion.php');
}


  

 ?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>S'inscrire sur Tribalup</title>
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="design/css/bootstrap.min.css" >
    
    <script type="text/javascript">
  $(document).ready(function(){
  
    var $punch = $('#punch'),
        $future = $('#future'),
        $help1 = $('#help1'),
        $help2 = $('#help2'),
        $help3 = $('#help3'),
        $help4 = $('#help4'),
        $help5 = $('#help5'),
        $age = $('#age'),
        $city = $('#city'),
        
    $("#punch").keyup(function(){
          if($("#nom").val() == "" ){
            $("#nom").next(".error-message").show().text("Quel est votre nom ?");
            $("#nom").css("border-color","#FF0000");
          
          }
          else{ 
            $("#nom").next(".error-message").hide().text("");
            
          }
          
        });
    $("#future").keyup(function(){
          if($("#prenom").val() == "" ){
            $("#prenom").next(".error-message").show().text("Quel est votre prenom ?");
            $("#prenom").css("border-color","#FF0000");
          
          }
          else{ 
            $("#prenom").next(".error-message").hide().text("");
            
          }
          
        });

    $("#help1").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });
     $("#help2").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });
      $("#help3").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });
       $("#help4").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });
        $("#help5").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });
         $("#age").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });
         $("#city").keyup(function(){
          if($("#metier").val() == "" ){
            $("#metier").next(".error-message").show().text("Quel est votre metier ?");
            $("#metier").css("border-color","#FF0000");
            
          }
          else{ 
            $("#metier").next(".error-message").hide().text("");
            
          }
          
        });

     

 


});
</script>
  </head>
  <body class="beauty">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
  
    <img src="design/icone/logo_tribalup" WIDTH=90 HEIGHT=80/>Tribalup 
  
      
      <div class="mx-auto my-2 order-0 order-md-1 position-relative tai">1.But who are you? Tell us about yourself</div>
   
      
    </div>
  </div>
   
    
</nav>
<div class="container">

    <?php if(isset($_SESSION['flash'])): ?>

        <?php foreach($_SESSION['flash'] as $type => $message): ?>

          <div class="alert alert-<?= $type; ?>">
            
            <?= $message; ?>

          </div>
        
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']); ?>

    <?php endif; ?>

 </div>

</br>


<!--<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   

    <div class="mx-auto my-2 order-0 order-md-1 position-relative">
      
            <img src="//placehold.it/120/ccff00" class="rounded-circle">
        
        
    </div>

  
</nav>-->



    <?php if(!empty($errors)): ?>

    <div class="alert alert-danger">

      <p>You have not completed the form correctly</p>

      <ul>

        <?php foreach ($errors as $error): ?>

          <li><?= $error; ?></li>
        
        <?php endforeach; ?>

      </ul>

    </div>

    <?php endif; ?>

 
</br></br>

<div class="container">
    <form method="POST" action="">
          <div class="form-group">
            <label for="">1. Your punchline (min: 10 - max: 140)</br>
        Describe in one sentence why we must make an appointment with you.</label>
            <input type="text" class="form-control" name="punch" id="punch" placeholder="ex: welcome to my profil..."><span class="error-message">erreur</span>
          </div>




          <div class="form-group">
              <label for="">2. Your future profession (min: 10 - max: 140)</br>
        Baker, trader on Wall Street, breeder of cavia porcellus.</br></label>
            <input type="text" class="form-control" name="future" id="punch" placeholder="ex: Baker,trader on Wall Street..."><span class="error-message">erreur</span>
          </div>

         

             <label for="">3. Your top 5 (min 10 / question)</br>

        What are the 5 big questions students ask you to answer?</br></br></label>
        <div class="form-group">
            <input type="text" class="form-control" name="help1" id="help1" placeholder="ex: Baker,trader on Wall Street..."><span class="error-message">erreur</span>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="help2" id="help2" placeholder="ex: Baker,trader on Wall Street..."><span class="error-message">erreur</span>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="help3" id="help3" placeholder="ex: Baker,trader on Wall Street..."><span class="error-message">erreur</span>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="help4" id="help4" placeholder="ex: Baker,trader on Wall Street..."><span class="error-message">erreur</span>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="help5" id="help5" placeholder="ex: Baker,trader on Wall Street..."><span class="error-message">erreur</span>
          </div>
     

        <div class="form-group">
          <label for="">5. Your age</label>
          <input type="text" class="form-control" name="age" id="age" placeholder="Ex: 23 "><span class="error-message">erreur</span>
        </div>
        

          <div class="form-group">
            <label for="">6. Your city of residence</br></label>

        Tell us where you live today, this will allow us to offer you good deals around your home!</br>
            <input type="text" class="form-control" name="city" id="city" placeholder="City"><span class="error-message">erreur</span>
          </div>

          <div class="form-group">
      <label for="exampleInputEmail1">7. Your student profile in terminal (min: 80 - max: 400)</br>

      Describe the student that you were in your last year of high school.</br>

      <textarea rows="4" cols="50" name="profile" placeholder="ex: once upon a time">

      </textarea></br>
      </div>
       
       <div class="form-group">
        <label for="exampleInputEmail1">8. Your story since high school (min: 80 - max: 400)</br>
        Tell us your story since you left the cozy nest of high school</label></br>
        <textarea rows="4" cols="50" name="story" placeholder="ex: become an aviator">
        </textarea></div></br>

         <div class="form-group">
        <label for="exampleInputEmail1">9. What is your current level of education
        The level of education where you are currently</label>

        <div class="dropdown">
            level of education
          <select name="level">
            <option value="ASC 1">ASC 1</option>
            <option value="ASC 2">ASC 2</option>
            <option value="BACHELOR">BACHELOR</option>
            <option value="MSC 1">MSC 1</option>
            <option value="MSC 2">MSC 2</option>
          </select>
        </div></br>

        <div class="form-group">
            <label for="exampleInputEmail1">10. What is your current training or training?</br>What are the fields of study of your training? (between 1 and 3)</label>
            <input type="text" class="form-control" name="fields" id="exampleInputEmail1" placeholder="">
          </div>

         <div class="form-group">
            <label for="exampleInputEmail1">11. Establishment Name</label>
            <input type="text" class="form-control" name="Name_establishment" id="exampleInputEmail1" placeholder="">
          </div>

 <div class="form-group">
<label for="exampleInputEmail1">12. On which platforms will your future meetings take place?</label>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="What's app" name="defaultCheck1">
  <label class="form-check-label" for="defaultCheck1">
    What's app
  </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Skype" name="defaultCheck2" >
  <label class="form-check-label" for="defaultCheck2">
    Skype
  </label>
</div>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" value="Facebook" name="defaultCheck3" >
  <label class="form-check-label" for="defaultCheck2">
    Facebook
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Not platforms,just phone" name="defaultCheck4" >
  <label class="form-check-label" for="defaultCheck2">
    Not platforms,just phone
  </label>
</div>
</div>




        <div class="text-center"><button type="submit" id="envoi" name="formIns" class="btn btn-success">Connect to your account !</button></div>

    </form>
</div>
  </body>
  
</html>
