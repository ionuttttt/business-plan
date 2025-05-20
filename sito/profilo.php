<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');
if(strlen($_SESSION['login'])==0)
{ 
    header('location:index.php');
}
else{
    if(isset($_POST['updateprofile']))
    {
        $name = $_POST['fullname'];
        $mobileno = $_POST['mobilenumber'];
        $dob = $_POST['dob'];
        $adress = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $email = $_SESSION['login'];

        // Validazioni
        $error = "";

        if(empty($name)) {
            $error .= "Il nome non può essere vuoto. ";
        }

if(!empty($mobileno) && !preg_match('/^[0-9]{10}$/', $mobileno)) {
    $error .= "Il numero di telefono deve contenere esattamente 10 cifre. ";
}

$dobPattern = '/^(0[1-9]|1[0-9]|2[0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d\d$/';
if(!empty($dob) && !preg_match($dobPattern, $dob)) {
    $error .= "La data di nascita non è valida (formato dd/mm/yyyy). ";
}


        if(empty($error)) {
            try {
                // Inizio transazione
                $dbh->beginTransaction();

                $sql = "UPDATE tblusers SET nome=:name, telefono=:mobileno, nascita=:dob, indirizzo=:adress, citta=:city, paese=:country WHERE EmailId=:email";
                $query = $dbh->prepare($sql);
                $query->bindParam(':name', $name, PDO::PARAM_STR);
                $query->bindParam(':mobileno', $mobileno, PDO::PARAM_STR);
                $query->bindParam(':dob', $dob, PDO::PARAM_STR);
                $query->bindParam(':adress', $adress, PDO::PARAM_STR);
                $query->bindParam(':city', $city, PDO::PARAM_STR);
                $query->bindParam(':country', $country, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();

                // Commit se tutto ok
                $dbh->commit();

                $msg = "Profilo Aggiornato con Successo";

            } catch (Exception $e) {
                // Rollback in caso di errore
                $dbh->rollBack();
                $error = "Errore durante l'aggiornamento: " . $e->getMessage();
            }
        }
        else {
            $msg = $error;
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
        
<!--Header-->
<?php include('inclusioni/header.php');?>
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Il Tuo Profilo</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Profilo</li>
      </ul>
    </div>
  </div>
  <div class="dark-overlay"></div>
</section>


<?php 
$useremail = $_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
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
          <?php echo htmlentities($result->citta);?>&nbsp;<?php echo htmlentities($result->paese);?></p>
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-3 col-sm-3">
        <?php include('inclusioni/barra.php');?>
      <div class="col-md-6 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase underline">Impostazioni Generali</h5> 
          <?php if($error){?><div class="errorWrap"><strong>ERRORE</strong>:<?php echo htmlentities($error); ?> </div><?php } 
          else if($msg){?><div class="succWrap"><strong>SUCCESSO</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
          <form  method="post">
           <div class="form-group">
              <label class="control-label">Data di Registrazione -</label>
             <?php echo htmlentities($result->dataReg);?>
            </div>
             <?php if($result->dataAgg!=""){?>
            <div class="form-group">
              <label class="control-label">Ultimo Aggiornamento il  -</label>
             <?php echo htmlentities($result->dataAgg);?>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="control-label">Nome</label>
              <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->nome);?>" id="fullname" type="text"  required>
            </div>
            <div class="form-group">
              <label class="control-label">Indirizzo Email</label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId);?>" name="emailid" id="email" type="email" required readonly>
            </div>
            <div class="form-group">
              <label class="control-label">Numero di Telefono</label>
              <input class="form-control white_bg" name="mobilenumber" value="<?php echo htmlentities($result->telefono);?>" id="phone-number" type="text" required>
            </div>
            <div class="form-group">
              <label class="control-label">Data di Nascita&nbsp;(dd/mm/yyyy)</label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->nascita);?>" name="dob" placeholder="dd/mm/yyyy" id="birth-date" type="text" >
            </div>
            <div class="form-group">
              <label class="control-label">Indirizzo</label>
              <textarea class="form-control white_bg" name="address" rows="4" ><?php echo htmlentities($result->indirizzo);?></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Paese</label>
              <input class="form-control white_bg"  id="country" name="country" value="<?php echo htmlentities($result->paese);?>" type="text">
            </div>
            <div class="form-group">
              <label class="control-label">Città</label>
              <input class="form-control white_bg" id="city" name="city" value="<?php echo htmlentities($result->citta);?>" type="text">
            </div>
            <?php }} ?>
           
            <div class="form-group">
              <button type="submit" name="updateprofile" class="btn">Salva <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
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
<?php } ?>
