<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NiteStreaming App | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <img src="./img/Logo_icon.png" style="width: 300px;">
        </div>
        <br/>
        <br/>
        <p>Login in. To see it in action.</p>
        <form class="m-t" role="form" action="action.php" method="post">
            <div class="form-group">
                <p style="color: red;">
                    <?php if(isset($_REQUEST['err'])){ ?>
                        <span class="label label-sm label-danger">Alert: </span>
                        <?php
                        if($_REQUEST['err'] == 'error1'){
                            echo "Invalid username/password combination";
                        }elseif($_REQUEST['err'] == 'error2'){
                            echo "Please register.";
                        }elseif($_REQUEST['err'] == 'error3'){
                            echo "Invalid input value.";
                        }elseif($_REQUEST['err'] == 'error4'){
                            echo "User already exist.";
                        }elseif($_REQUEST['err'] == 'error5'){
                            echo "Due to complaints that we received, your profile is currently under review.
                                    We're sorry for any inconvenience.";
                        }
                    }
                    ?>
                </p>
            </div>
            <div class="form-group">
                <input type="username" name="username" class="form-control" placeholder="Username" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            <input type="hidden" name="key" value="login">
        </form>
        <p class="m-t"> <small>Nite Streaming App Admin Panel base on Bootstrap 3 &copy; 2016.4</small> </p>
    </div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>

</html>
