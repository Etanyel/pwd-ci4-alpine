<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Manage Records | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Manage Records<?= $this->endSection(); ?>

<?= $this->section('manage-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ManageRecordPage()">
    <div class="card shadow-sm mt-2 p-3 border-0 d-flex flex-row gap-3">
        <div class="form-group mb-0">
            <input type="text" x-model.debounce.500ms="search" class="form-control" placeholder="Search here...">
            <p class="fw-light">Search here like (pwd number, lastname, and firstname)</p>
        </div>

        <div class="form-group">
            <select name="" id="" class="form-select">
                <option value="">All Records</option>

            </select>
        </div>
    </div>

    <div class="card shadow-sm mt-3 p-3 border-0">
        <div class="">
            <h4 class="text-primary">
                PWD Records
            </h4>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>PWD NUMBER</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>MIDDLE NAME</th>
                    <th>SUFFIX</th>
                    <th>DATE OF BIRTH</th>
                    <th>AGE</th>
                    <th>SEX</th>
                    <th>BARANGAY</th>
                    <th>PUROK</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="record in records" :key="record.id">
                    <tr @click="window.location.href=`/admin/manage-record/${record.id}`" style="cursor: pointer;">
                        <td x-text="record.pwd_no"></td>
                        <td x-text="record.lastname"></td>
                        <td x-text="record.firstname"></td>
                        <td x-text="record.middlename ? record.middlename : 'N/A'"></td>
                        <td x-text="record.suffix ? record.suffix : 'N/A'"></td>
                        <td x-text="formatDate(record.birthdate)"></td>
                        <td x-text="record.age"></td>
                        <td class="text-uppercase" x-text="record.sex"></td>
                        <td class="text-uppercase" x-text="record.barangay"></td>
                        <td class="text-uppercase" x-text="record.street_name ? record.street_name : 'N/A'"></td>
                    </tr>
                </template>
            </tbody>
        </table>
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
            search: '',

            resetForm() {
                this.errors = {};
            },

            init() {
                this.fetchRecords();
                this.$watch('search', () => {
                    this.fetchRecords();
                });
            },

            async fetchRecords() {
                try {
                    const response = await fetch(`/admin/fetch-records?search=${this.search}`);
                    const data = await response.json();

                    if (data.status === 'error') {
                        console.error(data.errors);
                        return;
                    }

                    this.records = data.data;
                    // console.log(this.records);

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