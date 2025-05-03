<?= $this->extend('layout/header')?>
<?= $this->section('content') ?>
<div class="home-hero" style="
    background: url('<?= base_url('public/uploads/view-ready-eat-delicious-meal-go.jpg') ?>') no-repeat center center/cover;
    height: 400px;
    display: flex;
    justify-content: flex-start; /* <-- Moves content to left */
    align-items: center;
    padding-left: 100px; /* <-- Padding on the left side */
    text-align: left;
    color: white;
    font-family: 'Poppins', sans-serif;
">
    <div>
        <h1 style="font-size: 3rem; font-weight: 700;  color: #fff8dc; text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
            Welcome to My Restaurant
        </h1>
        <p class="lead" style="font-size: 1.5rem; color:rgb(251, 252, 187); margin-bottom: 20px; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
            Delicious food made with extra love... 🍽️
        </p>
        <a href="<?= base_url('/menu/index') ?>" class="btn btn-primary mt-3" style="font-size: 1.1rem; padding: 10px 20px;">
            Explore Our Menu
        </a>
    </div>
</div>
<?= $this->endSection()?>