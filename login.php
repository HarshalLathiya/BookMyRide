<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - BookMyRide</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/login_form.css">
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
        <p>Sign in to your account</p>
      </div>
      
      <div class="message error" id="message" style="display: none;"></div>
      
      <form class="form-box" method="POST" id="loginForm">
        <div class="input-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email address" required>
        </div>
        
        <div class="input-group">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>
        
        <div class="options">
          <label class="remember">
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a href="#" class="forgot-password" id="forgotBtn">Forgot password?</a>
        </div>
        
        <button type="submit" class="btn-login">Sign In</button>
      </form>
      
      <div class="separator">or continue with</div>
      
      <div class="social-login">
        <div class="social-btn facebook">
          <i class="fab fa-facebook-f"></i>
        </div>
        <div class="social-btn google">
          <i class="fab fa-google"></i>
        </div>
        <div class="social-btn twitter">
          <i class="fab fa-twitter"></i>
        </div>
      </div>
      
      <div class="register-link">
        Don't have an account? <a href="register.php">Register here</a>
      </div>
    </div>
  </div>
 <div class="modal" id="forgotModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Reset Password</h3>
      <span class="close">&times;</span>
    </div>
    <p>Enter your email and new password.</p>
    <div class="modal-input-group">
      <i class="fas fa-envelope"></i>
      <input type="email" class="modal-input" placeholder="Email address" id="resetEmail" required>
    </div>
    <div class="modal-input-group">
      <i class="fas fa-lock"></i>
      <input type="password" class="modal-input" placeholder="New Password" id="newPassword" required>
      <i class="fas fa-eye password-toggle" id="toggleNewPassword"></i>
    </div>
    <div class="modal-input-group">
      <i class="fas fa-lock"></i>
      <input type="password" class="modal-input" placeholder="Confirm New Password" id="confirmPassword" required>
      <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
    </div>
    <button class="modal-btn" id="sendResetBtn">Submit</button>
  </div>
</div>

<script>
  // DOM Elements
  const forgotModal = document.getElementById("forgotModal");
  const forgotBtn = document.getElementById("forgotBtn");
  const closeBtns = document.querySelectorAll(".close");

  // Open modal
  forgotBtn.addEventListener("click", function(e){
    e.preventDefault();
    forgotModal.style.display = "flex";
  });

  // Close modal
  closeBtns.forEach(btn => {
    btn.addEventListener("click", function(){
      forgotModal.style.display = "none";
    });
  });

  window.addEventListener("click", function(e){
    if(e.target === forgotModal) forgotModal.style.display = "none";
  });

  // Toggle password visibility
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
  togglePassword("toggleNewPassword", "newPassword");
  togglePassword("toggleConfirmPassword", "confirmPassword");

  // Submit new password
  document.getElementById("sendResetBtn").addEventListener("click", function(){
    const email = document.getElementById("resetEmail").value.trim();
    const newPassword = document.getElementById("newPassword").value.trim();
    const confirmPassword = document.getElementById("confirmPassword").value.trim();

    if(!email || !newPassword || !confirmPassword){
      alert("Please fill in all fields.");
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(email)){
      alert("Please enter a valid email address.");
      return;
    }

    if(newPassword !== confirmPassword){
      alert("Passwords do not match.");
      return;
    }

    // Send POST request to PHP
    fetch('reset_password.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(newPassword)}`
    })
    .then(res => res.json())
    .then(data => {
      if(data.status === 'success'){
        alert(data.message);
        forgotModal.style.display = "none";
        document.getElementById("resetEmail").value = "";
        document.getElementById("newPassword").value = "";
        document.getElementById("confirmPassword").value = "";
      } else {
        alert(data.message);
      }
    })
    .catch(err => {
      console.error(err);
      alert("Something went wrong. Try again.");
    });
  });

  // Login form submission
  document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();
    const email = this.email.value.trim();
    const password = this.password.value.trim();

    fetch('login_user.php', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {
      if(data.status === 'success'){
        if(data.is_admin) {
          window.location.href = "admin/dashboard_admin.php";
        } else {
          window.location.href = "index.php";
        }
      } else {
        document.getElementById("message").innerText = data.message;
        document.getElementById("message").style.display = "block";
      }
    })
    .catch(err => alert("Something went wrong"));
  });
</script>
</body>
</html>