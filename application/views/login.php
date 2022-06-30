<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienvenue sur DOMPilote Smart Home</title>

    <link rel="icon" href="<?=base_url('assets/');?>favicon.png" type="image/png" />

    <!-- Bootstrap -->
    <link href="<?=base_url('assets/');?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=base_url('assets/');?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=base_url('assets/');?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?=base_url('assets/');?>vendors/animate.css/animate.min.css" rel="stylesheet">

    <link href="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=base_url('assets/');?>build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <input type="hidden" id="base_url" value="<?=base_url();?>">
    <div>
      
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="javascript:connect()" method="POST">
              <h1>Bienvenue</h1>
              <div>
                <input id="email" type="email" class="form-control" placeholder="Adresse Email" required />
              </div>
              <div>
                <input id="pwd" type="password" class="form-control" placeholder="Mot de passe" required />
              </div>
              <div>
                <button type="submit" id="loginBtn" class="btn btn-default submit"><span>Connexion</span> <img alt="loading..." style="margin-bottom: 5px;display: none;" src="<?=base_url('assets/');?>radio.gif" width="20" height="20"></button>
                <a class="reset_pass" href="#">Mot de passe oublié ?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />
                <p class="text-center">
                  <img alt="logo" src="<?=base_url('assets/');?>logo.png" width="250" height="70">
                </p>
                <div>
                  <p>&copy; 2022 All Rights Reserved. DOMPilote Smart Home</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>

      </div>
    </div>

    <script src="<?=base_url('assets/');?>vendors/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <script src="<?=base_url('assets/');?>login.js"></script>
    <script>
      $(document).ready(function(){
          $(".disclaimer").hide();
        })
    </script>
  </body>
</html>
