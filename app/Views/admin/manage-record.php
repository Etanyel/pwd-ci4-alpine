<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?><?= $record['lastname'] . " " . $record['firstname'] ?> | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?><?= $record['lastname'] . " " . $record['firstname'] ?><?= $this->endSection(); ?>

<?= $this->section('manage-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ManageRecordPage()">
    <div class="card shadow-sm mt-3 p-3 border-0">
        <div class="row">
            <div class="col-md-4 border-end">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="<?= base_url('/img/no_profile.jpg') ?>" class="rounded border" alt="" style="width: 50vh;">
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-light border form-control">
                        <i class="bi bi-upload me-2"></i>
                        Upload Photo
                    </button>
                </div>

                <div class="">
                    <span class="badge text-bg-dark">Test</span>
                </div>
            </div>

            <div class="col-md-8">
                <div class="">
                    <h4 class="text-primary font-monospace">
                        Personal Information
                    </h4>
                </div>
                <div class="row px-3">
                    <div class="col-md-6 border border-dark">
                        <label for="" class="form-label fw-semibold">PWD NUMBER</label>
                        <p x-text="record.pwd_no"></p>
                    </div>

                    <div class="col-md-6 border border-dark">
                        <label for="" class="form-label fw-semibold">DATE APPLIED</label>
                        <p x-text="formatDate(record.date_applied)"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-3 border border-dark">
                        <label for="" class="form-label fw-semibold">LAST NAME</label>
                        <p x-text="record.lastname"></p>
                    </div>

                    <div class="col-md-4 border border-dark">
                        <label for="" class="form-label fw-semibold">FIRST NAME</label>
                        <p x-text="record.firstname"></p>
                    </div>
                    <div class="col-md-3 border border-dark">
                        <label for="" class="form-label fw-semibold">MIDDLE NAME</label>
                        <p x-text="record.middlename"></p>
                    </div>

                    <div class="col-md-2 border border-dark">
                        <label for="" class="form-label fw-semibold">SUFFIX NAME</label>
                        <p x-text="record.suffix"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-6 border border-dark">
                        <label for="" class="form-label fw-semibold">TYPE OF DISABILITY</label>
                        <p x-text="record.type_of_disability"></p>
                    </div>

                    <div class="col-md-6 border border-dark">
                        <label for="" class="form-label fw-semibold">CAUSE OF DISABILITY</label>
                        <p x-text="record.cause_of_disability"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-2 border border-dark">
                        <label for="" class="form-label fw-semibold">ADDRESS:</label>
                        <p></p>
                    </div>
                    <div class="col-md-5 border border-dark">
                        <label for="" class="form-label fw-semibold">HOUSE NO. AND STREET NAME</label>
                        <p x-text="record.street_name"></p>
                    </div>
                    <div class="col-md-5 border border-dark">
                        <label for="" class="form-label fw-semibold">BARANGAY</label>
                        <p x-text="record.barangay"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-5 border border-dark">
                        <label for="" class="form-label fw-semibold">CITY/MUNICIPALITY</label>
                        <p x-text="record.city_municipality"></p>
                    </div>
                    <div class="col-md-5 border border-dark">
                        <label for="" class="form-label fw-semibold">PROVINCE</label>
                        <p x-text="record.province"></p>
                    </div>
                    <div class="col-md-2 border border-dark">
                        <label for="" class="form-label fw-semibold">REGION</label>
                        <p x-text="record.region"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <p class="mb-0  border border-dark fw-semibold">CONTACT DETAILS</p>
                </div>
                <div class="row px-3">
                    <div class="col-md-4 border border-dark">
                        <div class="d-flex gap-2">
                            <p class="fw-semibold">LANDLINE: </p>
                            <span x-text="record.landline"></span>
                        </div>
                    </div>
                    <div class="col-md-4 border border-dark">
                        <div class="d-flex gap-2">
                            <p class="fw-semibold">MOBILE: </p>
                            <span x-text="record.mobile"></span>
                        </div>
                    </div>
                    <div class="col-md-4 border border-dark">
                        <div class="d-flex gap-2">
                            <p class="fw-semibold">EMAIL: </p>
                            <span x-text="record.email"></span>
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-5 border border-dark">
                        <label for="" class="form-label fw-semibold">DATE OF BIRTH</label>
                        <p x-text="formatDate(record.birthdate)"></p>
                    </div>
                    <div class="col-md-2 border border-dark">
                        <label for="" class="form-label fw-semibold">SEX</label>
                        <p x-text="record.sex" class="text-uppercase"></p>
                    </div>
                    <div class="col-md-5 border border-dark">
                        <label for="" class="form-label fw-semibold">CIVIL STATUS</label>
                        <p x-text="record.civil_status"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-4 border border-dark">
                        <label for="" class="form-label fw-semibold">EDUCATIONAL ATTAINMENT</label>
                        <p x-text="record.educational_attainment"></p>
                    </div>
                    <div class="col-md-4 border border-dark p-0">
                        <div class="p-2 border-bottom border-dark">
                            <label for="" class="form-label fw-semibold">EMPLOYMENT STATUS</label>
                            <p x-text="record.employment_status"></p>
                        </div>
                        <div class="border-top border-bottom border-dark p-2">
                            <label for="" class="form-label fw-semibold">CATEGORY OF EMPLOYMENT</label>
                            <p x-text="record.category_of_employment"></p>
                        </div>
                        <div class="border-top border-bottom border-dark p-2">
                            <label for="" class="form-label fw-semibold">NATURE OF EMPLOYMENT</label>
                            <p x-text="record.nature_of_employment"></p>
                        </div>
                    </div>
                    <div class="col-md-4 border border-dark">
                        <label for="" class="form-label fw-semibold">OCCUPATION</label>
                        <p x-text="record.occupation"></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-4 border border-dark">
                        <label for="" class="form-label fw-semibold">BLOOD TYPE</label>
                    </div>
                    <div class="col-md-4 border border-dark">
                        <label for="" class="form-label fw-semibold">ORGANIZATION AFFLIATED</label>
                        <p>Organization Affliated: <span x-text="record.organization_affiliated"></span></p>
                        <p>Contact Person: <span x-text="record.contact_person"></span></p>
                        <p>Office Address: <span x-text="record.office_address"></span></p>
                        <p></p>
                    </div>
                    <div class="col-md-4 border border-dark">
                        <label for="" class="form-label fw-semibold">ID REFERENCE NO.</label>
                        <p>SSS NO.: <span x-text="record.sss_no"></span></p>
                        <p>GSIS NO.: <span x-text="record.gsis_no"></span></p>
                        <p>PHILHEALTH NO.: <span x-text="record.philhealth_no"></span></p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-6 border border-dark">
                        <label for="" class="form-label fw-semibold">FATHER'S NAME</label>
                        <p x-text="record.fathers_name"></p>
                    </div>

                    <div class="col-md-6 border border-dark">
                        <label for="" class="form-label fw-semibold">MOTHER'S NAME</label>
                        <p x-text="record.mothers_name"></p>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-dark">Update Information</button>
                </div>
            </div>
        </div>
    </div>

</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function ManageRecordPage() {
        return {
            errors: {},
            record: [],

            resetForm() {
                this.errors = {};
            },

            init() {
                this.fetchRecord();
            },

            async fetchRecord() {
                try {
                    const response = await fetch('/admin/fetch-records/<?= $record['id'] ?>');
                    const data = await response.json();

                    if (data.status === 'error') {
                        console.error(data.errors);
                        return;
                    }

                    this.record = data.data;
                    console.log(this.record);

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