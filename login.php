<?php 
require_once 'php/db.php';
require_once 'php/functions.php';

  if(session_status() == PHP_SESSION_NONE){

    session_start();
  }
  if(isset($_POST['search'])){

    header("Location: recherche.php?search=".$_POST['search']);
  
  }
$dem = $pdo->prepare('SELECT * FROM members WHERE id = ?');
$dem->execute(array($_SESSION['id']));
$demarage = $dem->fetch();

if(!empty($_POST)){

  if(!empty($_POST['new'])){

  $user_id = $_SESSION['id']->id;

  $pdo->prepare('UPDATE members SET email = ? WHERE id= ?')->execute([$_POST['new'],$user_id]);

  }
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
     <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
  </head>
  <body>

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
        <a class="nav-link" href="account.php?id="<?php echo $_SESSION['id'] ?>">Home</a>
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
      <input class="form-control mr-sm-2" type="search" name="search" placeholder=" work or studies..." aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" >Search</button>
    </form>
  </div>
</nav>
<br/>
<div class="container">

    <?php if(isset($_SESSION['flash'])): ?>

        <?php foreach($_SESSION['flash'] as $type => $message): ?>

          <div class="alert alert-success">
            
            <?= $message; ?>

          </div>
        
        <?php endforeach; ?>

        <?php unset($_SESSION['flash']); ?>

    <?php endif; ?>

 </div>




<div class="text-center autre ">
    <h4>Confirm your email address</h4>
<p>To continue using Tribalup, you must confirm your email address. As you registered with <?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>, you can do it automatically via Gmail.</p>

<!-- <button type="button" class="btn btn-light" data-toggle="modal" data-target="#change">Update coordinates</button>-->

<a type="button" class="btn btn-secondary" href="https://accounts.google.com/ServiceLogin/identifier?service=mail&passive=true&rm=false&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&ss=1&scc=1&ltmpl=default&ltmplcache=2&emr=1&osid=1&flowName=GlifWebSignIn&flowEntry=AddSession
">Go to gmail</a>


<!-- 
<div class="modal fade" id="change" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <h8 class="modal-title" id="modalLabel">New mail adress</h8>
        </div>
            <div class="modal-body">
                <form method="POST" id="insert_form" action="">
                    <label>New e-mail adress</label>
                    <input type="text" name="new" id="new"/><br> 
                    <input type="button" class="btn btn-secondary edit_data" id="edit" name="edit" data-toggle="modal" value="Ajouter"/></input>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"/>Cancel</button>
                </form> 
            </div>

        </div>
      </div>
  </div>
</div>-->


 
<? require_once 'php/footer.php'; ?>
  
