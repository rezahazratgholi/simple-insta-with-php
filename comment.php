<?php
include ("assets/php/connection.php");
include "assets/php/check_login.php";
// this query is for useable tables for name showing and....
$query = "SELECT * FROM `post` INNER JOIN useres ON useres.userid=post.userid WHERE postid = '".$_GET['id']."'";
$query = mysqli_query($connection , $query);
$query = mysqli_fetch_assoc($query);
// this query is for likes count
$querylike = "SELECT * FROM likes WHERE postid='".$_GET['id']."' ";
$querylike = mysqli_query($connection,$querylike);
// this query is for comments
$querylcomment = "SELECT * FROM comment WHERE postid='".$_GET['id']."' ";
$querylcomment = mysqli_query($connection,$querylcomment);
// like color
$colorquery = "SELECT * FROM likes WHERE postid='".$_GET['id']. "' AND userid='" . $_COOKIE['userid'] . "'";
$colorquery = mysqli_query($connection, $colorquery);
// adding comments to a post
if (isset($_POST['commentpost'])){
    $now = date("Y-m-d");
    $query1 = "INSERT INTO comment(postid , userid , text , `date`) VALUES ('".$_GET['id']."','".$_COOKIE['userid']."','".$_POST['comment']."','".$now."')";
    $result1 = mysqli_query($connection,$query1);
    if($result1){
        // echo "done";
        header("Refresh:0");
//        header("Location: home.php");
    }else{
        echo $connection->error;
    }

}
?>
<!doctype html>
<html lang="en">
<head>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background: -webkit-linear-gradient(#8CA6DB, #B993D6);
            background: linear-gradient(#8CA6DB, #B993D6);
        }
        .container{
            /*display: flex;*/

            justify-content: center;
            align-items: center;

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
            width: 100px;
        }

        .ghost-round:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            -webkit-transition: all .2s ease;
            transition: all .2s ease;
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
            width: 200px;
            margin-left: 50px;
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
    <title>comment</title>
    <?php include 'template/head.php'?>
</head>
<body>

    <?php include 'template/header.php'?>
    <div class="container">
    <br><br><br>
    <div class="card" >
        <div class="post_header">

            <img src=<?php echo $query['imagepro']; ?> alt=""><span class="username"><?php echo $query['username']; ?></span>

            <div class="heading">
                <p class="main_heading"></p>
                <p class="sub_heading"></p>
            </div>
        </div>
        <div class="post_img">
            <figure>
                <img src="<?php echo $query['url'];?>" >
            </figure>
        </div>
        <div class="post_footer">
            <div class="left_box">
                <a href=like1.php?likeid=<?php echo $_GET["id"];?> class="like" <?php if (mysqli_num_rows($colorquery) == 1){ echo 'style="transition: 0.5s; font-weight: 700; color: darkred!important; -webkit-text-stroke-width: 0px;"';}  ?> > <i class="fa fa-heart fa-lg .mbtn" aria-hidden="true" style=""></i></a><span style="padding-right: 2px;"> <?php echo mysqli_num_rows($querylike);?></span>
                <i class="fa fa-comment-o fa-lg" aria-hidden="true" style="border-left: 2px solid black; padding-left: 5px; margin-left: 3px;"></i><span > <?php echo mysqli_num_rows($querylcomment);?></span>
            </div>
            <div class="post_footer_description">
                <div style="color: black !important; ">


                    <br>
                    <p class="para1" style="display: inline-block;">
                        <?php echo $query['description'];?>
                    </p>
                </div>
                <div class="right_box">
            <span style="color: gray(); font-size:large ;">
                date : <?php echo $query['date']; echo '<br><br><br>'; ?>
            </span>
                </div>
            </div>
        </div>

        <?php
        $query2 = "SELECT * FROM `comment` INNER JOIN useres ON comment.userid=useres.userid WHERE postid='".$_GET['id']."'";
        $query2 = mysqli_query($connection,$query2);

        while($comment = mysqli_fetch_assoc($query2)) {
            echo '
    
    
            <p style="color: gray; font-weight: lighter; " >
             comment by: '.$comment['username'].'   '.$comment['text'].'
             <br>
            <span style="color: silver; font-weight: lighter;">'.$comment['date'].'</span>
            </p>
    ';
        }
        ?>
    </div>


<hr>
    </div>
    <div class="container2">
        <div class='bold-line'></div>
        <div class="container1">

            <div class='window'>
                <div class='overlay'></div>
                <div class='content'>
                    <div class='welcome'>comment</div>
<form action="" method="POST">
    <div class='form-group'>

        <textarea  placeholder='write your comment' class='input-line full-width' name="comment" row="5"></textarea></textarea>
    </div>
    <button class='ghost-round full-width' name="commentpost">sumbit your comment</button>

</form>
                </div>
            </div>
        </div>
</div>



</body>
</html>
