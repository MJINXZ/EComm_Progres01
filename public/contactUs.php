<?php 
session_start();
$pageClass = "contact-page";
include('admin/includes/header.php');
include('admin/includes/topbar.php');
include_once("../app/config/config.php");
?>

<!-- ========== CONTACT SECTION ========== -->
<section class="contact-section" id="contact">
    <div class="container">
        
        <div class="section-header">
            <h2>Get In Touch</h2>
            <p>We'd love to hear from you! Reach out for orders, inquiries, or just to say hello.</p>
        </div>

        <div class="contact-wrapper">
            
            <!-- Contact Info -->
            <div class="contact-info">
                <div class="info-card">
                    <div class="icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="details">
                        <h3>Our Location</h3>
                        <p>123 Pastry Lane, Sweet Town,<br>Bakery District, ST 45678</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="icon"><i class="fas fa-phone-alt"></i></div>
                    <div class="details">
                        <h3>Call Us</h3>
                        <p>+1 (555) 123-4567<br>+1 (555) 765-4321</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="icon"><i class="fas fa-envelope"></i></div>
                    <div class="details">
                        <h3>Email Us</h3>
                        <p>hello@sweetbakery.com<br>orders@sweetbakery.com</p>
                    </div>
                </div>

                <div class="info-card">
                    <div class="icon"><i class="fas fa-clock"></i></div>
                    <div class="details">
                        <h3>Opening Hours</h3>
                        <p>Mon - Fri: 7:00 AM - 8:00 PM<br>Sat - Sun: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <h3>Send Us a Message</h3>
                <form class="contact-form" action="#" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="firstName" placeholder="First Name *" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="lastName" placeholder="Last Name *" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address *" required>
                    </div>

                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject">
                    </div>

                    <div class="form-group">
                        <textarea name="message" rows="5" placeholder="Your Message *" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        Send Message <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- ========== REVIEWS SECTION ========== -->
<section class="reviews-section" id="reviews">
    <div class="container">
        
        <div class="section-header">
            <h2>What Our Customers Say</h2>
            <p>Don't just take our word for it — hear from our happy customers!</p>
        </div>

        <div class="reviews-grid">

            <!-- Review 1 -->
            <div class="review-card">
                <div class="review-header">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" class="reviewer-img">
                    <div>
                        <h4>Sarah Johnson</h4>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <p>"The croissants here are absolutely divine!"</p>
            </div>

            <!-- Review 2 -->
            <div class="review-card">
                <div class="review-header">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="reviewer-img">
                    <div>
                        <h4>Michael Chen</h4>
                        <div class="stars">★★★★★</div>
                    </div>
                </div>
                <p>"Ordered a custom cake and it was perfect!"</p>
            </div>

            <!-- Review 3 -->
            <div class="review-card">
                <div class="review-header">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" class="reviewer-img">
                    <div>
                        <h4>Emily Rodriguez</h4>
                        <div class="stars">★★★★☆</div>
                    </div>
                </div>
                <p>"My go-to bakery for all family gatherings."</p>
            </div>

        </div>

        <div class="review-cta">
            <a href="#" class="btn-review">Leave a Review</a>
        </div>

    </div>
</section>

<!-- ========== LOCATION SECTION ========== -->
<section class="location-section" id="location">
    <div class="container">
        
        <div class="section-header">
            <h2>Find Us Here</h2>
        </div>

        <div class="map-wrapper">
            <img src="assets/img/Le_france.png" class="map-image">
        </div>

    </div>
</section>

<?php include('admin/includes/footer.php'); ?>