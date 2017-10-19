<?php
    require_once("../api/Database.php");
    define('SAVE_PHOTO', './images/photos/');  // save image path
    define('DELETE_PHOTO', './images/photos/');  // delete image path

    define('SAVE_USER_PHOTO', './images/user/');  // save user image path
    define('DELETE_USER_PHOTO', './images/user/');  // delete user image path

    $GENDER = array("1"=>"Male", "2"=>"Female");
    $permission = array("0"=>"default", "1"=>"admin");

    $db = new Database();

    function redirect_url( $url = './index.php' ){
        echo '<script>location.href = "'.$url.'"; </script>';exit;
    }
    function generate_token($length = 8) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        //length:36
        $final_rand = '';
        for ($i = 0; $i < $length; $i++) {
            $final_rand .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $final_rand;
    }
    function qa_email_validate($email)
    {
        return preg_match("/^[\-\!\#\$\%\&\'\*\+\/\=\?\_\`\{\|\}\~a-zA-Z0-9\.\^]+\@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\.\-]+$/", $email) === 1;
    }
    function pastTime($seconds)
    {
    //    echo $seconds;exit;
        $seconds=max($seconds, 1);
        $scales=array(
            31557600 => array( '1year'   , 'years'   ),
            2629800 => array( '1month'  , 'months'  ),
            604800 => array( '1week'   , 'weeks'   ),
            86400 => array( '1day'    , 'days'    ),
            3600 => array( '1hour'   , 'hours'   ),
            60 => array( '1minute' , 'minutes' ),
            1 => array( '1second' , 'seconds' ),
        );
        $string = "";
        foreach ($scales as $scale => $phrases)
            if ($seconds>=$scale) {
                $count=floor($seconds/$scale);

                if ($count==1)
                    $string .= $phrases[0];
                else
                    $string .= $count . $phrases[1];
                break;
            }
        return $string;
    }
    function check_user(){
        global $db;
        if( isset($_SESSION['log_in']) && $_SESSION['log_in'] ){
            return true;
        }else{
            redirect_url('./login.php');
        }
    }
    function login($username, $password){

        if($username == "" || $password == "" ){
            redirect_url("./login.php?err=error1");
        }
        global $db;
        $info = $db -> single("select * from admin where username= '$username' and password='".$password ."'");

        if (count($info) == 0) {
            redirect_url("./login.php?err=error1");
        }else {
            /* session register */
            $_SESSION['user_id'] = $info['id'];
            $_SESSION['username'] = $info['username'];
            $_SESSION['photo'] = "Logo_icon.png";
            $_SESSION['log_in'] = true;
            $_SESSION['password'] = $info['password'];
            $_SESSION['admin'] = $info['permission'];
            redirect_url("./index.php");
        }
    }
    function forgotPassword(){

        global $db;
        $email = $_REQUEST['email'];
        $info = $db -> single("SELECT email FROM account WHERE email = '$email' ");
        $to = $info['email'];
        $newpass = rand(100000, 999999);
        $db -> execute("update account set password = '".md5($newpass)."' where email = '$to'");
        $subject = "Change Password";
        $txt = "Your password changed. New password : ".$newpass. "\r\n" ;

        try {
            $headers = 'From: admin@indyhost.com' . "\r\n" .
                'Reply-To: admin@indyhost.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $txt, $headers);
        }
        catch (Exception $e)
        {
            redirect_url('./signup.php');
        }
        redirect_url('./login.php');

    }
    function register($username, $password, $email){
        if($username == "" || $email == "" || (!qa_email_validate($email)) || $password == "" ){
            redirect_url("./login.php?err3");
        }
        global $db;
        $check = $db -> single("select count(*) as count from account where username= '$username' and email='$email'");
        if ($check["count"] > 0) {
            redirect_url("./login.php?err4");
        } else {
            // add new user
            if(!$db -> execute("insert into account values(null,'$username','$username', '$email', 'avatar.png', '".md5($password)."','0')")){
                redirect_url("./login.php?err2");
            }
            redirect_url("./login.php");
        }
    }
    /* admin */

    /* user */
    function dashboardInfo(){
        global $db;
        $result = array();
        $now = time();

        $count_user = $db -> single("select count(*) as ct from account where active = 1 ");
        $count_streaming = $db -> single("select count(*) as ct from streams where state = 1 ");

        $result['count_users'] = $count_user['ct'];
        $result['count_streams'] = $count_streaming['ct'];
        return $result;
    }
    function adminGetUsers(){
        global $db;
        $sql = "SELECT * FROM account ORDER BY created DESC";
        $result = $db -> result($sql);
        return $result;
    }
    function delUser($uid){
        global $db;
        $sql = "delete from account where id = $uid ";
        $db->execute($sql);
        redirect_url("./view_users.php");
    }
    function activeUser($uid){
        global $db;
        $sql = "update account set state = 1 where id = $uid ";
        $db->execute($sql);
        redirect_url("./view_users.php");
    }
    function deActiveUser($uid){
        global $db;
        $sql = "update account set state = 0 where id = $uid ";
        $db->execute($sql);
        redirect_url("./view_users.php");
    }

    /* category */
    function adminGetCategory(){
        global $db;
        $sql = "SELECT * FROM categories";
        $result = $db -> result($sql);
        return $result;
    }
    function getCategory($cid){
        global $db;
        $new_cat = array("id"=>0,"icon"=>"icon.png","image"=>"icon.png","catName"=>"", "descr"=>"");
        if($cid > 0){
            $sql = "SELECT *
                        FROM categories
                        WHERE id = $cid";
            $new_cat = $db -> single($sql);
        }
        return $new_cat;
    }
    function deleteCategory($cid){
        global $db;
        $sql = "delete from categories where id = $cid ";
        $db->execute($sql);
        redirect_url("./view_categories.php");
    }
    function editCategory($cid, $catName, $descr){
        global $db;
        $newid = $cid;
        $catName = htmlspecialchars($catName, ENT_QUOTES);
        if($cid > 0){//update
            $sql = "update categories set catName = '$catName', descr = '$descr' where id = $cid ";
            $db->execute($sql);
        }else{
            $sql = "insert into categories(catName, descr) values('$catName', '$descr'); ";
            $db->execute($sql);
            $newid = $db->_db->insert_id;
        }
        if (isset($_FILES['icon'])) {
            $default = explode(".", $_FILES["icon"]["name"]);
            $extension = end($default);
            $filename = generate_token(8) . "." . $extension;
            $now = time();
            if (move_uploaded_file($_FILES["icon"]["tmp_name"], '../images/category/' . $filename)) {
                $db->execute("update categories set icon = '$filename' where id = $newid ");
            }
        }
        if (isset($_FILES['image'])) {
            $default = explode(".", $_FILES["image"]["name"]);
            $extension = end($default);
            $filename = generate_token(8) . "." . $extension;
            $now = time();
            if (move_uploaded_file($_FILES["image"]["tmp_name"], '../images/category/' . $filename)) {
                $db->execute("update categories set image = '$filename' where id = $newid ");
            }
        }
        redirect_url('./view_categories.php');
    }
    function adminCategories(){
        global $db;
        $sql = "SELECT * FROM categories";
        $result = $db -> result($sql);
        return $result;
    }

    /* venue */
    function getVenue($vid){
        global $db;
        $new_venue = array("id"=>0,"logo"=>"","venueName"=>"","address"=>"","lot"=>0,"lat"=>0);
        if($vid > 0){
            $sql = "select * from venues where id = $vid ";
            $new_venue = $db -> single($sql);
        }
        return $new_venue;
    }
    function editVenue($venue){
        global $db;
        extract($venue);
        $venueName = htmlspecialchars($venueName, ENT_QUOTES);
        $venueName = $db->_db->real_escape_string($venueName);
        $address = htmlspecialchars($address, ENT_QUOTES);
        $address = $db->_db->real_escape_string($address);

        $now = time();
        $sql = "";
        $newID = $id;
        if($id > 0){//update
            $sql = "update venues set venueName='$venueName', address= '$address', lot=$lot, lat=$lat where id = $newID ";
            $db->execute($sql);
        }else{
            $sql = "insert into venues(venueName, address, lot, lat, created)
                        values('$venueName', '$address', $lot, $lat, '$now') ";
            $db->execute($sql);
            $newID = $db->_db->insert_id;
        }

        if (isset($_FILES['image'])) {
            $default = explode(".", $_FILES["image"]["name"]);
            $extension = end($default);
            $filename = generate_token(8) . "." . $extension;
            $now = time();
            if (move_uploaded_file($_FILES["image"]["tmp_name"], '../images/venues/' . $filename)) {
                $db->execute("update venues set logo = '$filename' where id = $newID ");
            }
        }
        redirect_url('./view_venues.php');
    }
    function adminGetVenues(){
        global $db;
        $sql = "select * from venues order by venueName ";
        $result = $db -> result($sql);
        return $result;
    }
    function deleteVenue($vid){
        global $db;
        $sql = "delete from venues where id = $vid ";
        $db->execute($sql);
        redirect_url("./view_venues.php");
    }

    /* streams */
    function adminGetStreams(){
        global $db;
        $sql = "select * from streams order by created desc ";
        $result = $db -> result($sql);
        return $result;
    }
    function delStream($sid){
        global $db;
        $sql = "delete from streams where id = $sid ";
        $db->execute($sql);
        redirect_url("./view_streams.php");
    }
    function activeStream($sid){
        global $db;
        $sql = "update streams set state = 1 where id = $sid ";
        $db->execute($sql);
        redirect_url("./view_streams.php");
    }
    function deActiveStream($sid){
        global $db;
        $sql = "update streams set state = 0 where id = $sid ";
        $db->execute($sql);
        redirect_url("./view_streams.php");
    }

    /* admin */
    function editSetting($userName, $is_changePassword = 0, $newPass = ""){
        global $db;
        $sql = "";
        if($is_changePassword){
            $sql = "update admin set username = '$userName', password = '".md5($newPass)."' where id = 1 ";
        }else{
            $sql = "update admin set username = '$userName' where id = 1 ";
        }

        $db->execute($sql);

        $info = $db -> single("select * from admin where id = 1");
        $_SESSION['user_id'] = $info['id'];
        $_SESSION['username'] = $info['username'];
        $_SESSION['photo'] = "Logo_icon.png";
        $_SESSION['log_in'] = true;
        $_SESSION['password'] = $info['password'];
        $_SESSION['admin'] = $info['permission'];
        redirect_url("./settings.php");
    }
    ?>