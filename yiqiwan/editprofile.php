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
    $job = mysqli_real_escape_string($dbc, trim($_POST['job']));
    $education = mysqli_real_escape_string($dbc, trim($_POST['education']));
    $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $area = mysqli_real_escape_string($dbc, trim($_POST['area']));
    $street = mysqli_real_escape_string($dbc, trim($_POST['street']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    if (!empty($_FILES['new_picture']['name'])) {
      $new_picture = mysqli_real_escape_string($dbc, trim($_SESSION['user_id'] . $_FILES['new_picture']['name']));
      $new_picture_type = $_FILES['new_picture']['type'];
      $new_picture_size = $_FILES['new_picture']['size']; 
    }
    if (!empty($_FILES['new_picture']['tmp_name'])) {
      $uploadedfile = $_FILES['new_picture']['tmp_name'];

      if ($new_picture_type == 'image/jpeg') {
        $src = imagecreatefromjpeg($uploadedfile);
      }
      else if ($new_picture_type == 'image/png') {
        $src = imagecreatefrompng($uploadedfile);
      }
      else if ($new_picture_type == 'image/pjpeg') {
        $src = imagecreatefrompjpeg($uploadedfile);
      }
      else if ($new_picture_type == 'image/gif') {
        $src = imagecreatefromgif($uploadedfile);
      }

      list($new_picture_width, $new_picture_height) = getimagesize($uploadedfile);
    }
    $resume = str_replace("<br />", PHP_EOL, mysqli_real_escape_string($dbc, trim($_POST['resume'])));
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!$error) {
      if (!empty($new_picture)) {
        if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
          ($new_picture_type == 'image/png')) && ($new_picture_size > 0)) {

            $newwidth = 100;
            $newheight = 100;
            $tmp = imagecreatetruecolor($newwidth,$newheight); 

            imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$new_picture_width,$new_picture_height);


            // Move the file to the target upload folder
            $target = MM_UPLOADPATH . basename($new_picture);
            if (imagejpeg($tmp,$target,100)) {
              // The new picture file move was successful, now make sure any old picture is deleted
              if (!empty($old_picture) && ($old_picture != $new_picture)) {
                @unlink(MM_UPLOADPATH . $old_picture);
              }
            }
            else {
              // The new picture file move failed, so delete the temporary file and set the error flag
              @unlink($_FILES['new_picture']['tmp_name']);
              $error = true;
              echo '<p class="error">对不起,上传图片出错.</p>';
                        
              $query = "SELECT username, education, job, gender, area, street, email, picture, resume FROM match_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
              $data = mysqli_query($dbc, $query);
              $row = mysqli_fetch_array($data);

              if ($row != NULL) {
                $username = $row['username'];
                $education = $row['education'];
                $job = $row['job'];
                $gender = $row['gender'];
                $area = $row['area'];
                $street = $row['street'];
                $email = $row['email'];
                $old_picture = $row['picture'];
                $resume = $row['resume'];
              }
              else {
                echo '<p class="error">访问您的资料有误</p>';
              }
            }
        }
        else {
          // The new picture file is not valid, so delete the temporary file and set the error flag
          @unlink($_FILES['new_picture']['tmp_name']);
          $error = true;
          echo '<p class="error">您的图片必须是 GIF, JPEG, 或者 PNG 格式</p>';

          $query = "SELECT username, education, job, gender, area, street, email, picture, resume FROM match_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
          $data = mysqli_query($dbc, $query);
          $row = mysqli_fetch_array($data);

          if ($row != NULL) {
            $username = $row['username'];
            $education = $row['education'];
            $job = $row['job'];
            $gender = $row['gender'];
            $area = $row['area'];
            $street = $row['street'];
            $email = $row['email'];
            $old_picture = $row['picture'];
            $resume = $row['resume'];
          }
          else {
            echo '<p class="error">访问您的资料有误</p>';
          }
        }
      }
    }

    // Update the profile data in the database
    if (!$error) {
      if (!empty($gender) && ($area != "请选择--区") && ($street != "请选择--镇")) {
        // Only set the picture column if there is a new picture
        if (!empty($new_picture)) {
          $query = "UPDATE match_user SET education = '$education', job = '$job', gender = '$gender', resume = '$resume', " .
            " area = '$area', street = '$street', picture = '$new_picture', resume = '$resume' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        else {
          $query = "UPDATE match_user SET education = '$education', job = '$job', gender = '$gender', resume = '$resume', " .
            " area = '$area', street = '$street' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        mysqli_query($dbc, $query);

        // Confirm success with the user
        echo '<h2 class="noPeople">修改成功，您可以查看 <a href="viewprofile.php">我的资料</a></h2>';

        mysqli_close($dbc);
        exit();
      }
      else {
        echo '<p class="error">访问您的资料有误</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    $query = "SELECT username, education, job, gender, area, street, email, picture, resume FROM match_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $username = $row['username'];
      $education = $row['education'];
      $job = $row['job'];
      $gender = $row['gender'];
      $area = $row['area'];
      $street = $row['street'];
      $email = $row['email'];
      $old_picture = $row['picture'];
      $resume = $row['resume'];
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
          <div><table>
            <tr>
              <td><input type="file" id="new_picture" name="new_picture" /></td>
              <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
            </tr>
            <tr>
              <td>你可以上传JPG、JPEG、GIF、PNG文件。我们会自动调整至100*100像素。</td>
            </tr>
          </table></div>
        </div>
        <div class="editprofile-details">
          <p>
            <label for="username">用户名:</label>
            <span style="font-size: 12px;"><?php if (!empty($username))  echo $username; ?>&nbsp<a href="pre_usernamechange.php">更改</a></span>
          </p>
          <p>
            <label for="email">邮箱:</label>
            <span style="font-size: 12px;"><?php if (!empty($email))  echo $email; ?>&nbsp<a href="pre_emailchange.php">更改</a></span>
          </p>
          <p>
            <label for="gender">性别:</label>
            <select id="gender" name="gender">
              <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>男</option>
              <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>女</option>
            </select>
          </p>
          <p>
            <label for="location">常居地:</label>
            <select class="select" name="area" id="s1">
              <option></option>
            </select>
            <select class="select" name="street" id="s2">
              <option></option>
            </select>
          </p>
          <p>
            <label for="job">职业经历:</label>
            <input type="text" id="job" name="job" value="<?php if (!empty($job)) echo $job; ?>" placeholder="公司名称和职位" size="50" />
          </p>
          <p>
            <label for="education">教育经历:</label>
            <input type="text" id="education" name="education" value="<?php if (!empty($education)) echo $education; ?>" placeholder="学校名称和专业" size="50" />
          </p>
          <p>
            <label for="resume">个人简介:</label>
            <textarea id="resume" name="resume" rows="16" cols="52" maxlength="3000"><?php if (!empty($resume))  echo $resume; ?></textarea>
            <p class="describle">详细介绍一下自己吧，这样会有更多人找你玩哦！</p>
          </p>
          <p>
            <input class="changeButton" type="submit" value="保存修改" name="submit" />
          </p>
        </div>
    </form>
  </div>

  <script type="text/javascript">
    var opt0 = ["<?php if(!empty($area)) echo $area; else echo '请选择--区'; ?>", "<?php if(!empty($street)) echo $street; else echo '请选择--镇'; ?>"];
  </script>

  <script type="text/javascript" src="geo.js"></script>
<?php
  require_once('footer.php');
?>
