<?php
    $data["active"] = 'users';
    $data['title'] = "Utilisateurs - DOMPilote Smart Home";
    ob_start();
?>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Liste des utilisateurs</h2> 
        <ul class="nav navbar-right panel_toolbox">
          <li>
            <a href="#" data-toggle="modal" data-target=".add-modal"><i style="color:blue!important;" class="fa fa-plus"></i></a>
          </li>
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table id="usersDatatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nom</th>
              <th>Email</th>
              <th>Role</th>
              <th>Expire le</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>


          <tbody>
            <?php foreach($users as $u):?>
              <tr>
                <td><a href="#" data-toggle="modal" data-target=".view-modal<?=$u->id;?>" class="text-primary"><?=$u->name;?></a></td>
                <td><?=$u->email;?></td>
                <td><?=$u->userRole;?></td>
                <td><?=$this->tools->dateInFrenchFormat($u->disableAt,true);?></td>
                <td>
                  <?php
                    $today = date("Y-m-d H:i:s");

                    if($today > $u->disableAt){
                      echo "<p class='text-gray'>Expiré</p>";
                    }
                    elseif($u->deletedAt != NULL){
                      echo "<p class='text-danger'>Désactivé</p>"; 
                    }
                    else{
                      echo "<p class='text-success'>Actif</p>";
                    }
                  ?>
                </td>
                <td>
                  <a class="btn btn-sm btn-info" data-toggle="modal" data-target=".edit-modal<?=$u->id;?>" href="#"><i class="fa fa-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" onclick="return confirm('Êtes vous sûr de vouloir supprimer cet utilisateur ?');" href="<?=base_url('delete_user/'.$u->id);?>"><i class="fa fa-trash"></i></a>
                </td>
              </tr>

              <div class="modal fade view-modal<?=$u->id;?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">

                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span>
                      </button>
                      <h4 class="modal-title" id="myModalLabel2">Détails de l'utilisateur</h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-xs-12 widget widget_tally_box">
                          <div class="x_panel">
                            <div class="x_content">
                              <h3 class="name"><?=$u->name;?></h3>
                              <p><strong>Email:</strong> <?=$u->email;?></p>

                              <div class="flex">
                                <ul class="list-inline count2 text-center">
                                  <li>
                                    <h3><i class="fa fa-shield"></i></h3>
                                    <span><?=$u->userRole;?></span>
                                  </li>
                                </ul>
                              </div>
                              <p>
                                <?php
                                  $userApts = $this->admin->getUserApts($u->id);

                                  if(count($userApts) == 0){
                                    echo "Aucun appartement";
                                  }
                                  else{
                                    ?>
                                    Appartements: <br>
                                    <?php
                                    foreach ($userApts as $ua) {
                                      ?>
                                      <strong><a href="<?=base_url('apartments/'.$ua->apartementId);?>"><?=$ua->aptName;?></a></strong><br>
                                      <?php
                                    }
                                  }
                                ?>
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

              <div class="modal fade edit-modal<?=$u->id;?>" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">

                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span>
                      </button>
                      <h4 class="modal-title" id="myModalLabel2">Modifier <strong><?=$u->name;?></strong></h4>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <div class="col-md-12">
                          <form action="<?=base_url('edit_user/'.$u->id);?>" method="POST">
                            
                            <div class="form-group">
                              <div class="col-md-12">
                                <input type="text" name="name" required class="form-control" placeholder="Nom" value="<?=$u->name;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-12">
                                <input value="<?=$u->email;?>" type="email" style="margin-top: 1.5em;" name="email" required class="form-control" placeholder="Adresse E-mail">
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-12">
                                <select style="margin-top: 1.5em;" class="form-control" name="role">
                                  <option <?php if($u->userRole == 'Super Admin'){echo "selected";} ?> value="1">Super Admin</option>
                                  <option <?php if($u->userRole == 'Admin'){echo "selected";} ?> value="2">Admin</option>
                                  <option <?php if($u->userRole == 'Technicien'){echo "selected";} ?> value="3">Technicien</option>
                                  <option <?php if($u->userRole == 'Utilisateur'){echo "selected";} ?> value="4">Utilisateur</option>
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                  <div style="margin-top: 1.5em;" class='input-group date disable_dp'>
                                    <input type='text' value="<?=date("m/d/Y H:i A", strtotime($u->disableAt));?>" required name="disable" placeholder="Date d'expiration" class="form-control" />
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-12">
                                <button style="margin-top: 1.5em;" type="submit" class="btn btn-success">Modifier <i class="fa fa-edit"></i></button>
                              </div>
                            </div>

                          </form>

                          <form action="<?=base_url('update_password/'.$u->id);?>" method="POST">  

                            <div class="form-group">
                              <div class="col-md-12">
                                <h4 style="margin-top: 2.5em;">Changer le mot de passe</h4>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <div class="col-md-12">
                                <input style="margin-top: 1.5em;" type="password" name="pwd" required minlength="8" class="form-control" placeholder="Nouveau mot de passe">
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-12">
                                <input style="margin-top: 1.5em;" type="password" name="confirm" required minlength="8" class="form-control" placeholder="Confirmer le mot de passe">
                              </div>
                            </div>

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
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade add-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close"></i></span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Ajouter un utilisateur</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form method="POST" action="#">
              <h5>Importer un fichier CSV</h5>
              <p>
                <input accept=".xls,.xlsx,.csv" type="file" id="usersExcel" class="form-control">
              </p>
              <p>
                <button id="exportBtn" type="button" onclick="UploadCSV()" class="btn btn-primary btn-sm">Exporter <img alt="loading..." style="margin-bottom: 5px;display: none;" src="<?=base_url('assets/');?>gear.gif" width="20" height="20"></button>
              </p>
            </form>
          </div>
          <div class="col-md-12">
            <h4 class="text-center">OU</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <form action="<?=base_url('add_user');?>" method="POST">
              
              <div class="form-group">
                <div class="col-md-12">
                  <input type="text" name="name" required class="form-control" placeholder="Nom">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input type="email" style="margin-top: 1.5em;" name="email" required class="form-control" placeholder="Adresse E-mail">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <select style="margin-top: 1.5em;" class="form-control" name="role">
                    <option value="1">Super Admin</option>
                    <option value="2">Admin</option>
                    <option value="3">Technicien</option>
                    <option value="4">Utilisateur</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                  <div class="col-md-12">
                    <div style="margin-top: 1.5em;" class='input-group date' id='myDatepicker'>
                      <input type='text' required name="disable" placeholder="Date d'expiration" class="form-control" />
                      <span class="input-group-addon">
                         <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>
                  </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input onkeyup="confirmPwd()" style="margin-top: 1.5em;" type="password" name="pwd" id="pwd" required minlength="8" class="form-control" placeholder="Mot de passe">
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <input onkeyup="confirmPwd()" style="margin-top: 1.5em;" type="password" name="confirm" id="confirm" required minlength="8" class="form-control" placeholder="Confirmer le mot de passe">
                </div>
                <div class="col-md-12">
                  <p class="text-danger" id="pwdConfirmAlert" style="display: none;">Les mots de passe ne correspondent pas !</p>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-12">
                  <button id="submitBtn" style="margin-top: 1.5em;" type="submit" class="btn btn-success" disabled>Ajouter <i class="fa fa-plus"></i></button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<?php
    $data['content'] = ob_get_clean();
    $this->load->view('templates/template.php',$data);
?>