
<?php
$connection = mysqli_connect('localhost','root','root',);
$select_db = mysqli_select_db($connection,'photo');
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require ('connect.php');
    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];

        $query= "INSERT INTO users (username,password) VALUES('$username','$password')";
        $result = mysqli_query($connection,$query);

        if($result)
        {
            $smsg = "Регистрация выполнена";
        }
        else
        {
            $fsmsg = "Ошибка";
        }
    }
    ?>
    <div class="container">
        <form class="form-signin" method="post">
            <h2>Регистрация</h2>
            <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php }?>
            <?php if(isset($fsmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fsmsg; ?> </div><?php }?>
            <input type="text" name="username" class="form-control" placeholder="username" required>
            <input type="password" name="password" class="form-control" placeholder="password" required>
            <button class="btn btn-lg btn primary btn-block" type="submit">Зарегистрироваться</button>
            <a href="login.php" class="btn btn-lg btn-primary btn-block">Войти</a>
        </form>
    </div>
    </body>
    </html>

<?php session_start(); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    <body>
    <div class="container">
        <form class="form-signin" method="post">
            <h2>Вход</h2>
            <input type="text" name="username" class="form-control" placeholder="username" required>
            <input type="password" name="password" class="form-control" placeholder="password" required>
            <button class="btn btn-lg btn primary btn-block" type="submit">Войти</button>
            <a href="Registration.php" class="btn btn-lg btn-primary btn-block">Зарегистрироваться</a>
        </form>
    </div>
    <?php
    require ('connect.php');
    if (isset($_POST['username']) and isset($_POST['password']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];
        $query = "SELECT * FROM users where username='$username' and password='$password'";
        $result = mysqli_query($connection,$query) or die(mysqli_error($connection));
        $count = mysqli_num_rows($result);
        if($count==1)
        {
            $_SESSION['username']=$username;
        }
        else
        {
            $fsmg="ошибка";
        }
    }
    if(isset($_SESSION['username']))
    {
        $username=$_SESSION['username'];
        echo "<a href='loader.php?user=$username'>";
        echo "<meta http-equiv=\"refresh\" content=\"0; url=loader.php\">";
    }
    ?>
    </body>
    </html>

<?php session_start(); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require ('connect.php');
    $username=$_SESSION['username'];
    $folderUploads = 'uploads';
    $image = $_FILES['image'];
    $date = Date('d.m.Y.H.i.s.u');
    if($image) {
        $image_name = $image['name'];
        $date=$date.$image_name;
        $tmp_name = $image['tmp_name'];
        if(!move_uploaded_file($tmp_name, $folderUploads . DIRECTORY_SEPARATOR. $date)){
            echo "Не удалось загрузить файл";
        }
        else
        {
            $query= "INSERT INTO photos (username,url) VALUES('$username','$date')";
            $result = mysqli_query($connection,$query);
        }
    }

    ?>
    <div class="container">
        <form class="form-signin" method="post" enctype="multipart/form-data">
            <h2>Загрузка фото</h2>
            <a href='myphoto.php' class='btn btn-lg btn-primary btn-block'>Мои фото</a>
            <a href='allphoto.php' class='btn btn-lg btn-primary btn-block'>Все фото</a>
            <a href='loader.php' class='btn btn-lg btn-primary btn-block'>Загрузить фото</a>
            <a href='logout.php' class='btn btn-lg btn-primary btn-block'>Выйти</a>
            <input type="file" name="image" value="">
            <button class="btn btn-lg btn primary btn-block" type="submit">Загрузить</button>
        </form>
    </div>

    </body>
    </html>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    ?>
    <div class="container">
        <form class="form-signin" method="post">
            <h2>Мои фото</h2>
            <a href='myphoto.php?username' class='btn btn-lg btn-primary btn-block'>Мои фото</a>
            <a href='allphoto.php' class='btn btn-lg btn-primary btn-block'>Все фото</a>
            <a href='loader.php' class='btn btn-lg btn-primary btn-block'>Загрузить фото</a>
            <a href='logout.php' class='btn btn-lg btn-primary btn-block'>Выйти</a>
        </form>
    </div>

    </body>
    </html>

<?php session_start(); ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    <body>
    <?php
    require ('connect.php');
    $username=$_SESSION['username'];
    $query = "SELECT url FROM photos where username='$username'";
    $result = mysqli_query($connection,$query) or die(mysqli_error($connection));
    ?>
    <div class="container">
        <form class="form-signin" method="post">
            <h2>Все фото</h2>
            <a href='myphoto.php' class='btn btn-lg btn-primary btn-block'>Мои фото</a>
            <a href='allphoto.php' class='btn btn-lg btn-primary btn-block'>Все фото</a>
            <a href='loader.php' class='btn btn-lg btn-primary btn-block'>Загрузить фото</a>
            <a href='logout.php' class='btn btn-lg btn-primary btn-block'>Выйти</a>
        </form>
    </div>
    <?php
    if(isset($result)) {
        echo "<img src='uploads/29.06.2020.10.50.14.000000Sketchpad.png' width='600' height='400'>";
    }
    ?>
    </body>
    </html>

<?php
session_start();
session_destroy();
header('location: login.php');
exit;

.form-signin{
    max-width: 400px;
    padding: 15px;
    margin: 0 auto;
}