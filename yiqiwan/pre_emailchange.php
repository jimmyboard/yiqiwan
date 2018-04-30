<?php
  require_once('startsession.php');

  $page_title = '修改资料';
  require_once('header.php');

  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">请 <a href="login.php">登录</a> 后访问此页.</p>';
    exit();
  }
?>

<body onload="setup();preselect('<?php if(!empty($area)) echo $area; ?>');">
  <div class="allprofile">

<?php
  // echo '<pre>'; print_r($_POST); print_r($_FILES); echo '</pre>';

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    $error = false;

    $query = "SELECT * FROM match_user WHERE email = '$email'";
    $data = mysqli_query($dbc, $query);
    if (mysqli_num_rows($data) == 0) {
      if (!empty($email)) {
        if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/', $email)) {
          $error = true;
          echo '<p class="error">您的email地址不正确.</p>';
        }
        else {
          $domain = preg_replace('/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/', '', $email);
          if (!checkdnsrr($domain)) {
            $error = true;
            echo '<p class="error">您的email地址不正确.</p>';
          }
        }
      }

      // Update the profile data in the database
      if (!$error) {
        if (!empty($email)) {
          // Only set the picture column if there is a new picture
          $query = "UPDATE match_user SET email = '$email' WHERE user_id = '" . $_SESSION['user_id'] . "'";
          mysqli_query($dbc, $query);

          // Confirm success with the user
          echo '<h2 class="noPeople">修改成功，您可以查看 <a href="viewprofile.php">我的资料</a></h2>';

          mysqli_close($dbc);
          exit();
        }
        else {
          echo '<p class="error">邮箱不能为空</p>';
        }
      }
    }
    else {
      echo '<p class="error">邮箱已存在，请输入其他邮箱</p>';
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT email, picture FROM match_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $email = $row['email'];
      $old_picture = $row['picture'];
    }
    else {
      echo '<p class="error">访问您的资料有误</p>';
    }

    // echo '<pre>'; print_r($row); echo '</pre>';
  }

  mysqli_close($dbc);
?>

    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="hidden" name="MAX_FILE_SIZE" />
        <div class="editprofile">
          <?php
          if (!empty($old_picture)) {
            echo '<div><img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" /></div>';
          } else {
            echo '<div><img class="profile" src="images/nopic.png" alt="Profile Picture" /></div>';
          }
          ?>
          <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
        </div>
        <div class="editprofile-details">
          <p>
            <label for="email">当前邮箱:</label>
            <span><?php if (!empty($email))  echo $email; ?></span>
          </p>
          <p>
            <label for="email">新邮箱:</label>
            <input id="email" name="email" type="text" size="30"/>
          </p>
          <p>
            <input class="changeButton" type="submit" value="保存修改" name="submit" />
          </p>
        </div>
    </form>
  </div>
<?php
  require_once('footer.php');
?>
