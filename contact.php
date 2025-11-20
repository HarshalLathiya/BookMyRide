<?php
$page_title = 'BookMyRide - Contact Us';
include("includes/header.php");
?>

<div class="contact-container">

    <!-- LEFT CARD -->
    <div class="contact-card">
        <h3>Get in Touch</h3>

        <p><i class="fas fa-phone"></i> +91-9737612352</p>
        <p><i class="fas fa-envelope"></i>harshalplathiya@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i>Chital,Amreli,India</p>

        <p>We are available 24/7 for bookings and support.</p>

        <!-- MAP INSIDE CARD -->
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.957180245307!2d71.21101037513066!3d21.602305080191043!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39584565f6e0b1a9%3A0xacf5b657b2ef3eaf!2sAmreli%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1661091496785!5m2!1sen!2sin"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- RIGHT CARD -->
    <div class="contact-card">
        <h3>Send a Message</h3>

        <form action="contact_submit.php" method="POST">

            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Subject</label>
            <input type="text" name="subject" required>

            <label>Message</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit" class="submit-btn">Send Message</button>

        </form>
    </div>

</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
