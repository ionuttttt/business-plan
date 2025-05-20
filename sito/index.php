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
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
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

<section id="banner" class="banner-section">
  <div class="container">
    <div class="div_zindex">
      <div class="row">
        <div class="col-md-5 col-md-push-7">
          <div class="banner_content">
            <h1>&nbsp;</h1>
            <p>&nbsp; </p>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="section-padding gray-bg">
  <div class="container">
    <div class="section-header text-center">
      <h2>Trova la migliore <span>Macchina per te</span></h2>
      <p>Siamo il tuo partner ideale per un'esperienza di viaggio senza pensieri. Offriamo una vasta gamma di veicoli moderni e sicuri, pronti a soddisfare ogni tua esigenza, che tu stia pianificando un viaggio di lavoro o una fuga nel weekend. Con EasyCar, noleggiare un'auto è facile, veloce e conveniente. Preparati a partire verso nuove destinazioni con il massimo del comfort e della libertà.</p>
    </div>
    <div class="row"> 
      
      <div class="recent-tab">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">Auto Nuove</a></li>
        </ul>
      </div>
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="resentnewcar">

<?php $sql = "SELECT tblauto.veicolo,tblmarchi.marchio,tblauto.tariffa,tblauto.carburante,tblauto.anno,tblauto.id,tblauto.posti,tblauto.panoramica,tblauto.Vimage1 from tblauto join tblmarchi on tblmarchi.id=tblauto.marchio limit 9";

$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
?>  

<div class="col-list-3">
<div class="recent-car-list">
<div class="car-info-box"> <a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image"></a>
<ul>
<li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->carburante);?></li>
<li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->anno);?> Modello</li>
<li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->posti);?> posti</li>
</ul>
</div>
<div class="car-title-m">
<h6><a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"> <?php echo htmlentities($result->veicolo);?></a></h6>
<span class="price">$<?php echo htmlentities($result->tariffa);?> /al Giorno</span> 
</div>
<div class="inventory_info_m">
<p><?php echo substr($result->panoramica,0,70);?></p>
</div>
</div>
</div>
<?php }}?>
       
      </div>
    </div>
  </div>
</section>

<section class="fun-facts-section">
  <div class="container div_zindex">
    <div class="row">
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-calendar" aria-hidden="true"></i>40+</h2>
            <p>Anni Di Attività</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-car" aria-hidden="true"></i>1200+</h2>
            <p>Auto Nuove In Vendita</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-car" aria-hidden="true"></i>1000+</h2>
            <p>Auto Usante In Vendita</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>600+</h2>
            <p>Clienti Soddisfatti</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>


<section class="section-padding testimonial-section parallex-bg">
  <div class="container div_zindex">
    <div class="section-header white-text text-center">
      <h2>I Nostri Clienti <span>Soddisfatti</span></h2>
    </div>
    <div class="row">
      <div id="testimonial-slider">
<?php 
$tid=1;
$sql = "SELECT tbltestimonianze.recensione,tblusers.nome from tbltestimonianze join tblusers on tbltestimonianze.UserEmail=tblusers.EmailId where tbltestimonianze.status=:tid limit 4";

$query = $dbh -> prepare($sql);
$query->bindParam(':tid',$tid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


        <div class="testimonial-m">
 
          <div class="testimonial-content">
            <div class="testimonial-heading">
              <h5><?php echo htmlentities($result->nome);?></h5>
            <p><?php echo htmlentities($result->recensione);?></p>
          </div>
        </div>
        </div>
        <?php }} ?>
        
       
  
      </div>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>


<!--Footer -->
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