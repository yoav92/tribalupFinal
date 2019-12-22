<?php 

session_start(); 

require_once 'php/functions.php';
require_once 'php/db.php';
logged_only();


$req = $pdo->prepare('SELECT * FROM members WHERE id=?');
$req->execute(array($_SESSION['id']));
$donnees = $req->fetch();
$id=$donnees['id'];$prenom=$donnees['userFname'];$nom=$donnees['username'];


/*if(isset($_POST['suivre'])){
$req = $pdo->prepare("SELECT * FROM admirateurs WHERE id_admirateurs=?");
$req->execute(array($_SESSION['id']));
$compte = $req->rowCount();
    if($compte == 0){
    $req = $pdo ->prepare ("INSERT INTO admirateurs SET id_memberss = ?,id_admirateurs = ? ");
    $req->execute([$_GET['id'],$_SESSION['id']]);
    }
}

if(isset($_POST['non_suivre'])){
$req = $pdo->prepare("DELETE FROM admirateurs WHERE id_admirateurs=?");
$req->execute(array($_SESSION['id']));

}*/
if(isset($_POST['search'])){

  header("Location: recherche.php?search=".$_POST['search']);

}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="design/css/calendarForProfil.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <title><?php echo $_GET['prenom']?> <?php echo $_GET['nom'] ?></title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
	</head>

