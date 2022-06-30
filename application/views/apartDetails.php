<?php
  if(count($apartment) > 0){
    foreach($apartment as $apt):

    $data["active"] = 'apart-details';
    $data['title'] = $apt->aptName." - DOMPilote Smart Home";
    ob_start();
?>

<script>
  function random_rgba() {
    var o = Math.round, r = Math.random, s = 255;
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',0.5)';
}
</script>
  
<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2><?=$apt->aptName;?></h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">

        <div class="row" style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
          <div class="col-md-7">
            <?php
              $fullAdress = $apt->adress.", ".$apt->state;

              if($apt->type != NULL){
                $fullAdress .= ', '.$apt->type;
              }

              if($apt->nBat != NULL){
                $fullAdress .= ', Batiment N°'.$apt->nBat;
              }

              if($apt->nStair != NULL){
                $fullAdress .= ', Escalier N°'.$apt->nStair;
              }

              if($apt->nFloor != NULL){
                $fullAdress .= ', Etage N°'.$apt->nFloor;
              }
            ?>
            <p>
              <strong>Adresse Complète:</strong> <?=$fullAdress;?>
            </p>
            <?php
              if($_SESSION['__sess_dompilote_role'] == "Super Admin"){
                  ?>
                      <p>
              <strong>Compagnie:</strong> <?=$apt->company;?>
            </p>
                  <?php
              }
            ?>
            
            <p>
              <strong>Contacts:</strong> <?=$apt->tel1;?>/<?=$apt->tel2;?>
            </p>
          </div>

          <div class="col-md-12">
            <h4>Consignes</h4><br>
            <?php
              $rooms = $this->admin->getAptRooms($apt->id);
              if(count($rooms)>0){
            ?>

<div class="tabset">
              <?php
                  
                  $class = 'checked';
                  foreach($rooms as $r){
                ?>
                <input type="radio" name="tabset" id="<?=$this->tools->slugify($r->single_room);?>-tab" aria-controls="<?=$this->tools->slugify($r->single_room);?>-panel" <?=$class;?>>
                <label for="<?=$this->tools->slugify($r->single_room);?>-tab"><?=$r->single_room;?></label>
              <?php if($class=='checked'){$class = '';}}?>
              
              <div class="tab-panels">

              <?php
                foreach($rooms as $r){
                    foreach($consignes as $key=>$val){
                      if($key == $r->single_room){
                  ?>
                <section id="<?=$this->tools->slugify($r->single_room);?>-tabpanel" class="tab-panel">
                  <p style="font-size: 18px;">Confort: <strong id="consA-<?=$this->tools->slugify($r->single_room);?>"><?=$val['A'];?></strong> <a data-toggle="modal" data-target=".edit-consA-<?=$this->tools->slugify($r->single_room);?>" href="#"><i class="fa fa-edit text-primary"></i></a></p>
                  <p style="font-size: 18px;">Eco: <strong id="consB-<?=$this->tools->slugify($r->single_room);?>"><?=$val['B'];?></strong> <a data-toggle="modal" data-target=".edit-consB-<?=$this->tools->slugify($r->single_room);?>" href="#"><i class="fa fa-edit text-primary"></i></a></p>
                  <br>
                  <p>Dernière mise à jour: <strong><?=$this->tools->dateInFrenchFormat($val['datetime'],true);?></strong></p>
                </section>
                <div class="modal fade edit-consA-<?=$this->tools->slugify($r->single_room);?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modifier la consigne <strong>Confort</strong> de la pièce <strong><?=$r->single_room;?></strong></h4>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <form method="POST" action="<?=base_url('update_consigne');?>">
                              
                              <div class="form-group">
                                <div class="col-md-12">
                                  <input type="number" value="<?=$val['A'];?>" name="value" id="consA-input-<?=$this->tools->slugify($r->single_room);?>" required class="form-control" placeholder="Valeur">
                                </div>
                              </div>

                              <input type="hidden" name="cons" value="A">
                              <input type="hidden" name="tempID" value="<?=$val['TempID'];?>">
                              <input type="hidden" name="aptID" id="aptID" value="<?=$apt->id;?>">
                              <div class="form-group">
                                <div class="col-md-12">
                                  <button style="margin-top: 1.5em;" type="submit" class="btn btn-success">Modifier <i class="fa fa-edit"></i></button>
                                </div>
                              </div>

                            </form>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <div class="modal fade edit-consB-<?=$this->tools->slugify($r->single_room);?>" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-sm">
                    <div class="modal-content">

                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Modifier la consigne <strong>Eco</strong> de la pièce <strong><?=$r->single_room;?></strong></h4>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-12">
                            <form method="POST" action="<?=base_url('update_consigne');?>">
                              
                              <div class="form-group">
                                <div class="col-md-12">
                                  <input type="number" value="<?=$val['B'];?>" name="value" id="consB-input-<?=$this->tools->slugify($r->single_room);?>" required class="form-control" placeholder="Valeur">
                                </div>
                              </div>

                              <input type="hidden" name="cons" value="B">
                              <input type="hidden" name="tempID" value="<?=$val['TempID'];?>">
                              <input type="hidden" name="aptID" id="aptID" value="<?=$apt->id;?>">
                              <div class="form-group">
                                <div class="col-md-12">
                                  <button style="margin-top: 1.5em;" type="submit" class="btn btn-success">Modifier <i class="fa fa-edit"></i></button>
                                </div>
                              </div>

                            </form>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              <?php }} }?>

              </div>
              
            </div>
            
            <?php
              $roomColors = [];
                foreach ($rooms as $r) {
                  $roomColors[$this->tools->slugify($r->single_room)] = $this->tools->random_color_part();
                }
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>
          Température par pièce
          <?php
            if($datetime != ''){
              echo ": <strong>".$this->tools->dateInFrenchFormat($datetime,true)."</strong> <a href='".base_url('apartments/'.$apt->id)."' class='btn btn-sm btn-danger'><i class='fa fa-close'></i></a>";
            }
          ?>
        </h2> 
        <div class="nav navbar-right">
          <form method="GET" class="form-inline" action="<?=base_url('apartments/'.$apt->id);?>">
            <div class="form-group">
                <div class='input-group date' id='appartDP'>
                    <input value="<?=$datetime;?>" name="datetime" required type='text' class="form-control" />
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Valider</button>
          </form>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="usersDatatable" class="dataTable table table-striped table-bordered">
          <thead>
            <tr>
              <?php
                if($_SESSION['__sess_dompilote_role'] != "Utilisateur"){
                  ?>
                  <th>Pièce</th>
                  <th>°C</th>
                  <th>Fin man.</th>
                  <th>%</th>
                  <th>Compteur</th>
                  <th>Kwh</th>
                  <th>Regime</th>
                  <th>Puissance</th>
                  <th>Diamètre</th>
                  <th>V.Pos</th>
                  <?php
                }
                else{
                  ?>
                  <th>Pièce</th>
                  <th>°C</th>
                  <th>Fin manuel</th>
                  <th>Compteur</th>
                  <th>Kwh</th>
                  <?php
                }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $totalKwh = 0;

            if($datetime != ''){
              $datetime = date("Y-m-d H:i:s", strtotime($datetime));
            }

            $rooms = $this->admin->getAptRooms($apt->id);
              if($_SESSION['__sess_dompilote_role'] != "Utilisateur"){
                foreach($rooms as $r):
                  $dt = $this->admin->getAptRoomsStats($apt->id,$r->single_room,$datetime);
                ?>
                  <tr style="background-color: <?=$roomColors[$this->tools->slugify($r->single_room)]['rgb'];?>!important;color:black!important;">
                    <td><a style="color: blue!important;" href="<?=base_url('apartments/'.$apt->id.'/rooms?r='.urlencode($r->single_room));?>"><?=$r->single_room;?></a></td>
                    <td><?=(isset($dt->temperature_air_degC)) ? $dt->temperature_air_degC : '-';?></td>
                    <td><?=(isset($dt->end_manual)) ? $dt->end_manual : '-';?></td>
                    <td><?=(isset($dt->heat_operating_range)) ? $dt->heat_operating_range : '-';?></td>
                    <td><?=(isset($dt->heat_meter_dl)) ? $dt->heat_meter_dl : '-';?></td>
                    <td><?=(isset($dt->heat_meter_kWh)) ? $dt->heat_meter_kWh : '-';?></td>
                    <td><?=(isset($dt->regim)) ? $dt->regim : '-';?></td>
                    <td><?=(isset($dt->heater_power)) ? $dt->heater_power : '-';?></td>
                    <td><?=(isset($dt->valve_diam)) ? $dt->valve_diam : '-';?></td>
                    <td><?=(isset($dt->valve_position)) ? $dt->valve_position : '-';?></td>
                  </tr>
                <?php
                if(isset($dt->heat_meter_kWh)){
                  $totalKwh += $dt->heat_meter_kWh;
                }
                endforeach;
                ?>
                <tr style="background-color: #2A3F54;color: white;">
                  <td>Total</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><?=$totalKwh;?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <?php
              }
              else{
                foreach($rooms as $r):
                  $dt = $this->admin->getAptRoomsStats($apt->id,$r->single_room,$datetime);
                ?>
                  <tr style="background-color: <?=$roomColors[$this->tools->slugify($r->single_room)]['rgb'];?>!important;color:black!important;">
                    <td><a style="color: blue!important;" href="<?=base_url('apartments/'.$apt->id.'/rooms?r='.urlencode($r->single_room));?>"><?=$r->single_room;?></a></td>
                    <td><?=(isset($dt->temperature_air_degC)) ? $dt->temperature_air_degC : '-';?></td>
                    <td><?=(isset($dt->end_manual)) ? $dt->end_manual : '-';?></td>
                    <td><?=(isset($dt->heat_meter_dl)) ? $dt->heat_meter_dl : '-';?></td>
                    <td><?=(isset($dt->heat_meter_kWh)) ? $dt->heat_meter_kWh : '-';?></td>
                  </tr>
                <?php
                if(isset($dt->heat_meter_kWh)){
                  $totalKwh += $dt->heat_meter_kWh;
                }
                endforeach;
                ?>
                <tr style="background-color: #2A3F54;color: white;">
                  <td>Total</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><?=$totalKwh;?></td>
                </tr>
                <?php
              }
            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2 style="overflow: visible;">
          Statistiques
          <?php
            if($start != '' && $end != ''){
              echo "<br><strong style='font-size:15px;'>".$this->tools->dateInFrenchFormat($start,true)."</strong> - <strong style='font-size:15px;'>".$this->tools->dateInFrenchFormat($end,true)."</strong> <a href='".base_url('apartments/'.$apt->id)."' class='btn btn-sm btn-danger'><i class='fa fa-close'></i></a>";
            }
          ?>
        </h2> 
        <div class="nav navbar-right">
          <form method="GET" class="form-inline" action="<?=base_url('apartments/'.$apt->id);?>">
            <div class="form-group">
              <select name="roomStats" class="form-control">
              <option <?= $roomStats == 'all' ? 'selected' : '';?> value="all">Pièce</option>
                <?php foreach($rooms as $r):?>
                <option <?= $roomStats == $r->single_room ? 'selected' : '';?> value="<?=$r->single_room;?>"><?=$r->single_room;?></option>
                <?php endforeach;?>
              </select>
            </div>
            <div class="form-group">
                <div class='input-group date' id='appartDP2'>
                    <input placeholder="Début" value="<?=$start;?>" name="start" required type='text' class="form-control" />
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class='input-group date' id='appartDP3'>
                    <input placeholder="Fin" value="<?=$end;?>" name="end" required type='text' class="form-control" />
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Valider</button>
          </form>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php if($start != '' && $end != ''): ?>
        <div class="row">
          <div class="col-md-12">
            <h3>Statistiques Températures</h3>
            <canvas style="margin-top: 1em;" id="apartChart1"></canvas>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <h3>Consommation Kwh</h3>
          <div id="apartChart2" style="width:100%; height:400px;margin-top: 1em;"></div>
          </div>
        </div>
        <?php else:?>
          <div class="row">
            <div class="col-md-12">
              <p class="text-center">
                <img src="<?=base_url('assets/chart.png');?>" width="80" height="80">
              </p>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>

<?php
  if ($start != '' && $end != '') {
?>
<script type="text/javascript">
  
  window.onload = function() {

    //Graph pie
    var ctx = document.getElementById("apartChart1");
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: [<?php foreach($graphPie['datas'] as $gp_datas){echo "\"".$gp_datas['date']."\",";}?>],
        datasets: [
        <?php foreach($graphPie['rooms'] as $room):?>
        {
          label: "<?=$room;?>",
          backgroundColor: "<?=$roomColors[$room]['rgba'];?>",
          borderColor: "<?=$roomColors[$room]['rgb'];?>",
          pointBorderColor: "#000",
          pointBackgroundColor: "#"+Math.floor(Math.random()*16777215).toString(16),
          pointHoverBackgroundColor: "#"+Math.floor(Math.random()*16777215).toString(16),
          pointHoverBorderColor: "#000",
          pointBorderWidth: 1,
          data: [
            <?php foreach($graphPie['datas'] as $gp_datas){
              echo $gp_datas['data'][$room].",";
            };?>
          ]
        },
        <?php endforeach;?>
        ]
      },
    });
    
    //BAR CHART
    Morris.Bar({
      element: 'apartChart2',
      data: [
        <?php foreach($barChart['datas'] as $datas):?>
        {date: '<?=$datas['date'];?>', <?php foreach($barChart['rooms'] as $room){echo "$room: ".$datas['data'][$room].",";}?>},
      
      <?php endforeach;?>
      ],
      xkey: 'date',
      ykeys: [<?php foreach($barChart['rooms'] as $room){echo "'$room',";}?>],
      barColors: [
        <?php foreach($barChart['rooms'] as $room){echo "\"".$roomColors[$room]['rgb']."\",";}?>
      ],
      hideHover: 'auto',
      labels: [<?php foreach($barChart['rooms'] as $room){echo "'$room',";}?>],
      resize: true
    });

  }
  
</script>
<?php
}

    $data['content'] = ob_get_clean();
    $this->load->view('templates/template.php',$data);

  endforeach;
  }
  else{
    show_404();
  }
?>