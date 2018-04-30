<?php
  require_once('startsession.php');

  $page_title = '查看详情';
  require_once('header.php');

  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">请 <a href="login.php">登录</a> 后访问此页.</p>';
    exit();
  }

  function put_url_in_a($arr) {
    return sprintf('<a href="%1$s" target="_blank">%1$s</a>', $arr[0]);
  }

  if (!isset($_GET['user_id'])) {
    $query = "SELECT user_id, username, gender, area, street, email, picture, resume, job, education FROM match_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
  }
  else {
    $query = "SELECT user_id, username, gender, area, street, email, picture, resume, job, education FROM match_user WHERE user_id = '" . $_GET['user_id'] . "'";
  }
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    $row = mysqli_fetch_array($data);
    // echo '<pre>'; print_r($row); echo'</pre>';

    $query2 = "SELECT mt.name AS topic_name " .
    "FROM match_response AS mr " .
    "INNER JOIN match_topic AS mt USING (topic_id) " .
    "WHERE response != 'NULL' && user_id = '" . $row['user_id'] . "'";
    $data2 = mysqli_query($dbc, $query2);
    $row2 = mysqli_fetch_array($data2);

    // echo '<pre>'; print_r($row2['topic_name']); echo '</pre>';

    echo '<div class="allprofile">';
    if (!empty($row['picture'])) {
      echo '<img src="' . MM_UPLOADPATH . $row['picture'] .
        '" alt="Profile Picture" />';
    }
    else {
      echo '<img src="images/nopic.png" alt="Profile Picture" />';
    }
    echo '<div class="viewprofile">';
    if (!empty($row['username'])) {
      echo '<span>用户名: ' . $row['username'] . '</span><br/>';
    }
    if (!empty($row['gender'])) {
      echo '<span>性别: ';
      if ($row['gender'] == 'M') {
        echo '男';
      }
      else if ($row['gender'] == 'F') {
        echo '女';
      }
      else {
        echo '?';
      }
      echo '</span><br/>';
    }
    if (!empty($row['area']) && !empty($row['street'])) {
      echo '<span>常居地: ' . $row['area'] . $row['street'] . '</span><br/>';
    }
    if (!empty($row['email'])) {
      echo '<span>邮箱: ' . $row['email'] . '</span><br/>';
    }
    if (!empty($row['job'])) {
      echo '<span>职业经历: ' . $row['job'] . '<span><br/>';
    }
    if (!empty($row['education'])) {
      echo '<span>教育经历: ' . $row['education'] . '<span><br/>';
    }
    if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
      echo '<div><a href="editprofile.php"><button>修改资料</button></a></div>';
    }
    if (isset($_GET['user_id']) && ($_SESSION['user_id'] != $_GET['user_id'])) {
      echo '<div><a href=conversation.php?user_id=' . $_GET['user_id'] . '><button>约Ta一起玩</button></a></div>';
    }
    echo '</div><div class="resume">';
    if (!empty($row2['topic_name'])) {
      echo '<div class="resume-detail">Ta想玩</div><span style="margin-left: 16px;">' . $row2['topic_name'] . '</span>';
    }
    else {
      echo '<div class="resume-detail">Ta想玩</div><span>还没有选择想玩的项目</span>';
    }
    if (!empty($row['resume'])) {
      echo '<div class="resume-detail">个人简介</div><span style="font-size:13px;">' . preg_replace_callback('#(?<!href\=[\'"])(https?|ftp|file)://[-A-Za-z0-9+&@\#/%()?=~_|$!:,.;]*[-A-Za-z0-9+&@\#/%()=~_|$]#', 'put_url_in_a', nl2br($row['resume'])) . '</span>';
    }
    else {
      echo '<div class="resume-detail">个人简介</div><span>暂时没有个人简介</span>';
    }
    echo '</div></div>';
  }
  else {
    echo '<p class="error">访问您的资料出错.</p>';
  }

  mysqli_close($dbc);
?>

<?php
  require_once('footer.php');
?>
