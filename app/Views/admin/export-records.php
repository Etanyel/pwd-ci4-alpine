<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Export Records | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Export Records<?= $this->endSection(); ?>

<?= $this->section('export-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ExportRecordPage()">
    <div class="card shadow-sm mt-3 p-3 border-0">
        
    </div>
</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ExportRecordPage', () => {
            return {

            }
        });
    });
</script>
<?= $this->endSection(); ?>