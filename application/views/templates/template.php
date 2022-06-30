<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?=base_url('assets/');?>favicon.png" type="image/png" />

    <title><?=$title;?></title>

    <!-- Bootstrap -->
    <link href="<?=base_url('assets/');?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/756da74e6d.js" crossorigin="anonymous"></script>
    <!-- NProgress -->
    <link href="<?=base_url('assets/');?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?=base_url('assets/');?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    
    <!-- bootstrap-progressbar -->
    <link href="<?=base_url('assets/');?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?=base_url('assets/');?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?=base_url('assets/');?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="<?=base_url('assets/');?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">

    <!-- Datatables -->
    <link href="<?=base_url('assets/');?>vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <link href="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="<?=base_url('assets/');?>build/css/custom.min.css" rel="stylesheet">

    <style type="text/css">
      #usersDatatable_filter {
        overflow: hidden;
      }
      .chosen-container{
        width: 100%!important;
      }
    </style>
</head>

<body class="nav-md">
<input type="hidden" id="base_url" value="<?=base_url();?>">
  <?php
    $userApts = $this->admin->getUserApts($_SESSION['__sess_dompilote_id']);
  ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?=base_url();?>" class="site_title"><i class="fas fa-lightbulb"></i> <span>DOMPilote</span></a>
            </div>

            <div class="clearfix"></div>
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                  <?php
                    if($_SESSION['__sess_dompilote_role'] == "Super Admin"){
                        ?>
                            <li><a href="<?=base_url("users");?>"><i class="fa fa-user"></i> Utilisateurs</a>
                          </li>
                        <?php
                    }

                    if($_SESSION['__sess_dompilote_role'] == "Super Admin" || $_SESSION['__sess_dompilote_role'] == "Admin"){
                      ?>
                      <li><a href="<?=base_url("apartments");?>"><i class="fa fa-building"></i> Appartements</a>
                          </li>
                      <?php
                    }

                    foreach($userApts as $ua):
                  ?>
                    <li><a href="<?=base_url('apartments/'.$ua->apartementId);?>"><i class="fa"><?=strtoupper(substr($ua->aptName,0,1));?></i> <?=$ua->aptName;?></a></li>
                  <?php endforeach;?>
                </ul>
              </div>

            </div>
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?=$_SESSION['__sess_dompilote_name'];?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"><i class="fa fa-user"></i> Profil</a></li>
                    <li><a href="<?=base_url("logout");?>"><i class="fa fa-sign-out pull-right"></i> Déconnexion</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <?=$content;?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            DOMPilote &copy; 2022 All Rights Reserved
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    
    <!-- jQuery -->
    <script src="<?=base_url('assets/');?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?=base_url('assets/');?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?=base_url('assets/');?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?=base_url('assets/');?>vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?=base_url('assets/');?>vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?=base_url('assets/');?>vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?=base_url('assets/');?>vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?=base_url('assets/');?>vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?=base_url('assets/');?>vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?=base_url('assets/');?>vendors/Flot/jquery.flot.js"></script>
    <script src="<?=base_url('assets/');?>vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url('assets/');?>vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?=base_url('assets/');?>vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?=base_url('assets/');?>vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?=base_url('assets/');?>vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?=base_url('assets/');?>vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?=base_url('assets/');?>vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?=base_url('assets/');?>vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?=base_url('assets/');?>vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?=base_url('assets/');?>vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?=base_url('assets/');?>vendors/moment/min/moment.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- bootstrap-datetimepicker -->    
    <script src="<?=base_url('assets/');?>vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Datatables -->
    <script src="<?=base_url('assets/');?>vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?=base_url('assets/');?>vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pdfmake/build/vfs_fonts.js"></script>

    <script src="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?=base_url('assets/');?>vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- jQuery Smart Wizard -->
    <script src="<?=base_url('assets/');?>vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

    <!-- morris.js -->
    <script src="<?=base_url('assets/');?>vendors/raphael/raphael.min.js"></script>
    <script src="<?=base_url('assets/');?>vendors/morris.js/morris.min.js"></script>

    <!-- Chart.js -->
    <script src="<?=base_url('assets/');?>vendors/Chart.js/dist/Chart.min.js"></script>

    <!-- jQuery autocomplete -->
    <script src="<?=base_url('assets/');?>vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>

    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?=base_url('assets/');?>build/js/custom.js"></script>
    <script src="<?=base_url('assets/');?>scripts.js?v=1"></script>

    <script>
        if($('#myDatepicker')){
            $('#myDatepicker').datetimepicker({
              defaultDate: "now",
              format: 'DD-MM-YYYY hh:mm',
              sideBySide: true
            });
        }

        if($('#appartDP')){
            $('#appartDP').datetimepicker({
              defaultDate: "now",
              format: 'DD-MM-YYYY hh:mm',
              sideBySide: true
            })
        }

        if($('#appartDP2')){
            $('#appartDP2').datetimepicker({
              defaultDate: "now",
              format: 'DD-MM-YYYY hh:mm',
              sideBySide: true
            })
        }

        if($('#appartDP3')){
            $('#appartDP3').datetimepicker({
              defaultDate: "now",
              format: 'DD-MM-YYYY hh:mm',
              sideBySide: true
            })
        }

        if($('.disable_dp')){
            $('.disable_dp').datetimepicker({
              defaultDate: "now",
              format: 'DD-MM-YYYY hh:mm',
              sideBySide: true
            });
        }

        $(document).ready(function(){
          $(".chosen-select").chosen();

          $("input[name='tabset']").click(function(){
            $(".tab-panel").hide();
            $("#"+this.id+"panel").show();
          });
          $(".disclaimer").hide();
        })
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.min.js"></script>
    <script type="text/javascript">
      function UploadCSV() {
        var files = document.getElementById('usersExcel').files;
        if(files.length==0){
          alert("Please choose any file...");
          return;
        }
        var filename = files[0].name;
        var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
        if (extension == '.XLS' || extension == '.XLSX') {
            $('#usersExcel').prop('disabled','true');
        $('#exportBtn').prop('disabled','true');
        $('#exportBtn img').show();
            excelFileToJSON(files[0]);
        }else{
            alert("Please select a valid excel file.");
        }
      }
       
      //Method to read excel file and convert it into JSON 
      function excelFileToJSON(file){
          try {
            var reader = new FileReader();
            reader.readAsBinaryString(file);
            reader.onload = function(e) {
       
                var data = e.target.result;
                var workbook = XLSX.read(data, {
                    type : 'binary'
                });
                var result = {};
                workbook.SheetNames.forEach(function(sheetName) {
                    var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    if (roa.length > 0) {
                        result[sheetName] = roa;
                    }
                });
                console.log(result);
                importUsersExcel(result);
                }
            }catch(e){
                console.error(e);
            }
      }

      function importUsersExcel(json){
        $.post('<?=base_url('import_users');?>',json,function(res,state){
          if(state == 'success'){
            window.location.replace('<?=base_url('users');?>');
          }
          else{
            new PNotify({
                      title: 'Importation échouée !',
                      text: 'Une erreur est survenue ! Veuillez réessayer !',
                      type: 'error',
                      styling: 'bootstrap3'
                    });
          }

          $('#usersExcel').prop('disabled','');
          $('#exportBtn').prop('disabled','');
          $('#exportBtn img').hide();
        });
      }
    </script>
    <?php
        if(isset($_SESSION['alert'])){
          echo $this->tools->setNotif($_SESSION['alert']['title'],$_SESSION['alert']['text'],$_SESSION['alert']['type']);
        }
    ?>
</body>
</html>