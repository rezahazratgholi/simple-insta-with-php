<?php
include 'assets/php/connection.php';
include "assets/php/check_login.php";
$query = "SELECT * FROM post INNER JOIN useres ON post.userid=useres.userid  ORDER BY postid DESC";
$result = mysqli_query($connection,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'template/head.php'; ?>
    <title>Document</title>


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


  </style>
</head>
<body>
<?php include 'template/header.php';
?>
<div class="container pt-4">
  <a href="newpost.php" ><button type="button" class="ghost-round">new post</button></a>
    <br>
    <?php
    while ($post=mysqli_fetch_assoc($result)) {

        $query9 = "SELECT * FROM likes WHERE postid='".$post['postid']."' ";
        $query9 = mysqli_query($connection,$query9);
        $query10 = "SELECT * FROM comment WHERE postid='".$post['postid']."' ";
        $query10 = mysqli_query($connection,$query10);
        $colorquery = "SELECT * FROM likes WHERE postid='" . $post['postid'] . "' AND userid='" . $_COOKIE['userid'] . "'";
        $colorquery = mysqli_query($connection, $colorquery);


        echo '    
  <br><br><br><br>
<div class="card" id="post'.$post['postid'].'">
    <div class="post_header">

        <img src="'.$post['imagepro'].'" alt=""><span class="username">'.$post['username'].'</span>

        <div class="heading">
            <p class="main_heading"></p>
            <p class="sub_heading"></p>
        </div>';
        if ($_COOKIE['userid'] == $post['userid']){
        echo '<a href="deletepost.php?id='.$post['postid'].'" class="deletpost"><i class="fa fa-times" style="font-size: 15pt"></i></a>';
        }
            echo '</div>
    <div class="post_img">
        <figure >
        <img src="'.$post['url'].'" alt="">
        </figure>
    </div>
    <div class="post_footer">
        <div class="left_box">
            <a href="like.php?likeid='.$post['postid'].'" class="like"';
        if (mysqli_num_rows($colorquery) == 1) {
        echo ' style="transition: 0.5s;
              font-weight: 700;
              color: darkred!important;
              -webkit-text-stroke-width: 0px;" ';}
            echo '><i class="fa fa-heart fa-lg .mbtn" aria-hidden="true" style=""></i></a>
             <span style="padding-right: 2px;"> '.mysqli_num_rows($query9).'</span>
            <a href="comment.php?id='.$post['postid'].'"  style="color: black !important; "><i class="fa fa-comment-o fa-lg" aria-hidden="true" style="border-left: 2px solid black; padding-left: 5px; margin-left: 3px;"></i></a><span > '.mysqli_num_rows($query10).'</span>
        </div>
        
        <div class="post_footer_description">
            <div style="color: black !important; ">
                
                <p class="para1" style="display: inline-block;">
                    '.$post['description'].'
                </p>
            </div>
            <div class="right_box">
           <span style="color: silver; font-weight: lighter; font-size: smaller;"> date : '.$post['date'].' </span>
            </div>
        </div>
     </div>
    </div>
      
      ';}
    ?>

    </div>
</body>
</html>