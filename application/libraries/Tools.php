<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tools
 *
 * @author Cedric Datcha
 */
class Tools {
    
    protected $ci;
    
    public function __construct() {
        $this->ci = & get_instance();
    }
    
    public function verify_admin_logged(){
        if (!$this->ci->session->userdata("__sess_dompilote_id")){
                redirect(base_url());
        }
    }

    public function verify_admin_role($role){
        if(is_array($role)){
            if (!in_array($_SESSION['__sess_dompilote_role'],$role)){
                echo "Accès refusé ! Vous n'avez pas le niveau d'accès nécessaire pour effectuer cette action !";
                exit(0);
            }
        }
        else{
            if ($_SESSION['__sess_dompilote_role'] != $role){
                echo "Accès refusé ! Vous n'avez pas le niveau d'accès nécessaire pour effectuer cette action !";
                exit(0);
            }
        }
    }

    public function dateInFrenchFormat($date,$isTime=false){
        $newFormat = 'd-m-Y';

        if($isTime){
            $newFormat .= ' H:i:s';
        }
        return date($newFormat, strtotime($date));
    }

    public function setNotif($title,$text,$type){
        $script = "
        <script>
            new PNotify({
                  title: \"$title\",
                  text: \"$text\",
                  type: \"$type\",
                  styling: \"bootstrap3\"
                });
        </script>
        ";

        return $script;
    }

    public function verifyAdminManage($aptID){
        if (!($this->ci->admin->verifyAdminManage($this->ci->session->userdata("__sess_dompilote_id"),$aptID)) && ($_SESSION['__sess_dompilote_role'] != "Super Admin")){
            echo "Accès refusé ! Vous ne pouvez pas accéder aux données de cet appartement !";
            exit(0);
        }
    }

    public function slugify($str){
        $newStr = str_replace(' ', '', strtolower($str));
        return $newStr;
    }

    public function random_color_part() {
        $dt = '';
        for($o=1;$o<=3;$o++)
        {
            $dt .= str_pad( dechex( mt_rand( 127, 255 ) ), 2, '0', STR_PAD_LEFT);
        }

        list($r, $g, $b) = sscanf("#".$dt, "#%02x%02x%02x");

        $color['rgb'] = "rgb($r,$g,$b)";
        $color['rgba'] = "rgba($r,$g,$b,0.5)";
        return $color;
    }
    
}
