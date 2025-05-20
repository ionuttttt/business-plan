<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_POST['submit']))
  {
$vehicletitle=$_POST['vehicletitle'];
$brand=$_POST['brandname'];
$vehicleoverview=$_POST['vehicalorcview'];
$priceperday=$_POST['priceperday'];
$fueltype=$_POST['fueltype'];
$modelyear=$_POST['modelyear'];
$seatingcapacity=$_POST['seatingcapacity'];
$airconditioner=$_POST['airconditioner'];
$powerdoorlocks=$_POST['powerdoorlocks'];
$antilockbrakingsys=$_POST['antilockbrakingsys'];
$brakeassist=$_POST['brakeassist'];
$powersteering=$_POST['powersteering'];
$driverairbag=$_POST['driverairbag'];
$passengerairbag=$_POST['passengerairbag'];
$powerwindow=$_POST['powerwindow'];
$cdplayer=$_POST['cdplayer'];
$centrallocking=$_POST['centrallocking'];
$crashcensor=$_POST['crashcensor'];
$leatherseats=$_POST['leatherseats'];
$id=intval($_GET['id']);

$sql="update tblauto set veicolo=:vehicletitle,marchio=:brand,panoramica=:vehicleoverview,tariffa=:priceperday,carburante=:fueltype,anno=:modelyear,posti=:seatingcapacity,aria=:airconditioner,serratureE=:powerdoorlocks,antibloccaggio=:antilockbrakingsys,frenataAssistita=:brakeassist,servosterzo=:powersteering,airbagC=:driverairbag,airbagP=:passengerairbag,vetriE=:powerwindow,CD=:cdplayer,chiusura=:centrallocking,sensoreCollisione=:crashcensor,sediliPelle=:leatherseats where id=:id ";
$query = $dbh->prepare($sql);
$query->bindParam(':vehicletitle',$vehicletitle,PDO::PARAM_STR);
$query->bindParam(':brand',$brand,PDO::PARAM_STR);
$query->bindParam(':vehicleoverview',$vehicleoverview,PDO::PARAM_STR);
$query->bindParam(':priceperday',$priceperday,PDO::PARAM_STR);
$query->bindParam(':fueltype',$fueltype,PDO::PARAM_STR);
$query->bindParam(':modelyear',$modelyear,PDO::PARAM_STR);
$query->bindParam(':seatingcapacity',$seatingcapacity,PDO::PARAM_STR);
$query->bindParam(':airconditioner',$airconditioner,PDO::PARAM_STR);
$query->bindParam(':powerdoorlocks',$powerdoorlocks,PDO::PARAM_STR);
$query->bindParam(':antilockbrakingsys',$antilockbrakingsys,PDO::PARAM_STR);
$query->bindParam(':brakeassist',$brakeassist,PDO::PARAM_STR);
$query->bindParam(':powersteering',$powersteering,PDO::PARAM_STR);
$query->bindParam(':driverairbag',$driverairbag,PDO::PARAM_STR);
$query->bindParam(':passengerairbag',$passengerairbag,PDO::PARAM_STR);
$query->bindParam(':powerwindow',$powerwindow,PDO::PARAM_STR);
$query->bindParam(':cdplayer',$cdplayer,PDO::PARAM_STR);
$query->bindParam(':centrallocking',$centrallocking,PDO::PARAM_STR);
$query->bindParam(':crashcensor',$crashcensor,PDO::PARAM_STR);
$query->bindParam(':leatherseats',$leatherseats,PDO::PARAM_STR);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();

$msg="Dati aggiornati con successo";


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
	
	<title>EasyCar</title>

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
					
						<h2 class="page-title">Modifica Veicolo</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Info</div>
									<div class="panel-body">
<?php if($msg){?><div class="succWrap"><strong>SUCCESSO</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
<?php 
$id=intval($_GET['id']);
$sql ="SELECT tblauto.*,tblmarchi.marchio,tblmarchi.id as bid from tblauto join tblmarchi on tblmarchi.id=tblauto.marchio where tblauto.id=:id";
$query = $dbh -> prepare($sql);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Veicolo<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="vehicletitle" class="form-control" value="<?php echo htmlentities($result->veicolo)?>" required>
</div>
<label class="col-sm-2 control-label">Seleziona Marchio<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value="<?php echo htmlentities($result->bid);?>"><?php echo htmlentities($bdname=$result->marchio); ?> </option>
<?php $ret="select id,marchio from tblmarchi";
$query= $dbh -> prepare($ret);
$query-> execute();
$resultss = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($resultss as $results)
{
if($results->marchio==$bdname)
{
continue;
} else{
?>
<option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->marchio);?></option>
<?php }}} ?>

</select>
</div>
</div>
											
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Panoramica del Veicolo<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="vehicalorcview" rows="3" required><?php echo htmlentities($result->panoramica);?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Tariffa Giornaliera($)<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" value="<?php echo htmlentities($result->tariffa);?>" required>
</div>
<label class="col-sm-2 control-label">Seleziona Tipo di Carburante<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="fueltype" required>
<option value="<?php echo htmlentities($result->carburante);?>"> <?php echo htmlentities($result->carburante);?> </option>

