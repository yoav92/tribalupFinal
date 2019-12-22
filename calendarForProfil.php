<?php
require 'src/Date/bootstrap.php';
require 'src/Date/Month.php';
require 'src/Date/Events.php';


$id=$_GET['id'];
$age=$_GET['age'];
$prenom=$_GET['prenom'];
$nom=$_GET['nom'];
$ville=$_GET['ville'];


$pdo=get_pdo();
$events=new Date\Events($pdo);

if(isset($_GET['success'])):
?>
<div class="container">
	<div class="alert alert-success">
		The event is successfully recorded!
	</div>
</div>
 <?php endif;

try
{

	$month = new App\Date\Month($_GET['month'] ?? null,$_GET['year'] ?? null); /*si dans l'url,on definie le mois/annee alors on affiche ces valeurs sinon(traduit par des ?) ca sera nul*/

	$start=$month->getStartingDay();
	$start = $start->format('N')==='1'?$start:$month->getStartingDay()->modify('last monday');/*format('N') permet de prendre le jour,si n=1=lundi*/
	/*modify() est une methode de la classe DateTime*/
	
	$weeks=$month->getWeeks();
	$end=(clone $start)->modify('+'. (6+7*($weeks-1)) .'days');
	$events=$events->getEventsBetweenByDay($start,$end,$id);

	
} catch(\Exception $e) {

	$month = new App\Date\Month();

}
?>
<div class="calendar">
	<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
		<span class="mois"><?= $month->toString(); ?></span>
		<div>
			<a href="affichage_profil.php?month=<?= $month->previousMonth()->month;?>&year=<?= $month->previousMonth()->year;?>&id=<?=$id?>&prenom=<?=$prenom?>&nom=<?=$nom?>&age=<?=$age?>&ville=<?=$ville?>" class="btn btn-dark">&lt</a>
			<a href="affichage_profil.php?month=<?= $month->nextMonth()->month;?>&year=<?=$month->nextMonth()->year;?>&id=<?=$id?>&prenom=<?=$prenom?>&nom=<?=$nom?>&age=<?=$age?>&ville=<?=$ville?>" class="btn btn-dark">&gt</a>
		</div>
	</div>

	



	<br/>

	<table class="calendar__table calendar__table--<?= $weeks; ?>Weeks">
		<?php for($i=0;$i<$weeks;$i++) :/*on avance dans les semaines*/?>
			<tr>
					<?php foreach($month->days as $k=>$day)/*on avance dans les jours*/:/*dans $day on a du lundi au dimanche,dans $k on a de 0 a 6*/
					$date= (clone $start)->modify("+" .($k+$i*7)."days"); 
					$eventsForDay=$events[$date->format('Y-m-d')] ?? [];
					
					?>

				<td class="<?=$month->withinMonth($date) ? '' : 'calendar__othermonth';?>">
					<?php if($i===0): ?> 
						<div class="calendar__weekday"><?= $day;?></div>
					<?php endif; ?>

						<div class="calendar__day"><?= $date->format('d');/*affiche les jours du mois* de 1 a 31*/?></div>
					<?php foreach ($eventsForDay as $event): ?>
						<div class="calendar__event">
							<div class="ev"> <?= (new DateTime($event['start']))->format('H:i') ?> - <?php echo h($event['name']);?></div>
						</div>
						
					<?php endforeach; ?>
				</td>
					<?php endforeach;?>
			</tr>
		<?php endfor;       ?>


	</table>
	<?php 
	$test = $pdo->prepare('SELECT status FROM members WHERE id = ?');
    $test->execute(array($_SESSION['id']));
	$valeur = $test->fetch(); 
	if($valeur['status']==1){
	?><a href="addForProfil.php?id=<?=$id?>&prenom=<?=$prenom?>&nom=<?=$nom?>&age=<?=$age?>&ville=<?=$ville?>" class="calendar__button">+</a><?php
	}?>
</div>

