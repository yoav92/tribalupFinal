<?php 
session_start(); 
require_once 'php/functions.php';
require_once 'php/db.php';


if(isset($_SESSION['id'])){


$dem = $pdo->prepare('SELECT * FROM members WHERE id = ?');
$dem->execute(array($_SESSION['id']));
$demarage = $dem->fetch();

if(isset($_POST['search'])){

  header("Location: recherche.php?search=".$_POST['search']);

}

if(isset($_POST['submit'])){

  if(!empty($_POST['commentaire'])){

    $post=$pdo->prepare('INSERT INTO comments(id_members,comments,date_comments) VALUES(?,?,now())');
    $post->execute(array($_SESSION['id'],$_POST['commentaire']));

    //$pdo->exec("UPDATE comments SET mess_post=mess_post+1 WHERE id_members='".$_SESSION['id']."'");
    $lastid = $pdo->query('SELECT last_insert_id() FROM comments');
    $salut=$lastid->fetch();



    $req=$pdo->prepare('INSERT INTO comments_profil(id_comments,on_profil_id,from_profil_id) VALUES(?,?,?)');
    $req->execute(array($salut[0],$_SESSION['id'],$_SESSION['id']));

    header('Location:account.php');
  }
}



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Tribalup</title>
    <link rel="stylesheet"  href="design/css/design.css">
    <link rel="stylesheet" href="design/css/bootstrap.min.css">
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" ></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
	
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
        <a class="nav-link" href="account.php?id=<?php echo $_SESSION['id'];?>">Home</a>
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
    <form method="POST" action="" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2" type="search" name="search" placeholder="studies or work" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
<?php
if($demarage['confirmed_at']==NULL)
{
  ?><div class="alert alert-danger text-center" ><?php echo "Please confirm your registration on your mailbox"?></div><?php
}
?>



<br/><br/>
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


<br/>

  <form  method="POST" action="">
    <div class="container">
        <div class="row">
        <div class="col">
            <div class="vertical-menu">
                <div class="ban"><a class="btn btn-default active" href="account.php?id=<?php echo $_SESSION['id'];?>"> News</a>
                <a class="btn btn-default " href="profil.php?id=<?php echo $_SESSION['id'];?>">My profile</a></div>
               
            </div>
        </div>
        <div class="form-group col-6 " >
            <textarea name="commentaire" id="editor" class="bout" placeholder="Exprimez-vous ,<?php echo $demarage['userFname']?>">Express yourself ,<?php echo $demarage['userFname']?></textarea>
            <!--<textarea class="form-control" name="commentaire" id="" rows="3" placeholder="Exprimez-vous ,<?php /*echo $_SESSION['userprenom']*/?>"></textarea><br/>-->
            <!--<button class="btn btn-outline-success my-2 my-sm-0" name="submit" type="submit">Publier</button>-->
            <script>
            ClassicEditor
              .create( document.querySelector( '#editor' ) )
              .then( editor => {
                console.log( editor );
              } )
              .catch( error => {
                console.error( error );
              } );
          </script>
          <button class="btn btn-outline-success my-2 my-sm-0" name="submit" type="submit">Publish</button>
        </div>
        <div class="col">
           
          </div>
          </div>
    </div>
  </form>



<?php

    $req=$pdo->prepare('SELECT * FROM comments_profil inner join comments on comments_profil.id_comments=comments.id WHERE on_profil_id=? order by date_comments desc');
    $req->execute(array($_SESSION['id']));

    while($donnees=$req->fetch()){
   
        
        $mess = $pdo->prepare('SELECT * FROM comments WHERE id=?');
        $mess->execute(array($donnees['id_comments']));

      while($affichage=$mess->fetch()){

        $reqq=$pdo->prepare('SELECT * FROM members WHERE id=? ');
        $reqq->execute(array($donnees['from_profil_id']));

        $de=$reqq->fetch();

          $reqqq=$pdo->prepare('SELECT * FROM members WHERE id=? ');
          $reqqq->execute(array($donnees['on_profil_id']));

          $a=$reqqq->fetch();

  ?>
<div class="container">
  <div class="row justify-content-md-center">
    <!--Testimonial Section-->
    <div class="col col-lg-7">
      
    <div class="fb-testimonial">
      <div class="fb-testimonial-inner">
        <div class="fb-profile">
                      <?php  
          $photo = $pdo->prepare('SELECT avatar FROM avatar_members WHERE id_members = ?');
          $photo->execute(array($donnees['from_profil_id']));
          $picture = $photo->fetch();
          if(isset($picture['avatar']) AND !empty($picture['avatar'])){
            ?>
          <img class="img" src="design/upload/<?php echo $picture['avatar'] ; ?>" height="60px" width="60px"/> 
          <?php } else { ?>
          <img src="design/icone/1.jpg" alt="Photo de profil" class="img"/>  
          <?php }  ?>
        </div>
        <div>
             <p class="facebook-name"><?php 

             if($donnees['from_profil_id']==0 OR $donnees['from_profil_id']==$_SESSION['id']) { ?>
              <?php echo $a['userFname'];?> <?php echo $a['username'];?>
              <?php  } else { ?>
              <?php echo $de['userFname'];?> <?php echo $de['username'];?>
              <?php
              }
              ?>


             <img src="design/open-iconic/svg/chevron-right.svg" > <?php echo $a['userFname'];?> <?php echo $a['username']; ?><br><span class="facebook-date"><span><?php echo date('F j, Y, g:i a',strtotime($affichage['date_comments'])); ?></span> · <i class="fa fa-globe"></i></span></p>
          </div>
          <div class="fb-testimonial-copy exit">
                <p><?php echo $affichage['comments'] ;?></p>
          </div>
      </div>
    </div>
  </div>
    <!--END Testimonial Section-->
    </div>
  </div>


  <?php

}
}

$req->closeCursor(); // Termine le traitement de la requête



?>
</br></br></br>
<!--<footer class="footer">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
  
    <div class=""><img src="icone/logo_tribalup" WIDTH=90 HEIGHT=80 /></div>
    
 
<li class="nav-item">
   <a class="nav-link color_face" href="#"><a href="https://www.facebook.com/TribalupInc"> Follow us <img src="icone/facebook" WIDTH=30 HEIGHT=30 /></a>
  </li>

    
    
    
</nav>
</footer>-->
</body>

</html>

<?php } else {
header('location: connexion.php');
}
?>
