<?php

class AdminModel extends CI_Model {
    
    public function AutoLogin(){
        $this->load->database();
      
        if($this->input->cookie("__dompilote_email") && $this->input->cookie("__dompilote_token")):
            $email = $this->input->cookie("__dompilote_email");
            $token = $this->input->cookie("__dompilote_token");
            
            $today = date("Y-m-d H:i:s");

            $q = $this->db->select("user.id as id,email,user.name as name, password,role.name as userRole")->from("user")
            ->join("role","user.roleId = role.id")->where("email",$email)
            ->where("token",$token)
            ->where("deletedAt",NULL)
            ->where("disableAt >",$today)->get();
            
            if ($q->num_rows() == 1):
                $userFound = $q->row();
                
                $NewToken = strtotime(date("d-m-y H:i:s")).md5(uniqid(rand(), TRUE));
                $data = ["token" => $NewToken];
                $this->db->where("id",$userFound->id)->update("user",$data);
                $expire = time()+60*60*24*30;
                $this->input->set_cookie('__dompilote_token', $NewToken,$expire);
                $this->input->set_cookie('__dompilote_email', $email,$expire);

                $userData = [
                    '__sess_dompilote_email' => $userFound->email,
                    '__sess_dompilote_id' => $userFound->id,
                    '__sess_dompilote_name' => $userFound->name,
                    '__sess_dompilote_role' => $userFound->userRole
                ];
                $this->session->set_userdata($userData);

                redirect (base_url());
            endif;
        endif;
    }
    
    public function login($email,$mdp,$token) {
        $this->load->database();

        $today = date("Y-m-d H:i:s");

        $q = $this->db->select("user.id as id,email,user.name as name, password,role.name as userRole")->from("user")
        ->join("role","user.roleId = role.id")->where("email",$email)
        ->where("deletedAt",NULL)
        ->where("disableAt >",$today)->get();

        if ($q->num_rows() == 1){
            $userFound = $q->row();

            if (password_verify($mdp,$userFound->password)){
                
                $data = ["token" => $token];
                $this->db->where("id",$userFound->id)->update("user",$data);
                
                $expire = time()+60*60*24*30;
                $this->input->set_cookie('__dompilote_email', $userFound->email,$expire);
                $this->input->set_cookie('__dompilote_token', $token,$expire);

                $userData = [
                    '__sess_dompilote_email' => $userFound->email,
                    '__sess_dompilote_id' => $userFound->id,
                    '__sess_dompilote_name' => $userFound->name,
                    '__sess_dompilote_role' => $userFound->userRole
                ];
                $this->session->set_userdata($userData);

                return true;

            }
            else{
                return false;//Identifiers correct,password wrong
            }
        }
        else{
            return false;//Identifiers incorrect
        }
    }

    public function getAllUsers(){
        $q = $this->db->select("user.id as id,email,user.name as name,role.name as userRole,disableAt,deletedAt")->from("user")
        ->join("role","user.roleId = role.id")->where('deletedAt',NULL)->get()->result();

        return $q;
    }

    public function getUserInfos($userID){
        $q = $this->db->select("user.id as id,email,user.name as name,role.name as userRole,disableAt,deletedAt")->from("user")
        ->join("role","user.roleId = role.id")->where('deletedAt',NULL)->where('user.id',$userID)->get()->row();

        return $q;
    }

    public function getUserApts($userID){
        $user = $this->getUserInfos($userID);
        if($user->userRole == "Super Admin"){
            $q = $this->db->select("*,id as apartementId")->from("apartment")->where('deletedAt',NULL)->get()->result();
        }
        else{
            $q = $this->db->select("*")->from("manage")
            ->join("apartment","apartment.id = manage.apartementId")
            ->where('userId',$userID)->where('deletedAt',NULL)
            ->get()->result();
        }

        return $q;
    }

    public function getApartUsers($aptID){
        $q = $this->db->select("*")->from("manage")
            ->join("user","user.id = manage.userId")
            ->where('apartementId',$aptID)->where('deletedAt',NULL)
            ->get()->result();

        return $q;
    }

    public function addUser($name,$email,$role,$pwd,$disable){
        $data = [
            "name" => $name,
            "email" => $email,
            "roleId" => $role,
            "password" => $pwd,
            "disableAt" => $disable
        ];
        $this->db->insert("user",$data);
    }

    public function deleteUser($userID){
        $today = date("Y-m-d H:i:s");

        $data = [
            "deletedAt" => $today,
        ];
        $this->db->where('id',$userID)->update("user",$data);
    }

    public function deleteAppt($apptID){
        $today = date("Y-m-d H:i:s");

        $data = [
            "deletedAt" => $today,
        ];
        $this->db->where('id',$apptID)->update("apartment",$data);
    }

