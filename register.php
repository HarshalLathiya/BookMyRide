
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - BookMyRide</title>
<link rel="stylesheet" href="assets/css/login_form.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="login-container">
  <div class="image-section">
    <div class="image-content">
      <h1>Explore the World</h1>
      <p>Discover amazing destinations with BookMyRide</p>
    </div>
  </div>

  <div class="form-section">
    <div class="logo">
      <h2>BookMyRide</h2>
      <p>Create your account</p>
    </div>

    <form class="form-box" method="POST" id="registerForm">
      <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="text" name="fullname" placeholder="Full Name" required>
      </div>

      <div class="input-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" placeholder="Email address" required>
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" id="regPassword" required>
        <i class="fas fa-eye password-toggle" id="toggleRegPassword"></i>
      </div>

      <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="confirm_password" placeholder="Confirm Password" id="regConfirmPassword" required>
        <i class="fas fa-eye password-toggle" id="toggleRegConfirmPassword"></i>
      </div>

      <button type="submit" class="btn-login">Register</button>
    </form>

    <div class="register-link">
      Already have an account? <a href="login.php">Sign in here</a>
    </div>
  </div>
</div>

<script>
function togglePassword(toggleId, inputId){
  document.getElementById(toggleId).addEventListener("click", function(){
    const input = document.getElementById(inputId);
    if(input.type === "password"){
      input.type = "text";
      this.classList.remove("fa-eye");
      this.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      this.classList.remove("fa-eye-slash");
      this.classList.add("fa-eye");
    }
  });
}
togglePassword("toggleRegPassword", "regPassword");
togglePassword("toggleRegConfirmPassword", "regConfirmPassword");

document.getElementById("registerForm").addEventListener("submit", function(e){
  e.preventDefault();
  const fullname = this.fullname.value.trim();
  const email = this.email.value.trim();
  const password = this.password.value.trim();
  const confirmPassword = this.confirm_password.value.trim();

  if(password !== confirmPassword){
    alert("Passwords do not match.");
    return;
  }

  fetch('register_user.php', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded'},
    body: `fullname=${encodeURIComponent(fullname)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if(data.status === 'success'){
      window.location.href = "login.php";
    }
  })
  .catch(err => alert("Something went wrong"));
});
</script>
</body>
</html>
