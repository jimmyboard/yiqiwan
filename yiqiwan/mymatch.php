<?php
  // Start the session
  require_once('startsession.php');

  // Insert the page header
  $page_title = '一起玩的人';
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
                <li><a href="questionnaire.php">找项目</a></li>
                <li><a href="mymatch.php" class="selected">找朋友</a></li>
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
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">请 <a href="login.php">登录</a> 后访问此页.</p>';
    exit();
  }

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

  // Only look for a match if the user has questionnaire responses stored
  $query = "SELECT * FROM match_response WHERE user_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query);
  $alls = array();
  while ($row = mysqli_fetch_array($data)) {
      array_push($alls, $row);
  }

  $tt = 0;
  foreach ($alls as $all) {
    if ($all['response'] != NULL)
      $tt = $all['response'];
  }

  // echo '<pre>'; print_r($tt); echo '</pre>';

  if (mysqli_num_rows($data) != 0 && $tt != 0) {
    // First grab the user's responses from the response table (JOIN to get the topic)
    $query = "SELECT mr.response_id, mr.topic_id, mr.response, mt.name AS topic_name, mu.area AS area, mu.street AS street " .
      "FROM match_response AS mr " .
      "INNER JOIN match_topic AS mt USING (topic_id) " .
      "INNER JOIN match_user AS mu USING (user_id)" .
      "WHERE mr.user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $user_responses = array();
    while ($row = mysqli_fetch_array($data)) {
      array_push($user_responses, $row);
    }

    $results = array();


    // Loop through the user table comparing other people's responses to the user's responses
    $query = "SELECT user_id FROM match_user WHERE user_id != '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
      // Grab the response data for the user (a potential match)
      $query2 = "SELECT response_id, topic_id, response, response_date, mu.area AS area, mu.street AS street " .
        "FROM match_response " .
        "INNER JOIN match_user AS mu USING (user_id)" .
        "WHERE user_id = '" . $row['user_id'] . "'";
      $data2 = mysqli_query($dbc, $query2);
      $match_responses = array();
      while ($row2 = mysqli_fetch_array($data2)) {
        array_push($match_responses, $row2);
      } // End of inner while loop

      // Compare each response and calculate a match total
      $score = 0;
      $area = 0;
      $street = 0;
      $topics = array();
      for ($i = 0; $i < count($user_responses); $i++) {
        if (isset($match_responses[$i]['response'])) {
          if ($user_responses[$i]['response'] + $match_responses[$i]['response'] == 2) {
            $score += 1;
            $response_date = $match_responses[$i]['response_date'];
            array_push($topics, $user_responses[$i]['topic_name']);
            if ($user_responses[$i]['area'] == $match_responses[$i]['area']) {
              $area = 1;
            }
            if ($user_responses[$i]['street'] == $match_responses[$i]['street']) {
              $street = 1;
            }
          }
        }
      }

      if ($score > 0) {
        $info = array();
        $info['user_id'] = $row['user_id'];
        $info['score'] = $score;
        $info['area'] = $area;
        $info['street'] = $street;
        $info['response_date'] = $response_date;
        $info['match_topics'] = array_slice($topics, 0);
        array_push($results, $info);
      }
    } // End of outer while loop

    function compare($x, $y) {
      $criteria = array(
        'street' => 'desc',
        'area' => 'desc',
        'response_date'=>'desc',
        'score'=>'desc'  //这里还可以根据需要继续加条件 如:'x'=>'asc'等
      );
      foreach($criteria as $what => $order){
        if($x[$what] == $y[$what]){
            continue;
        }
        return (($order == 'desc')?-1:1) * (($x[$what] < $y[$what]) ? -1 : 1);
      }
      return 0;
    }

    usort($results, 'compare');

    // echo '<pre>'; print_r($results); echo '</pre>';

    if (count($results) == 0) {
      echo "<h2 class='noPeople'>咦...... 暂时还没有人想玩这个项目</h2>";
      exit();
    }
    else{
      echo '<div class="allsection"><div class="allmymatch"><h3><i class="fa fa-paper-plane"></i>&nbsp;找到'. count($results) . '个想和你一起玩的朋友</h3><p style="margin-bottom: 0;">以下结果按距离排序</p>';
    }

    foreach ($results as $result) {
      $user_id = $result['user_id'];
      $match_topics = $result['match_topics'];
      $response_date = $result['response_date'];

      $query = "SELECT username, area, street, picture FROM match_user WHERE user_id = '$user_id'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 1) {
        // The user row for the match was found, so display the user data
        $row = mysqli_fetch_array($data);

        echo '<div class="mymatch">';
        if (!empty($row['picture'])) {
          echo '<div class="detail-pic"><img src="' . MM_UPLOADPATH . $row['picture'] . '" alt="Profile Picture" /></div>';
        }
        else {
          echo '<div class="detail-pic"><img src="images/nopic.png" alt="Profile Picture" /></div>';
        }

        echo '<div class="detail">';
        if (!empty($row['username'])) {
          echo '<h4>' . custom_echo($row['username']) . '也想一起玩';
        }
        $i = 0;
        foreach ($match_topics as $topic) {
          echo $topic . '</h4>';
          if (++$i > 3) {
            $i = 0;
          }
        }
        if (!empty($row['area']) && !empty($row['street'])) {
          echo '<p>常居地: ' . $row['area'] . $row['street'] . '</p>';
        }
        echo '<p>发布于' . ltrim(date('m月d日 H:i', strtotime($response_date)), '0') . '</p></div>';

        echo '<div class="detail-button"><a href="viewprofile.php?user_id=' . $user_id . '" target="_blank">查看详情</a></div></div>';
      } // End of check for a single row of match user results
    } // End of check for a user match
?>
      </div>
      <section class="sidebar" style="margin-top:4em">
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
          <a href="http://www.weibo.com/walizzwell" target="_blank" style="text-decoration:none; color:#000;"><img src="images/sinaweibo.png" alt="sinaweibo"><b>新浪微博</b></a>&nbsp;&nbsp;&nbsp;&nbsp;<a id="weixin-contact" href="http://yiqiwan.today/test/images/orcode.jpg" target="_blank"><img src="images/weixin.png" alt="weixin"><b>微信</b><span id="pop-up"><img src="images/orcode.jpg" alt="orcode"></span></a><br/>
          如果您有更有趣的学习方式，或者是对于一起玩的建议。欢迎通过一起玩的微博或者微信联系我们。
          </p>
        </div>
      </section>
      </div>
<?php
  } // End of check for any questionnaire response results
  else {
    echo '<h2 class="noPeople">你必须先 <a href="questionnaire.php">选择你想玩的项目</a> 才能找到一起玩的朋友</h2>';
  }

  mysqli_close($dbc);

  // Insert the page footer
  require_once('footer.php');
?>
