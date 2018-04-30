<?php
  require_once('startsession.php');

  $page_title = '私信对话';
  require_once('header.php');

  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">请 <a href="login.php">登录</a> 后访问此页.</p>';
    exit();
  }

  if (isset($_GET['user_id']) && ($_GET['user_id'] != $_SESSION['user_id'])) {
    $query = "SELECT username, picture FROM match_user WHERE user_id = '" . $_GET['user_id'] . "'";

    $data = mysqli_query($dbc, $query);

    if (mysqli_num_rows($data) == 1) {
      $row = mysqli_fetch_array($data);
      echo '<div class="allprofile">';
    }

    if (isset($_POST['submit'])) {
      $content = $_POST['yiqiwancontent'];
      $output_form = false;

      if (empty($content)) {
        echo '<p class="error">请填写私信内容</p>';
        $output_form = true;
      }
    }
    else {
      $output_form = true;
    }

    if (!empty($content)) {
      
      $query2 = "INSERT INTO match_conversation (user_one, user_two, content, c_date, status) VALUES ('" . $_SESSION['user_id']. "', '" . $_GET['user_id'] . "', '$content', NOW(), '1')";
      $content = str_replace("<br />", PHP_EOL, mysqli_real_escape_string($dbc, trim($content)));
      mysqli_query($dbc, $query2);

      echo '<h2 class="noPeople">私信发送成功</h2>';
      header("refresh:1;url=inbox.php");
      exit();
    }
    if (!empty($row['picture'])) {
      echo '<a href="viewprofile.php?user_id=' . $_GET['user_id'] . '"><img src="' . MM_UPLOADPATH . $row['picture'] .
        '" alt="Profile Picture" /></a>';
    }
    else {
      echo '<a href="viewprofile.php?user_id=' . $_GET['user_id'] . '"><img src="images/nopic.png" alt="Profile Picture" /></a>';
    }

    if ($output_form) {
?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?user_id=' . $_GET['user_id']; ?>">
        <div class="conversation">
          <p>
            <label>发给:</label>
            <span><?php echo $row['username']; ?></span>
          </p>
          <p>
            <label for="yiqiwancontent">私信内容:</label>
            <textarea id="yiqiwancontent" name="yiqiwancontent" rows="20" cols="68" maxlength="3000"><?php if(!empty($content)) echo $content; ?></textarea>
          </p>
        </div>
        <p><input class="changeButton" type="submit" name="submit" value="发送私信" /></p>
      </form>
    </div>
<?php
    }
  } else {
      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewprofile.php?' . SID;
      header('Location: ' . $home_url);
  }
  mysqli_close($dbc);
?>


<?php
  require_once('footer.php');
?>
