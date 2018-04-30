<?php ob_start(); ?>
<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 
  mysqli_query($dbc, "set character set 'utf8'");//读库 
  mysqli_query($dbc, "set names 'utf8'");//写库 
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>一起玩 - 注册</title>
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
<body onload="setup();preselect('<?php if(!empty($area)) echo $area; ?>');">
  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="logo">
        <a href="index.php"><img src="images/logo.png" alt="logo"></a>
    </div>

<?php
  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
    $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));
    $area = mysqli_real_escape_string($dbc, trim($_POST['area']));
    $street = mysqli_real_escape_string($dbc, trim($_POST['street']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $error = false;

    if (!empty($email)) {
      if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/', $email)) {
        $error = true;
        echo '<p class="error">您的email地址不正确</p>';
      }
      else {
        $domain = preg_replace('/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/', '', $email);
        if (!checkdnsrr($domain)) {
          $error = true;
          echo '<p class="error">您的email地址不正确</p>';
        }
      }
    }

    if (!empty($password1) && !empty($password2)) {
      if (!($password1 === $password2)) {
        $error = true;
        echo '<p class="error">两次填写的密码不一致</p>';
      }
    }

    if (!$error) {
      if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2) && !empty($email) && ($area != "请选择--区") && ($street != "请选择--镇")) {

        $query = "SELECT * FROM match_user WHERE email = '$email'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 0) {
          $query = "INSERT INTO match_user (username, password, join_date, area, street, email) VALUES ('$username', SHA('$password1'), NOW(), '$area', '$street', '$email')";

          if(mysqli_query($dbc, $query)) {
            $query = "SELECT user_id, email FROM match_user WHERE email = '$email' AND password = SHA('$password1')";
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

              mysqli_close($dbc);
              exit();

            }
          }
        }
        else {
          // An account already exists for this username, so display an error message
          echo '<p class="error">邮箱已存在，请输入其他邮箱</p>';
          $email = "";
        }
      }
      else {
        echo '<p class="error">请填写所有注册信息</p>';
      }
    }
  }

  mysqli_close($dbc);
?>
    <p>
      <label for="username">用户名</label>
      <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" />
    </p>
    <p>
      <label for="email">邮箱</label>
      <input id="email" name="email" type="text" value="<?php if (!empty($email))  echo $email; ?>"/>
    </p>
    <p>
      <label for="password1">密码</label>
      <input type="password" id="password1" name="password1" />
    </p>
    <p>
      <label for="password2">确认密码</label>
      <input type="password" id="password2" name="password2" />
    </p>
    <p>
      <label for="location">常居地 (目前仅限深圳市)</label>
      <select class="select" name="area" id="s1">
        <option></option>
      </select>
      <select class="select" name="street" id="s2">
        <option></option>
      </select>
    </p>
    <p>
      <input type="submit" value="注册" name="submit" />
    </p>
  </form>
  <div class="note">
    <p>已经拥有一起玩帐号? <a href="login.php">直接登录</a></p>
  </div>
  <script type="text/javascript">
    var opt0 = ["<?php if(!empty($area)) echo $area; else echo '请选择--区'; ?>", "<?php if(!empty($street)) echo $street; else echo '请选择--镇'; ?>"];
  </script>

  <script type="text/javascript" src="geo.js"></script>
</body>
</html>
