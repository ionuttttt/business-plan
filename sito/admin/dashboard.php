<?php
session_start();
error_reporting(0);
include('inclusioni/config.php');

if(strlen($_SESSION['alogin'])==0)
{   
    if(isset($_GET['ajax']) && $_GET['ajax'] == 1) {
        // Se è chiamata ajax e non loggato
        echo json_encode(['error' => 'Non autorizzato']);
        exit;
    } else {
        header('location:index.php');
        exit;
    }
}

// Gestione chiamata AJAX
if(isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    $response = [];
    try {
        $sql = "SELECT COUNT(*) as count FROM tblusers";
        $query = $dbh->prepare($sql);
        $query->execute();
        $response['regusers'] = $query->fetch(PDO::FETCH_OBJ)->count;

        $sql = "SELECT COUNT(*) as count FROM tblauto";
        $query = $dbh->prepare($sql);
        $query->execute();
        $response['totalvehicle'] = $query->fetch(PDO::FETCH_OBJ)->count;

        $sql = "SELECT COUNT(*) as count FROM tblnoleggi";
        $query = $dbh->prepare($sql);
        $query->execute();
        $response['bookings'] = $query->fetch(PDO::FETCH_OBJ)->count;

        $sql = "SELECT COUNT(*) as count FROM tblmarchi";
        $query = $dbh->prepare($sql);
        $query->execute();
        $response['brands'] = $query->fetch(PDO::FETCH_OBJ)->count;

        $sql = "SELECT COUNT(*) as count FROM tblcontattaci";
        $query = $dbh->prepare($sql);
        $query->execute();
        $response['requests'] = $query->fetch(PDO::FETCH_OBJ)->count;

        $sql = "SELECT COUNT(*) as count FROM tbltestimonianze";
        $query = $dbh->prepare($sql);
        $query->execute();
        $response['testimonials'] = $query->fetch(PDO::FETCH_OBJ)->count;

        echo json_encode($response);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
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
</head>

<body>
<?php include('inclusioni/header.php');?>

    <div class="ts-main-content">
<?php include('inclusioni/barra.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Dashboard</h2>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-primary text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-number h1" id="regusers">0</div>
                                                    <div class="stat-panel-title text-uppercase">Registrazioni Utenti</div>
                                                </div>
                                            </div>
                                            <a href="reg-users.php" class="block-anchor panel-footer">Dettagli <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-success text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-number h1" id="totalvehicle">0</div>
                                                    <div class="stat-panel-title text-uppercase">Veicoli Disponibili</div>
                                                </div>
                                            </div>
                                            <a href="gestisci-veicoli.php" class="block-anchor panel-footer text-center">Dettagli &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-info text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-number h1" id="bookings">0</div>
                                                    <div class="stat-panel-title text-uppercase">Noleggi</div>
                                                </div>
                                            </div>
                                            <a href="gestisci-noleggi.php" class="block-anchor panel-footer text-center">Dettagli &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-warning text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-number h1" id="brands">0</div>
                                                    <div class="stat-panel-title text-uppercase">Marchi Disponibili</div>
                                                </div>
                                            </div>
                                            <a href="gestisci-marchi.php" class="block-anchor panel-footer text-center">Dettagli &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-success text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-number h1" id="requests">0</div>
                                                    <div class="stat-panel-title text-uppercase">Richieste</div>
                                                </div>
                                            </div>
                                            <a href="gestisci-richieste.php" class="block-anchor panel-footer text-center">Dettagli &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel panel-default">
                                            <div class="panel-body bk-info text-light">
                                                <div class="stat-panel text-center">
                                                    <div class="stat-panel-number h1" id="testimonials">0</div>
                                                    <div class="stat-panel-title text-uppercase">Recensioni</div>
                                                </div>
                                            </div>
                                            <a href="recensioni.php" class="block-anchor panel-footer text-center">Dettagli &nbsp; <i class="fa fa-arrow-right"></i></a>
                                        </div>
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

    <script>
    $(document).ready(function(){
        function aggiornaContatori() {
            $.ajax({
                url: 'dashboard.php?ajax=1',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (!data.error) {
                        $('#regusers').text(data.regusers);
                        $('#totalvehicle').text(data.totalvehicle);
                        $('#bookings').text(data.bookings);
                        $('#brands').text(data.brands);
                        $('#requests').text(data.requests);
                        $('#testimonials').text(data.testimonials);
                    } else {
                        console.error(data.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Errore AJAX:', error);
                }
            });
        }

        // Aggiorna subito e poi ogni 10 secondi
        aggiornaContatori();
        setInterval(aggiornaContatori, 10000);
    });
    </script>

</body>
</html>

