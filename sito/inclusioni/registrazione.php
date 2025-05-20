<?php
if(isset($_POST['signup']))
{
    $fname = trim($_POST['fullname']);
    $email = trim($_POST['emailid']); 
    $mobile = trim($_POST['mobileno']);
    $passwordRaw = $_POST['password'];

    $error = "";

    // Controllo nome
    if(empty($fname)) {
        $error .= "Il nome è obbligatorio. ";
    }

    // Controllo email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "Email non valida. ";
    }

    // Controllo telefono (esatto 10 cifre)
    if(!preg_match('/^[0-9]{10}$/', $mobile)) {
        $error .= "Il numero di telefono deve contenere esattamente 10 cifre. ";
    }

    // Controllo password
    if(empty($passwordRaw)) {
        $error .= "La password è obbligatoria. ";
    }

    if(empty($error)) {
        try {
            $dbh->beginTransaction();

            $password = md5($passwordRaw);

            $sql="INSERT INTO tblusers(nome,EmailId,telefono,Password) VALUES(:fname,:email,:mobile,:password)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':fname',$fname,PDO::PARAM_STR);
            $query->bindParam(':email',$email,PDO::PARAM_STR);
            $query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
            $query->bindParam(':password',$password,PDO::PARAM_STR);
            
            $query->execute();

            $lastInsertId = $dbh->lastInsertId();

            if($lastInsertId) {
                $dbh->commit();
                echo "<script>alert('Registrazione avvenuta con successo.');</script>";
            } else {
                $dbh->rollBack();
                echo "<script>alert('Qualcosa è andato storto. Per favore riprova.');</script>";
            }
        } catch (Exception $e) {
            $dbh->rollBack();
            echo "<script>alert('Errore: " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('Errore: " . addslashes($error) . "');</script>";
    }
}
?>

<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "verifica-disponibilita.php",
        data:'emailid='+$("#emailid").val(),
        type: "POST",
        success:function(data){
            $("#user-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
    });
}
</script>

<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Iscriviti</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="post" name="signup">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Nome" required="required">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Numero di Telefono" maxlength="10" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" onBlur="checkAvailability()" placeholder="Indirizzo Email" required="required">
                  <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="required">
                </div>
          
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">Acconsento <a href="#">Termini e Condizioni</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Iscriviti" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>      
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Hai già un account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login</a></p>
      </div>
    </div>
  </div>
</div>
