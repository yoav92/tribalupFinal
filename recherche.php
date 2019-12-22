<?php 
ob_start();
session_start(); 

require_once 'php/functions.php';
require_once 'php/db.php';

if(isset($_SESSION['id'])){
  
$dem = $pdo->prepare('SELECT * FROM members WHERE id = ?');
$dem->execute(array($_SESSION['id']));
$demarage = $dem->fetch();


 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $demarage['userFname']?> <?php echo $demarage['username'] ?></title>
    <link rel="stylesheet"  href="design/css/design.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
   

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
        <a class="nav-link" href="profil.php"><?php echo $demarage['userFname']?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="account.php">Home</a>
      </li>
       <?php if ($demarage['status']==0) { ?>
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
    
  </div>
</nav>
<?php
if($demarage['confirmed_at']==NULL)
{
  ?><div class="alert alert-danger text-center" ><?php echo "Please confirm your registration on your mailbox"?></div><?php
}
?>
<br/>
<h5 class="text-center default">Find a community of students ready to help you in your choice of orientation</h5>
<br/>
<div class="container ">
	
    
  <div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form method="POST" action="" class="card card-sm">
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-search h4 text-body"></i>
                                    </div>
                                    <!--end of col-->
                                    <div class="col">
                                        <input class="form-control form-control-lg form-control-borderless" type="search" name="jobs" placeholder="Write what do you want to do: Jobs,Studies,University...">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto">
                                        <button class="btn btn-lg btn-info" type="submit">Search <img src="design/icone/logo_tribalup" WIDTH=30 HEIGHT=30 /></button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>
</div>

  <br/><br/>

	
<?php
if(isset($_GET['search'])){

$stmt = $pdo->prepare('SELECT members.id,members.username,members.userFname,info_members_pro.age,info_members_pro.city,info_members_pro.future_job,info_members_pro.fields,avatar_members.avatar,info_members_pro.level,info_members_pro.way,info_members_pro.way2,info_members_pro.way3,info_members_pro.way4
                          FROM members INNER JOIN info_members_pro ON info_members_pro.id_members=members.id
                          LEFT JOIN avatar_members ON avatar_members.id_members=members.id
                          WHERE (info_members_pro.future_job like ? OR info_members_pro.level like ? OR info_members_pro.fields like ? )AND members.id != "'.$_SESSION['id'].'" ');

$search = '%'.$_GET['search'].'%';
$stmt->execute(array($search,$search,$search));




  while ($donnees = $stmt->fetch())

  {
    ?>
    <div class="container">
      <ul class="list-group">
        <li class="list-group-item">
          <div class="row">
            <div class="col-sm">
              <?php if(isset($donnees['avatar'])){?>
              <img class="im " src="design/upload/<?php echo $donnees['avatar'] ; ?>" height="150px" width="150px"/> 
              <?php } else { ?>
              <img class="im " src="design/icone/1.jpg" height="150px" width="150px"/>   
              <?php } ?>
            </div>
            <div class="col-sm">
              <h3><?php echo $donnees['userFname']?>, <?php echo $donnees['age'];?> years</h3><br/>
              <span class="font-weight-bold">Field of study:</span> <?php echo $donnees['fields'];?><br/>
              <span class="font-weight-bold">My future job:</span> <?php echo $donnees['future_job'];?><br/>
            </div>
              
            <div class="col-sm text-center"><br/><br/>
            <?php if($demarage['confirmed_at']!=NULL){
            echo '<a type="button" class="btn btn-info" href="affichage_profil.php?id='. $donnees['id'].'&prenom='.$donnees['userFname'].'&nom='.$donnees['username'].'&age='.$donnees['age'].'&ville='.$donnees['city'].'">View Profile</a>';
             } ?>
          </div>
        </li>
      </ul>
    </div>
    <?php
  }
    
}

  if(!empty($_POST['jobs'])){
    header("Location: recherche.php?search=".$_POST['jobs']);
  }

/* $reponse = $pdo->prepare('SELECT members.id,members.username,members.userprenom,info_members_pro.age,info_members_pro.ville,info_members_pro.future_job,info_members_pro3.fields,avatar_members.avatar
                          FROM (((members INNER JOIN members_pro ON members_pro.id_members=members.id)
                          INNER JOIN info_members_pro ON info_members_pro.id_members=members.id)
                          INNER JOIN info_members_pro3 ON info_members_pro3.id_members=members.id)
                          INNER JOIN avatar_members ON avatar_members.id_members=members.id
                          WHERE info_members_pro.future_job=?');
$reponse->execute(array($_POST['jobs']));

  while ($donnees = $reponse->fetch())

  {
    ?>
    <div class="container">
      <ul class="list-group">
        <li class="list-group-item">
          <div class="row">
            <div class="col-sm">
              <?php if(!empty($donnees['avatar'])){
                ?>
              <img class="im " src="upload/<?php echo $donnees['avatar'] ; ?>" height="150px" width="150px"/> 
              <?php } else { ?>
              <img class="im " src="icone/1.jpg" alt="Photo de profil" height="100px" width="100px"/>   
              <?php } ?>
            </div>
            <div class="col-sm">
              <h3><?php echo $donnees['userprenom']?>, <?php echo $donnees['age'];?> ans</h3><br/>
              <span class="font-weight-bold">Domaine d'etude:</span> <?php echo $donnees['fields'];?><br/>
              <span class="font-weight-bold">Mon futur metier:</span> <?php echo $donnees['future_job'];?><br/>
            </div>
            <div class="col-sm text-center"><br/><br/>
            <a type="button" class="btn btn-success" href="affichage_profil.php?id=<?=$donnees['id']?>&prenom=<?=$donnees['userprenom']?>&nom=<?=$donnees['username']?>&age=<?=$donnees['age']?>&ville=<?=$donnees['ville']?>">Voir le profil</a>
          </div>
        </li>
      </ul>
    </div>
    <?php
  }
}


/*
$reponse = $pdo->prepare('SELECT * FROM members WHERE statut=0 AND id!=?');
$reponse->execute(array($_SESSION['id']));

while ($donnees = $reponse->fetch())

{
  	$affichage = $pdo->prepare('SELECT avatar FROM avatar_members WHERE id_members = ?');
  	$affichage->execute(array($donnees['id']));
    $picture = $affichage->fetch();

        
      	if(!empty($picture['avatar'])){
            ?>
          <img class="im " src="upload/<?php echo $picture['avatar'] ; ?>" height="60px" width="60px"/> 
          <?php } else { ?>
          <img class="im " src="icone/1.jpg" alt="Photo de profil" height="60px" width="60px"/>   
          <?php } 
      


  	$req = $pdo->prepare('SELECT metier FROM members_pro WHERE id_members=?');
  	$req->execute(array($donnees['id']));
  	$don = $req->fetch();

    $req2 = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members=?');
    $req2->execute(array($donnees['id']));
    $vous = $req2->fetch();
    
    ?>
  	<a class="pro_re" href="affichage_profil.php?id=<?=$donnees['id']?>&prenom=<?=$donnees['userprenom']?>&nom=<?=$donnees['username']?>&age=<?=$vous['age']?>&ville=<?=$vous['ville']?>">

	<?php

}


$reponse->closeCursor();
*/
?>
</br></br></br>


  </body>
  </html>

  <?php
} else {
  header("Location: connexion.php");
}
?>