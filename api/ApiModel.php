<?php
require_once ("Database.php");

date_default_timezone_set("UTC");

define('SAVE_PHOTO', '../images/');  // save image path
define('DELETE_PHOTO', '../images/');  // delete image path

class ApiModel {

    private $_provider = null;

    private $_host = "";
    private $_google_api_key = "AIzaSyCRSNRos8ahMkjNcMID6cVdDgLYcaUsjVI";

    public function __construct() {
        $this -> _provider = new Database();
    }
    public function __destruct() {
        $this -> _provider = null;
    }
    public static function getInstance() {
        return new ApiModel();
    }
    public function provider() {
        return $this -> _provider;
    }
    private function generate_token($length = 8) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
    }
    public function push_test() {

        // iphone2 35:  4a43f9f6e47fb7899ce28f5a6a46da96c2423472cf6d0d3c15c1ae5c5193619b
        // iphone1 34: 416af4a0d0b05af72f65907872a4b8fcc4c7a5653fc21ffb305daa1eb71f47c8
        $result = $this -> push("95460DB53C0324BCB150FADE4522855DBAD973B98FFA3094CEF28DA0768098DE", array("aps" => array("alert" => "VanityDatingApp push test message")));

        if (!$result)
            echo 'Message not delivered' . PHP_EOL;
        else
            echo 'Message successfully delivered' . PHP_EOL;
    }
    public function push_test_android() {
        $message = "test push message for android";
        $device_id3 = array("APA91bHGahHnTqtdmyeVNdAdo9v5SH5gb29iTw55wm5NWNvY41Ct-qEHxQDvzxbcVvpk6VxUvXc6kvRVDfgmgAuJgty2LyuMc4uID_PrGwKg-TE3YpEtAOo1r4-d1KPTUHMG_Mbbr9St");
        $this->android_push($device_id3, array("message" => $message));
        echo "success";exit;
    }
    private function push($deviceToken, $body = array()) {
        /*
        if ($deviceToken == "")
            return false;
        $deviceToken = strtolower(str_replace(array(" ", "-", "_"), array("", "", ""), $deviceToken));
        $passphrase = '1234';
        ////////////////////////////////////////////////////////////////////////////////

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');

        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        stream_context_set_option($ctx, 'ssl', 'cafile', 'entrust_2048_ca.cer');
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp) {
            return false;
        }
        $payload = json_encode($body);
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        $result = fwrite($fp, $msg, strlen($msg));
        if (!$result)
            return false;
        fclose($fp);
        */
        return true;
    }
    public function android_push($regids, $body = array()) {
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array('registration_ids' => $regids, 'data' => $body);

        $headers = array('Authorization: key=' . $this -> _google_api_key, 'Content-Type: application/json');

        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);
    }
    private function authentication() {
        $headers = apache_request_headers();

        if (isset($headers['Access-Token']) && isset($headers['Device-Id'])) :
            $sql = "select a.account_id, b.state from device a, account b where a.account_id = b.id and a.access_token = '" . $headers['Access-Token'] . "' and a.device_id='" . $headers['Device-Id'] . "'";
            $info = $this -> provider() -> single($sql);
            if (count($info) > 0) :
                switch($info['state']) :
                    case 1 :
                        return $info['account_id'];
                        break;
                    case -1 :
                        echo json_encode(array('success' => 'false', 'error' => "Your account is blocked. Please contact us about this."));
                        exit ;
                        break;
                    case 0 :
                        echo json_encode(array('success' => 'false', 'error' => "Your account is not active yet. Please confirm your mailbox."));
                        exit ;
                        break;
                endswitch;
            else :
                echo json_encode(array('success' => 'false', 'error' => "Access denied."));
                exit ;
            endif;
        else :
            echo json_encode(array('success' => 'false', 'error' => "Access denied."));
            exit ;
        endif;
    }

    /*************************************    account    *****************************************/
    public function login() {
        $password = $this -> provider() -> _db -> real_escape_string($_POST['password']);
        $userName = $this -> provider() -> _db -> real_escape_string($_POST['userName']);
        $device_id = $_POST["device_id"];
        $device_type = $_POST["device_type"];
        $created = time();
        $check = $this -> provider() -> single("select count(*) as count from account where userName = '$userName' or email='$userName'");
        if ($check['count'] > 0) :
            if(count($this -> provider() -> single("select * from account where (userName = '$userName' and password = '".md5($password)."') or ( userName = '$userName' and password = '".md5($password)."')")) > 0){
                $info = $this -> provider() -> single("select * from account where (userName = '$userName' and password = '".md5($password)."') or ( userName = '$userName' and password = '".md5($password)."')") ;
                if (count($info) > 0) :
                    $token = $this -> generate_token(32);
                    /*
                    $count = $this->provider()->single("select count(*) ct  from device where device_id = '$device_id'");
                    if($count['ct'] > 0){
                        $this -> provider() -> execute("delete from device where device_id = '$device_id'");
                    }
                    */
                    $chk_device = $this->provider()->single("select count(*) as ct from device where  account_id = " . $info["id"]);
                    $sql_device = "";
                    if($chk_device['ct'] == 0){
                        $sql_device = "insert into device(account_id, device_type, device_id, access_token, created) values('" . $info["id"] . "', '$device_type', '$device_id', '$token', '$created')";
                    }else{
                        $sql_device = "update device set device_type = '$device_type', device_id = '$device_id', access_token = '$token' where account_id = ".$info['id'];
                    }

                    if(!$this -> provider() -> execute($sql_device)){
                        echo json_encode(array("success" => "0", "message" => "sql error : insert device error."));exit;
                    }
                    echo json_encode(array("success" => "1","Access-Token" => $token, "Device-Id" => $device_id, "userInfo" => $info, "avatar" => $info['avatar']));
                else :
                    echo json_encode(array("success" => "0", "message" => "sql error : user not exist."));exit;
                endif;
            }else{
                echo json_encode(array("success" => "0", "message" => "sql error : password is wrong."));exit;
            }
        else :
            echo json_encode(array("success" => "0", "message" => "There's no account associated with this username."));exit;
        endif;
    }
    public function social_login() {

        $social_id = $this -> provider() -> _db -> real_escape_string($_POST['social_id']);
        $social_type = $this -> provider() -> _db -> real_escape_string($_POST['social_type']);
        $userName = $this -> provider() -> _db -> real_escape_string($_POST['userName']);
        $device_id = $_POST["device_id"];
        $device_type = $_POST["device_type"];
        $created = time();
        $check = $this -> provider() -> single("select count(*) as count from account where userName = '$userName' or email='$userName'");
        if ($check['count'] > 0) :
            if(count($this -> provider() -> single("select * from account where (userName = '$userName' and social_id = '$social_id') or ( userName = '$userName' and social_id = '$social_id')")) > 0){
                $info = $this -> provider() -> single("select * from account where (userName = '$userName' and social_id = '$social_id') or ( userName = '$userName' and social_id = '$social_id')") ;
                if (count($info) > 0) :
                    $token = $this -> generate_token(32);
                    $chk_device = $this->provider()->single("select count(*) as ct from device where  account_id = " . $info["id"]);
                    $sql_device = "";
                    if($chk_device['ct'] == 0){
                        $sql_device = "insert into device(account_id, device_type, device_id, access_token, created) values('" . $info["id"] . "', '$device_type', '$device_id', '$token', '$created')";
                    }else{
                        $sql_device = "update device set device_type = '$device_type', device_id = '$device_id', access_token = '$token' where account_id = ".$info['id'];
                    }
//                    $this -> provider() -> execute("delete from device where account_id = " . $info["id"]);
                    if(!$this -> provider() -> execute($sql_device)){
                        echo json_encode(array("success" => "0", "message" => "sql error : insert device error."));exit;
                    }
                    echo json_encode(array("success" => "1","Access-Token" => $token, "Device-Id" => $device_id, "userInfo" => $info, "avatar" => $info['avatar']));
                else :
                    echo json_encode(array("success" => "0", "message" => "sql error : user not exist."));exit;
                endif;
            }else{
                echo json_encode(array("success" => "0", "message" => "sql error : password is wrong."));exit;
            }
        else :
            echo json_encode(array("success" => "0", "message" => "There's no account associated with this username."));exit;
        endif;
    }
    public function signup() {

        $userName = $_POST["userName"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];
        $userCategory = $_POST['userCategory'];

        $created = time();
        $check = $this -> provider() -> single("select count(*) as count from account where userName='$userName'");

        if ($check["count"] > 0) {
            // exist user
            echo json_encode(array("success" => "0", "message" => "User already exist."));exit;
        } else {
            // new user
            $sql1 = "insert into account( userName, gender, email, password, userCategory, created)
                values( '$userName', $gender, '$email', '".md5($password)."', '$userCategory', '$created')";

            if(!$this -> provider() -> execute($sql1)){
                echo json_encode(array("success" => "0", "message" => "sql error : user register."));exit;
            }
            $newid = $this -> provider() -> _db -> insert_id;
            if (isset($_FILES['avatar'])) { // user profile
                $default = explode(".", $_FILES["avatar"]["name"]);
                $extension = end($default);
                $filename = $this -> generate_token(16) . "." . $extension;
                //echo SAVE_PHOTO . $filename;exit;
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], SAVE_PHOTO ."photo/". $filename)) {
                    if(!$this -> provider() -> execute("update account set avatar = '$filename' where id = $newid")){
                        echo json_encode(array("success" => "0", "message" => "image upload error."));exit;
                    }
                }
                else{
                    $this -> provider() -> execute("delete from account where id = $newid");
                    echo json_encode(array("success" => "0", "message" => "image upload error."));exit;
                }
            }
            echo json_encode(array("success" => "1"));
        }
    }
    public function social_signup() {

        $userName = $_POST["userName"];
        $email = $_POST["email"];
        $social_id = $_POST["social_id"];
        $social_type = $_POST["social_type"];
        $userCategory = $_POST['userCategory'];

        $created = time();
        $check = $this -> provider() -> single("select count(*) as count from account where userName='$userName'");

        if ($check["count"] > 0) {
            // exist user
            echo json_encode(array("success" => "0", "message" => "User already exist."));exit;
        } else {
            // new user
            $sql1 = "insert into account( userName, email, social_id, social_type, userCategory, created)
                values( '$userName', '$email', '$social_id','$social_type', '$userCategory', '$created')";
            if(!$this -> provider() -> execute($sql1)){
                echo json_encode(array("success" => "0", "message" => "sql error : user register."));exit;
            }
            $newid = $this -> provider() -> _db -> insert_id;
            if (isset($_FILES['avatar'])) { // user profile
                $default = explode(".", $_FILES["avatar"]["name"]);
                $extension = end($default);
                $filename = $this -> generate_token(16) . "." . $extension;
                //echo SAVE_PHOTO . $filename;exit;
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], SAVE_PHOTO ."photo/". $filename)) {
                    if(!$this -> provider() -> execute("update account set avatar = '$filename' where id = $newid")){
                        echo json_encode(array("success" => "0", "message" => "image upload error."));exit;
                    }
                }
                else{
                    $this -> provider() -> execute("delete from account where id = $newid");
                    echo json_encode(array("success" => "0", "message" => "image upload error."));exit;
                }
            }
            echo json_encode(array("success" => "1"));
        }
    }
    public function changePassword() {
        $account_id = $this -> authentication();

        $newPass = $_POST['newPass'];
        $oldPass = $_POST['oldPass'];
        $chk = $this->provider()->single("SELECT COUNT(*) AS ct FROM account WHERE id= $account_id AND password = '".md5($oldPass)."'");
        if($chk['ct'] > 0){
            if(!$this -> provider() -> execute("update account set password = '".md5($newPass)."' where id = $account_id")){
                echo json_encode(array("success" => "0", "message" => "sql error : account password update."));exit;
            }
            echo json_encode(array("success" => "1"));
        }else{
            echo json_encode(array("success" => "0", "message" => "Your current password is not correct."));exit;
        }

    }
    public function logout() {

        $account_id = $this -> authentication();
        echo json_encode(array("success" => "1"));
    }
    public function updateProfile() {
        $account_id = $this -> authentication();
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        $userCategory = $_POST['userCategory'];

        $created = time();
        $check = $this -> provider() -> single("select count(*) as count from account where id='$account_id'");

        if ($check["count"] == 0) {
            // exist user
            echo json_encode(array("success" => "0", "message" => "User not exist."));exit;
        } else {
            // update user
            $sql1 = "update account set gender= $gender, email= '$email', userCategory='$userCategory' where id = $account_id";

            if(!$this -> provider() -> execute($sql1)){
                echo json_encode(array("success" => "0", "message" => "sql error : update user fail."));exit;
            }
            if (isset($_FILES['avatar'])) { // user profile
                $default = explode(".", $_FILES["avatar"]["name"]);
                $extension = end($default);
                $filename = $this -> generate_token(16) . "." . $extension;
                //echo SAVE_PHOTO . $filename;exit;
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], SAVE_PHOTO ."photo/". $filename)) {
                    if(!$this -> provider() -> execute("update account set avatar = '$filename' where id = $account_id")){
                        echo json_encode(array("success" => "0", "message" => "image upload error."));exit;
                    }
                }
                else{
                    $this -> provider() -> execute("delete from account where id = $account_id");
                    echo json_encode(array("success" => "0", "message" => "image upload error."));exit;
                }
            }
            $userInfo = $this -> provider() -> single("select * from account where id='$account_id'");
            echo json_encode(array("success" => "1", "userInfo"=>$userInfo));
        }
    }
    public function get_users() {
        $account_id = $this -> authentication();

        $keyword = $_POST['keyword'];
        $offset = $_POST['offset'];
        $from = $offset * 10;

        $sql = "";
        $now = time();
        if($keyword == ""){
            $sql = "SELECT a.id, a.userName, a.avatar, a.gender, a.email, a.userCategory, ($now - a.created) as created, IF(ISNULL(b.id), 0, 1) AS follow
                    FROM account a
                    LEFT JOIN follow b
                    ON a.id = b.follow_id AND b.account_id = $account_id
                    WHERE  a.id != $account_id limit $from, 10 ";
        }else{
            $sql = "SELECT a.id, a.userName, a.avatar, a.gender, a.email, a.userCategory, ($now - a.created) as created, IF(ISNULL(b.id), 0, 1) AS follow
                    FROM account a
                    LEFT JOIN follow b
                    ON a.id = b.follow_id AND b.account_id = $account_id
                    WHERE a.userName LIKE '%$keyword%' and  a.id != $account_id  limit $from, 10 ";
        }

        $result = $this -> provider() -> result($sql);
        $users = array();
        foreach($result as $row){
            $temp = array();
            $user_id = $row['id'];
            $temp['user_info'] = $row;
            $following = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE account_id = $user_id");
            $followed = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE follow_id = $user_id");
            $temp['followed'] = $followed['ct'];
            $temp['following'] = $following['ct'];
            $users[] = $temp;
        }
        if(count($users) > 0){
            echo json_encode(array("success" => "1", "users"=>$users));
        }else{
            echo json_encode(array("success" => "0", "users"=>array()));exit;
        }

    }
    public function get_user() {
        $account_id = $this -> authentication();
        $user_id = $_POST['user_id'];
        $now = time();
        $info = $this->provider()->single("select a.id, a.userName, a.avatar, a.gender, a.email, a.userCategory, ($now - a.created) as created from account a where a.id = $user_id");
        $following = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE account_id = $user_id");
        $followed = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE follow_id = $user_id");

        if(count($info) > 0){
            echo json_encode(array("success" => "1", "user"=>$info, "followed"=>$followed['ct'], "following"=>$following['ct']));
        }else{
            echo json_encode(array("success" => "0", "message"=>"User not exist"));exit;
        }

    }

    /////////////////  follow  ////////////////////////////
    public function follow() {
        $account_id = $this -> authentication();
        $follow_id = $_POST['follow_id'];
        $chk = $this->provider()->single("SELECT COUNT(*) AS chk FROM follow WHERE account_id = $account_id AND follow_id = $follow_id");

        if($chk['chk'] == 0 ){
            $this->provider()->execute("INSERT INTO follow(account_id, follow_id) VALUES($account_id, $follow_id)");
        }

        $now = time();
        // notification
        $device = $this -> provider() -> single("select * from device where account_id = $follow_id ");
        $token = $device['device_id'];
        $info = $this -> provider() -> single("select * from account where id = $account_id");
        $message = $info['userName']." followed you.";
        $data = array("aps" => array(
            "alert" => $message,
            "sender_id" => $account_id,
            "userName" => $info['userName'],
            "photo_url" => $info['avatar'],
            "type" => "follow"
        ));
        if($device['device_type'] == "ios"){
            $this -> push($token, $data);
        }
        // add noti
        $this->provider()->execute("INSERT INTO noti(account_id, receiver_id, noti_type, message, created)
                VALUES( $account_id, $follow_id, 'follow', '$message', '$now')");

        echo json_encode(array("success" => "1"));exit;
    }
    public function unfollow() {
        $account_id = $this -> authentication();
        $unfollow_id = $_POST['unfollow_id'];

        $chk = $this->provider()->single("SELECT COUNT(*) AS chk FROM follow WHERE account_id = $account_id AND follow_id = $unfollow_id");
        if($chk['chk'] > 0 ){
            $this->provider()->execute("delete from follow where account_id = $account_id and follow_id = $unfollow_id");
            echo json_encode(array("success" => "1"));exit;
        }else{

            echo json_encode(array("success" => "1"));exit;
        }
    }
    public function getFollow() {
        $account_id = $this -> authentication();
        $offset = $_POST['offset'];
        $user_id = $_POST['user_id'];
        $limit = $offset * 10;
        $now = time();
        $result = $this->provider()->result("select a.id, a.userName, a.avatar, a.email, a.userCategory, ($now - a.created) as created from account a where a.id in (select follow_id from follow where account_id = $user_id ) LIMIT $limit, 10 ");
        $users = array();
        foreach($result as $row){
            $temp = array();
            $user_id = $row['id'];
            $temp['user_info'] = $row;
            $following = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE account_id = $user_id");
            $followed = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE follow_id = $user_id");
            $temp['followed'] = $followed['ct'];
            $temp['following'] = $following['ct'];
            $users[] = $temp;
        }
        echo json_encode(array( "success" => "1", "users"=>$users ));exit;
    }
    public function getFollowing() {
        $account_id = $this -> authentication();
        $offset = $_POST['offset'];
        $user_id = $_POST['user_id'];
        $limit = $offset * 10;
        $now = time();
        $result = $this->provider()->result("select a.id, a.userName, a.avatar, a.email, a.userCategory, ($now - a.created) as created from account a where a.id in (select account_id from follow where follow_id = $user_id) LIMIT $limit, 10 ");
        $users = array();
        foreach($result as $row){
            $temp = array();
            $user_id = $row['id'];
            $temp['user_info'] = $row;
            $following = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE account_id = $user_id");
            $followed = $this->provider()->single("SELECT COUNT(*) AS ct FROM follow WHERE follow_id = $user_id");
            $temp['followed'] = $followed['ct'];
            $temp['following'] = $following['ct'];
            $users[] = $temp;
        }
        echo json_encode(array( "success" => "1", "users"=>$users ));exit;
    }

    /************************ chat ***************************************************/
    public function get_chat_friends() {
        $account_id = $this -> authentication();
        $offset = $_POST['offset'];
        $limit = $offset * 10;

        $sql_users = "SELECT	DISTINCT CASE WHEN sender_id = $account_id THEN receiver_id ELSE sender_id END AS target_id
                      FROM 	chat WHERE sender_id = $account_id OR receiver_id = $account_id LIMIT $limit, 10";
        $users = $this->_provider->result($sql_users);
        $result = array();
        $now = time();
        foreach($users as $user){
            $temp = array();

            $temp['id'] = $user['target_id'];
            $receiver_id = $user['target_id'];
            $add = "((sender_id = $account_id AND receiver_id= $receiver_id) OR (sender_id = $receiver_id AND receiver_id= $account_id))";
            $sql_count = "SELECT COUNT(*) AS ct FROM chat WHERE $add AND checked = 0";
            $count = $this->provider()->single($sql_count);
            $sql_receiver = "SELECT * FROM account WHERE id = $receiver_id";
            $receiver = $this->provider()->single($sql_receiver);
            $temp['missing_count'] = $count['ct'];
            $sql_last_message = "SELECT message, ($now - created) as created, media_type, link FROM chat WHERE $add ORDER BY created DESC LIMIT 1";
            $message_info = $this->provider()->single($sql_last_message);
            $temp['message_info'] = $message_info;
            $temp['sender_info'] = $receiver;
            $result[] = $temp;
        }
        echo json_encode(array("success"=>"1","result" => $result));

    }
    public function sendMessage() {

        $account_id = $this -> authentication();
        $receiver_id = $_POST['receiver_id'];
        $media_type = $_POST['media_type'];
        $message = $this -> provider() -> _db -> real_escape_string($_POST['message']);

        $now = time();
        if(!$this -> provider() -> execute("insert into chat( sender_id, receiver_id, media_type, message, created) values( $account_id, $receiver_id, 'text','$message', '$now')")){
            echo json_encode(array("success" => "0", "message" => "sql error : chat runtime."));exit;
        }
        $newid = $this -> provider() -> _db -> insert_id;
        $upload_filename = "";
        switch($media_type){
            case "text":
                break;
            case "audio":
                if (isset($_FILES['media'])) { // media audio
                    $default = explode(".", $_FILES["media"]["name"]);
                    $extension = end($default);
                    $filename = $this -> generate_token(16) . "." . $extension;
                    //echo SAVE_PHOTO . $filename;exit;
                    if (move_uploaded_file($_FILES["media"]["tmp_name"], SAVE_PHOTO ."audio/". $filename)) {
                        if(!$this -> provider() -> execute("update chat a set a.link = '$filename', a.media_type = 'audio' where a.id = $newid")){
                            echo json_encode(array("success" => "0", "message" => "audio upload error."));exit;
                        }
                    }
                    else{
                        $this -> provider() -> execute("delete from chat where id = $newid");
                        echo json_encode(array("success" => "0", "message" => "audio upload error."));exit;
                    }
                    $upload_filename = $filename;
                }
                break;
            case "video":
                if (isset($_FILES['media'])) { // media video
                    $default = explode(".", $_FILES["media"]["name"]);
                    $extension = end($default);
                    $filename = $this -> generate_token(16) . "." . $extension;
                    //echo SAVE_PHOTO . $filename;exit;
                    if (move_uploaded_file($_FILES["media"]["tmp_name"], SAVE_PHOTO ."video/". $filename)) {
                        if(!$this -> provider() -> execute("update chat a set a.link = '$filename', a.media_type = 'video' where a.id = $newid")){
                            echo json_encode(array("success" => "0", "message" => "video upload error."));exit;
                        }
                    }
                    else{
                        $this -> provider() -> execute("delete from chat where id = $newid");
                        echo json_encode(array("success" => "0", "message" => "video upload error."));exit;
                    }
                    $upload_filename = $filename;
                }
                break;
            case "photo":
                if (isset($_FILES['media'])) { // media audio
                    $default = explode(".", $_FILES["media"]["name"]);
                    $extension = end($default);
                    $filename = $this -> generate_token(16) . "." . $extension;
                    //echo SAVE_PHOTO . $filename;exit;
                    if (move_uploaded_file($_FILES["media"]["tmp_name"], SAVE_PHOTO ."photo/". $filename)) {
                        if(!$this -> provider() -> execute("update chat a set a.link = '$filename', a.media_type = 'photo' where a.id = $newid")){
                            echo json_encode(array("success" => "0", "message" => "photo upload error."));exit;
                        }
                    }
                    else{
                        $this -> provider() -> execute("delete from chat where id = $newid");
                        echo json_encode(array("success" => "0", "message" => "photo upload error."));exit;
                    }
                    $upload_filename = $filename;
                }
                break;
            default :
                break;

        }

        $device = $this -> provider() -> single("select * from device where account_id = $receiver_id");
        $chat_id = $this->provider()->_db->insert_id;
        $token = $device['device_id'];
        $info = $this -> provider() -> single("select * from account where id = $account_id");
        $data = array("aps" => array(
            "alert" => $message,
            "chat_id" => $chat_id,
            "sender_id" => $account_id,
            "receiver_id" => $receiver_id,
            "userName" => $info['userName'],
            "photo_url" => $info['avatar'],
            "media_type" => $media_type,
            "media_link" => $upload_filename,
            "type" => "chat"
        ));
        $data_android = array(
            "message" => $message,
            "type" => "chat",
            "chat_id" => $chat_id,
            "sender_id" => $account_id,
            "userName" => $info['userName'],
            "sender_photo" => $info['avatar'],
            "media_type" => $media_type,
            "media_link" => $upload_filename
        );
        if($device['device_type'] == "ios"){
            $this -> push($token, $data);
        }elseif($device['device_type'] == "android"){
            $this -> android_push(array($token), $data_android);
        }
        // add noti
        $message = $info['userName']." messaged you.";
        $this->provider()->execute("INSERT INTO noti(account_id, receiver_id, info_id, noti_type, message, created)
                VALUES( $account_id, $receiver_id, $chat_id, 'chat', '$message', '$now')");

        echo json_encode(array("success" => "1","media_type" => $media_type,"media_link" => $upload_filename));
    }
    public function delete_chat_user() {
        $account_id = $this -> authentication();
        $sel_id = $_POST['user_id'];
        $sql = "INSERT INTO block_user(account_id, target_id) VALUES($account_id, $sel_id );";
        if(!$this -> provider() -> execute($sql)){
            echo json_encode(array("success" => "0", "message"=>"sql error : block_user"));
        }
        echo json_encode(array("success" => "1"));
    }
    public function check_message($chk_ids){
        foreach($chk_ids as $key=>$value){
            $chat_id = $value;
            $this -> provider() -> execute("update chat set checked = 1 where id = $chat_id ");
        }
        return true;
    }
    public function checkMessage(){
        $chat_id = $_POST['chat_id'];
        $this->check_message(array("0"=>$chat_id));
        // update noti
        $this -> provider() -> execute("update noti set checked = 1 where noti_type='chat' and info_id = $chat_id ");
        echo json_encode(array("success" => "1"));
    }
    public function get_chatHistory(){
        $account_id = $this -> authentication();
        $receiver_id = $_POST['receiver_id'];
        $last_id = $_POST['last_id'];
        $limit_start = $last_id * 10;

        $now = time();
        $sql = "SELECT a.id, a.sender_id, a.receiver_id, b.userName, IF(ISNULL(b.avatar), '', b.avatar) AS avatar,a.media_type, a.link, a.message, a.checked , ($now - a.created) as created
                FROM chat a left join account b on a.receiver_id = b.id where a.id IN (SELECT id AS chat_id FROM chat WHERE sender_id = $account_id AND receiver_id = $receiver_id
                UNION
                SELECT id AS chat_id FROM chat WHERE sender_id = $receiver_id AND receiver_id = $account_id)  ORDER BY a.id DESC LIMIT $limit_start, 10";

        if($arr = $this->provider()->result($sql)){
            $history = array();
            $chk_ids = array();
            foreach($arr as $row){
                $temp['chat_id'] = $row['id'];
                $chk_ids[] = $row['id'];
                $temp['sender_id'] = $row['sender_id'];
                $temp['userName'] = $row['userName'];
                $temp['receiver_id'] = $row['receiver_id'];
                $temp['avatar'] = $row['avatar'];
                $temp['media_type'] = $row['media_type'];
                $temp['link'] = $row['link'];
                $temp['message'] = $row['message'];
                $temp['checked'] = $row['checked'];
                $temp['created'] = $row['created'];
                $history[] = $temp;
            }
            echo json_encode(array("success" => "1", "history"=> $history));
            $this->check_message($chk_ids);
        }else{
            echo json_encode(array("success" => "1", "history"=>array()));
        }
    }


    /*************************************  category  *************************************************/
    public function getCategories() {
        $account_id = $this -> authentication();
        $offset = $_POST['offset'];
        $from = $offset * 10;
        $sql = "SELECT * FROM categories ORDER BY created DESC LIMIT 0, 10";

        if($result = $this->provider()->result($sql)){
            if(count($result) > 0){
                echo json_encode(array("success" => "1", "categories" => $result));exit;
            }else{
                echo json_encode(array("success" => "1", "categories" => array()));exit;
            }

        }else{
            echo json_encode(array("success" => "0", "message" => "sql : error video"));exit;
        }
    }

    /*************************************  venues  *************************************************/
    public function getVenues() {
        $account_id = $this -> authentication();
        $offset = $_POST['offset'];
        $from = $offset * 10;
        $sql = "SELECT * FROM venues ORDER BY created DESC LIMIT 0, 10";

        if($result = $this->provider()->result($sql)){
            if(count($result) > 0){
                echo json_encode(array("success" => "1", "venues" => $result));exit;
            }else{
                echo json_encode(array("success" => "1", "venues" => array()));exit;
            }

        }else{
            echo json_encode(array("success" => "0", "message" => "sql : error video"));exit;
        }
    }

    /*************************************  Streams *************************************************/
    public function getRecent() {
        $account_id = $this -> authentication();
        $from = 0;

        $now = time();

        // live stream
        $sql_stream = "select id, cat_id, account_id, userName, title, description, reported, blocked, state, ($now-created) as created from streams where state = 1 order by created desc limit $from, 10";
        $result_streams = $this->provider()->result($sql_stream);

        // fun
        $sql_fun = "select id, cat_id, account_id, userName, title, description, reported, blocked, state, ($now-created) as created from categories order by catName desc limit $from, 10";
        $result_fun = $this->provider()->result($sql_fun);

        // venues
        $sql_venues = "select id, cat_id, account_id, userName, title, description, reported, blocked, state, ($now-created) as created from venues order by venueName desc limit $from, 10";
        $result_venues = $this->provider()->result($sql_venues);

        // live stream
        $sql_myStream = "select id, cat_id, account_id, userName, title, description, reported, blocked, state, ($now-created) as created from streams where state = 1 and account_id = $account_id order by created desc limit $from, 10";
        $result_myStream = $this->provider()->result($sql_myStream);

        // follow stream
        $sql_follow = "select id, cat_id, account_id, userName, title, description, reported, blocked, state, ($now-created) as created from streams where state = 1 order by created desc limit $from, 10";
        $result_follow = $this->provider()->result($sql_follow);

        echo json_encode(array("success" => "1", "recent_streams"=>$result_streams,
            "fun"=>$result_fun, "venues"=>$result_venues, "myStreams"=>$result_myStream, "interestStreams"=>$result_follow));exit;

    }
    public function getStreamByCategory() {
        $account_id = $this -> authentication();
        $offset_id = $_POST['offset'];
        $cat_id = $_POST['cat_id'];
        $from = $offset_id * 10;

        $now = time();

        // live stream
        $sql_stream = "SELECT b.catName, b.image as catImage, a.id, a.cat_id, a.account_id, a.userName, a.title, a.description, a.reported, a.blocked, a.state, ($now-a.created) as created  FROM streams a LEFT JOIN categories b ON a.cat_id = b.id
                       WHERE a.state = 1 AND a.cat_id = $cat_id ORDER BY a.created DESC LIMIT $from, 10";
        $result_streams = $this->provider()->result($sql_stream);

        echo json_encode(array("success" => "1", "streams"=>$result_streams));exit;
    }
    public function getStream() {
        $account_id = $this -> authentication();
        $stream_id = $_POST['stream_id'];

        $now = time();

        // live stream
        $sql_stream = "SELECT b.catName, b.image as catImage, a.id, a.cat_id, a.account_id, a.userName, a.title, a.description, a.reported, a.blocked, a.state, ($now-a.created) as created  FROM streams a LEFT JOIN categories b ON a.cat_id = b.id
                       where a.id = $stream_id";
        $tmp_stream = $this->provider()->single($sql_stream);
        $stream = array();
        $sql_comment = "select a.id, a.stream_id, a.account_id, a.message, a.media_type, a.media_link, ($now - a.created) as created, b.userName, b.avatar, b.gender from comments a left join account b on a.account_id = b.id where stream_id = $stream_id order by created desc ";
        $tmp_comment = $this->provider()->result($sql_comment);
        $stream['stream_info'] = $tmp_stream;
        $stream['comments'] = $tmp_comment;
        $s_count = count($tmp_comment);
        $percent = 0;
        $male_count = 0;
        if($s_count > 0){
            foreach($tmp_comment as $tmp){
                if($tmp['gender'] == 1) $male_count++;
            }
            $percent = round($male_count / $s_count, 2);
        }

        echo json_encode(array("success" => "1", "stream"=>$stream, "percent"=>$percent, "total"=>$s_count, "male_count"=>$male_count));exit;
    }

    /************************ notification ***************************************************/
    public function getNotification() {
        $account_id = $this -> authentication();
        $offset = $_POST['offset'];
        $from = $offset * 10;

        $now = time();
        $sql = "SELECT a.id, a.account_id, a.receiver_id, a.info_id, a.noti_type, a.message, a.checked, ($now - a.created) as created, b.userName FROM noti a LEFT JOIN account b ON a.account_id = b.id
                WHERE a.receiver_id = $account_id order by a.created DESC LIMIT $from, 10";
        $result = $this->provider()->result($sql);
        foreach($result as $row){
            $this->provider()->execute("update noti set checked = 1 WHERE id = ".$row['id']);
        }
        echo json_encode(array("success" => "1", "notification"=>$result));exit;
    }
    public function getNotiByCheck() {
        $account_id = $this -> authentication();
        $noti_id = $_POST['noti_id'];

        $now = time();
        $sql = "UPDATE noti SET checked = 1 WHERE id = $noti_id";
        $this->provider()->execute($sql);

        echo json_encode(array("success" => "1"));exit;

    }

    /************************ comment ***************************************************/
    public function comment() {
        $account_id = $this -> authentication();
        $stream_id = $_POST['stream_id'];
        $comment = $_POST['comment'];
        $media_type = $_POST['media_type'];
        $media_link = "";
        $now = time();
        $sql = "INSERT INTO comments(stream_id, account_id, message, created)
                VALUES($stream_id, $account_id, '$comment', '$now')";
        if($result = $this->provider()->execute($sql)){
            $newid = $this -> provider() -> _db -> insert_id;
            switch($media_type){
                case "text":
                    break;
                case "video":
                    if (isset($_FILES['media'])) { // media video
                        $default = explode(".", $_FILES["media"]["name"]);
                        $extension = end($default);
                        $filename = $this -> generate_token(16) . "." . $extension;
                        //echo SAVE_PHOTO . $filename;exit;
                        if (move_uploaded_file($_FILES["media"]["tmp_name"], SAVE_PHOTO ."video/". $filename)) {
                            if(!$this -> provider() -> execute("update comments a set a.media_link = '$filename', a.media_type = 'video' where a.id = $newid")){
                                echo json_encode(array("success" => "0", "message" => "video upload error."));exit;
                            }
                        }
                        else{
                            $this -> provider() -> execute("delete from chat where id = $newid");
                            echo json_encode(array("success" => "0", "message" => "video upload error."));exit;
                        }
                        $media_link = $filename;
                    }
                    break;
                case "photo":
                    if (isset($_FILES['media'])) { // media audio
                        $default = explode(".", $_FILES["media"]["name"]);
                        $extension = end($default);
                        $filename = $this -> generate_token(16) . "." . $extension;
                        //echo SAVE_PHOTO . $filename;exit;
                        if (move_uploaded_file($_FILES["media"]["tmp_name"], SAVE_PHOTO ."photo/". $filename)) {
                            if(!$this -> provider() -> execute("update comments a set a.media_link = '$filename', a.media_type = 'photo' where a.id = $newid")){
                                echo json_encode(array("success" => "0", "message" => "photo upload error."));exit;
                            }
                        }
                        else{
                            $this -> provider() -> execute("delete from chat where id = $newid");
                            echo json_encode(array("success" => "0", "message" => "photo upload error."));exit;
                        }
                        $media_link = $filename;
                    }
                    break;
                default :
                    break;

            }
            echo json_encode(array("success" => "1", "media_link"=>$media_link));exit;
        }else{
            echo json_encode(array("success" => "0", "message"=>"sql error"));exit;
        }

    }


    /////////////////  like  ////////////////////////////
    public function like() {
        $account_id = $this -> authentication();
        $video_id = $_POST['video_id'];

        $now = time();
        $chk = $this->provider()->single("SELECT COUNT(*) AS ck FROM user_like WHERE account_id = $account_id AND like_type = 'like' and video_id = '$video_id'");
        if($chk['ck'] == 0 ){
            $this->provider()->execute("INSERT INTO user_like(account_id, like_type, video_id, created) VALUES($account_id, 'like', $video_id, '$now')");
        }

        // get video poster
        $author = $this->provider()->single("SELECT account_id FROM videos WHERE is_create = 1 AND video_id = $video_id");
        $author_id = $author["account_id"];
        // notification
        $device = $this -> provider() -> single("select * from device where account_id = $author_id ");
        $token = $device['device_id'];
        $info = $this -> provider() -> single("select * from account where id = $account_id");
        $message = $info['userName']." liked your video.";
        $data = array("aps" => array(
            "alert" => $message,
            "sender_id" => $account_id,
            "userName" => $info['userName'],
            "photo_url" => $info['avatar'],
            "type" => "like"
        ));
        if($device['device_type'] == "ios"){
            $this -> push($token, $data);
        }
        // add noti
        $this->provider()->execute("INSERT INTO noti(account_id, receiver_id, info_id, noti_type, created)
                VALUES( $account_id, $author_id, $video_id, 'like', '$now')");
        echo json_encode(array("success" => "1"));exit;

    }
    public function unlike() {
        $account_id = $this -> authentication();
        $video_id = $_POST['video_id'];

        $now = time();
        $chk = $this->provider()->single("SELECT COUNT(*) AS ck FROM user_like WHERE account_id = $account_id AND like_type = 'like' and video_id = '$video_id'");
        if($chk['ck'] > 0 ){
            $this->provider()->execute("delete from user_like where account_id = $account_id and like_type = 'like' and video_id = '$video_id' ");
            echo json_encode(array("success" => "1"));exit;
        }else{
            echo json_encode(array("success" => "1"));exit;
        }

    }
    public function view() {
        $account_id = $this -> authentication();
        $video_id = $_POST['video_id'];

        $now = time();
        $chk = $this->provider()->single("SELECT COUNT(*) AS ck FROM user_like WHERE account_id = $account_id AND like_type = 'view' and video_id = '$video_id'");
        if($chk['ck'] == 0 ){
            $this->provider()->execute("INSERT INTO user_like(account_id, like_type, video_id, created) VALUES($account_id, 'view', $video_id, '$now')");
        }

        // get video poster
        $author = $this->provider()->single("SELECT account_id FROM videos WHERE is_create = 1 AND video_id = $video_id");
        $author_id = $author["account_id"];
        // notification
        $device = $this -> provider() -> single("select * from device where account_id = $author_id ");
        $token = $device['device_id'];
        $info = $this -> provider() -> single("select * from account where id = $account_id");
        $message = $info['userName']." viewed your video.";
        $data = array("aps" => array(
            "alert" => $message,
            "sender_id" => $account_id,
            "userName" => $info['userName'],
            "photo_url" => $info['avatar'],
            "type" => "view"
        ));
        if($device['device_type'] == "ios"){
            $this -> push($token, $data);
        }
        // add noti
        $this->provider()->execute("INSERT INTO noti(account_id, receiver_id, noti_type, message, created)
                VALUES( $account_id, $author_id, 'view', $video_id, '$now')");

        echo json_encode(array("success" => "1"));exit;

    }
    public function share() {
        $account_id = $this -> authentication();
        $video_id = $_POST['video_id'];

        $now = time();
        $old_videos = $this->provider()->result("select * from videos where video_id = $video_id order by created");
        $new_id = 0;
        $creator = $account_id;
        for($j = 0; $j < count($old_videos); $j ++){
            extract($old_videos[$j]);
            if($j == 0){
                $sql_insert = "INSERT INTO videos(account_id, descr, video, is_create, state, invite, is_share, shared_user, posted, created)
                        VALUES($account_id, '$descr', '$video', 1, 1, '$invite', 1, $creator,'$now', '$now')";
                $this->provider()->execute($sql_insert);
                $new_id = $this->provider()->_db->insert_id;
                $this -> provider() -> execute("update videos set video_id = $new_id where id = $new_id");
            }else{
                $sql_insert = "INSERT INTO videos(account_id, descr, video, video_id, is_create, state, invite, is_share, posted, created)
                        VALUES($account_id, '$descr', '$video', '$new_id', 0, 1, '$invite', 1, '$now', '$now')";
                $this->provider()->execute($sql_insert);
            }
        }


        $chk = $this->provider()->single("SELECT COUNT(*) AS ck FROM user_like WHERE account_id = $account_id AND like_type = 'share' and video_id = '$video_id'");
        if($chk['ck'] == 0 ){
            echo json_encode(array("success" => "1"));exit;
        }else{
            $this->provider()->execute("INSERT INTO user_like(account_id, like_type, video_id, created) VALUES($account_id, 'share', $video_id, '$now')");
            echo json_encode(array("success" => "1"));exit;
        }

        // get video poster
        $author = $this->provider()->single("SELECT account_id FROM videos WHERE is_create = 1 AND video_id = $video_id");
        $author_id = $author["account_id"];
        // notification
        $device = $this -> provider() -> single("select * from device where account_id = $author_id ");
        $token = $device['device_id'];
        $info = $this -> provider() -> single("select * from account where id = $account_id");
        $message = $info['userName']." shared your video.";
        $data = array("aps" => array(
            "alert" => $message,
            "sender_id" => $account_id,
            "userName" => $info['userName'],
            "photo_url" => $info['avatar'],
            "type" => "share"
        ));
        if($device['device_type'] == "ios"){
            $this -> push($token, $data);
        }
        // add noti
        $this->provider()->execute("INSERT INTO noti(account_id, receiver_id, noti_type, message, created)
                VALUES( $account_id, $author_id, 'share', $video_id, '$now')");
        echo json_encode(array("success" => "1"));exit;
    }
    /////////////////  Live Stream  ////////////////////////////
    public function getName_liveStream() {
        $account_id = $this -> authentication();
        $check = 0;
        $streamName = "";
        while($check != 1){
            $streamName = $this->generate_token(10);
            $chk = $this->provider()->single("SELECT COUNT(*) AS ck FROM live_stream WHERE streamID = '$streamName'");
            if($chk['ck'] == 0 ){
                $check = 1;
            }
        }
        $stream_life = $this->provider()->single("select stream_life from account where  id = $account_id");
        echo json_encode(array("success" => "1", "streamID" => $streamName, "stream_life"=>$stream_life['stream_life']));exit;

    }
    public function create_liveStream() {
        $account_id = $this -> authentication();
        $streamID = $_POST['streamID'];

        $now = time();
        $this->provider()->execute("INSERT INTO live_stream(account_id, streamID, state, created) VALUES($account_id, '$streamID', 1, '$now')");

        // add join stream
        $this->provider()->execute("INSERT INTO join_stream(account_id, streamID, state, created)
                                    VALUES($account_id, $streamID, 1, '$now')");
        echo json_encode(array("success" => "1"));exit;
    }
    public function end_liveStream() {
        $account_id = $this -> authentication();
        $streamID = $_POST['streamID'];

        $now = time();
        $start = $this->provider()->single("select created from live_stream where  streamID = '$streamID'");
        $during_stream = round(($now - $start['created'])/60);
        $this->provider()->execute("update account set stream_life = (stream_life - $during_stream) where id = $account_id ");
        $this->provider()->execute("update live_stream set state = 0 where streamID = '$streamID'");

        // update join stream
        $this->provider()->execute("update join_stream set state = 0 where streamID = $streamID");

        echo json_encode(array("success" => "1"));exit;
    }
    public function get_liveStream() {

        $offset = $_POST['offset'];
        $from = $offset * 10;
        $account_id = $this -> authentication();
        $now = time();
        $result = $this->provider()->result("select a.id, a.streamID, a.account_id, a.state, ($now - a.created) as created, b.userName, b.avatar from live_stream a left join account b on a.account_id = b.id where a.state = 1 limit $from, 10");


        echo json_encode(array("success" => "1", "result"=>$result));exit;
    }
    public function join_liveStream() {
        $account_id = $this -> authentication();
        $streamID = $_POST['streamID'];

        $now = time();
        // add join stream
        $this->provider()->execute("INSERT INTO join_stream(account_id, streamID, state, created)
                                    VALUES($account_id, $streamID, 1, '$now')");

        echo json_encode(array("success" => "1"));exit;
    }
    /************************ comment ***************************************************/
    public function live_comment() {
        $account_id = $this -> authentication();
        $streamID = $_POST['streamID'];
        $message = $_POST['message'];

        $now = time();
        $sql = "INSERT INTO comment_stream(account_id, streamID, message, state, created)
                VALUES($account_id, $streamID, '$message', 1, '$now')";
        if($result = $this->provider()->execute($sql)){
            // get video poster
            $receivers = $this->provider()->result("SELECT account_id FROM join_stream WHERE state = 1 AND streamID = $streamID");
            foreach($receivers as $author){
                $author_id = $author["account_id"];
                // send notification
                $device = $this -> provider() -> single("select * from device where account_id = $author_id ");
                $token = $device['device_id'];
                $info = $this -> provider() -> single("select * from account where id = $account_id");
                $data = array("aps" => array(
                    "alert" => $message,
                    "sender_id" => $account_id,
                    "userName" => $info['userName'],
                    "photo_url" => $info['avatar'],
                    "streamID" => $streamID,
                    "type" => "liveComment"
                ));
                if($device['device_type'] == "ios"){
                    $this -> push($token, $data);
                }
            }

            echo json_encode(array("success" => "1"));exit;
        }else{
            echo json_encode(array("success" => "0", "message"=>"sql error"));exit;
        }

    }

}