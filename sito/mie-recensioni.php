
<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?>
<!DOCTYPE HTML>
<html lang="en">
<head>

<title>EasyCar </title>
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
        <h1>Le Mie Recensioni</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Le Mie Recensioni</li>
      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail";
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
          <h5 class="uppercase underline">Le Mie Recensioni </h5>
          <div class="my_vehicles_list">
            <ul class="vehicle_listing">
<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tbltestimonianze where UserEmail=:useremail";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($cnt=$query->rowCount() > 0)
{
foreach($results as $result)
{ ?>

              <li>
           
                <div>
                 <p><?php echo htmlentities($result->recensione);?> </p>
                   <p><b>Data:</b><?php echo htmlentities($result->data);?> </p>
                </div>
                <?php if($result->status==1){ ?>
                 <div class="vehicle_status"> <a class="btn outline btn-xs active-btn">Attivo</a>

                  <div class="clearfix"></div>
                  </div>
                  <?php } else {?>
               <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">In Attesa Di Approvazione</a>
                  <div class="clearfix"></div>
                  </div>
                  <?php } ?>
              </li>
              <?php } } ?>
              
            </ul>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<<!--Footer -->
<?php include('inclusioni/footer.php');?>

<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
<?php } ?>