
<?php
include "assets/php/check_login.php";
include ('assets/php/connection.php');
include ('uplaodefile.php');
//if( isset($_COOKIE['userid']) )
//    Header("Location: index.php");

$newpost='';
$edit='';
    if (!empty($_GET['id'])){
        $querypostedit="SELECT * FROM post WHERE postid='".$_GET['id']."' AND userid='".$_COOKIE['userid']."'";
        $querypostedit = mysqli_query($connection,$querypostedit);
        $edit = mysqli_fetch_assoc($querypostedit);
        if (isset($_POST['imgpost'])){
            $now = date("y/n/d - H:i");
            $queryupdate = "UPDATE `post` SET description='" . $_POST['description'] . "',`date`='" . $now . "' WHERE postid= '".$_GET['id']."'";
            $queryupdate = mysqli_query($connection,$queryupdate);
            
            Header("Location: profile.php");
            if (isset($_POST['imgpost']) && empty($_FILES['newpost']['name']) ){
                $now = date("y/n/d - H:i");
                $editpost = uploadfile("uploadspost/", "newpost");
                $queryupdate1 = "UPDATE `post` SET url='".$editpost."' description`='" . $_POST['description'] . "', `date` ='" . $now . "' WHERE postid= '".$_GET['id']."'";
                $queryupdate1 = mysqli_query($connection, $queryupdate1);
            }
        }
    }

    if (empty($_GET['id'])){
        if (isset($_POST['imgpost'])) {

            $checking = explode(".", $_FILES['newpost']['name']);
            if (!empty($_POST["description"]) && isset($_FILES['newpost']) && !empty($_FILES['newpost']['name']) && ($checking[1] == "jpg" || $checking[1] == "png" || $checking[1] == "gif" || $checking[1] == "jpeg")) {
                $newpost = uploadfile("uploadspost/", "newpost");
                $now = date("Y-m-d");
                $query = "INSERT INTO post(url,userid, description , `date`) VALUES ('" . $newpost . "','" . $_COOKIE['userid'] . "','" . $_POST['description'] . "','" . $now . "')";
                $result = mysqli_query($connection, $query);
                
                if( $result ){
                    header("Location: home.php");
                }else{
                    array_push($errors, $connection->error);
                }

            } else {
                array_push($errors, "there is a problem with the post");
            }

        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'template/head.php'; ?>
    <title>new post</title>
    <style>

        body{
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);
            height: 100vh;
        }

        input , textarea{
            border: none;
        }

        button:focus {
            outline: none;
        }
        ::-webkit-input-placeholder {
            color: rgba(255, 255, 255, 0.65);
        }

        ::-webkit-input-placeholder .input-line:focus +::input-placeholder {
            color: #fff;
        }
        .container1{
            margin-right: auto;
            margin-left: auto;
            width: 1000px!important;

        }
        .container2 {

            /*height: 100%;*/
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            /*background: #eee;*/
            /*height: 100%;*/
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);
        }

        .content {

            /*height: 1000px  ;*/
            padding-left: 25px;
            padding-right: 25px;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-flow: column;
            -ms-flex-flow: column;
            flex-flow: column;
            z-index: 5;
        }

        .welcome {
            font-weight: 200;
            margin-top: 75px;
            text-align: center;
            font-size: 40px;
            font-size: 2.5rem;
            letter-spacing: 0px;
            letter-spacing: 0.05rem;
        }
        .window {

            z-index: 100;
            color: #fff;
            font-family: roboto;
            position: relative;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-flow: column;
            -ms-flex-flow: column;
            flex-flow: column;
            box-shadow: 0px 15px 50px 10px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            /*height: 560px;*/
            width: 360px;
            /*background: #fff;*/
            background: url('https://pexels.imgix.net/photos/27718/pexels-photo-27718.jpg?fit=crop&w=1280&h=823') top left no-repeat;
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);
        }

        .overlay {
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);

            opacity: 0.85;
            filter: alpha(opacity=85);
            height: 100%;
            position: absolute;
            width: 800px;
            z-index: 1;
        }
        .label{
            cursor: pointer;
            border: 2px solid rgba(0,0,0,0.07);
            padding: 10px;
            color: rgba(255, 255, 255, 0.65);
            transition: all .2s ease;
            border: 1px solid rgba(255, 255, 255, 0.65);
            border-radius: 25px;
        }
        .label:hover{
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }
        .ghost-round {
            cursor: pointer;
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.65);
            border-radius: 25px;
            color: rgba(255, 255, 255, 0.65);
            -webkit-align-self: flex-end;
            padding: 0px 10px 0px 10px;
            -ms-flex-item-align: end;
            align-self: flex-end;
            font-size: 19px;
            font-size: 1.2rem;
            font-family: roboto;
            font-weight: 300;
            line-height: 2.5em;
            margin-top: auto;
            margin-bottom: 25px;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }

        .ghost-round:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }
        .input-line {
            width: 600px;
            margin-left: 60px;
            background: none;
            margin-bottom: 10px;
            line-height: 2.4em;
            color: #fff;
            font-family: roboto;
            font-weight: 300;
            letter-spacing: 0px;
            letter-spacing: 0.02rem;
            font-size: 19px;
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.65);
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }
        .input-line:focus {
            outline: none;
            border-color: #fff;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }
        .postimgedit{
            width: 200px;
            height: 200px;
            margin-bottom: 20px;

        }
    </style>
</head>
<body>
<?php include 'template/header.php'?>
<div class="container1" >
<div class="container2" style="">
    <div class='window' style="width: 800px!important;">
        <div class='overlay' style="width: 690px!important;"></div>
        <div class='content'>
            <?php
            if (!empty($_GET['id'])){
                echo '<div class="welcome">edit post</div>';
                echo '<img src="'.$edit['url'].'" class="postimgedit">';
            }if (empty($_GET['id'])){
                echo '<div class="welcome">new post</div>';
            }

            ?>
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">


    <input type="FILE" class="form-control" name="newpost" id="imageproo" value="<?php if (!empty($_GET['id'])) echo $edit['url'];?>" hidden/>
        <?php
        if (!empty($_GET['id'])){
        echo '<label for="imageproo" class="label" >edit you post photo</label>';
        }if (empty($_GET['id'])){
        echo '<label for="imageproo" class="label" >select new post photo</label>';
        }
        ?>

    </div>
    <div class="form-group">

        <br>
        <textarea  placeholder='your description' class='input-line full-width' name="description" row="5"><?php
            if (!empty($_GET['id']))
                echo $edit['description'];
            ?></textarea>
    </div>
        <?php
        if (!empty($_GET['id'])){
            echo '<button class="ghost-round full-width" name="imgpost">edit your post</button>';
        }if (empty($_GET['id'])){
            echo '<button class= "ghost-round full-width" name="imgpost">add new post</button>';
        }
        ?>


</form>
    <ul>
    <?php
    foreach ($errors as $error){
        echo '<li>'.$error.'</li> <br>';
    }
    ?>
    </ul>
        </div>
        </div>
    </div>
</div>

</body>
</html>