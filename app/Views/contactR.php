<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container my-5 contact-section">
    <h2 class="text-center mb-4">📞 Contact Us</h2>
    <p class="text-center mb-5">Reach out to us for reservations, catering, or feedback!</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="contact-info mb-4">
                <p><strong>📍 Address:</strong> 123 Food Street, Hyderabad</p>
                <p><strong>📞 Phone:</strong> <a href="tel:+919876543210">+91-98765-43210</a></p>
                <p><strong>📧 Email:</strong> <a href="mailto:contact@myrestaurant.com">contact@myrestaurant.com</a></p>
            </div>

            <!-- Optional contact form -->
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">👤 Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Your full name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">📧 Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Your email address">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">✉️ Message</label>
                    <textarea class="form-control" id="message" rows="4" placeholder="Your message..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Message 🚀</button>
            </form>
        </div>
    </div>
</div>

<?= $this->include('layout/footer') ?>

<?= $this->endSection() ?>
