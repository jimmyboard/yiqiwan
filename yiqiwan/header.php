<?php ob_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
<?php
  echo '<title>一起玩 - ' . $page_title . '</title>';
?>
    <meta name="keywords" content="学习编程,学习设计,编程,编程入门,网页设计,网页设计学习,一起玩,一起学习,找朋友,找小伙伴,找同学,html,css,javascript,python,rails,php,ios,andriod,ps,ai,photoshop,illustrator">
    <meta name="description" content="yiqiwan.today是提供一起玩编程、设计的平台，通过私信你想联系的同学，你们可以约去咖啡厅、图书馆等进行交流学习方法，帮助你结识志同道合的小伙伴">
    <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <!-- 
    <script type="text/javascript">
      var _hmt = _hmt || [];
      (function() {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?ed6a418e44c13fa8139e9d035a6104ac";
        var s = document.getElementsByTagName("script")[0]; 
        s.parentNode.insertBefore(hm, s);
      })();
    </script>
     -->
</head>
<body>
<header>
    <div class="nav">
        <a href="index.php"><img src="images/logo.png" alt="logo"></a>
        <div id="Navigation">
            <ul class="Navigation">
                <li><a href="index.php">首页</a></li>
                <li><a href="questionnaire.php">找项目</a></li>
                <li><a href="mymatch.php">找朋友</a></li>
                <li><a href="viewprofile.php" class="fa fa-bars"></a>
<?php
  require_once('appvars.php');
  require_once('connectvars.php');


  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
  mysqli_query($dbc, "set character set 'utf8'");//读库 
  mysqli_query($dbc, "set names 'utf8'");//写库 


  $query = "SELECT c_id FROM match_conversation WHERE user_two = '" . $_SESSION['user_id'] . "' AND status = 1";
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) != 0) {
    echo '<span id="notice-top"></span>';
  }
?>               
                    <ul>
                        <li><a href="viewprofile.php"><i class="fa fa-user"></i>&nbsp;&nbsp;我的资料</a></li>
                        <li><a href="inbox.php"><i class="fa fa-envelope-o"></i>&nbsp;私信
<?php 
  if (mysqli_num_rows($data) != 0) {
    echo '<span id="notice"></span>';
  }
?>
                        </a></li>
                        <li><a href="editprofile.php"><i class="fa fa-pencil-square-o"></i>&nbsp;设置</a></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out"></i>&nbsp;退出</a></li>
                    </ul>         
                </li> 
            </ul>
        </div>    
    </div>
</header>