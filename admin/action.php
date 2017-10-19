<?php
    require_once "./function.php";

$param = $_REQUEST;

$response = array();
if(!isset($param['key'])){
    redirect_url("./index.php");
}

//print_r($param);exit;
switch($param['key']){
    case "login":
        login($param['username'], $param['password']);
        break;
    case "register":
        register($param['username'], $param['password'], $param['email']);
        break;
    case "editProfile":
        editProfile();
        break;
    case "editCategory":
        $id = $param['cid'];
        $catName = $param['catName'];
        $descr = $param['descr'];
        editCategory($id, $catName, $descr);
        break;
    case "delCategory":
        deleteCategory($param['cid']);
        break;
    case "editVenue":
        $new_venue = array("id"=>0,"logo"=>"","venueName"=>"","address"=>"","lot"=>0,"lat"=>0);
        $new_venue['id'] = $param['vid'];
        $new_venue['venueName'] = $param['venueName'];
        $new_venue['address'] = $param['address'];
        $new_venue['lot'] = $param['longitude'];
        $new_venue['lat'] = $param['latitude'];
        editVenue($new_venue);
        break;
    case "delVenue":
        deleteVenue($param['vid']);
        break;
    case "delStream":
        delStream($param['sid']);
        break;
    case "activeStream":
        activeStream($param['sid']);
        break;
    case "deActiveStream":
        deActiveStream($param['sid']);
        break;
    case "delUser":
        delUser($param['uid']);
        break;
    case "activeUser":
        activeUser($param['uid']);
        break;
    case "deActiveUser":
        deActiveUser($param['uid']);
        break;
    case "editSetting":
        if($param['changePassword'] == 0){
            editSetting($param['userName'], 0, "");
        }else{
            editSetting($param['userName'], 1, $param['newPassword']);
        }
        break;
    case "ajax":
        $response = json_encode(adminCalendarEvents($param['venue_id']));
        break;
    default:
        redirect_url("./index.php");
}

echo $response;
exit;
?>