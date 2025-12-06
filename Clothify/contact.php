<?php include 'views/include/header.php'; ?>
<?php include 'views/include/navbar.php'; ?>

<div class="container">
    <h2 class="page-title">Contact Us</h2>

    <div class="contact-section">
        <div class="contact-info">
            <h3>Get in Touch</h3>
            <p>Email: support@clothify.com</p>
            <p>Phone: +92 300 1234567</p>
            <p>Address: Lahore, Pakistan</p>
        </div>

        <form class="contact-form" method="POST" action="">
            <input type="text" name="name" placeholder="Your Name" required>

            <input type="email" name="email" placeholder="Your Email" required>

            <textarea name="message" placeholder="Your Message" required></textarea>

            <button type="submit" class="btn">Send Message</button>
        </form>
    </div>
</div>

<?php include 'views/include/footer.php'; ?>
