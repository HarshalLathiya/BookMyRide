<?php
$page_title = 'Testimonials - BookMyRide';
include("includes/header.php");
?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="container">
      <h1>What Our Customers Say</h1>
      <p>Discover why thousands of travelers choose BookMyRide for their journeys</p>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials-section">
    <div class="container">
      <h2 class="section-title">Customer Experiences</h2>
      
      <div class="rating-summary">
  <div class="overall-rating">4.8</div>
  <div class="rating-stars">
    <i class="fas fa-star"></i>
    <i class="fas fa-star"></i>
    <i class="fas fa-star"></i>
    <i class="fas fa-star"></i>
    <i class="fas fa-star-half-alt"></i>
  </div>
  <div class="total-reviews">Based on 1,247 reviews</div>

  <div class="rating-bars">
    <div class="rating-bar">
      <div class="rating-label">5 stars</div>
      <div class="bar-container">
        <div class="bar" style="width: 85%;"></div>
      </div>
    </div>
    <div class="rating-bar">
      <div class="rating-label">4 stars</div>
      <div class="bar-container">
        <div class="bar" style="width: 12%;"></div>
      </div>
    </div>
    <div class="rating-bar">
      <div class="rating-label">3 stars</div>
      <div class="bar-container">
        <div class="bar" style="width: 2%;"></div>
      </div>
    </div>
    <div class="rating-bar">
      <div class="rating-label">2 stars</div>
      <div class="bar-container">
        <div class="bar" style="width: 1%;"></div>
      </div>
    </div>
    <div class="rating-bar">
      <div class="rating-label">1 star</div>
      <div class="bar-container">
        <div class="bar" style="width: 0%;"></div>
      </div>
    </div>
  </div>
</div>

      <!-- Testimonials Grid -->
      <div class="testimonials-grid">
        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <div class="quote">"BookMyRide made my family trip so smooth and comfortable. The car was clean and the driver was very polite. Highly recommend!"</div>
          <div class="author">
            <div class="author-avatar">ML</div>
            <div class="author-info">
              <div class="author-name">Mihir Lathiya</div>
              <div class="author-role">Family Vacation</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="stars">★★★★☆</div>
          <div class="quote">"Great service and easy booking process. The SUV was perfect for our hill station vacation. Will definitely use again."</div>
          <div class="author">
            <div class="author-avatar">VL</div>
            <div class="author-info">
              <div class="author-name">Varshil Lathiya</div>
              <div class="author-role">Adventure Trip</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <div class="quote">"Luxury car package was worth every penny for my wedding day. Professional drivers and pristine vehicles. Thanks BookMyRide!"</div>
          <div class="author">
            <div class="author-avatar">NL</div>
            <div class="author-info">
              <div class="author-name">Nikhil Lathiya</div>
              <div class="author-role">Wedding Event</div>
            </div>
          </div>
        </div>
        
        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <div class="quote">"I've been using BookMyRide for my business trips for over a year now. Always punctual and professional service."</div>
          <div class="author">
            <div class="author-avatar">NB</div>
            <div class="author-info">
              <div class="author-name">Navdeep Bhalu</div>
              <div class="author-role">Business Traveler</div>
            </div>
          </div>
        </div>
        
        <div class="testimonial-card">
          <div class="stars">★★★★★</div>
          <div class="quote">"The airport transfer service is exceptional. Flight was delayed but the driver waited without any extra charges."</div>
          <div class="author">
            <div class="author-avatar">MS</div>
            <div class="author-info">
              <div class="author-name">Miraj Sarvaiya</div>
              <div class="author-role">Frequent Flyer</div>
            </div>
          </div>
        </div>
        
        <div class="testimonial-card">
          <div class="stars">★★★★☆</div>
          <div class="quote">"Reasonable prices and good vehicles. The app makes booking so convenient. Overall a great experience."</div>
          <div class="author">
            <div class="author-avatar">HA</div>
            <div class="author-info">
              <div class="author-name">Harshil Amreliya</div>
              <div class="author-role">Weekend Traveler</div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- CTA Section -->
      <div class="cta-section">
        <h3 class="cta-title">Ready to experience our service?</h3>
        <a href="booking.php" class="cta-button">Book Your Ride Now</a>
      </div>
    </div>
  </section>

  <?php include("includes/footer.php"); ?> 

  <script>
    // Mobile navigation toggle
    document.querySelector('.mobile-nav-toggle').addEventListener('click', function() {
      document.querySelector('.nav-links').classList.toggle('active');
    });
  </script>
</body>
</html>