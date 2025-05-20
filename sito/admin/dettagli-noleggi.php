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
$status="2";
$sql = "UPDATE tblnoleggi SET Status=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
  echo "<script>alert('Noleggio cancellato con successo');</script>";
echo "<script type='text/javascript'> document.location = 'noleggi-cancellati.php; </script>";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE tblnoleggi SET Status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
echo "<script>alert('Noleggio Confermato con successo');</script>";
echo "<script type='text/javascript'> document.location = 'noleggi-confermati.php'; </script>";
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
	
	<title>EasyCar   </title>

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
		<?php include('includinclusionies/barra.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Dettagli Noleggi</h2>

						<div class="panel panel-default">
							<div class="panel-heading">Info Noleggi</div>
							<div class="panel-body">


<div id="print">
								<table border="1"  class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%"  >
				
									<tbody>

									<?php 
$bid=intval($_GET['bid']);
$sql = "SELECT tblusers.*,tblmarchi.marchio,tblauto.veicolo,tblnoleggi.dataI,tblnoleggi.dataF,tblnoleggi.messaggio,tblnoleggi.IDveicolo as vid,tblnoleggi.Status,tblnoleggi.data,tblnoleggi.id,tblnoleggi.Nnoleggio,
DATEDIFF(tblnoleggi.dataF,tblnoleggi.dataI) as totalnodays,tblauto.tariffa
                                      from tblnoleggi join tblauto on tblauto.id=tblnoleggi.IDveicolo join tblusers on tblusers.EmailId=tblnoleggi.userEmail join tblmarchi on tblauto.marchio=tblmarchi.id where tblnoleggi.id=:bid";

$query = $dbh -> prepare($sql);
$query -> bindParam(':bid',$bid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
	<h3 style="text-align:center; color:red">#<?php echo htmlentities($result->Nnoleggio);?> Dettagli Noleggio </h3>

		<tr>
											<th colspan="4" style="text-align:center;color:blue">Dettagli Utente</th>
										</tr>
										<tr>
											<th>Numero Noleggio.</th>
											<td>#<?php echo htmlentities($result->Nnoleggio);?></td>
											<th>Nome</th>
											<td><?php echo htmlentities($result->nome);?></td>
										</tr>
										<tr>											
											<th>Email </th>
											<td><?php echo htmlentities($result->EmailId);?></td>
											<th>Telefono</th>
											<td><?php echo htmlentities($result->telefono);?></td>
										</tr>
											<tr>											
											<th>Indirizzo</th>
											<td><?php echo htmlentities($result->indirizzo);?></td>
											<th>Città</th>
											<td><?php echo htmlentities($result->citta);?></td>
										</tr>
											<tr>											
											<th>Paese</th>
											<td colspan="3"><?php echo htmlentities($result->paese);?></td>
										</tr>

										<tr>
											<th colspan="4" style="text-align:center;color:blue">Dettagli Noleggio</th>
										</tr>
											<tr>											
											<th>Veicolo</th>
											<td><a href="edit-veicolo.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></td>
											<th>Data Noleggio</th>
											<td><?php echo htmlentities($result->data);?></td>
										</tr>
										<tr>
											<th>Da</th>
											<td><?php echo htmlentities($result->dataI);?></td>
											<th>A</th>
											<td><?php echo htmlentities($result->dataF);?></td>
										</tr>
<tr>
	<th>Giorni Totali</th>
	<td><?php echo htmlentities($tdays=$result->totalnodays);?></td>
	<th>Tariffa Giornaliera</th>
	<td><?php echo htmlentities($ppdays=$result->tariffa);?></td>
</tr>
<tr>
	<th colspan="3" style="text-align:center">Totale</th>
	<td><?php echo htmlentities($tdays*$ppdays);?></td>
</tr>
<tr>
<th>Status Noleggio</th>
<td><?php 
if($result->Status==0)
{
echo htmlentities('Non ancora confermato');
} else if ($result->Status==1) {
echo htmlentities('Confermato');
}
 else{
 	echo htmlentities('Cancellato');
 }
										?></td>
										<th>Ultimo Aggiornamento</th>
										<td><?php echo htmlentities($result->dataAgg);?></td>
									</tr>

									<?php if($result->Status==0){ ?>
										<tr>	
										<td style="text-align:center" colspan="4">
				<a href="dettagli-noleggi.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Vuoi davvero confermare il noleggio?')" class="btn btn-primary"> Conferma Noleggio</a> 

<a href="dettagli-noleggi.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Vuoi davvero cancellare il noleggio?')" class="btn btn-danger"> Cancella Noleggio</a>
</td>
</tr>
<?php } ?>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>
								<form method="post">
	   <input name="Submit2" type="submit" class="txtbox4" value="Stampa" onClick="return f3();" style="cursor: pointer;"  />
	</form>

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
	<script language="javascript" type="text/javascript">
function f3()
{
window.print(); 
}
</script>
</body>
</html>
<?php } ?>
