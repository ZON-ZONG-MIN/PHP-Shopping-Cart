<?php

include 'config.php';

session_start();

error_reporting(0);

if (isset($_SESSION['username'])) {
  header("Location: home.php");
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $sql);

  if ($result->num_rows > 0) {

    //將資料庫找到的資料存入SESSION
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];

    //轉到home.php頁面
    header("Location: home.php");
  } else {

    //沒找到資料產生錯誤訊息
    echo "<script>alert('Woops! Email or Password is Wrong.')</script>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7
.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Login Form - Rufus Coding</title>
</head>

<body>
  <div class="container">
    <form action="" method="POST" class="login-email">
      <p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
      <div class="input-group">
        <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="password" name="password" value="<?php echo $_POST['password']; ?>" required>
      </div>
      <div class="input-group">
        <button name="submit" class="btn">Login</button>
      </div>
      <p class="login-register-text">Don't have an account? <a href="register.php">Register Here</a></p>
    </form>
  </div>
</body>

</html>