
<?php
require 'src/Date/bootstrap.php';
require 'src/Date/Month.php';
require 'src/Date/Events.php';
require 'views/header.php';

if(isset($_GET['id'])){
	$prendre=$pdo->prepare('SELECT * FROM events WHERE id = ?');
	$prendre->execute([$_GET['id']]);
	$dem = $prendre->fetch();

	$prendre2=$pdo->prepare('SELECT * FROM members WHERE id = ?');
	$prendre2->execute([$dem['id_members_ex']]);
	$dem2 = $prendre2->fetch();

	$prendre3=$pdo->prepare('SELECT * FROM members WHERE id = ?');
	$prendre3->execute([$dem['id_members']]);
	$dem3 = $prendre3->fetch();

	$header="MIME-Version: 1.0\r\n";
    $header.='From:"tribalup.com"<support@Tribalup.com>'."\n";
    $header.='Content-Type:text/html; charset="utf-8"'."\n";
    $header.='Content-Transfer-Encoding: 8bit';
    $name=$dem['name'];
    $date=$dem['start'];
	if($_SESSION['id']==$dem2['id']){
		mail($dem3['email'], "Event deleted - Tribalup.com", "The event $name of $date was deleted by the student",$header);
	}else{
		mail($dem2['email'], "Event deleted - Tribalup.com", "The event $name of $date was deleted by the profesionnal",$header);
	}

	$confirm = $pdo->prepare('DELETE FROM events WHERE id = ?');
	$confirm->execute([$_GET['id']]);

	
	?><br/><div class="container">
		<div class="alert alert-danger">
			the event has been successfully deleted!
		</div>
	</div>
	<?php	}

if($demarage['confirmed_at']==NULL)
{
  ?><div class="alert alert-danger text-center" ><?php echo "Please confirm your registration on your mailbox"?></div><?php
}

if(isset($_SESSION['id'])){


$pdo=get_pdo();
$events=new Date\Events($pdo);//on cree un objet events en chargeant la BDD

if(isset($_GET['success'])):
?>
<br/>
<div class="container">
	<div class="alert alert-success">
		The event is successfully recorded!
	</div>
</div>
 <?php endif;

try
{

	$month = new App\Date\Month($_GET['month'] ?? null,$_GET['year'] ?? null); /*si dans l'url,on definie le mois/annee alors on affiche ces valeurs sinon(traduit par des ?) ca sera nul*/
	//on cree une nouvelle instance de month qui a un mois et une annee

	$start=$month->getStartingDay();//recevoir le premier jour du mois
	$start = $start->format('N')==='1'?$start:$month->getStartingDay()->modify('last monday');/*format('N') permet de prendre le jour,si n=1=lundi*/
	/*modify() est une methode de la classe DateTime*/
	
	$weeks=$month->getWeeks();//recevoir le nombre de semaines
	$end=(clone $start)->modify('+'. (6+7*($weeks-1)) .'days');//recevoir le nombre de jour dans le mois
	$events=$events->getEventsBetweenByDay($start,$end,$_SESSION['id']);//placer les evenements dans le mois,on recupere un tableau d'evenement

	
} catch(\Exception $e) {

	$month = new App\Date\Month();

}
?>
<div class="calendar">
	<div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
		<span class="month"><?= $month->toString(); ?></span>
		<div>
			<a href="calendar.php?month=<?= $month->previousMonth()->month;?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-dark">&lt</a>
			<a href="calendar.php?month=<?= $month->nextMonth()->month;?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-dark">&gt</a>
		</div>
	</div>




	<table class="calendar__table calendar__table--<?= $weeks; ?>Weeks">
		<?php for($i=0;$i<$weeks;$i++) :/*on avance dans les semaines*/?>
			<tr>
					<?php foreach($month->days as $k=>$day)/*on avance dans les jours*/:/*dans $day on a du lundi au dimanche,dans $k on a de 0 a 6*/
					$date= (clone $start)->modify("+" .($k+$i*7)."days"); //il prendre le premier jour du mois puis rajoute le nb de jours
					$eventsForDay=$events[$date->format('Y-m-d')] ?? [];//recuperer evenement dans le tableau $events en fonction de la date
					
					?>

				<td class="<?=$month->withinMonth($date) ? '' : 'calendar__othermonth';?>">
					<?php if($i===0): ?> 
						<div class="calendar__weekday"><?= $day;//les 7 jours de semaine ecrit litteralemt only first week(i===0)?></div>
					<?php endif; ?>

						<div class="calendar__day"><?= $date->format('d');/*affiche les jours du mois* de 1 a 31*/?></div>
					<?php foreach ($eventsForDay as $event): //afficher tous les evenements?>
						<div class="calendar__event">
							<?= (new DateTime($event['start']))->format('H:i') ?> - <a href="edit_event.php?id=<?= $event['id'];?>"><?= h($event['name']);?></a>
						</div>
						
					<?php endforeach; ?>
				</td>
					<?php endforeach;?>
			</tr>
		<?php endfor;       ?>


	</table>

	<!--<a href="add.php" class="calendar__button">+</a>-->
</div>

<?php require 'views/footer.php'; } else { header('location:connexion.php');}?>