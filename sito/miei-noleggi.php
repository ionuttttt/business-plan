<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?><!DOCTYPE HTML>
<html lang="en">
<head>

<title>EasyCar</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
        
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>
        
<!--Header-->
<?php include('inclusioni/header.php');?>

<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>I Miei Noleggi</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>I Miei Noleggi</li>
      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail ";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
<section class="user_profile inner_pages">
  <div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40">
      <div class="upload_user_logo"> <img src="assets/images/dealer-logo.jpg" alt="image">
      </div>

      <div class="dealer_info">
        <h5><?php echo htmlentities($result->nome);?></h5>
        <p><?php echo htmlentities($result->indirizzo);?><br>
          <?php echo htmlentities($result->citta);?>&nbsp;<?php echo htmlentities($result->paese); }}?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3">
       <?php include('inclusioni/barra.php');?>
   
      <div class="col-md-8 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase underline">I Miei Noleggi </h5>
          <div class="my_vehicles_list">
            <ul class="vehicle_listing">
<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT tblauto.Vimage1 as Vimage1,tblauto.veicolo,tblauto.id as vid,tblmarchi.marchio,tblnoleggi.dataI,tblnoleggi.dataF,tblnoleggi.messaggio,tblnoleggi.Status,tblauto.tariffa,DATEDIFF(tblnoleggi.dataF,tblnoleggi.dataI) as totaldays,tblnoleggi.Nnoleggio from tblnoleggi join tblauto on tblnoleggi.IDveicolo=tblauto.id join tblmarchi on tblmarchi.id=tblauto.marchio where tblnoleggi.userEmail=:useremail order by tblnoleggi.id desc";

$query = $dbh -> prepare($sql);
$query-> bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

<li>
    <h4 style="color:red">Noleggio N#<?php echo htmlentities($result->Nnoleggio);?></h4>
                <div class="vehicle_img"> <a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->vid);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
                <div class="vehicle_title">

                  <h6><a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->vid);?>"> <?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></a></h6>
                  <p><b>Dal </b> <?php echo htmlentities($result->dataI);?> <b>Al </b> <?php echo htmlentities($result->dataF);?></p>
                  <div style="float: left"><p><b>Message:</b> <?php echo htmlentities($result->messaggio);?> </p></div>
                </div>
                <?php if($result->Status==1)
                { ?>
                <div class="vehicle_status"> <a href="#" class="btn outline btn-xs active-btn">Confermato</a>
                           <div class="clearfix"></div>
        </div>

              <?php } else if($result->Status==2) { ?>
 <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Cancellato</a>
            <div class="clearfix"></div>
        </div>
             


                <?php } else { ?>
 <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Non Ancora Confermato</a>
            <div class="clearfix"></div>
        </div>
                <?php } ?>
       
              </li>

<h5 style="color:blue">Fattura</h5>
<table>
  <tr>
    <th>Marca dell'Auto</th>
    <th>Da</th>
    <th>A</th>
    <th>Giorni Totali</th>
    <th>Tariffa Giornaliera</th>
  </tr>
  <tr>
    <td><?php echo htmlentities($result->veicolo);?>, <?php echo htmlentities($result->marchio);?></td>
     <td><?php echo htmlentities($result->dataI);?></td>
      <td> <?php echo htmlentities($result->dataF);?></td>
       <td><?php echo htmlentities($tds=$result->totaldays);?></td>
        <td> <?php echo htmlentities($ppd=$result->tariffa);?></td>
  </tr>
  <tr>
    <th colspan="4" style="text-align:center;"> Totale</th>
    <th><?php echo htmlentities($tds*$ppd);?></th>
  </tr>
</table>
<hr />
              <?php }}  else { ?>
                <h5 style="text-align:center; color:red" >Ancora Nessun Noleggio</h5>
              <?php } ?>
             
         
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('inclusioni/footer.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
<?php } ?>