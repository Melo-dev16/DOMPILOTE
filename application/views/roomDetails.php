<?php
    foreach($apartment as $apt):

    $data["active"] = 'room-details';
    $data['title'] = $room." - ".$apt->aptName." - DOMPilote Smart Home";
    ob_start();
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>
          <?=$apt->aptName;?> - <strong><?=$room;?></strong>
          <?php
            if($start != '' && $end != ''){
              echo ": <strong>".$this->tools->dateInFrenchFormat($start,true)."</strong> - <strong>".$this->tools->dateInFrenchFormat($end,true)."</strong> <a href='".base_url('apartments/'.$apt->id."/rooms?r=".$room)."' class='btn btn-sm btn-danger'><i class='fa fa-close'></i></a>";
            }
          ?>
        </h2> 
        <div class="nav navbar-right">
          <form method="GET" class="form-inline" action="<?=base_url('apartments/'.$apt->id.'/rooms');?>">
            <input type="hidden" name="r" value="<?=$room;?>">
            <div class="form-group">
                <div class='input-group date' id='appartDP'>
                    <input placeholder="Début" value="<?=$start;?>" name="start" required type='text' class="form-control" />
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class='input-group date' id='appartDP2'>
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
        <table id="usersDatatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <?php
                if($_SESSION['__sess_dompilote_role'] != "Utilisateur"){
                  ?>
                  <th>Date</th>
                  <th>°C</th>
                  <th>Fin manuel</th>
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
                  <th>Date</th>
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
              if($_SESSION['__sess_dompilote_role'] != "Utilisateur"){
                foreach($stats as $dt):
                ?>
                  <tr>
                    <td><?=$this->tools->dateInFrenchFormat($dt->datetime,true);?></td>
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
                endforeach;
              }
              else{
                foreach($stats as $dt):
                ?>
                  <tr>
                    <td><?=$this->tools->dateInFrenchFormat($dt->datetime,true);?></td>
                    <td><?=(isset($dt->temperature_air_degC)) ? $dt->temperature_air_degC : '-';?></td>
                    <td><?=(isset($dt->end_manual)) ? $dt->end_manual : '-';?></td>
                    <td><?=(isset($dt->heat_meter_dl)) ? $dt->heat_meter_dl : '-';?></td>
                    <td><?=(isset($dt->heat_meter_kWh)) ? $dt->heat_meter_kWh : '-';?></td>
                  </tr>
                <?php
                endforeach;
              }
            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
    $data['content'] = ob_get_clean();
    $this->load->view('templates/template.php',$data);

  endforeach;
?>