<body class="beautyy">

  

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">
    <img src="design/icone/logo_tribalup" WIDTH=50 HEIGHT=50/> Tribalup
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="profil.php"><?php echo $donnees['userFname']?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="account.php">Home</a>
      </li>
       <?php if ($donnees['status']==0) { ?>
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
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="Work or studies" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
    </form>
  </div>
</nav>
<?php
   if(isset($_GET['id']) AND !empty($_GET['id'])){

      if( !empty($message) ) 
      {
        echo '<p>',"\n";
        echo "\t\t<strong>", htmlspecialchars($message) ,"</strong>\n";
        echo "\t</p>\n\n";
      }
    ?>

<?php  if(isset($_GET['id'])){ 
    $fond = $pdo->prepare('SELECT * FROM background_members WHERE id_members = ?');
    $fond->execute(array($_GET['id']));
    $picture_fond = $fond->fetch();
    if(isset($picture_fond['background']) AND !empty($picture_fond['background'])){
      ?>
      <?php 
    $expo = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $expo->execute(array($_GET['id']));
    $valeur = $expo->fetch(); ?>

  <div class="">
        <img class=" mx-auto d-block fo" alt="Responsive image" width=100% height=400 src="design/upload/<?php echo $picture_fond['background'] ; ?>"/>
         <p class="block col-sm pu"><?= $valeur['punchline'] ?></p>
  </div>

        <?php } else { ?>
<?php 
    $expo = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $expo->execute(array($_GET['id']));
    $valeur = $expo->fetch(); ?>
        <div class="">
        <img src="design/icone/fond.jpg" alt="Responsive image" width=100% height=400  class="rounded mx-auto d-block fo" /> 
        <p class="block col-sm pu"><?= $valeur['punchline'] ?></p>
        </div>        
 
    <?php } } ?>
<div class="container">
  <div class="row">
    <div class="col">   <br/><br/><br/><br/><br/>
        <?php  if(isset($_SESSION['id'])){ 
          $affichage = $pdo->prepare('SELECT * FROM avatar_members WHERE id_members = ?');
          $affichage->execute(array($_GET['id']));
          $picture = $affichage->fetch();
          if(isset($picture['avatar']) AND !empty($picture['avatar'])){
            ?>
          <img class="image " src="design/upload/<?php echo $picture['avatar'] ; ?>" height="180px" width="170px"/> <?php  echo '<span class="nom">'.$_GET['prenom'].'</span>'?> <?php echo '<span class="nom">'.$_GET['nom'].',</span>'  ?> <?php echo '<span class="nom">'.$_GET['ville'].',</span>'  ?> <?php echo '<span class="nom">'.$_GET['age'].' years</span>'  ?>
          <?php } else { ?>
          <img class="image " src="design/icone/1.jpg" alt="Photo de profil" />  <?php echo '<span class="nom">' .$_GET['prenom'].'</span>'?> <?php echo '<span class="nom">'.$_GET['nom'].',</span>' ?> <?php echo '<span class="nom">'.$_GET['ville'].',</span>'  ?> <?php echo '<span class="nom">'.$_GET['age'].' years</span>'  ?>
      </div>
      <?php } } ?>   
    </div>
     <?php 
    $expo = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $expo->execute(array($_GET['id']));
    $valeur = $expo->fetch(); ?>
   
    <div class="col border border-dark rounded fond">
      <div class="text-center"><span class="choose">Choose a date to chat with <?php  echo $_GET['prenom'] ?> on <?php if($valeur['way']!=NULL OR $valeur['way']!=0) { ?>
          <img  src="design/icone/w.png" class="pa" alt="Photo de profil" height="25px" width="25px"/>
          <?php } if($valeur['way2']!=NULL OR $valeur['way2']!=0) { ?>
          <img src="design/icone/s.png" class="pa" alt="Photo de profil" height="25px" width="25px"/>
          <?php } if($valeur['way3']!=NULL OR $valeur['way3']!=0) { ?>
          <img  src="design/icone/f.jpg" class="pa" alt="Photo de profil" height="25px" width="25px"/>
          <?php } if($valeur['way4']!=NULL OR $valeur['way4']!=0) { ?>
          <img src="design/icone/t.png" class="pia" alt="Photo de profil" height="25px" width="25px"/>
        <?php } ?></span></div>
      <br/>

      <?php 
      require_once 'calendarForProfil.php';

      /*$req = $pdo->prepare("SELECT * FROM admirateurs WHERE id_admirateurs=?");
      $req->execute(array($_SESSION['id']));
      $compte = $req->rowCount();
                  if($compte == 0){ ?>
                    <form method="POST" action="" >
                      <button type="submit" name="suivre" class="btn btn-secondary">Suivre</button> 
                    </form>
             <?php   } else {  ?>
                    <form method="POST" action="" >
                      <button type="submit" name="non_suivre" class="btn btn-secondary">Ne plus suivre</button> 
                    </form>
             <?php   } */?>
             <br/>
    </div>
  </div>
</div>



    <!-- Debut du formulaire -->
<!--<div class="">    
  <div class="container">
    <div class="row">    
      <div class="col-6 "><?php /* if(isset($_SESSION['id'])){ 
      $affichage = $pdo->prepare('SELECT * FROM avatar_memberss WHERE id_memberss = ?');
      $affichage->execute(array($_GET['id']));
      $picture = $affichage->fetch();
      if(isset($picture['avatar']) AND !empty($picture['avatar'])){
        ?>
      <img class="im " src="upload/<?php echo $picture['avatar'] ; ?>" height="180px" width="170px"/> <?php  echo '<span class="nom">'.$_GET['prenom'].'</span>'?> <?php echo '<span class="nom">'.$_GET['nom'].',</span>'  ?> <?php echo '<span class="nom">'.$_GET['ville'].',</span>'  ?> <?php echo '<span class="nom">'.$_GET['age'].' ans</span>'  ?>
      <?php } else { ?>
      <img src="icone/1.jpg" alt="Photo de profil" height="180px" width="170px"/>  <?php echo $_GET['prenom']?> <?php echo $_GET['nom'] ?> </div>
      <?php } }*/ ?>
    </div>

  </div>
         

</div>-->





<br/><br/><br/><br/>
<?php require 'parcours_profil.php'; ?>


<?php require 'journal_profil_student.php'; ?>


  
<?php

 }else {
  header("Location: connexion.php");
}
 
?>

</body>
</html>