<option value="Petrol">Benzina</option>
<option value="Diesel">Diesel</option>
<option value="CNG">Metano</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Anno di Immatricolazione<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="modelyear" class="form-control" value="<?php echo htmlentities($result->anno);?>" required>
</div>
<label class="col-sm-2 control-label">Posti<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" value="<?php echo htmlentities($result->posti);?>" required>
</div>
</div>
<div class="hr-dashed"></div>								
<div class="form-group">
<div class="col-sm-12">
<h4><b>Immagini veicolo</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Immagine 1 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" width="300" height="200" style="border:solid 1px #000">
<a href="cambiaimg1.php?imgid=<?php echo htmlentities($result->id)?>">Cambia Immagine 1</a>
</div>
<div class="col-sm-4">
Immagine 2<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" width="300" height="200" style="border:solid 1px #000">
<a href="cambiaimg2.php?imgid=<?php echo htmlentities($result->id)?>">Cambia Immagine 2</a>
</div>
<div class="col-sm-4">
Immagine 3<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3);?>" width="300" height="200" style="border:solid 1px #000">
<a href="cambiaimg3.php?imgid=<?php echo htmlentities($result->id)?>">Cambia Immagine 3</a>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Immagine 4<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage4);?>" width="300" height="200" style="border:solid 1px #000">
<a href="cambiaimg4.php?imgid=<?php echo htmlentities($result->id)?>">Cambia Immagine 4</a>
</div>
<div class="col-sm-4">
Immagine 5
<?php if($result->Vimage5=="")
{
echo htmlentities("File non disponibile");
} else {?>
<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage5);?>" width="300" height="200" style="border:solid 1px #000">
<a href="cambiaimg5.php?imgid=<?php echo htmlentities($result->id)?>">Cambia Immagine 5</a>
<?php } ?>
</div>

</div>
<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>
	
							

<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">Accessori</div>
<div class="panel-body">


<div class="form-group">
<div class="col-sm-3">
<?php if($result->aria==1)
{?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="airconditioner" checked value="1">
<label for="inlineCheckbox1"> Aria Condizionata </label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="airconditioner" value="1">
<label for="inlineCheckbox1"> Aria Condizionata </label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->serratureE==1)
{?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powerdoorlocks" checked value="1">
<label for="inlineCheckbox2"> Bloccaggio Elettrico delle Porte </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-success checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powerdoorlocks" value="1">
<label for="inlineCheckbox2"> Bloccaggio Elettrico delle Porte </label>
</div>
<?php }?>
</div>
<div class="col-sm-3">
<?php if($result->antibloccaggio==1)
{?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="antilockbrakingsys" checked value="1">
<label for="inlineCheckbox3"> Sistema di Frenata Antibloccaggio </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="antilockbrakingsys" value="1">
<label for="inlineCheckbox3"> Sistema di Frenata Antibloccaggio </label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->frenataAssistita==1)
{
	?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="brakeassist" checked value="1">
<label for="inlineCheckbox3"> Assistenza alla Frenata </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="brakeassist" value="1">
<label  for="inlineCheckbox3"> Assistenza alla Frenata </label>
</div>
<?php } ?>
</div>

<div class="form-group">
<?php if($result->servosterzo==1)
{
	?>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powersteering" checked value="1">
<label for="inlineCheckbox1"> Servosterzo </label>
</div>
<?php } else {?>
<div class="col-sm-3">
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powersteering" value="1">
<label for="inlineCheckbox1"> Servosterzo </label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->airbagC==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="driverairbag" checked value="1">
<label for="inlineCheckbox2">Airbag per il Conducente</label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="driverairbag" value="1">
<label for="inlineCheckbox2">Airbag per il Conducente</label>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->airbagP==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="passengerairbag" checked value="1">
<label for="inlineCheckbox3"> Airbag per il Passeggero</label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="passengerairbag" value="1">
<label for="inlineCheckbox3"> Airbag per il Passeggero </label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->vetriE==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powerwindow" checked value="1">
<label for="inlineCheckbox3"> Vetri Elettrici </label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="powerwindow" value="1">
<label for="inlineCheckbox3"> Vetri Elettrici</label>
</div>
<?php } ?>
</div>


<div class="form-group">
<div class="col-sm-3">
<?php if($result->CD==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="cdplayer" checked value="1">
<label for="inlineCheckbox1"> Lettore CD </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="cdplayer" value="1">
<label for="inlineCheckbox1">Lettore CD </label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->chiusura==1)
{
?>
<div class="checkbox  checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="centrallocking" checked value="1">
<label for="inlineCheckbox2">Chiusura Centralizzata</label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-success checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="centrallocking" value="1">
<label for="inlineCheckbox2">Chiusura Centralizzata</label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->sensoreCollisione==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="crashcensor" checked value="1">
<label for="inlineCheckbox3"> Sensore di Collisione </label>
</div>
<?php } else {?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="crashcensor" value="1">
<label for="inlineCheckbox3"> Sensore di Collisione</label>
</div>
<?php } ?>
</div>
<div class="col-sm-3">
<?php if($result->sediliPelle==1)
{
?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="leatherseats" checked value="1">
<label for="inlineCheckbox3"> Sedili in Pelle </label>
</div>
<?php } else { ?>
<div class="checkbox checkbox-inline">
<input type="checkbox" id="inlineCheckbox1" name="leatherseats" value="1">
<label for="inlineCheckbox3"> Sedili in Pelle</label>
</div>
<?php } ?>
</div>
</div>

<?php }} ?>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2" >
													
<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Salva</button>
												</div>
											</div>

										</form>
									</div>
								</div>
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