<?php
  require_once('startsession.php');

  $page_title = '私信';
  require_once('header.php');

  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">请 <a href="login.php">登录</a> 后访问此页.</p>';
    exit();
  }

  $query = "UPDATE match_conversation SET status = '0' WHERE user_two = '" . $_SESSION['user_id'] . "'";
    mysqli_query($dbc, $query);

  $query = "SELECT u1.username AS sender, u2.username AS recipient, u1.picture AS picture,mc.user_one, mc.user_two, mc.content, mc.c_date " .
    "FROM match_conversation AS mc " .
    "LEFT JOIN `match_user` u1 ON (u1.user_id = mc.user_one) " .
    "LEFT JOIN `match_user` u2 ON (u2.user_id = mc.user_two) " .
    "WHERE user_one = '" . $_SESSION['user_id'] . "' OR user_two = '" . $_SESSION['user_id'] .
    "' ORDER BY c_date DESC";

  $data = mysqli_query($dbc, $query);
  $conversations = array();
  while ($row = mysqli_fetch_array($data)) {
    array_push($conversations, $row);
  }

  if (count($conversations) == 0) {
    echo "<h2 class='noPeople'>还没有人给你发私信，不如你主动一点，给一起玩的小伙伴发一封问候私信吧:)</h2>";
    exit();
  }

  // echo '<pre>'; print_r($conversations); echo '</pre>';

  echo '<div class="allmyinbox"><h3><i class="fa fa-envelope-o"></i>&nbsp;我的私信</h3>';

  foreach ($conversations as $conversation) {
    $user_one = $conversation['user_one'];
    $sender = $conversation['sender'];
    $recipient = $conversation['recipient'];
    $picture = $conversation['picture'];
    $content = $conversation['content'];
    $c_date = $conversation['c_date'];

    echo '<div class="myinbox">';

    if (!empty($picture)) {
      echo '<a href="viewprofile.php?user_id=' . $user_one . '"><img class="myinbox-pic" src="' . MM_UPLOADPATH . $picture . '" alt="Profile Picture"></a>';
    } else {
      echo '<a href="viewprofile.php?user_id=' . $user_one . '"><img class="myinbox-pic" src="images/nopic.png" alt="Profile Picture" /></a>';
    }

    echo '<div class="myinbox-detail">' . $sender . ' 发送给' . $recipient . ' :<br/>';

    echo nl2br($content) . '<br/>';

    echo '<span style="font-size: 12px; color: #999;">' . ltrim(date('m月d日 H:i', strtotime($c_date)), '0') . '</span>';

    if ($user_one != $_SESSION['user_id']) {
      echo '<span style="color: #BBB;"> | </span><a href="conversation.php?user_id=' . $user_one . '"><span>回复</span></a>';
    }

    echo '</div></div>';
  }

  echo '</div>';
  mysqli_close($dbc);
?>


<?php
  require_once('footer.php');
?>
