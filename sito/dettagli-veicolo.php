<?php 
session_start();
include('inclusioni/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate']; 
    $message = $_POST['message'];
    $useremail = $_SESSION['login'];
    $status = 0;  // Lo status iniziale della prenotazione è 0
    $vhid = $_GET['vhid'];
    $bookingno = mt_rand(100000000, 999999999);
    $oggi = date('Y-m-d');

    // Controllo data passato
    if($fromdate < $oggi) {
        echo "<script>
            alert('La data di inizio noleggio non può essere nel passato.');
            setTimeout(function(){
                window.location.href = 'elenco-auto.php';
            }, 500);
        </script>";
        exit;  // interrompe l'esecuzione
    }
        // la data di inizio deve essere prima della data di fine**
    if($fromdate >= $todate) {
        echo "<script>
            alert('La data di inizio noleggio deve essere precedente alla data di fine noleggio.');
            setTimeout(function(){
                window.location.href = 'elenco-auto.php';
            }, 500);
        </script>";
        exit;
    }

    // Aggiunta della condizione sullo status
    $ret = "SELECT * FROM tblnoleggi 
            WHERE 
            (:fromdate BETWEEN date(dataI) AND date(dataF) 
            OR :todate BETWEEN date(dataI) AND date(dataF) 
            OR date(dataI) BETWEEN :fromdate AND :todate) 
            AND IDveicolo = :vhid
            AND Status = 1";  // Aggiungi il controllo sullo status
    
    $query1 = $dbh->prepare($ret);
    $query1->bindParam(':vhid', $vhid, PDO::PARAM_STR);
    $query1->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
    $query1->bindParam(':todate', $todate, PDO::PARAM_STR);
    $query1->execute();
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

    if($query1->rowCount() == 0)
    {
        // Se non ci sono prenotazioni, inserisci la nuova prenotazione
        $sql = "INSERT INTO tblnoleggi(Nnoleggio, userEmail, IDveicolo, dataI, dataF, messaggio, Status) 
                VALUES(:bookingno, :useremail, :vhid, :fromdate, :todate, :message, :status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bookingno', $bookingno, PDO::PARAM_STR);
        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
        $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo "<script>alert('Richiesta noleggio avvenuta con successo.');</script>";
            echo "<script type='text/javascript'> document.location = 'miei-noleggi.php'; </script>";
        }
        else 
        {
            echo "<script>alert('Qualcosa è andato storto. Per favore riprova');</script>";
            echo "<script type='text/javascript'> document.location = 'elenco-auto.php'; </script>";
        }  
    }
    else
    {
        // Se la macchina è già prenotata con status = 1, mostra un messaggio di errore
        echo "<script>
            alert('La macchina è già stata prenotata per questi giorni. Scegli un\'altra data.');
            setTimeout(function(){
                window.location.href = 'elenco-auto.php';
            }, 500);
        </script>";
    }
}
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

<!--Header-->
<?php include('inclusioni/header.php');?>


<?php 
$vhid=intval($_GET['vhid']);
$sql = "SELECT tblauto.*,tblmarchi.marchio,tblmarchi.id as bid from tblauto join tblmarchi on tblmarchi.id=tblauto.marchio where tblauto.id=:vhid";
$query = $dbh -> prepare($sql);
$query->bindParam(':vhid',$vhid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$_SESSION['brndid']=$result->bid;  
?>  

<section id="listing_img_slider">
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage3);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage4);?>" class="img-responsive"  alt="image" width="900" height="560"></div>
  <?php if($result->Vimage5=="")
{

} else {
  ?>
  <div><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage5);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>


<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>$<?php echo htmlentities($result->tariffa);?> </p>Al Giorno
         
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="main_features">
          <ul>
          
            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->anno);?></h5>
              <p>Anno di Immatricolaione</p>
            </li>
            <li> <i class="fa fa-cogs" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->carburante);?></h5>
              <p>Tipo di Carburante</p>
            </li>
       
            <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->posti);?></h5>
              <p>Posti</p>
            </li>
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap"> 
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab">Panoramica del Veicolo </a></li>
          
              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accessori</a></li>
            </ul>
            
            <div class="tab-content"> 
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                
                <p><?php echo htmlentities($result->panoramica);?></p>
              </div>
              
              
              <div role="tabpanel" class="tab-pane" id="accessories"> 
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Accessori</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Aria Condizionata</td>
<?php if($result->aria==1)
{
?>
                      <td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?> 
   <td><i class="fa fa-close" aria-hidden="true"></i></td>
   <?php } ?> </tr>

<tr>
<td>Sistema di Frenata Antibloccaggio</td>
<?php if($result->antibloccaggio==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
                    </tr>

<tr>
<td>Servosterzo</td>
<?php if($result->servosterzo==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   

<tr>

<td>Vetri Elettrici</td>

<?php if($result->vetriE==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   
 <tr>
<td>Lettore CD</td>
<?php if($result->CD==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Sedili in Pelle</td>
<?php if($result->sediliPelle==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Chiusura Centralizzata</td>
<?php if($result->chiusura==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Bloccaggio Elettrico delle Porte</td>
<?php if($result->serratureE==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
                    </tr>
                    <tr>
<td>Assistenza alla Frenata</td>
<?php if($result->frenataAssistita==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php  } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Airbag per il Conducente</td>
<?php if($result->airbagC==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
 </tr>
 
 <tr>
 <td>Airbag per il Passeggero</td>
 <?php if($result->airbagP==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

<tr>
<td>Sensore di Collisione</td>
<?php if($result->sensoreCollisione==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
<?php }} ?>
   
      </div>
      
      <aside class="col-md-3">
      
        <div class="share_vehicle">
          <p>Condividi: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
        </div>
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Noleggia Ora</h5>
          </div>
          <form method="post">
            <div class="form-group">
              <label>Da:</label>
              <input type="date" class="form-control" name="fromdate" placeholder="From Date" required>
            </div>
            <div class="form-group">
              <label>A:</label>
              <input type="date" class="form-control" name="todate" placeholder="To Date" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="Messaggio" required></textarea>
            </div>
          <?php if($_SESSION['login'])
              {?>
              <div class="form-group">
                <input type="submit" class="btn"  name="submit" value="Noleggia Ora">
              </div>
              <?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login Per Noleggiare</a>

              <?php } ?>
          </form>
        </div>
      </aside>
    </div>
    
    <div class="space-20"></div>
    <div class="divider"></div>
    
    <div class="similar_cars">
      <h3>Macchine Simili</h3>
      <div class="row">
<?php 
$bid=$_SESSION['brndid'];
$sql="SELECT tblauto.veicolo,tblmarchi.marchio,tblauto.tariffa,tblauto.carburante,tblauto.anno,tblauto.id,tblauto.posti,tblauto.panoramica,tblauto.Vimage1 from tblauto join tblmarchi on tblmarchi.id=tblauto.marchio where tblauto.marchio=:bid";
$query = $dbh -> prepare($sql);
$query->bindParam(':bid',$bid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>      
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="dettagli-veicolo.php?vhid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->marchio);?> , <?php echo htmlentities($result->veicolo);?></a></h5>
              <p class="list-price">$<?php echo htmlentities($result->tariffa);?></p>
          
              <ul class="features_list">
                
             <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->posti);?> posti</li>
                <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->anno);?></li>
                <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->carburante);?></li>
              </ul>
            </div>
          </div>
        </div>
 <?php }} ?>       

      </div>
    </div>
    
  </div>
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