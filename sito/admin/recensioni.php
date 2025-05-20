<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="0";
$sql = "UPDATE tbltestimonianze SET status=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Recensione distattivata con successo";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE tbltestimonianze SET status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();

$msg="Recensione attivata con successo";
}


 ?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>EasyCar  </title>

	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>

<body>
	<?php include('inclusioni/header.php');?>

	<div class="ts-main-content">
		<?php include('inclusioni/barra.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Gestisci Recensioni</h2>

						<div class="panel panel-default">
							<div class="panel-heading">Recensioni degl Utenti</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>ERRORE</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESSO</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
											<th>Nome</th>
											<th>Email</th>
											<th>Recensioni</th>
											<th>Data di Pubblicazione</th>
											<th>Azioni</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
										<th>Nome</th>
											<th>Email</th>
											<th>Recensioni</th>
											<th>Data di Pubblicazione</th>
											<th>Azioni</th>
										</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT tblusers.nome,tbltestimonianze.UserEmail,tbltestimonianze.recensione,tbltestimonianze.data,tbltestimonianze.status,tbltestimonianze.id from tbltestimonianze join tblusers on tblusers.Emailid=tbltestimonianze.UserEmail";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->nome);?></td>
											<td><?php echo htmlentities($result->UserEmail);?></td>
											<td><?php echo htmlentities($result->recensione);?></td>
											<td><?php echo htmlentities($result->data);?></td>
										<td><?php if($result->status=="" || $result->status==0)
{
	?><a href="recensioni.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Vuoi davvero disabilitare?')"> Abilita</a>
<?php } else {?>

<a href="recensioni.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Vuoi daveero abilitare?')"> Disabilita</a>
</td>
<?php } ?></td>
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>

						

							</div>
						</div>

					

					</div>
				</div>

			</div>
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>
