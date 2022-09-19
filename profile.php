<?php
include 'assets/php/connection.php';
include 'uplaodefile.php';
include "assets/php/check_login.php";
$queryid = "SELECT * FROM post INNER JOIN useres ON post.userid=useres.userid ORDER BY postid DESC";
$resultid = mysqli_query($connection,$queryid);
if (isset($_POST['update'])) {
    if (!empty($_POST['username']) && !empty($_POST['password']) && empty($_FILES['imagepost'])) {


        $query = "UPDATE useres SET username='" . $_POST['username'] . "',password='" . $_POST['password'] . "' WHERE userid='" . $_COOKIE['userid'] . "'";
        $result = mysqli_query($connection, $query);
        array_push($errors, "only your username and password changed");

    }elseif (!empty($_FILES['imagepro']) && empty($_POST['username']) && empty($_POST['password']) ){
        $image = uploadfile("uploadsprofile/", "imagepro");
        $queryimg = "UPDATE useres SET  imagepro='" . $image . "' WHERE userid='" . $_COOKIE['userid'] . "' ";
        $resultqueryimg = mysqli_query($connection,$queryimg);
        array_push($errors,"your profile photo changed" );
    }elseif (!empty($_FILES['imagepro']) && !empty($_POST['username']) && !empty($_POST['password']) ){
        $image2 = uploadfile("uploadsprofile/", "imagepro");
        $queryall = "UPDATE useres SET username='" . $_POST['username'] . "',password='" . $_POST['password'] . "' imagepro='" . $image2 . "' WHERE userid='" . $_COOKIE['userid'] . "'";
        $resultall = mysqli_query($connection, $queryall);
        array_push($errors, "your username and password and prophoto changed");
    }
    else{
        array_push($errors, "you only can change pass and username togheter");
    }
}
$queryinsert = "SELECT * FROM `useres` WHERE userid='".$_COOKIE['userid']."'";
$queryinsert = mysqli_query($connection , $queryinsert);
$queryinsert = mysqli_fetch_assoc($queryinsert);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>

        body{
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);
        }

        .ghost-round {
            cursor: pointer;
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.65);
            border-radius: 25px;
            color: rgba(255, 255, 255, 0.65);
            -webkit-align-self: flex-end;
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
            width: 150px;
        }

        .ghost-round:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }
        .input-line {
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
            width: 650px;
        }
        .input-line:focus {
            outline: none;
            border-color: #fff;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
        }
        ::-webkit-input-placeholder .input-line:focus +::input-placeholder {
            color: #fff;
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
            width: 800px;
            background: #fff;
            background: url('https://pexels.imgix.net/photos/27718/pexels-photo-27718.jpg?fit=crop&w=1280&h=823') top left no-repeat;
        }
        .overlay {
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);
            opacity: 0.85;
            filter: alpha(opacity=85);
            height: 100%;
            position: absolute;
            width: 360px;
            z-index: 1;
        }
        .content {
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
        @import url(https://fonts.googleapis.com/css?family=Roboto:400,300,100,500);
        input {
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
        .container2 {
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
            /*left: 70%;*/
            /*width: 1000px!important;*/
        }
        .container{
            width: 800px!important;

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
        .card{
            background: white;
            padding: 1em;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.09);
            width: 300px;
            margin: 0 auto;
        }
        .post_header{
            /*display: flex;*/
            align-items: center;
            margin-bottom: 0.4em;
            position: relative;
        }
        .post_header i{
            position: absolute;
            right: 0;
        }
        .heading{
            margin-left: 0.4em;
        }
        .heading .main_heading{
            font-size: 0.9em;
        }
        .heading .sub_heading{
            font-size: 0.6em;
            color: rgba(0,0,0,0.9);
        }
        .post_header img{
            width: 30px;
            height: 30px;
            border-radius: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
        }
        .post_img img{
            width: 230px;
            height: 230px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }
        .post_footer{
            width: 100%;


            align-items: center;
            justify-content: space-between;
        }

        .like{
            color:rgba(0,0,0,0);
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: black;
            transition-duration: 0.5s;
        }
        .like:hover{
            color: red;
            -webkit-text-stroke-width: 0;
        }
        .username{
            margin-left: 7px;
        }
        .deletpost{
            color: red;
            transition-duration: 0.5s;
        }
        .deletpost:hover{
            color: maroon;
        }
        .deletpost:active{
            color: maroon;
        }
        .editpost{
            color: gray;
            transition-duration: 0.5s;
        }
        .editpost:hover{
            color: black;
        }
        .editpost:active{
            color: gray;
        }
    </style>
<?php include 'template/head.php'; ?>
</head>
<body>
<?php include 'template/header.php'?>
<div class="container">
<div class="container pt-4" style="padding-left: 0!important; width: 785px!important;">

  <img src="<?php echo $queryinsert['imagepro']; ?>" style="width: 250px; height:250px; margin-left: 250px; padding: 40px; border: 2px solid gray; border-radius: 50%; margin-bottom: 10px;" >
  
  
             
  <table class="table table-striped">
    <thead>
      <tr>
        <th>username</th>
        <th>gender</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
    <?php

    
    
    echo "
      <tr>
        <td>".$queryinsert['username']."</td>
        <td>".$queryinsert['gender']."</td>
        <td>".$queryinsert['email']."</td>
      </tr>
      ";
    
    ?>
    </tbody>
  </table>

</div>
    <div class="container2">
    <div class='window'>
        <div class='overlay'></div>
        <div class='content'>
            <div class='welcome'>Change profile ditails </div>
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>new Username:</label>
                <input type="text" class="input-line full-width" name="username">
            </div>
            <div class="form-group">
                <label>new Password:</label>
                <input type="password" class="input-line full-width" name="password" >
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="imagepro" id="imageproo" hidden/>
                <label for="imageproo" class="label" >Choose profile photo</label>
            </div>
            <div style="text-align:center">
                <button class="ghost-round" name="update">update</button>
            </div>



  
            <ul>
                <?php
                    foreach ($errors as $error) {
                        echo "<li>".$error."</li>";
                    }
                ?>
            </ul>
        </form>
        </div>
    </div>
</div>
    <?php
    while ($post=mysqli_fetch_assoc($resultid)) {

        $query9 = "SELECT * FROM likes WHERE postid='".$post['postid']."' ";
        $query9 = mysqli_query($connection,$query9);
        $query10 = "SELECT * FROM comment WHERE postid='".$post['postid']."' ";
        $query10 = mysqli_query($connection,$query10);
        $colorquery = "SELECT * FROM likes WHERE postid='" . $post['postid'] . "' AND userid='" . $_COOKIE['userid'] . "'";
        $colorquery = mysqli_query($connection, $colorquery);

    if ($_COOKIE['userid'] == $post['userid']) {
        echo '    
  <br><br><br><br>
<div class="card" id="post' . $post['postid'] . '">
    <div class="post_header">

        <img src="' . $post['imagepro'] . '" alt=""><span class="username">' . $post['username'] . '</span>

        <div class="heading">
            <p class="main_heading"></p>
            <p class="sub_heading"></p>
        </div>
        
            <a href="deletepost.php?id=' . $post['postid'] . '" class="deletpost"><i class="fa fa-times" style="font-size: 15pt"></i></a>
            <br>
            <a href="newpost.php?id='. $post['postid'].'" class="editpost"><i class="fa fa-edit" style="font-size: 15pt"></i></a>
        
        </div>
    <div class="post_img">
        <figure >
        <img src="' . $post['url'] . '" alt="">
        </figure>
    </div>
    <div class="post_footer">
        <div class="left_box">
            <a href="like.php?likeid=' . $post['postid'] . '" class="like"';
        if (mysqli_num_rows($colorquery) == 1) {
            echo ' style="transition: 0.5s;
              font-weight: 700;
              color: darkred!important;
              -webkit-text-stroke-width: 0px;" ';
        }
        echo '><i class="fa fa-heart fa-lg .mbtn" aria-hidden="true" style=""></i></a>
             <span style="padding-right: 2px;"> ' . mysqli_num_rows($query9) . '</span>
            <a href="comment.php?id=' . $post['postid'] . '"  style="color: black !important; "><i class="fa fa-comment-o fa-lg" aria-hidden="true" style="border-left: 2px solid black; padding-left: 5px; margin-left: 3px;"></i></a><span > ' . mysqli_num_rows($query10) . '</span>
        </div>
        
        <div class="post_footer_description">
            <div style="color: black !important; ">
                
                <p class="para1" style="display: inline-block;">
                    ' . $post['description'] . '
                </p>
            </div>
            <div class="right_box">
           <span style="color: silver; font-weight: lighter; font-size: smaller;"> date : ' . $post['date'] . ' </span>
            </div>
        </div>
     </div>
    </div>
      
      ';
    }
    }
    ?>
    </div>
</body>
</html>