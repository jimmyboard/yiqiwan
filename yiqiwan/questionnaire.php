<?php
  require_once('startsession.php');

  $page_title = '你想玩什么';
?>
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
                <li><a href="questionnaire.php" class="selected">找项目</a></li>
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
<?
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">请 <a href="login.php">登录</a> 后访问此页.</p>';
    exit();
  }

  //  第一部分  ----------------------------------------------------------------------------------------------------

  $query = "SELECT * FROM match_response WHERE user_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query);
  if (mysqli_num_rows($data) == 0) {
    $query = "SELECT topic_id FROM match_topic ORDER BY topic_id";
    $data = mysqli_query($dbc, $query);
    $topicIDs = array();
    while ($row = mysqli_fetch_array($data)) {
      array_push($topicIDs, $row['topic_id']);
    }

    foreach ($topicIDs as $topic_id) {
      $query = "INSERT INTO match_response (user_id, topic_id, response_date) VALUES ('" . $_SESSION['user_id']. "', '$topic_id', NOW())";
      mysqli_query($dbc, $query);
    }
  }

  //  第二部分  ----------------------------------------------------------------------------------------------------

  if (isset($_POST['submit'])) {
    $response_id = $_POST["radiobutton"];
    $query = "UPDATE match_response SET response = NULL, response_date = NOW() WHERE user_id = '" . $_SESSION['user_id'] . "'";
    mysqli_query($dbc, $query);
    
    $query = "UPDATE match_response SET response = '1' WHERE response_id = '$response_id'";
    mysqli_query($dbc, $query);
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/mymatch.php?' . SID;
    header('Location: ' . $home_url);
    exit();
  }

  //  第三部分  ----------------------------------------------------------------------------------------------------

  $query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name " .
    "FROM match_response AS mr " .
    "INNER JOIN match_topic AS mt USING (topic_id) " .
    "WHERE mr.user_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query);
  $responses = array();
  while ($row = mysqli_fetch_array($data)) {
    array_push($responses, $row);
  }

  mysqli_close($dbc);

  //  第四部分  ----------------------------------------------------------------------------------------------------

  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
  echo '<div class="main"><h2>选择你想和大家一起玩的项目?</h2>';

  foreach ($responses as $response) {
    echo '<div class="radioholder"><input type="radio" id="' . $response['response_id'] . '" name="radiobutton" value="' . $response['response_id'] . '" ' . ($response['response'] == 1 ? 'checked="checked"' : '') . ' /><label> ' . $response['topic_name'] . '</label></div>';
  }
  echo '<input type="submit" value="提交" name="submit" /></div>';
  echo '</form>';
?>
    <footer>
      <div class="container">
        <p class="footer">You'll Never Play Alone™</p>
        <p class="footer-last"><a href="about.php">关于一起玩</a></p>
      </div>
    </footer>
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
        // preload image function
        function preload(arrayOfImages) {
            $(arrayOfImages).each(function(){
                $('<img/>')[0].src = this;
            });
        }

        $(document).ready(function(){

          // set up radio boxes
            $('.radioholder').each(function(){
                $(this).children().hide();
                var description = $(this).children('label').html();
                $(this).append('<span class="desc">'+description+'</span>');
                $(this).prepend('<span class="tick"></span>');
                // on click, update radio boxes accordingly
                $(this).click(function(){
                    $(this).children('input').prop('checked', true);
                    $(this).children('input').trigger('change');
                });
            });
            // update radio holder classes when a radio element changes
            $('input[type=radio]').change(function(){
            $('input[type=radio]').each(function(){
              if($(this).prop('checked') == true) {   
                $(this).parent().addClass('activeradioholder');
              }
                    else $(this).parent().removeClass('activeradioholder');
                });
            });
            // manually fire radio box change event on page load
            $('input[type=radio]').change();
            
            // preload hover images
          preload([
            'images/radio_tick.png'
          ]);

        });
    </script>
    <script type="text/javascript">
            if (document.body.clientHeight <= window.screen.availHeight){
                var footer = document.getElementsByTagName("footer")[0];
                footer.className = "fixed";
            }
    </script>
</body>
</html>

