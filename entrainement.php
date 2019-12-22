<?php
require_once 'php/db.php';

	$req=$pdo->prepare('SELECT * FROM comments_profil WHERE on_profil_id=? ');
    $req->execute(array($_SESSION['id']));

    while($donnees=$req->fetch()){
   
        
        $mess = $pdo->prepare('SELECT * FROM comments WHERE id=?');
        $mess->execute(array($donnees['id_comments']));

    	while($affichage=$mess->fetch()){

    		$reqq=$pdo->prepare('SELECT * FROM membres WHERE id=? ');
    		$reqq->execute(array($donnees['de_profil_id']));

   			$de=$reqq->fetch();

   				$reqqq=$pdo->prepare('SELECT * FROM membres WHERE id=? ');
    			$reqqq->execute(array($donnees['sur_profil_id']));

   				$a=$reqqq->fetch();

?>
	<div>
    	       <p class="facebook-name"><?php 

    	       if($donnees['de_profil_id']==0 OR $donnees['de_profil_id']==$_SESSION['id']) { ?>
    	       	<?php echo $a['userprenom'];?> <?php echo $a['username'];?>
    	       	<?php  } else { ?>
    	       	<?php echo $de['userprenom'];?> <?echo $de['username'];?>
    	       	<?php
    	       	}
    	       	?>


    	       <i class="fa fa-caret-right"></i> <?php echo $a['userprenom'];?> <?php echo $a['username']; ?><br><span class="facebook-date"><a href="https://www.facebook.com"><?php echo $affichage['date_commentaire']; ?></a> · <i class="fa fa-globe"></i></span></p>
            </div>
            <div class="fb-testimonial-copy">
                <p><?php echo $affichage['commentaire'] ;?></p>
            </div>
    </div>
<?php
			
		}
	}

?>