<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function index()
    {
        if ($this->session->userdata("__sess_dompilote_id")){
            $apts = $this->admin->getUserApts($this->session->userdata("__sess_dompilote_id"));
            if (count($apts) > 0) 
            {
                foreach ($apts as $a) {
                    redirect(base_url('apartments/'.$a->apartementId));
                }
            }
            else{
                $this->load->view('dashboard');
            }
        }
        else{
            $this->admin->AutoLogin();
            $this->load->view('login');
        }
    }
    
    public function login()
    {
        $email = $this->input->post("email");
        $pass = $this->input->post("pwd");

        $ticket = strtotime(date("d-m-y H:i:s")).md5(uniqid(rand(), TRUE));

        if($this->admin->login($email,$pass,$ticket)){

            echo json_encode(['token'=>$ticket]);
        }
        else{
            echo json_encode(["token"=> -1]);
        }
    }
    
    public function logout()
    {
        $this->tools->verify_admin_logged();
        $this->session->unset_userdata("__sess_dompilote_name");
        $this->session->unset_userdata("__sess_dompilote_email");
        $this->session->unset_userdata("__sess_dompilote_id");
        $this->session->unset_userdata("__sess_dompilote_role");
        
        delete_cookie('__dompilote_token');
        delete_cookie('__dompilote_email');
        redirect(base_url());
    }

    public function importUsers(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role('Super Admin');

        $users = $_POST['Feuil1'];

        $i = 0;
        foreach ($users as $u) {
            $name = $u['name'];
            $email = $u['email'];
            $pwd = password_hash($u['password'], PASSWORD_DEFAULT);
            $disable = date("Y-m-d H:i:s",strtotime("+3 month", strtotime(date("Y-m-d H:i:s"))));

            if(isset($u['disable']) && !is_numeric($u['disable'])){
                $disable = date("Y-m-d H:i:s", strtotime($u['disable']));
            }

            if($u['role'] == "Super Admin"){
                $role = 1;
            }
            elseif($u['role'] == "Admin"){
                $role = 2;
            }
            elseif($u['role'] == "Technicien"){
                $role = 3;
            }
            elseif($u['role'] == "Utilisateur"){
                $role = 4;
            }

            $this->admin->addUser($name,$email,$role,$pwd,$disable);
            $i++;
        }

        $this->session->set_flashdata('alert',['title'=>'Exportation réussie','text'=>"$i utilisateurs ajoutés",'type'=>'success']);
    }

    public function showUsers(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role('Super Admin');

        $data['users'] = $this->admin->getAllUsers();

        $this->load->view('users',$data);
    }

    public function addUser(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role('Super Admin');

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $pwd = password_hash($this->input->post('pwd'), PASSWORD_DEFAULT);
        $disable = date("Y-m-d H:i:s", strtotime($this->input->post('disable')));

        $this->admin->addUser($name,$email,$role,$pwd,$disable);

        $this->session->set_flashdata('alert',['title'=>'Utilisateur ajouté !','text'=>"<strong>$name</strong> a bien été ajouté.",'type'=>'success']);
        redirect(base_url('users'));
    }

    public function deleteUser(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role('Super Admin');

        $userID = $this->uri->segment(2);

        $this->admin->deleteUser($userID);

        $this->session->set_flashdata('alert',['title'=>'Utilisateur supprimé !','text'=>"L'utilisateur a bien été supprimé.",'type'=>'success']);
        redirect(base_url('users'));   
    }

    public function editUser(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role('Super Admin');

        $userID = $this->uri->segment(2);

        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $disable = date("Y-m-d H:i:s", strtotime($this->input->post('disable')));

        $this->admin->editUser($userID,$name,$email,$role,$disable);

        $this->session->set_flashdata('alert',['title'=>'Utilisateur édité !','text'=>"Les informations de l'utilisateur ont été mis à jour",'type'=>'success']);
        redirect(base_url('users'));   
    }

    public function passwordUpdate(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role('Super Admin');

        $userID = $this->uri->segment(2);

        $pwd = $this->input->post('pwd');
        $confirm = $this->input->post('confirm');

        if ($pwd != $confirm) {
            $this->session->set_flashdata('alert',['title'=>'Erreur de confirmation','text'=>"Mot de passe non confirmé ! veuillez réessayer.",'type'=>'error']);
        }
        else{
            $this->admin->updatePassword($userID,password_hash($pwd, PASSWORD_DEFAULT));

        $this->session->set_flashdata('alert',['title'=>'Action éffectuée !','text'=>"Mot de passe modifié avec succès",'type'=>'success']);
        }
        
        redirect(base_url('users')); 
    }

    public function Apartments(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role(['Super Admin','Admin']);

        $data['users'] = $this->admin->getAllUsers();
        $this->load->view('apartments',$data);
    }

    public function addApartment(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role(['Super Admin','Admin']);

        $aptName = $this->input->post('aptName');
        $aptAddr = $this->input->post('aptAddr');
        $aptCmp = $this->input->post('aptCmp');
        $aptState = $this->input->post('aptState');
        $aptLong = $this->input->post('aptLong');
        $aptLat = $this->input->post('aptLat');
        $aptType = $this->input->post('aptType');
        $aptMac = $this->input->post('aptMac');
        $aptTel1 = $this->input->post('aptTel1');
        $aptTel2 = $this->input->post('aptTel2');
        $aptBat = $this->input->post('aptBat');
        $aptStair = $this->input->post('aptStair');
        $aptFloor = $this->input->post('aptFloor');
        $owner = $this->input->post('owner');
        $techs = $this->input->post('techs');
        $admins = $this->input->post('admins');

        $this->admin->addApartment($aptName,$aptAddr,$aptCmp,$aptState,$aptLong,$aptLat,$aptType,$aptMac,$aptTel1,$aptTel2,$aptBat,$aptStair,$aptFloor,$owner,$techs,$admins);

        $this->session->set_flashdata('alert',['title'=>'Appartement ajouté !','text'=>"<strong>$aptName</strong> a bien été ajouté.",'type'=>'success']);
        redirect(base_url('apartments'));
    }

    public function editAppt(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role(['Super Admin','Admin']);

        $aptID = $this->uri->segment(2);
        $aptName = $this->input->post('aptName');
        $aptAddr = $this->input->post('aptAddr');
        $aptCmp = $this->input->post('aptCmp');
        $aptState = $this->input->post('aptState');
        $aptLong = $this->input->post('aptLong');
        $aptLat = $this->input->post('aptLat');
        $aptType = $this->input->post('aptType');
        $aptMac = $this->input->post('aptMac');
        $aptTel1 = $this->input->post('aptTel1');
        $aptTel2 = $this->input->post('aptTel2');
        $aptBat = $this->input->post('aptBat');
        $aptStair = $this->input->post('aptStair');
        $aptFloor = $this->input->post('aptFloor');
        $owner = $this->input->post('owner');
        $techs = $this->input->post('techs');
        $admins = $this->input->post('admins');

        
        $this->admin->editApartment($aptID,$aptName,$aptAddr,$aptCmp,$aptState,$aptLong,$aptLat,$aptType,$aptMac,$aptTel1,$aptTel2,$aptBat,$aptStair,$aptFloor,$owner,$techs,$admins);

        $this->session->set_flashdata('alert',['title'=>'Appartement Modifié !','text'=>"<strong>$aptName</strong> a bien été modifié.",'type'=>'success']);
        redirect(base_url('apartments'));
    }

    public function deleteAppt(){
        $this->tools->verify_admin_logged();
        $this->tools->verify_admin_role(['Super Admin','Admin']);

        $apptID = $this->uri->segment(2);

        $this->admin->deleteAppt($apptID);

        $this->session->set_flashdata('alert',['title'=>'Appartement supprimé !','text'=>"L'appartement a bien été supprimé.",'type'=>'success']);
        redirect(base_url('apartments'));   
    }

    public function apartmentDetails(){
        $this->tools->verify_admin_logged();

        $aptID = $this->uri->segment(2);

        $this->tools->verifyAdminManage($aptID);

        $data['datetime'] = '';
        $data['start'] = '';
        $data['end'] = '';

        if(isset($_GET['datetime'])){
            $data['datetime'] = $_GET['datetime'];
        }

        if(isset($_GET['start'])){
            $data['start'] = $_GET['start'];
        }

        if(isset($_GET['end'])){
            $data['end'] = $_GET['end'];
        }

        $data['apartment'] = $this->admin->getApartementDetails($aptID);
        $data['consignes'] = $this->admin->getConsigneByRooms($aptID);

        $data['roomStats'] = 'all';
        if($data['start'] != '' && $data['end'] != ''){
            $data['roomStats'] = $_GET['roomStats'];
            foreach($data['apartment'] as $da){
                //Graph Pie
                $data['graphPie'] = [];
                $data['graphPie']['rooms'] = [];
                $data['graphPie']['datas'] = [];

                $rooms = $this->admin->getAptRooms($da->id,$data['roomStats']);

                foreach ($rooms as $r) {
                    array_push($data['graphPie']['rooms'], $this->tools->slugify($r->single_room));
                }

                $dates = $this->admin->getDateFromTemps($da->id,date("Y-m-d H:i:s", strtotime($data['start'])),date("Y-m-d H:i:s", strtotime($data['end'])));
                
                foreach ($dates as $date) {
                    $tmp['date'] = $date->single_date;
                    $tmp['data'] = [];

                    foreach ($rooms as $r) {
                        $temp = $this->admin->getRoomMeanTemp($da->id,$r->single_room,$date->single_date);
                        $tmp['data'][$this->tools->slugify($r->single_room)] = $temp;
                    }
                    array_push($data['graphPie']['datas'],$tmp);
                }

                //Bar Chart
                $data['barChart'] = [];
                $data['barChart']['rooms'] = [];
                $data['barChart']['datas'] = [];

                foreach ($rooms as $r) {
                    array_push($data['barChart']['rooms'], $this->tools->slugify($r->single_room));
                }

                foreach ($dates as $date) {
                    $tmp['date'] = $date->single_date;
                    $tmp['data'] = [];
                    
                    foreach ($rooms as $r) {
                        $temp = $this->admin->getRoomKwh($da->id,$r->single_room,$date->single_date);
                        $tmp['data'][$this->tools->slugify($r->single_room)] = $temp;
                    }
                    array_push($data['barChart']['datas'],$tmp);
                }
            }
        }

        $this->load->view('apartDetails',$data);
    }

    public function roomDetails(){
        $this->tools->verify_admin_logged();

        $aptID = $this->uri->segment(2);

        $this->tools->verifyAdminManage($aptID);

        $data['start'] = '';
        $start = '';
        if(isset($_GET['start'])){
            $data['start'] = $_GET['start'];
            $start = date("Y-m-d H:i:s", strtotime($_GET['start']));
        }

        $data['end'] = '';
        $end = '';
        if(isset($_GET['end'])){
            $data['end'] = $_GET['end'];
            $end = date("Y-m-d H:i:s", strtotime($_GET['end']));
        }

        $room = urldecode($_GET['r']);
        $data['room'] = $room;

        $data['stats'] = $this->admin->getAptRoomDetails($aptID,$room,$start,$end);
        $data['apartment'] = $this->admin->getApartementDetails($aptID);

        $this->load->view('roomDetails',$data);        
    }
    
    public function AddTemperature(){
        if(isset($_REQUEST['json'])){
            $temp = json_decode($_REQUEST['json'],true);
            
            echo json_encode(['response'=>$this->admin->addTemperatures($temp)]);
        }
        else{
            echo json_encode(['response'=>-1]);
        }

    }

    public function updateCons(){
        $aptID = $_POST['aptID'];
        $tempID = $_POST['tempID'];
        $cons = $_POST['cons'];
        $val = $_POST['value'];

        $this->admin->updateCons($tempID,$cons,$val);

        $this->session->set_flashdata('alert',['title'=>'Consigne Modifié !','text'=>"La consigne a bien été modifié.",'type'=>'success']);
        redirect(base_url('apartments/'.$aptID));
    }
}
