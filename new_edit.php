<?php

session_start(); 

require_once 'php/functions.php';
require_once 'php/db.php';

if(isset($_POST['search'])){

  header("Location: recherche.php?search=".$_POST['search']);

}
if(isset($_POST['sup'])){

  $suppDEL = $pdo -> prepare('DELETE FROM members WHERE id=?');
  $suppDEL -> execute(array($_SESSION['id']));
  header("Location: logout.php");
}
if(isset($_POST['sup_pic'])){

  $suppDEL = $pdo -> prepare('DELETE FROM avatar_members WHERE id_members=?');
  $suppDEL -> execute(array($_SESSION['id']));
  header("Location: profil.php");
}
if(isset($_POST['sup_back'])){

  $suppDEL = $pdo -> prepare('DELETE FROM background_members WHERE id_members=?');
  $suppDEL -> execute(array($_SESSION['id']));
  header("Location: profil.php");
}


if(isset($_SESSION['id'])){
 
    $mail = $pdo->prepare('SELECT * FROM members WHERE id = ?');
    $mail->execute(array($_SESSION['id']));
    $exec = $mail->fetch();

    $affichage = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $affichage->execute(array($_SESSION['id']));
    $donnee = $affichage->fetch();
  

    if(isset($_POST['formIns']) AND $exec['status']==0){
    $confirm = $pdo->prepare('UPDATE info_members_pro SET punchline = ?, future_job = ?,story=?,level=?,fields=?,establishment=?,profile=?, top1 = ? , top2 = ?,top3 = ?,top4 = ?,top5 = ?,age = ?,city = ?,way=?, way2=?, way3=?, way4=? WHERE id_members = ?');
    $confirm->execute([$_POST['punch'] ,$_POST['future'] ,$_POST['story'] ,$_POST['level'] ,$_POST['fields'],$_POST['establishment'],$_POST['profile'],$_POST['help1'],$_POST['help2'],$_POST['help3'],$_POST['help4'],$_POST['help5'],$_POST['age'], $_POST['city'],$_POST['defaultCheck1'],$_POST['defaultCheck2'],$_POST['defaultCheck3'],$_POST['defaultCheck4'],$_SESSION['id']]);
    header("Location: profil.php");
  }else if(isset($_POST['formIns']) AND $exec['status']==1){

    $confirm3 = $pdo->prepare('UPDATE members SET username=?,userFname=?,email=? WHERE id = ?');
    $confirm3->execute([$_POST['nom'] ,$_POST['prenom'] ,$_POST['mail'],$_SESSION['id']]);

    header("Location: profil.php");
}

if(isset($_POST['submit_pic'])){
// Constantes
define('TARGET', 'design/upload/');    // Repertoire cible
define('MAX_SIZE', 100000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 8000000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 800000);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 
/************************************************************
 * Script d'upload
 *************************************************************/

if(!empty($_POST))
{
  // On verifie si le champ est rempli
  if( !empty($_FILES['fichier']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
 
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
 
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['fichier']['error']) 
            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
          {
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;
 
            // Si c'est OK, on teste l'upload
            $req2 = $pdo->prepare('SELECT id FROM avatar_members WHERE id_members = ?');

            $req2 ->execute([$_SESSION['id']]);

            $verif = $req2->fetch();

            if($verif && move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
                updatePic($nomImage,$_SESSION['id']);
              
            }
            

            else if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
            {
               addPic($_SESSION['id'],$nomImage);
            
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }
}
 header("Location: profil.php");

}

if(isset($_POST['submit_fond'])){
// Constantes
define('target', 'design/upload/');    // Repertoire cible
define('max_size', 10000000000000);    // Taille max en octets du fichier
define('width_max', 80000000000);    // Largeur max de l'image en pixels
define('height_max', 8000000000);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(target) ) {
  if( !mkdir(target, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
 
/************************************************************
 * Script d'upload
 *************************************************************/
if(!empty($_POST))
{
  // On verifie si le champ est rempli
  if( !empty($_FILES['document']['name']) )
  {
    // Recuperation de l'extension du fichier
    $extension  = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
 
    // On verifie l'extension du fichier
    if(in_array(strtolower($extension),$tabExt))
    {
      // On recupere les dimensions du fichier
      $infosImg = getimagesize($_FILES['document']['tmp_name']);
 
      // On verifie le type de l'image
      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
      {
        // On verifie les dimensions et taille de l'image
        if(($infosImg[0] <= width_max) && ($infosImg[1] <= height_max) && (filesize($_FILES['document']['tmp_name']) <= max_size))
        {
          // Parcours du tableau d'erreurs
          if(isset($_FILES['document']['error']) 
            && UPLOAD_ERR_OK === $_FILES['document']['error'])
          {
            // On renomme le fichier
            $nomImage = md5(uniqid()) .'.'. $extension;
 
            // Si c'est OK, on teste l'upload
            $req1 = $pdo->prepare('SELECT id FROM background_members WHERE id_members = ?');

            $req1 ->execute([$_SESSION['id']]);

            $verif = $req1->fetch();

            if($verif && move_uploaded_file($_FILES['document']['tmp_name'], target.$nomImage))
            {
              updateBack($nomImage,$_SESSION['id']);
            }
            

            else if(move_uploaded_file($_FILES['document']['tmp_name'], target.$nomImage))
            {
              addBack($_SESSION['id'],$nomImage);
            }
            else
            {
              // Sinon on affiche une erreur systeme
              $message = 'Problème lors de l\'upload !';
            }
          }
          else
          {
            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
          }
        }
        else
        {
          // Sinon erreur sur les dimensions et taille de l'image
          $message = 'Erreur dans les dimensions de l\'image !';
        }
      }
      else
      {
        // Sinon erreur sur le type de l'image
        $message = 'Le fichier à uploader n\'est pas une image !';
      }
    }
    else
    {
      // Sinon on affiche une erreur pour l'extension
      $message = 'L\'extension du fichier est incorrecte !';
    }
  }
  else
  {
    // Sinon on affiche une erreur pour le champ vide
    $message = 'Veuillez remplir le formulaire svp !';
  }
}



    header("Location: profil.php");

}

?>





<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"/> 
    <title><?php echo $exec['userFname']?> <?php echo $exec['username'] ?></title> 
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
 </head>

    <body class="beautyy">
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <img src="design/icone/logo_tribalup" WIDTH=50 HEIGHT=50 />
  <a class="navbar-brand " href="account.php">Tribalup</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="profil.php"><?php echo $exec['userFname']?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="account.php?id="<?php echo $_SESSION['id'] ?>">Accueil</a>
      </li>
      <?php if ($exec['status']==0) { ?>
      <li class="nav-item active">
        <a class="nav-link " href="calendar.php">Appointments</a>
      </li>
       <?php }else{ ?>
      <li class="nav-item active">
        <a class="nav-link " href="calendar_student.php">Appointments</a>
      </li>
       <?php } ?>
      <li class="nav-item active">
        <a class="nav-link " href="recherche.php">Search for members</a>
      </li>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="new_edit.php">Edit your profil</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>

    </ul>
    <form method="POST" action="" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="work or studies..." aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
    </form>
  </div>
</nav>
<?php
if($exec['confirmed_at']!=NULL){
?>

<br/><br/><br/>


<div class="container">
   
      <?php  if(isset($_SESSION['id'])){ 

          $affichage = $pdo->prepare('SELECT * FROM avatar_members WHERE id_members = ?');
          $affichage->execute(array($_SESSION['id']));
          $picture = $affichage->fetch();
          if(isset($picture['avatar']) AND !empty($picture['avatar'])){
            ?>
          <img class="im " src="design/upload/<?php echo $picture['avatar'] ; ?>" height="100px" width="90px"/>
          <?php } else { ?>
          <img class="im " src="design/icone/1.jpg" alt="Photo de profil" height="100px" width="90px"/>
          <?php } } ?>
   
    <form enctype="multipart/form-data" action="" class="form_post" method="post">
          <fieldset>
                <p>
                  <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !"></label>
              
                  <input name="fichier" type="file" id="fichier_a_uploader" class="btn"  style=""/>

                  <input type="submit" name="submit_pic" value="Update !" class="btn" />
                </p>
            </fieldset>
          </form>
<form method="POST" action="">
<button type="submit" name="sup_pic" class="btn btn-danger btn-sm">Delete your profil picture</button>
</form>
<br/>

    <?php if(isset($_SESSION['id'])){ 
    $fond = $pdo->prepare('SELECT * FROM background_members WHERE id_members = ?');
    $fond->execute(array($_SESSION['id']));
    $picture_fond = $fond->fetch();
    if(isset($picture_fond['background']) AND !empty($picture_fond['background'])){
      ?>
    <?php 
    $expo = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $expo->execute(array($_SESSION['id']));
    $valeur = $expo->fetch(); ?>

      <img class="mx-auto " id="" alt="Responsive image" width=30% height=90 src="design/upload/<?php echo $picture_fond['background'] ; ?>"/>
    
        <?php } else { ?>


        
          <img src="design/icone/fond.jpg" alt="Responsive image" width=30% height=90  class=" mx-auto " /> 
       </div> 

    <?php } } ?>

<div class="container">
  

    <form enctype="multipart/form-data" action="" class="form_post" method="post">
              <fieldset>
                    <p>
                      <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !"></label>
                     
                      <input  name="document" type="file" id="fichier_a_uploader" class="btn "/>
                      <input type="submit" name="submit_fond" value="Update !" class="btn" />
                    </p>
              </fieldset>
      </form>
<form method="POST" action="">
<button type="submit" name="sup_back" class="btn btn-danger btn-sm">Delete your background</button>
</form>
    </div>
</div>
   <br/>
   

<div class="container">
<form method="POST" action="">
  <h5>About you</h5>
  
      
            <input type="text" class="form-control" name="prenom" id="punch" value="<?php echo $exec['userFname'] ?>">
         <br/>
            <input type="text" class="form-control" name="nom" id="punch" value="<?php echo $exec['username'] ?>">
         <br/>
         
            <input type="text" class="form-control" name="mail" id="punch" value="<?php echo $exec['email']; ?>">
          <br/>
          <?php if ($exec['status']==0) { ?>
            <input type="text" class="form-control" name="age" id="punch" value="<?php echo $donnee['age']; ?>">
          <br/>
        
            <input type="text" class="form-control" name="city" id="punch" value="<?php echo $donnee['city']; ?>">
           <br/>
            <input type="text" class="form-control" name="punch" id="punch" value="<?php echo $donnee['punchline'] ?>">
        

        
  

<br/><br/><br/>


  <h5>About your studies</h5>
 
          
            <input type="text" class="form-control" name="level" id="punch" value="<?php echo $donnee['level']; ?>">
         <br/>
          
            <input type="text" class="form-control" name="establishment" id="punch" value="<?php echo $donnee['establishment']; ?>">
        <br/>
         
            <input type="text" class="form-control" name="future" id="punch" value="<?php echo $donnee['future_job']; ?>">
         <br/>
         
            <input type="text" class="form-control" name="fields" id="punch" value="<?php echo $donnee['fields']; ?>">
         <br/>
        
      
            <textarea type="text" class="form-control" name="story" id="punch" rows="4" cols="50"><?php echo $donnee['story']; ?></textarea>
            <br/>
             <textarea type="text" class="form-control" name="profile" id="punch" rows="4" cols="50"><?php echo $donnee['profile']; ?> </textarea>
       
       

<br/><br/><br/>



<h5>Questions that i can answer</h5>
  
          
            <input type="text" class="form-control" name="help1" id="help1" id="punch" value="<?php echo $donnee['top1']; ?>">
         <br/>
          
            <input type="text" class="form-control" name="help2" id="help2" id="punch" value="<?php echo $donnee['top2']; ?>">
        <br/>
         
            <input type="text" class="form-control" name="help3" id="help3" id="punch" value="<?php echo $donnee['top3']; ?>">
          <br/>
         
            <input type="text" class="form-control" name="help4" id="help4" id="punch" value="<?php echo $donnee['top4']; ?>">
          <br/>
           <input type="text" class="form-control" name="help5" id="help5" id="punch" value="<?php echo $donnee['top5']; ?>">

<br/><br/><br/>


<h5>12. On which platforms will your future meetings take place?</h5>

<?php if($donnee['way']!=NULL) {?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="What's app" name="defaultCheck1" checked='checked'>
  <label class="form-check-label" for="defaultCheck1">
    What's app
  </label>
</div>
<?php } else { ?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="What's app" name="defaultCheck1">
  <label class="form-check-label" for="defaultCheck1">
    What's app
  </label>
</div>
<?php } ?>

<?php if($donnee['way2']!=NULL) {?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Skype" name="defaultCheck2" checked='checked'>
  <label class="form-check-label" for="defaultCheck1">
    Skype
  </label>
</div>
<?php } else { ?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Skype" name="defaultCheck2">
  <label class="form-check-label" for="defaultCheck1">
    Skype
  </label>
</div>
<?php } ?>

<?php if($donnee['way3']!=NULL) {?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Facebook" name="defaultCheck3" checked='checked'>
  <label class="form-check-label" for="defaultCheck1">
    Facebook
  </label>
</div>
<?php } else { ?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Facebook" name="defaultCheck3">
  <label class="form-check-label" for="defaultCheck1">
    Facebook
  </label>
</div>
<?php } ?>

<?php if($donnee['way4']!=NULL) {?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Not platforms,just phone" name="defaultCheck4" checked='checked'>
  <label class="form-check-label" for="defaultCheck1">
    Not platforms,just phone
  </label>
</div>
<?php } else { ?>
<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Not platforms,just phone" name="defaultCheck4">
  <label class="form-check-label" for="defaultCheck1">
    Not platforms,just phone
  </label>
</div>
<?php } ?>

</div>
  
  <?php } ?>

<br/><br/>
<div class="text-center"><button type="submit" id="envoi" name="formIns" class="btn btn-success">Edit</button></div>
</form>


</div>
<form method="POST" action="">
<button type="submit" id="sup" name="sup" class="btn btn-outline-danger btn-sm">Delete your profile</button>
</form>
    </body>

</html>
<?php
}else{?>
  <br/>
  <div class="alert alert-danger text-center"><span class="tai">confirm your registration received by email to edit your profile</span></div></br>
  <?php
}
 }else{

    header("Location: connexion.php");
}
?>