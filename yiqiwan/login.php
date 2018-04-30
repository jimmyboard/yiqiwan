<?php
  require_once('connectvars.php');

  // Start the session
  session_start();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      mysqli_query($dbc, "set character set 'utf8'");//读库 
      mysqli_query($dbc, "set names 'utf8'");//写库 

      // Grab the user-entered log-in data
      $user_email = mysqli_real_escape_string($dbc, trim($_POST['email']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_email) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, email FROM match_user WHERE email = '$user_email' AND password = SHA('$user_password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['email'] = $row['email'];
          setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('email', $row['email'], time() + (60 * 60 * 24 * 30));  // expires in 30 days          
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = '邮箱或密码错误.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = '邮箱或密码错误';
      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>一起玩 - 登录</title>
  <meta name="keywords" content="学习编程,学习设计,编程,编程入门,网页设计,网页设计学习,一起玩,一起学习,找朋友,找小伙伴,找同学,html,css,javascript,python,rails,php,ios,andriod,ps,ai,photoshop,illustrator">
  <meta name="description" content="yiqiwan.today是提供一起玩编程、设计的平台，通过私信你想联系的同学，你们可以约去咖啡厅、图书馆等进行交流学习方法，帮助你结识志同道合的小伙伴">
  <link rel="stylesheet" href="enter-style.css" charset="utf-8">
  <link rel="shortcut icon" href="images/favicon.png">
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
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="logo">
      <a href="index.php"><img src="images/logo.png" alt="logo"></a>
    </div>
    <?php
      // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
      if (empty($_SESSION['user_id'])) {
        echo '<p class="error">' . $error_msg . '</p>';
    ?>
    <p>
      <label for="email">邮箱</label>
      <input id="email" name="email" type="text" value="<?php if (!empty($user_email)) echo $user_email; ?>">
    </p>
    <p>
      <label for="password">密码</label>
      <input id="password" name="password" type="password">
    </p>
    <p>
      <input type="submit" value="登录" name="submit">
    </p>
  </form>
  <div class="note">
    <p>还没有一起玩帐号？<a href="signup.php">立即注册</a></p>
  </div>
<?php
    }
    else {
      // Confirm the successful log-in
      echo('<p class="login">You are logged in as ' . $_SESSION['email'] . '.</p>');
    }
?>
</body>
</html>
