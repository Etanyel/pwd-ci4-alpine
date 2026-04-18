<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Manage Records | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Manage Records<?= $this->endSection(); ?>

<?= $this->section('manage-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ManageRecordPage()">

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

        init(){
            this.fetchRecords();
        },

        async fetchRecords() {
            try {
                const response = await fetch('/admin/fetch-records');
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
        }
    }
}
</script>
<?= $this->endSection(); ?>