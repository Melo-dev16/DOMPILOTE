<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DOMPilote Smart Home</title>
    <link rel="icon" href="<?=base_url('assets/');?>favicon.png" type="image/png" />
    <script src="https://kit.fontawesome.com/756da74e6d.js" crossorigin="anonymous"></script>
    <style>

  header {
    text-align: center;
    padding: 45px;
  }

  body {
    color: #333;
    font-family: Calibri,sans-serif;
    margin: 0;
  }

  div {
    border-radius: 10px;
    margin: 100px auto 0;
    text-align: center;
  }

  h1 {
    font-size: 34px;
    font-weight: normal;
    line-height: 45px;
    margin-top: 0;
  }

  h3 {
    font-size: 20px;
    font-weight: normal;
    margin-bottom: 10px;
  }

  @media (max-width: 767px) {
    div {
      margin: 75px 20px;
    }
  }

  button {
  font-family: 'Muli', sans-serif;
  -webkit-transition: 0.15s all ease-in-out;
  -o-transition: 0.15s all ease-in-out;
  transition: 0.15s all ease-in-out;
  cursor: pointer; }

  .curve {
  background: #2A3F54;
  color: #fff;
  border-radius: 6px;
  border: none;
  font-size: 16px;
  padding: 15px 30px;
  text-decoration: none; }

</style>
  </head>

  <body>
  <header>
    <img alt="logo" src="<?=base_url('assets/');?>logo.png" width="200" height="50">
  </header>
  <div>
    <h1>Aucun appartement trouvé !</h1>
    <h3>Contactez l'assistance pour plus d'informations</h3><br><br>
    <p>
      <a href="<?=base_url("logout");?>"><button class="curve">Déconnexion <i class="fa fa-sign-out"></i></button></a>
    </p>
  </div>
</body>
</html>
