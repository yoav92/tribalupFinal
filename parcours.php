<?php 
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
require_once 'php/functions.php';
require_once 'php/db.php';

if(isset($_SESSION['id'])){ 
    $affichage = $pdo->prepare('SELECT * FROM info_members_pro WHERE id_members = ?');
    $affichage->execute(array($_SESSION['id']));
    $donnee = $affichage->fetch();
    
}
if($demarage['confirmed_at']!=NULL){
?>

<br/>
<div class="text-center autre"><span class="tai">How did you become who you are?</span></div></br>
<div class="container-fluid">	
		<div class="row">
			<div class="col-md-4"></div>
	  		<div class="col-md-4"><span class="ecrit">Level of study:</span> <?php echo $donnee['level']; ?></br>
								  <span class="ecrit">Previous training:</span> <?php echo $donnee['establishment']; ?></br>
								  <span class="ecrit">My future job:</span> <?php echo $donnee['future_job']; ?></div></br>
	  		<div class="col-md-4"></div>
		</div>

		<div class="row">
			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
	  		
		</div>
		</br>
		<div class="row">
			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
  			<div class="col-md-1"><span class="taii2">Description</span></div>
	  		<div class="col-md-4"><h5>How may I help you ?</h5></div>
	  		
	  	</div>


	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><span href="#" class="list-group-item list-group-item-success exit2"><?php echo $donnee['top1']; ?></span></div>
	  		<div class="col-md-4"></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><span href="#" class="list-group-item list-group-item-info exit2"><?php echo $donnee['top2']; ?></span></div>
	  		<div class="col-md-4"></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><span href="#" class="list-group-item list-group-item-warning exit2"><?php echo $donnee['top3']; ?></span></div>
	  		<div class="col-md-4"></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"> <span href="#" class="list-group-item list-group-item-danger exit2"><?php echo $donnee['top4']; ?></span></div>
	  		<div class="col-md-4"></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><span href="#" class="list-group-item list-group-item-success exit2"><?php echo $donnee['top5']; ?></span></div></br></br>
	  		<div class="col-md-4"></div>
	  	</div>
	  </br>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><h5>My field</h5></div>
	  		<div class="col-md-4"></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><span class="ecrit"><?php echo $donnee['fields']; ?></span></div></br></br>
	  		<div class="col-md-4"></div>
	  	</div>
	  	<div class="row">
			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
	  		
		</div>
	</br>
		<div class="row">
			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
  			<div class="col-md-1"></div>
	  		<div class="col-md-1"><span class="taii2">My carrer</span></div>
	  		<div class="col-md-4"><h5>My life today</h5></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4  exit2"><p><?php echo $donnee['story']; ?></p></div>
	  		<div class="col-md-4"></div>
	  	</div>
	  </br>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4"><h5>My life in high school</h5></div>
	  		<div class="col-md-4"><h5></h5></div>
	  	</div>
	  	<div class="row">
	  		<div class="col-md-4"></div>
	  		<div class="col-md-4 exit2"><p ><?php echo $donnee['profile']; ?></p></div>
	  		<div class="col-md-4"></div>
	  	</div>
	</div>


</div>
<?php } else {?>
	<br/>
	<div class="alert alert-danger text-center"><span class="tai">confirm your registration received by email to complete your profile</span></div></br>
<?php 
}
?>


<?php
