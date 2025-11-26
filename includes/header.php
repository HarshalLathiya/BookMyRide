<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo isset($page_title) ? $page_title : 'BookMyRide'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <?php if (basename($_SERVER['PHP_SELF']) == 'booking.php'): ?>
  <link rel="stylesheet" href="assets/css/booking.css">
  <?php endif; ?>
  <?php if (basename($_SERVER['PHP_SELF']) == 'testimonials.php'): ?>
  <link rel="stylesheet" href="assets/css/testimonials.css">
  <?php endif; ?>
  <?php if (basename($_SERVER['PHP_SELF']) == 'contact.php'): ?>
  <link rel="stylesheet" href="assets/css/contact_form.css">
  <?php endif; ?>

  <style>
    /* Enhanced Header Styles */
    .navbar {
      background: linear-gradient(135deg, #5d6fbeff 0%, #5d3289ff 100%) !important;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .navbar-brand {
      font-weight: 700 !important;
      font-size: 1.5rem !important;
      color: #fff !important;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
      display: flex !important;
      align-items: center;
      gap: 10px;
    }

    .navbar-brand img {
      height: 45px !important;
      width: auto;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
      transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
      transform: scale(1.05);
    }

    .navbar-brand:hover {
      color: #e8f4f8 !important;
      text-decoration: none !important;
    }

    .navbar-nav .nav-link {
      color: rgba(255, 255, 255, 0.9) !important;
      font-weight: 500 !important;
      padding: 8px 16px !important;
      margin: 0 2px;
      border-radius: 6px;
      transition: all 0.3s ease;
      position: relative;
      text-decoration: none !important;
    }

    .navbar-nav .nav-link:hover {
      color: #fff !important;
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .navbar-nav .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      color: #fff !important;
      font-weight: 600;
    }

    .navbar-nav .nav-link i {
      margin-right: 6px;
      font-size: 0.9em;
    }

    .navbar-toggler {
      border: none !important;
      background: rgba(255, 255, 255, 0.1) !important;
      border-radius: 6px;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
    }

    /* User greeting */
    .user-greeting {
      background: rgba(255, 255, 255, 0.1);
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 500;
      color: #fff;
      margin-right: 10px;
    }

    /* Scroll effect */
    .navbar.scrolled {
      background: rgba(102, 126, 234, 0.95) !important;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
    }

    /* Mobile menu enhancements */
    @media (max-width: 991.98px) {
      .navbar-collapse {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin-top: 10px;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      }

      .navbar-nav .nav-link {
        margin: 2px 0;
        border-radius: 8px;
      }

      .navbar-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateX(5px);
      }
    }

    /* Animation for navbar items */
    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .navbar-nav {
      animation: fadeInDown 0.5s ease-out;
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="assets/images/logo.png" alt="BookMyRide Logo">
        <span>BookMyRide</span>
      </a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMenu">
        <ul class="navbar-nav me-auto align-items-center">
          <?php if(basename($_SERVER['PHP_SELF']) != 'index.php'): ?>
          <li class="nav-item">
            <a href="javascript:history.back()" class="nav-link" title="Go Back">
              <i class="fas fa-arrow-left"></i> Back
            </a>
          </li>
          <?php endif; ?>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center">
          <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <span class="user-greeting">
              <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>
            </span>
          </li>
          <?php endif; ?>

          <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
              <i class="fas fa-home"></i> Home
            </a>
          </li>

          <li class="nav-item">
            <a href="cars.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cars.php' ? 'active' : ''; ?>">
              <i class="fas fa-car"></i> Cars
            </a>
          </li>

          <li class="nav-item">
            <a href="booking.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'booking.php' ? 'active' : ''; ?>">
              <i class="fas fa-calendar-check"></i> Book Now
            </a>
          </li>

          <li class="nav-item">
            <a href="testimonials.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'testimonials.php' ? 'active' : ''; ?>">
              <i class="fas fa-star"></i> Testimonials
            </a>
          </li>

          <li class="nav-item">
            <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
              <i class="fas fa-envelope"></i> Contact
            </a>
          </li>

          <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </li>
          <?php else: ?>
          <li class="nav-item">
            <a href="login.php" class="nav-link">
              <i class="fas fa-sign-in-alt"></i> Login
            </a>
          </li>
          <li class="nav-item">
            <a href="register.php" class="nav-link">
              <i class="fas fa-user-plus"></i> Register
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <script>
    // Scroll effect for navbar
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
      const navbar = document.querySelector('.navbar');
      const navbarCollapse = document.querySelector('.navbar-collapse');

      if (!navbar.contains(event.target) && navbarCollapse.classList.contains('show')) {
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
          hide: true
        });
      }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>
</html>
