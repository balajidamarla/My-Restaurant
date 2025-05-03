<?= $this->extend('layout/header') ?>
<?= $this->section('content') ?>
<div class="container my-5 about-section">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="<?= base_url('public/uploads/about-us.jpg') ?>" alt="About Us" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">About Us 👨‍🍳</h2>
            <p>Welcome to <strong>My Restaurant</strong>! We proudly serve the best food in town, crafted with authentic flavors and a touch of love. Our chefs use only fresh, high-quality ingredients to prepare every dish with care.</p>
            <p>Whether you're here for a quick bite or a family dinner, our cozy ambiance and friendly staff will make you feel right at home. 🍝</p>
            <p>Come taste the difference! 🍽️</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->include('layout/footer') ?>
