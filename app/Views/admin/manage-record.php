<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?><?= $record['lastname'] . " " . $record['firstname'] ?> | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?><?= $record['lastname'] . " " . $record['firstname'] ?><?= $this->endSection(); ?>

<?= $this->section('manage-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ManageRecordPage()">
    <div class="card shadow-sm mt-3 p-3 border-0">
        
    </div>

</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function ManageRecordPage() {
        return {
            errors: {},
            records: [],

            resetForm() {
                this.errors = {};
            },

            init() {
                this.fetchRecords();
            },

            async fetchRecord() {
                try {
                    const response = await fetch('/admin/fetch-record/<?= $record['id'] ?>');
                    const data = await response.json();

                    if (data.status === 'error') {
                        console.error(data.errors);
                        return;
                    }

                    this.records = data.data;
                    console.log(this.records);

                } catch (error) {
                    console.error('Error fetching records:', error);
                }
            },

            formatDate(date) {
                return new Date(date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },
        }
    }
</script>
<?= $this->endSection(); ?>