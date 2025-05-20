<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
  .footer-top {
    padding: 20px 0;
    background-color: #2a2a2a; 
    color: #fff;
    font-size: 13px;
  }

  .footer-top ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
  }

  .footer-top li {
    margin-bottom: 6px;
    display: flex;
    align-items: center;
  }

  .footer-top li i {
    margin-right: 6px;
    color: #bbb;
    font-size: 14px;
  }

  .footer-top li a {
    color: #ddd;
    text-decoration: none;
  }

  .footer-top li a:hover {
    text-decoration: underline;
    color: #fff;
  }

  .footer-bottom {
    background-color: #1f1f1f; 
    padding: 15px 0;
    font-size: 13px;
    color: #ccc;
  }

  .footer_widget ul {
    list-style: none;
    padding-left: 0;
    display: flex;
    gap: 10px;
    margin: 0;
  }

  .footer_widget a {
    color: #ccc;
    font-size: 18px;
    transition: color 0.3s;
  }

  .footer_widget a:hover {
    color: #fff;
  }

  .copy-right {
    margin-top: 8px;
    color: #aaa;
  }

  @media (max-width: 576px) {
    .footer_widget {
      text-align: left !important;
      margin-top: 15px;
    }
  }
</style>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <ul>
            <li><i class="fa fa-info-circle"></i><a href="pagina.php?type=aboutus">Chi Siamo</a></li>
            <li><i class="fa fa-shield"></i><a href="pagina.php?type=privacy">Privacy</a></li>
            <li><i class="fa fa-file-text"></i><a href="pagina.php?type=terms">Termini di Servizio</a></li>
            <li><i class="fa fa-lock"></i><a href="admin/">Admin Login</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-push-6 text-right">
          <div class="footer_widget">
            <p>Contattaci su:</p>
            <ul>
              <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-md-pull-6">
          <p class="copy-right">EasyCar.</p>
        </div>
      </div>
    </div>
  </div>
</footer>