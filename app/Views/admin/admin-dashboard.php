<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Dashboard<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Dashboard<?= $this->endSection(); ?>

<?= $this->section('dashboard-active'); ?>bg-secondary<?= $this->endSection(); ?>


<!-- Content page -->
<?= $this->section('content'); ?>
<div class="container-fluid shadow">
    <h3>Admin Dashboard</h3>
</div>
<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>

<?= $this->endSection(); ?>