    public function editUser($userID,$name,$email,$role,$disable){
        $data = [
            "name" => $name,
            "email" => $email,
            "roleId" => $role,
            "disableAt" => $disable
        ];

        $this->db->where('id',$userID)->update("user",$data);
    }

    public function updatePassword($userID,$newPwd){
        $data = [
            "password" => $newPwd
        ];

        $this->db->where('id',$userID)->update("user",$data);
    }

    public function addApartment($aptName,$aptAddr,$aptCmp,$aptState,$aptLong,$aptLat,$aptType,$aptMac,$aptTel1,$aptTel2,$aptBat,$aptStair,$aptFloor,$owner,$techs,$admins){

        $data = [
            "aptName" => $aptName,
            "adress" => $aptAddr,
            "company" => $aptCmp,
            "state" => $aptState,
            "lat" => $aptLat,
            "long" => $aptLong,
            "host" => $aptMac,
            "tel1" => $aptTel1,
            "tel2" => $aptTel2,
            "type" => $aptType,
            "nBat" => $aptBat,
            "nStair" => $aptStair,
            "nFloor" => $aptFloor
        ];
        $this->db->insert("apartment",$data);

        $aptID = $this->db->insert_id();

        //Insertion du proprio
        $this->db->insert("manage",['apartementId'=>$aptID,'userId'=>$owner]);

        //Insertion des technos
        foreach ($techs as $t) {
            $this->db->insert("manage",['apartementId'=>$aptID,'userId'=>$t]);
        }

        //Insertion des managers
        foreach ($admins as $a) {
            $this->db->insert("manage",['apartementId'=>$aptID,'userId'=>$a]);
        }
        
    }

    public function editApartment($aptID,$aptName,$aptAddr,$aptCmp,$aptState,$aptLong,$aptLat,$aptType,$aptMac,$aptTel1,$aptTel2,$aptBat,$aptStair,$aptFloor,$owner,$techs,$admins){

        $data = [
            "aptName" => $aptName,
            "adress" => $aptAddr,
            "company" => $aptCmp,
            "state" => $aptState,
            "lat" => $aptLat,
            "long" => $aptLong,
            "host" => $aptMac,
            "tel1" => $aptTel1,
            "tel2" => $aptTel2,
            "type" => $aptType,
            "nBat" => $aptBat,
            "nStair" => $aptStair,
            "nFloor" => $aptFloor
        ];
        $this->db->where('id',$aptID)->update("apartment",$data);

        //Suppression de tous les gestionnaires

        $this->db->where('apartementId',$aptID)->delete('manage');
        
        //Insertion du proprio
        $this->db->insert("manage",['apartementId'=>$aptID,'userId'=>$owner]);

        //Insertion des technos
        foreach ($techs as $t) {
            $this->db->insert("manage",['apartementId'=>$aptID,'userId'=>$t]);
        }

        //Insertion des managers
        foreach ($admins as $a) {
            $this->db->insert("manage",['apartementId'=>$aptID,'userId'=>$a]);
        }
        
    }

