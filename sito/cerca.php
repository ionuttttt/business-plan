<?php 
session_start();
include('inclusioni/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
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

<?php include('inclusioni/header.php');?>

<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Risultati della Ricerca"<?php echo $_POST['searchdata'];?>"</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Noleggio</li>
      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>

<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
<?php 
$searchdata=$_POST['searchdata'];
$sql = "SELECT tblauto.id from tblauto 
join tblmarchi on tblmarchi.id=tblauto.marchio 
where tblauto.veicolo=:search || tblauto.carburante=:search || tblmarchi.marchio=:search || tblauto.anno=:search";
$query = $dbh -> prepare($sql);
$query -> bindParam(':search',$searchdata, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=$query->rowCount();
?>
<p><span><?php echo htmlentities($cnt);?> Risulatati trovati per la tua ricerca</span></p>
</div>
</div>

<?php 
$sql = "SELECT tblauto.*,tblmarchi.marchio,tblmarchi.id as bid from tblauto 
join tblmarchi on tblmarchi.id=tblauto.marchio 
where tblauto.veicolo=:search || tblauto.carburante=:search || tblmarchi.marchio=:search || tblauto.anno=:search";
$query = $dbh -> prepare($sql);
$query -> bindParam(':search',$searchdata, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>
        <div class="product-listing-m gray-bg">
          <div class="product-listing-img"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="Image" /> </a> 
          </div>
          <div class="product-listing-content">
            <h5><a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></a></h5>
            <p class="list-price">$<?php echo htmlentities($result->tariffa);?> Al Giorno</p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->posti);?> posti</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->anno);?></li>
              <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->carburante);?></li>
            </ul>
            <a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>" class="btn">Visualizza Dettagli <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
          </div>
        </div>
      <?php }} ?>
         </div>
      
      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-car" aria-hidden="true"></i> Auto di Recentissima Disponibilità </h5>
          </div>
          <div class="recent_addedcars">
            <ul>
<?php $sql = "SELECT tblauto.*,tblmarchi.marchio,tblmarchi.id as bid from tblauto join tblmarchi on tblmarchi.id=tblauto.marchio order by id desc limit 4";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

              <li class="gray-bg">
                <div class="recent_post_img"> <a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
                <div class="recent_post_title"> <a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></a>
                  <p class="widget_price">$<?php echo htmlentities($result->tariffa);?> Al Giorno</p>
                </div>
              </li>
              <?php }} ?>
              
            </ul>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

<?php include('inclusioni/footer.php');?>

<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<?php include('inclusioni/login.php');?>


<?php include('inclusioni/registratione.php');?>


<?php include('inclusioni/password-dimenticata.php');?>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
