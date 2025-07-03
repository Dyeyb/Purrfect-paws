<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LOGIN</title>
  <link rel="stylesheet" href="login.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>
  
  <a href="index.php" class="back-button">
  <i class='bx bx-arrow-back'></i> Back
</a>


  <div class="wrapper">
    <form action="main.php" method="post" class="login_box">
      <div class="login-header">
        <span>LOGIN</span>
      </div>

      <div class="input_box">
        <input type="text" id="user" class="input-field" name="username" required />
        <label for="user" class="label">Username</label>
        <i class="bx bx-user icon"></i>
      </div>

      <div class="input_box">
        <input type="password" id="pas" class="input-field" name="password" required />
        <label for="pas" class="label">Password</label>
        <i class="bx bx-lock-alt icon"></i>
      </div>

      <div class="remember-forgot">
        <div class="remember-me">
          <input type="checkbox" id="remember" />
          <label for="remember">Remember me</label>
        </div>
        <div class="forgot">
          <a href="#">Forgot password?</a>
        </div>
      </div>

      <div class="input_box">
        <input type="submit" class="input-submit" value="Login" />
      </div>

      <div class="register">
        <span>Don't have an account? <a href="#">Register</a></span>
      </div>
    </form>
  </div>

</body>
</html>
