<?php
  require_once('startsession.php');

  if(isset($_SESSION['user_id'])) {
?>
<?php ob_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>一起玩 学编程-学设计-找到一起玩的朋友</title>
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
                <li><a href="index.php" class="selected">首页</a></li>
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
<div class="intro-area">
  <div class="intro-content">
    <h1>如何一起玩 ?</h1>
    <h3>"一起玩.today。是一个可以让大家一起玩编程、设计... 的平台，通过私信你想联系的同学，你们可以约去咖啡厅、图书馆等进行交流学习方法。。。。"</h3>
    <div>
      <div class="intro-pic">
        <div class="intro-detail">
          <img src="images/project.png" alt="project">
          <p>1、“找项目”找你想玩的项目。<br/>例如“HTML”。</p>
        </div>
        <div class="intro-detail">
          <img src="images/friend.png" alt="friend">
          <p>2、“找朋友”选择你想一起玩<br/>的伙伴。</p>
        </div>
        <div class="intro-detail">
          <img src="images/location.png" alt="location">
          <p>3、私信交流 or 约到你们想一起<br/>学习的地方大家一起玩吧～</p>
        </div>
      </div>
    </div>
    <i class="fa fa-angle-down fa-3x"></i>
  </div>
</div>
<?
    function custom_echo($x) {
      if(strlen($x) != mb_strlen($x, 'utf-8')) { 
        if(strlen($x)<=33) {
          return $x;
        }
        else {
          $y=mb_substr($x,0,11,'utf-8') . '...';
          return $y;
        }
      }
      else {
        if(mb_strlen($x)<=16) {
          return $x;
        }
        else {
          $y=mb_substr($x,0,16,'utf-8') . '...';
          return $y;
        }
      }
    }

    $query = "SELECT mr.user_id, mr.response_date, mt.name AS topic_name, mu.picture AS picture, mu.username AS username " .
      "FROM match_response AS mr " .
      "INNER JOIN match_topic AS mt USING (topic_id) " .
      "INNER JOIN match_user AS mu USING (user_id) " .
      "WHERE response != 'NULL'" .
      "ORDER BY response_date DESC LIMIT 30 ";

    $data = mysqli_query($dbc, $query);
    $feeds = array();
    while ($row = mysqli_fetch_array($data)) {
      array_push($feeds, $row);
    }
?>
    <div class="allsection">
      <section class="sidebar">
        <h3>初学编程</h3>
        <div>
          <p>
            <a href="http://book.douban.com/subject/25752357/" target="_blank"><strong>1、</strong><img src="images/hf2.png" alt="hf2"><b>Head First HTML与CSS</b></a><br/>你可以从HTML开始学习编程，那么我们建议阅读O'reilly 出版的Head First HTML与CSS ，这本书用浅显的语言和方式讲述正确的道理和方法。是这个地球上最好的html和css入门书，没有之一。<br/>
            <a href="http://teamtreehouse.com/" target="_blank"><strong>2、</strong><img src="images/treehouse.png" alt="treehouse"><b>www.teamtreehouse.com</b></a><br/>TreeHouse是个非常有趣的视频学习网站。如果你希望有人为你详细解说一切，并且了解web的新玩意，就去上 Treehouse 的教学课程吧。
          </p>
        </div>        
        <h3>初学设计</h3>
        <div>
          <p>
            <a href="http://tutsplus.com/" target="_blank"><strong>1、</strong><img src="images/tutsplus.png" alt="tutsplus">&nbsp;<b>www.tutsplus.com</b></a><br/>一级棒的教程网站，有许多创意的设计教程。视觉的设计非常漂亮，在这里肯定能找到你觉得炫酷的东西。<br/>
            <a href="http://www.abduzeedo.com/" target="_blank"><strong>2、</strong><img src="images/abduzeedo.png" alt="abduzeedo">&nbsp;<b>www.abduzeedo.com</b></a><br/>对于初学设计的你，我们建议你直接从tutsplus和abduzeedo里面找到您感兴趣的教程开始学习PS和AI，只要是好玩的就去钻研吧，就这么简单。对于网页设计你就会觉得越来越好玩，这就是我们的目的
          </p>
        </div>
        <h3>中国网络审查</h3>
        <div>
          <p>如果你发现一起玩推荐的网站访问速度慢或者无法访问。没关系，这不是你的问题，当然也不是网站的问题。因为在中国会对互联网进行网络内容审查，这是一种行政行为。你可以使用 "翻墙" 工具登录国外的网站。以下是一起玩推荐的工具:<br/><a href="http://honx.in/i/VLtyvM6vDwo3sn7Y" target="_blank"><img src="images/honx.png" alt="honx">&nbsp;<b>www.dwz.cn/GOvKn</b></a><br/><a href="https://getastrill.com/" target="_blank"><img src="images/astrill.png" alt="astrill">&nbsp;<b>www.dwz.cn/GODpv</b></a><br/>如果你不能接受付费的翻墙工具，网上也有许多免费的翻墙工具。</p>
        </div>
        <h3>意见回馈</h3>
        <div>
          <p>
          <a href="http://www.weibo.com/walizzwell" target="_blank" style="text-decoration:none; color:#000;"><img src="images/sinaweibo.png" alt="sinaweibo"><b>新浪微博</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="weixin-contact" href="http://yiqiwan.today/images/orcode.jpg" target="_blank"><img src="images/weixin.png" alt="weixin"><b>微信</b><span id="pop-up"><img src="images/orcode.jpg" alt="orcode"></span></a><br/>
          如果您有更有趣的学习方式，或者是对于一起玩的建议。欢迎通过一起玩的微博或者微信联系我们。
          </p>
        </div>
      </section>
    <div class="allmymatch">
    <h3><i class="fa fa-paper-plane"></i>&nbsp;&nbsp;最新动态</h3>
<?php
    foreach ($feeds as $feed) {
      $username = $feed['username'];
      $user_id = $feed['user_id'];
      $response_date = $feed['response_date'];
      $topic_name = $feed['topic_name'];

      echo '<div class="mymatch">';
      
      if (!empty($feed['picture'])) {
        echo '<div class="detail-pic"><img src="' . MM_UPLOADPATH . $feed['picture'] . '" alt="Profile Picture" /></div>';
      } else {
        echo '<div class="detail-pic"><img src="images/nopic.png" alt="Profile Picture" /></div>';
      }
      
      echo '<div class="detail"><h4>' . custom_echo($username) . '想和大家一起玩'. $topic_name . '</h4>';
      echo '<p>发布于' . ltrim(date('m月d日 H:i', strtotime($response_date)), '0') . '</p></div>';
      echo '<div class="detail-button"><a href="viewprofile.php?user_id=' . $user_id . '" target="_blank">查看详情</a></div></div>';
    }

    mysqli_close($dbc);

    echo "</div></div>";
    require_once('footer.php');
  }
  else {
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>一起玩 学编程-学设计-找到一起玩的朋友</title>
    <meta name="keywords" content="学习编程,学习设计,编程,编程入门,网页设计,网页设计学习,一起玩,一起学习,找朋友,找小伙伴,找同学,html,css,javascript,python,rails,php,ios,andriod,ps,ai,photoshop,illustrator">
    <meta name="description" content="yiqiwan.today是提供一起玩编程、设计的平台，通过私信你想联系的同学，你们可以约去咖啡厅、图书馆等进行交流学习方法，帮助你结识志同道合的小伙伴">
    <link rel="shortcut icon" href="images/favicon.png">
    <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="layout.css">
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
    <div class="wrapper">
        <header>
          <div class="nav">
            <a href="index.php"><img src="images/logo.png" alt="logo"></a>
            <span>
              <img src="images/ps-logo.png" alt="ps-logo">
              <img src="images/ai-logo.png" alt="ai-logo">
              <img src="images/python-logo.png" alt="python-logo">
              <img src="images/rails-logo.png" alt="rails-logo">
              <img src="images/php-logo.png" alt="php-loho">
            </span>
          </div>
        </header>
        <div class="allcontent">
            <div class="banner1">
                <p class="text-1">今天, 我们一起玩吧!</p>
                <p class="text-2">学编程 - 学设计 - 找到一起玩的朋友</p>
                <p class="text-3">点击视频了解一起玩网站的介绍，找到小伙伴和你一起玩吧。You'll Never Play Alone™</p>
            </div>
            <div class="banner2">
                <p>
                  <a href="#">
                    <img src="images/video-pic2.jpg" alt="video-pic2" />
                  </a>
                </p>
            </div>
            <div class="warp1">
              <div class="inner-warp">
                  <a class="button" href="login.php">登 录</a>
              </div>
            </div>
            <div class="warp2">
              <div class="inner-warp">
                  <a class="button" href="signup.php">注 册</a>
              </div>
            </div>
            <div id="youku">
                <div id="youku-embed">
                    <a href="#" id="close"><img src="images/close.png" alt="close"></a>
                    <div id="youku-embed-inside">
                        <embed src="http://static.youku.com/v/swf/qplayer.swf?VideoIDS=XOTM1MjQ5Nzk2=&amp;isAutoPlay=true&amp;isShowRelatedVideo=false&amp;embedid=-&amp;showAd=0" allowFullScreen="true" quality="high" width="850" height="518" allowScriptAccess="always" type="application/x-shockwave-flash" />
                    </div>
                </div>
            </div>
        </div>
        <div class="push"></div>
    </div>
    <div class="footer">
      <div class="container">
        <p class="footer1">You'll Never Play Alone™</p>
        <p class="footer2"><a href="about.php">关于一起玩</a></p>
      </div>
    </div>
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
        $(".banner2").click(function(){
            $("#youku").show();
        });
        $("#close").click(function(){
            $("#youku").hide();
        });
    </script>
</body>
</html>
<?php
  }
?>
