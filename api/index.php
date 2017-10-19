<?php

require ('ext/Slim/Slim.php');
require ('ApiModel.php');
error_reporting(-1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
// http://domain.com/push_test
$app -> get('/push_test', function() {
    ApiModel::getInstance() -> push_test();
});
$app -> get('/push_test_android', function() {
    ApiModel::getInstance() -> push_test_android();
});


// http://domain.com/account/signup
$app -> post('/account/signup', function() {
    ApiModel::getInstance() -> signup();
});
// http://domain.com/account/social_signup
$app -> post('/account/social_signup', function() {
    ApiModel::getInstance() -> social_signup();
});
// http://domain.com/account/login
$app -> post('/account/login', function() {
    ApiModel::getInstance() -> login();
});
// http://domain.com/account/social_login
$app -> post('/account/social_login', function() {
    ApiModel::getInstance() -> social_login();
});
// http://domain.com/logout
$app -> post('/account/logout', function() {
    ApiModel::getInstance() -> logout();
});
// http://domain.com/account/updateProfile
$app -> post('/account/updateProfile', function() {
    ApiModel::getInstance() -> updateProfile();
});
// http://domain.com/account/changePassword
$app -> post('/account/changePassword', function() {
    ApiModel::getInstance() -> changePassword();
});
// http://domain.com/account/users
$app -> post('/account/users', function() {
    ApiModel::getInstance() -> get_users();
});
// http://domain.com/account/user
$app -> post('/account/user', function() {
    ApiModel::getInstance() -> get_user();
});
/************************ follow ***************************************************/

$app -> post('/follow', function() {
    ApiModel::getInstance() -> follow();
});
$app -> post('/unfollow', function() {
    ApiModel::getInstance() -> unfollow();
});
$app -> post('/getFollow', function() {
    ApiModel::getInstance() -> getFollow();
});
$app -> post('/getFollowing', function() {
    ApiModel::getInstance() -> getFollowing();
});


/***************************** chat ********************************************************/
// http://domain.com/chat/getFriends
$app -> post('/chat/getFriends/', function() {
    ApiModel::getInstance() -> get_chat_friends();
});
// http://domain.com/api/chat/delete_chart_user
$app -> post('/chat/delete_chart_user', function() {
    ApiModel::getInstance() -> delete_chat_user();
});
// http://domain.com/chat/sendMessage
$app -> post('/chat/sendMessage', function() {
    ApiModel::getInstance() -> sendMessage();
});
// http://domain.com/chat/checkMessage
$app -> post('/chat/checkMessage', function() {
    ApiModel::getInstance() -> checkMessage();
});
// http://domain.com/chat/sendMessage
$app -> post('/chat/getChatHistory', function() {
    ApiModel::getInstance() -> get_chatHistory();
});

/****************************** Categories *******************************************/
$app -> post('/getCategories', function() {
    ApiModel::getInstance() -> getCategories();
});

/****************************** Venues *******************************************/
$app -> post('/getVenues', function() {
    ApiModel::getInstance() -> getVenues();
});


/****************************** Streams *******************************************/
$app -> post('/Streams/getRecent', function() {
    ApiModel::getInstance() -> getRecent();
});
$app -> post('/Streams/getStreamByCategory', function() {
    ApiModel::getInstance() -> getStreamByCategory();
});
$app -> post('/Streams/getStream', function() {
    ApiModel::getInstance() -> getStream();
});

/************************ notification ***************************************************/

$app -> post('/notification/you', function() {
    ApiModel::getInstance() -> getNotification();
});
$app -> post('/notification/check', function() {
    ApiModel::getInstance() -> getNotiByCheck();
});

/************************ Comment ***************************************************/

$app -> post('/comment', function() {
    ApiModel::getInstance() -> comment();
});


/************************ like view share ***************************************************/

$app -> post('/like', function() {
    ApiModel::getInstance() -> like();
});
$app -> post('/unlike', function() {
    ApiModel::getInstance() -> unlike();
});
$app -> post('/view', function() {
    ApiModel::getInstance() -> view();
});
$app -> post('/share', function() {
    ApiModel::getInstance() -> share();
});

/************************ LiveStream ***************************************************/

$app -> post('/LiveStream/get_name', function() {
    ApiModel::getInstance() -> getName_liveStream();
});
$app -> post('/LiveStream/create', function() {
    ApiModel::getInstance() -> create_liveStream();
});
$app -> post('/LiveStream/end', function() {
    ApiModel::getInstance() -> end_liveStream();
});
$app -> post('/LiveStream/get', function() {
    ApiModel::getInstance() -> get_liveStream();
});
$app -> post('/LiveStream/join', function() {
    ApiModel::getInstance() -> join_liveStream();
});

/************************ Live Stream Comment ***************************************************/

$app -> post('/comment/live', function() {
    ApiModel::getInstance() -> live_comment();
});



/****************************************** end ******************************************/
/***********************************************************************************************/

$app -> run();