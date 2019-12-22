<?php 

require_once 'php/functions.php';
require_once 'php/db.php';

if(isset($_POST['submit'])){

	if(!empty($_POST['commentaire'])){

		addComment($_GET['id'],$_SESSION['id'],$_POST['commentaire']);
    

	}
}

?>

  
<form  method="POST" action="">
	<div class="container">
  		<div class="row ">
			<div class="col-md-3 offset-md-1">
        <h3>Comments</h3>
       		</div>
			<div class="form-group col-12" >
			     <textarea name="commentaire" id="editor" placeholder="">Exprimez-vous ,<?php echo $donnees['userFname']?></textarea>
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
			<div class="col-1">
		    </div>
        </div>
	</div>
</form>

<?php

    $req=$pdo->prepare('SELECT * FROM comments_profil inner join comments on comments_profil.id_comments=comments.id WHERE on_profil_id=? order by date_comments desc');
    $req->execute(array($_GET['id']));


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
    $photo = $pdo->prepare('SELECT * FROM avatar_members WHERE id_members = ?');
    $photo->execute(array($donnees['from_profil_id']));
    $picture = $photo->fetch();
    if(isset($picture['avatar']) AND !empty($picture['avatar'])){
      ?>
    <img class=" img" src="design/upload/<?php echo $picture['avatar'] ; ?>" height="50px" width="60px"/> 
    <?php } else { ?>
    <img class=" img" src="design/icone/1.jpg" alt="Photo de profil" height="50px" width="60px"/>  </div>
    <?php } ?>
                <div>
             <p class="facebook-name"><?php 

             if($donnees['from_profil_id']==0 OR $donnees['from_profil_id']==$_GET['id']) { ?>
              <?php echo $a['userFname'];?> <?php echo $a['username'];?>
              <?php  } else { ?>
              <?php echo $de['userFname'];?> <?php echo $de['username'];?>
              <?php
              }
              ?>


             <img src="design/open-iconic/svg/chevron-right.svg" > <?php echo $a['userFname'];?> <?php echo $a['username']; ?><br><span class="facebook-date"><?php echo date('F j, Y, g:i a',strtotime($affichage['date_comments'])); ?></span> · <i class="fa fa-globe"></i></span></p>
            </div>
            <div class="fb-testimonial-copy">
                <p><?php echo $affichage['comments'] ;?></p>
            
          </div>
    </div>
    <!--END Testimonial Section-->
    </div>
  </div>
</div>

  <?php

    }
  }



$req->closeCursor(); // Termine le traitement de la requête


?>
