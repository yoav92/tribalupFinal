<?php 
session_start(); 

require_once 'php/functions.php';
require_once 'php/db.php';


$dem = $pdo->prepare('SELECT * FROM members WHERE id = ?');
$dem->execute(array($_SESSION['id']));
$demarage = $dem->fetch();

$a = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members= ?');
$a->execute(array($_SESSION['id']));
$b = $a->fetch();


if(isset($_SESSION['id'])){

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"/> 
    <title><?php echo $demarage['userFname']?> <?php echo $demarage['username'] ?></title> 
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
     <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script><!--text editor-->
    
    <script>
    $(document).ready(function(){
    $('.form_post').hide();
    });
     $(document).ready(function(){
    $('.cancel').hide();
    });
    

    $(document).ready(function(){
    $('.modif').click(function(){
        $('.form_post').show();
        $('.modif').hide();
        $('.cancel').show();
    });
    });

    $(document).ready(function(){
    $('.cancel').click(function(){
        $('.form_post').hide();
        $('.modif').show();
        $('.cancel').hide();
    });
    });

     $(document).ready(function(){
    $('.form_pro').hide();
    });

      $(document).ready(function(){
    $('.modif_ex').click(function(){
        $('.form_pro').show();
        $('.modif_ex').hide();
        
    });
    });


      $(document).ready(function(){
    $('.annuler_form').click(function(){
        $('.form_pro').hide();
        $('.modif_ex').show();
        
    });
    });


      $(document).ready(function(){
    $('.form_pro2').hide();
    });

      $(document).ready(function(){
    $('.modif_ex2').click(function(){
        $('.form_pro2').show();
        $('.modif_ex2').hide();
        
    });
    });


      $(document).ready(function(){
    $('.annuler_form2').click(function(){
        $('.form_pro2').hide();
        $('.modif_ex2').show();
        
    });
    });

      $(document).ready(function(){
    $('.form_pro3').hide();
    });

      $(document).ready(function(){
    $('.modif_ex3').click(function(){
        $('.form_pro3').show();
        $('.modif_ex3').hide();
        
    });
    });


      $(document).ready(function(){
    $('.annuler_form3').click(function(){
        $('.form_pro3').hide();
        $('.modif_ex3').show();
        
    });
    });
         $(document).ready(function(){
    $('.form_pro4').hide();
    });

      $(document).ready(function(){
    $('.modif_ex4').click(function(){
        $('.form_pro4').show();
        $('.modif_ex4').hide();
        
    });
    });


      $(document).ready(function(){
    $('.annuler_form4').click(function(){
        $('.form_pro4').hide();
        $('.modif_ex4').show();
        
    });
    });
 </script>


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
          <a class="dropdown-item" href="logout.php">Log out</a>
        </div>
      </li>

    </ul>
    <form method="POST" action="" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="Work or studies..." aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
    </form>
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
<?php
if($demarage['confirmed_at']==NULL)
{
  ?><div class="alert alert-danger text-center" ><?php echo "Please confirm your registration on your mailbox"?></div><?php
}

      
?>


<?php  if(isset($_SESSION['id'])){ 
    $fond = $pdo->prepare('SELECT * FROM background_members WHERE id_members = ?');
    $fond->execute(array($_SESSION['id']));
    $picture_fond = $fond->fetch();
    if(isset($picture_fond['background']) AND !empty($picture_fond['background'])){
      ?>
    <?php 
    $expo = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $expo->execute(array($_SESSION['id']));
    $valeur = $expo->fetch(); ?>
<div class="">
      <img class="mx-auto d-block fo" id="" alt="Responsive image" src="design/upload/<?php echo $picture_fond['background'] ; ?>"/>
     
                 <p class="block col-sm pu"><?= $valeur['punchline'] ?></p>
      
</div>
        <?php } else { ?>
<div class="container">
  <div class="row">
        <div class="col align-self-center">
          <img src="design/icone/fond.jpg" alt="Responsive image" class="rounded mx-auto d-block fo" /> 
        </div>        
  </div>
</div>
    <?php } } ?>
  </br>
 <div class="container">
  <div class="row">
    <div class="col">      
    </div>
    <div class="col-5">
    </div>
    <div class="col">


</div>
  </div>
</div>

    <!-- full profile view -->
<div class="">    
  <div class="container">
      
      <?php if(isset($_SESSION['id'])){ 
      
      $affichage2 = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
      $affichage2->execute(array($_SESSION['id']));
      $donnee = $affichage2->fetch();

      $affichage3 = $pdo->prepare('SELECT * FROM info_members_no_pro WHERE id_members = ?');
      $affichage3->execute(array($_SESSION['id']));
      $donnee2 = $affichage3->fetch();



          $affichage = $pdo->prepare('SELECT * FROM avatar_members WHERE id_members = ?');
          $affichage->execute(array($_SESSION['id']));
          $picture = $affichage->fetch();
          if(!empty($picture['avatar']) AND $demarage['status']==0 ){
            ?>
          <img class="im " src="design/upload/<?php echo $picture['avatar'] ; ?>"/> <?php  echo '<span class="nom_profil">'.$demarage['userFname'].'</span>'?> <?php echo '<span class="nom_profil">'.$demarage['username'].'</span>'  ?> <?php echo '<span class="nom_profil">,'. $donnee['age'].' years</span>'; ?> <?php echo '<span class="nom_profil">,'. $donnee['city'].'</span>'; ?>

           <?php } else if (empty($picture['avatar']) AND $demarage['status']==0 AND $demarage['confirmed_at']!=NULL) { ?>
              
          <img class="im " src="design/icone/1.jpg"/> <?php  echo '<span class="nom_profil">'.$demarage['userFname'].'</span>'?> <?php echo '<span class="nom_profil">'.$demarage['username'].'</span>'  ?> <?php echo '<span class="nom_profil">,'. $donnee['age'].' years</span>'; ?> <?php echo '<span class="nom_profil">,'. $donnee['city'].'</span>'; ?>

          <?php } else if (empty($picture['avatar']) AND $demarage['status']==0 AND $demarage['confirmed_at']==NULL ){ ?>
              
          <img class="im " src="design/icone/1.jpg"/> <?php  echo '<span class="nom_profil">'.$demarage['userFname'].'</span>'?> <?php echo '<span class="nom_profil">'.$demarage['username'].'</span>'  ?> 
            
          <?php } else if (!empty($picture['avatar']) AND $demarage['status']==1) { ?>
              
          <img class="im " src="design/upload/<?php echo $picture['avatar'] ; ?>"/> <?php  echo '<span class="nom_profil">'.$demarage['userFname'].'</span>'?> <?php echo '<span class="nom_profil">'.$demarage['username'].',</span>'  ?> <?php echo '<span class="nom_profil">'.$donnee2['situation'].'</span>';?>
           
           <?php } else if (empty($picture['avatar']) AND $demarage['status']==1) { ?>
              
          <img class="im " src="design/icone/1.jpg"/> <?php  echo '<span class="nom_profil">'.$demarage['userFname'].'</span>'?> <?php echo '<span class="nom_profil">'.$demarage['username'].',</span>'  ?> <?php echo '<span class="nom_profil">'.$donnee2['situation'].'</span>';?>

                 
      
          <?php } } ?>

      
          <?php if($b['way']!=NULL OR $b['way']!=0) { ?>
          <img  src="design/icone/w.png" class="p" alt="Photo de profil" height="25px" width="25px"/>
          <?php } if($b['way2']!=NULL OR $b['way2']!=0) { ?>
          <img src="design/icone/s.png" class="p" alt="Photo de profil" height="25px" width="25px"/>
          <?php } if($b['way3']!=NULL OR $b['way3']!=0) { ?>
          <img  src="design/icone/f.jpg" class="p" alt="Photo de profil" height="25px" width="25px"/>
          <?php } if($b['way4']!=NULL OR $b['way4']!=0) { ?>
          <img src="design/icone/t.png" class="pi" alt="Photo de profil" height="25px" width="25px"/>
        <?php } ?>

    </div>


</div>






<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist"><!--menu-->
  <li class="nav-item">
    <a class="nav-link active" id="journal-tab" data-toggle="tab" href="#journal" role="tab" aria-controls="journal" aria-selected="true"><FONT color="green">Wall</FONT></a>
  </li>
  <?php if ($demarage['status']==0) { ?>
  <li class="nav-item">
    <a class="nav-link" id="parcours-tab" data-toggle="tab" href="#parcours" role="tab" aria-controls="parcours" aria-selected="false"><FONT color="green">Career</FONT></a>
  </li>
 <?php } ?>

  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="journal" role="tabpanel" aria-labelledby="journal-tab"> <?php require 'journal.php'; ?></div>
  <div class="tab-pane fade" id="parcours" role="tabpanel" aria-labelledby="parcours-tab"><?php require 'parcours.php'; ?></div>
 
  
</div>

<?php
} else {
  header("Location: connexion.php");
}
?>


</br></br></br>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
  
    <div class=""><img src="design/icone/logo_tribalup" WIDTH=90 HEIGHT=80 /></div>
    
 
    
    
    
</nav>




</body>
</html>