    public function verifyAdminManage($userID,$aptID){
        $q = $this->db->select("*")->from("manage")
        ->where('userId',$userID)->where('apartementId',$aptID)
        ->get()->result();

        if(count($q) > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function getApartementDetails($aptID){
        $q = $this->db->select("*")->from("apartment")
        ->where('id',$aptID)
        ->where('deletedAt',NULL)
        ->get()->result();

        return $q;
    }

    public function getAptRooms($aptID,$room = 'all'){

        if($room == 'all'){
            $rooms = $this->db->select("DISTINCT(room) as single_room")->from("temperature")
        ->where('apartementId',$aptID)->get()->result();
        }
        else{
            $rooms = $this->db->select("DISTINCT(room) as single_room")->from("temperature")
        ->where('apartementId',$aptID)->where('room',$room)->get()->result();
        }

        return $rooms;
    }

    public function getConsigneByRooms($aptID){
        $rooms = $this->db->select("DISTINCT(room) as single_room")->from("temperature")
        ->where('apartementId',$aptID)->get()->result();

        $datas = [];
        $tmp = [];

        foreach ($rooms as $r) {
            $data = $this->db->select("temperature_setpoint_degC as consA,heating_demand as consB,datetime,id")->from("temperature")
            ->where('apartementId',$aptID)->where('room',$r->single_room)
            ->order_by('datetime','DESC')->get()->row();
            
            $tmp['A'] = $data->consA;
            $tmp['B'] = $data->consB;
            $tmp['datetime'] = $data->datetime;
            $tmp['TempID'] = $data->id;

            $datas[$r->single_room] = $tmp;
        }

        return $datas;
    }

    public function getAptRoomsStats($aptID,$room,$date){
        $q = $this->db->select("*")->from("temperature")
        ->where('apartementId',$aptID)->where('room',$room);

        if($date != ''){
            $q = $q->where('datetime <=',$date);
        }

        $data = $q->order_by('datetime', 'DESC')->get()->row();
        return $data;
    }

    public function getDateFromTemps($aptID,$start,$end){
        $q = $this->db->select("DISTINCT(CAST(datetime AS DATE)) as single_date")->from("temperature")->where('apartementId',$aptID)->where('datetime >=',$start)->where('datetime <=',$end)->order_by('single_date', 'ASC')->get()->result();

        //var_dump($q);exit(0);
        return $q;
    }

    public function getAptRoomDetails($aptID,$room,$start,$end){
        $q = $this->db->select("*")->from("temperature")
        ->where('apartementId',$aptID)->where('room',$room);

        if($start != '' && $end != ''){
            $q = $q->where('datetime >=',$start)->where('datetime <=',$end);
        }

        $data = $q->order_by('datetime', 'DESC')->get()->result();
        return $data;
    }

    public function getRoomMeanTemp($aptID,$room,$date){
        $q = $this->db->select("CAST(datetime AS DATE) as temp_date,ROUND(AVG(temperature_air_degC),1) as temp")->from("temperature")->where('apartementId',$aptID)->where('room',$room)->where('CAST(datetime AS DATE) = ',$date)->get()->row();

        if(!isset($q->temp)){
            return 0;
        }
        $temp = $q->temp;

        return $temp;
    }

    public function getRoomKwh($aptID,$room,$date){
        $q = $this->db->select("CAST(datetime AS DATE) as temp_date,SUM(heat_meter_kWh) as kwh")->from("temperature")->where('apartementId',$aptID)->where('room',$room)->where('CAST(datetime AS DATE) = ',$date)->get()->row();

        if(!isset($q->kwh)){
            return 0;
        }
        $k = $q->kwh;

        return $k;
    }

    public function getApartByMac($mac,$info = '*'){
        if($info == '*'){
            $q = $this->db->select("*")->from("apartment")->where('host',$mac)->get()->row();
        }
        else{
            $q = $this->db->select("*")->from("apartment")->where('host',$mac)->get()->row();

            if(isset($q->$info)){
                $q = $q->$info;
            }
            else{
                $q = 0;
            }
        }

        return $q;
    }

    public function addTemperatures($temp){
        $datas = $temp['DATA'];
        $ctrl = $temp['controller'][0];

        $apt = $this->getApartByMac($ctrl['host'],"id");

        if($apt == 0){
            return $ctrl['host'];
        }
        else{
            foreach ($datas as $d) {
                $date = DateTime::createFromFormat('ymdHis', $ctrl['datetime']);
                $datetime = $date->format('Y-m-d H:i:s');
                $myData = [
                    "apartementId" => $apt,
                    "room" => $d['room'],
                    "datetime" => $datetime,
                    "temperature_water_degC" => $d['temperature_water_degC'] ? $d['temperature_water_degC'] : 0,
                    "temperature_air_degC" => $d['temperature_air_degC'] ? $d['temperature_air_degC'] : 0,
                    "end_manual" => $d['end_manual'] ? $d['end_manual'] : 0,
                    "heat_operating_range" => $d['heat_operating_range'] ? $d['heat_operating_range'] : 0,
                    "heat_meter_dl" => $d['heat_meter_dl'] ? $d['heat_meter_dl'] : 0,
                    "heat_meter_kWh" => $d['heat_meter_kWh'] ? $d['heat_meter_kWh'] : 0,
                    "regim" => $d['regim'] ? $d['regim'] : 0,
                    "heater_power" => $d['heater_power'] ? $d['heater_power'] : 0,
                    "valve_diam" => $d['valve_diam'] ? $d['valve_diam'] : 0,
                    "valve_position" => $d['valve_position'] ? $d['valve_position'] : 0,
                    "temperature_setpoint_degC" => $d['temperature_setpoint_degC'] ? $d['temperature_setpoint_degC'] : 0,
                    "heating_demand" => $d['heating_demand'] ? $d['heating_demand'] : 0
                ];
                $this->db->insert("temperature",$myData);
            }

            return 0;
        }
    }

    public function updateCons($tempID,$cons,$val){

        if($cons == 'A'){
            $data = [
                "temperature_setpoint_degC" => $val,
            ];
        }
        else{
            $data = [
                "heating_demand" => $val
            ];
        }
        
        $this->db->where("id",$tempID)->update("temperature",$data);
    }
    
}
