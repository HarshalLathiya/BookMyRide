<?php
$page_title = 'BookMyRide - Book Now';
include("includes/header.php");
$selectedCar = isset($_GET['car']) ? htmlspecialchars($_GET['car']) : '';
?>
  <div class="booking-container">
    <div class="booking-image"></div>
    
    <div class="booking-form">
      <div class="form-header">
        <h2>Book Your Car</h2>
        <p>Complete the form below to reserve your vehicle</p>
      </div>
      
      <div class="message" id="message"></div>
      
      <form action="db_booking_form.php" method="POST" id="bookingForm">
        <div class="form-grid">
          <div class="form-group">
            <label for="full_name">Full Name</label>
            <div class="input-icon">
              <i class="fas fa-user"></i>
              <input type="text" id="full_name" name="full_name" placeholder="Your full name" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-icon">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" placeholder="Your email address" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="input-icon">
              <i class="fas fa-phone"></i>
              <input type="tel" id="phone" name="phone" placeholder="Your phone number" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="car_type">Car Type</label>
            <div class="input-icon">
              <i class="fas fa-car"></i>
              <select id="car_type" name="car_type" required>
                <option value="">-- Select car type --</option>
                <option value="Ertiga" <?= ($selectedCar == 'Ertiga' ? 'selected' : '') ?>>Ertiga</option>
                <option value="Innova" <?= ($selectedCar == 'Innova' ? 'selected' : '') ?>>Innova</option>
                <option value="Swift" <?= ($selectedCar == 'Swift' ? 'selected' : '') ?>>Swift</option>
                <option value="Verna" <?= ($selectedCar == 'Verna' ? 'selected' : '') ?>>Verna</option>
                <option value="Fortuner" <?= ($selectedCar == 'Fortuner' ? 'selected' : '') ?>>Fortuner</option>
                <option value="Thar" <?= ($selectedCar == 'Thar' ? 'selected' : '') ?>>Thar</option>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label for="pickup_date">Pickup Date</label>
            <div class="input-icon">
              <i class="fas fa-calendar-alt"></i>
              <input type="date" id="pickup_date" name="pickup_date" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="drop_date">Drop Date</label>
            <div class="input-icon">
              <i class="fas fa-calendar-alt"></i>
              <input type="date" id="drop_date" name="drop_date" required>
            </div>
          </div>
          
          <div class="form-group full-width">
            <label for="pickup_location">Pickup Location</label>
            <div class="input-icon">
              <i class="fas fa-map-marker-alt"></i>
              <input type="text" id="pickup_location" name="pickup_location" placeholder="Enter pickup location" required>
            </div>
          </div>
          
          <div class="form-group full-width">
            <label for="drop_location">Drop Location</label>
            <div class="input-icon">
              <i class="fas fa-map-marker-alt"></i>
              <input type="text" id="drop_location" name="drop_location" placeholder="Enter drop location" required>
            </div>
          </div>
          
          <div class="form-group full-width">
            <label for="payment_method">Payment Method</label>
            <div class="input-icon">
              <i class="fas fa-credit-card"></i>
              <select id="payment_method" name="payment_method" required>
                <option value="">-- Select Payment Method --</option>
                <option value="UPI">UPI</option>
                <option value="Debit/Credit Card">Debit/Credit Card</option>
                <option value="Cash on Drop">Cash on Drop</option>
              </select>
            </div>
          </div>
        </div>
        
        <div class="calculation-box" id="calculationBox" style="display: none;">
          <div class="calculation-row">
            <span>Base Rate (3 days):</span>
            <span id="baseRate">₹0</span>
          </div>
          <div class="calculation-row">
            <span>Additional Days:</span>
            <span id="additionalDays">0 days × ₹0</span>
          </div>
          <div class="calculation-row calculation-total">
            <span>Total Amount:</span>
            <span id="totalAmount">₹0</span>
          </div>
        </div>
        
        <button type="submit" class="btn-submit" id="submitBtn">Confirm Booking</button>
      </form>
    </div>
  </div>

  <script>
    // Car pricing data
    const carPrices = {
      'Ertiga': 2500,
      'Innova': 3500,
      'Swift': 2000,
      'Verna': 2200,
      'Fortuner': 5000,
      'Thar': 4500
    };
    
    // Set minimum dates to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('pickup_date').setAttribute('min', today);
    document.getElementById('drop_date').setAttribute('min', today);
    
    // Form validation and calculation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
      const pickupDate = new Date(document.getElementById('pickup_date').value);
      const dropDate = new Date(document.getElementById('drop_date').value);
      const phone = document.getElementById('phone').value;
      const phonePattern = /^[0-9]{10}$/;
      
      // Validate dates
      if (pickupDate >= dropDate) {
        e.preventDefault();
        showMessage('Drop date must be after pickup date.', 'error');
        return false;
      }
      
      // Validate phone number
      if (!phonePattern.test(phone)) {
        e.preventDefault();
        showMessage('Please enter a valid 10-digit phone number.', 'error');
        return false;
      }
    });
    
    // Calculate price when dates or car type changes
    document.getElementById('pickup_date').addEventListener('change', calculatePrice);
    document.getElementById('drop_date').addEventListener('change', calculatePrice);
    document.getElementById('car_type').addEventListener('change', calculatePrice);
    
    function calculatePrice() {
      const pickupDate = new Date(document.getElementById('pickup_date').value);
      const dropDate = new Date(document.getElementById('drop_date').value);
      const carType = document.getElementById('car_type').value;
      
      if (!pickupDate || !dropDate || !carType || pickupDate >= dropDate) {
        document.getElementById('calculationBox').style.display = 'none';
        return;
      }
      
      // Calculate number of days
      const timeDiff = dropDate - pickupDate;
      const days = Math.ceil(timeDiff / (1000 * 60 * 60 * 24)) + 1; // Include both start and end day
      
      if (days < 1) {
        document.getElementById('calculationBox').style.display = 'none';
        return;
      }
      
      // Get car price
      const dailyRate = carPrices[carType] || 0;
      
      // Calculate costs (first 3 days at base rate, additional days at discounted rate)
      const baseDays = Math.min(days, 3);
      const additionalDays = Math.max(0, days - 3);
      const baseCost = baseDays * dailyRate;
      const additionalCost = additionalDays * dailyRate * 0.9; // 10% discount for additional days
      const totalCost = baseCost + additionalCost;
      
      // Update calculation box
      document.getElementById('baseRate').textContent = `₹${baseCost}`;
      document.getElementById('additionalDays').textContent = `${additionalDays} days × ₹${Math.round(dailyRate * 0.9)}`;
      document.getElementById('totalAmount').textContent = `₹${Math.round(totalCost)}`;
      document.getElementById('calculationBox').style.display = 'block';
    }
    
    function showMessage(text, type) {
      const messageDiv = document.getElementById('message');
      messageDiv.textContent = text;
      messageDiv.className = `message ${type}`;
      messageDiv.style.display = 'block';
      
      // Auto hide after 5 seconds
      setTimeout(() => {
        messageDiv.style.display = 'none';
      }, 5000);
    }
    
    // Initialize date inputs with tomorrow's date as default
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowFormatted = tomorrow.toISOString().split('T')[0];
    
    document.getElementById('pickup_date').value = tomorrowFormatted;
    
    const dayAfterTomorrow = new Date();
    dayAfterTomorrow.setDate(dayAfterTomorrow.getDate() + 3);
    const dayAfterTomorrowFormatted = dayAfterTomorrow.toISOString().split('T')[0];
    
    document.getElementById('drop_date').value = dayAfterTomorrowFormatted;
  </script>
<?php include("includes/footer.php"); ?>
</body>
</html>
