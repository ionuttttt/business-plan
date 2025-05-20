<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

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
		<?php include('inclusioni/barra.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Noleggi Confermati</h2>

						<div class="panel panel-default">
							<div class="panel-heading">Info Noleggi</div>
							<div class="panel-body">

								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
										<th>Nome</th>
											<th>Numero Noleggio</th>
											<th>Veicolo</th>
											<th>Da</th>
											<th>A</th>
											<th>Status</th>
											<th>Data di Pubblicazione</th>
											<th>Azioni</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
										<th>Nome</th>
											<th>Numero Noleggio</th>
											<th>Veicolo</th>
											<th>Da</th>
											<th>A</th>
											<th>Status</th>
											<th>Data di Pubblicazione</th>
											<th>Azioni</th>
										</tr>
									</tfoot>
									<tbody>

									<?php 

$status=1;
$sql = "SELECT tblusers.nome,tblmarchi.marchio,tblauto.veicolo,tblnoleggi.dataI,tblnoleggi.dataF,tblnoleggi.messaggio,tblnoleggi.IDveicolo as vid,tblnoleggi.Status,tblnoleggi.data,tblnoleggi.id,tblnoleggi.Nnoleggio  
from tblnoleggi join tblauto on tblauto.id=tblnoleggi.IDveicolo join tblusers on tblusers.EmailId=tblnoleggi.userEmail join tblmarchi on tblauto.marchio=tblmarchi.id where tblnoleggi.Status=:status";

$query = $dbh -> prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
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
											<td><?php echo htmlentities($result->Nnoleggio);?></td>
											<td><a href="edit-veicolo.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></td>
											<td><?php echo htmlentities($result->dataI);?></td>
											<td><?php echo htmlentities($result->dataF);?></td>
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
											<td><?php echo htmlentities($result->data);?></td>
										<td>


<a href="dettagli-noleggi.php?bid=<?php echo htmlentities($result->id);?>"> Visualizza</a>
</td>

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
