<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Add Record | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Add Record<?= $this->endSection(); ?>

<?= $this->section('add-record-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>
<div class="" x-data="addRecordApp()">
    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">
        <form @submit.prevent="addRecord">
            <!-- PWD NUMBER -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label fw-semibold">1. PWD NUMBER <span :class="form.pwd_no.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="text" x-model="form.pwd_no" class="form-control" placeholder="(RR-PPMM-BB-NNNNNNNN)" required>
                        <p x-text=""></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">2. DATE APPLIED <span :class="form.date_applied.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="date" class="form-control" x-model="form.date_applied" required>
                        <p x-text=""></p>
                    </div>
                </div>
            </div>

            <!-- PERSONAL INFO -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold">3. LAST NAME <span :class="form.lastname.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="text" class="form-control" x-model="form.lastname" placeholder="eg. DELA CRUZ" required>
                        <p x-text=""></p>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">FIRST NAME <span :class="form.firstname.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="text" class="form-control" x-model="form.firstname" placeholder="eg. JUAN" required>
                        <p x-text=""></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">MIDDLE NAME <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                        <input type="text" class="form-control" x-model="form.middlename" placeholder="eg. D." maxlength="1">
                        <p x-text=""></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">SUFFIX <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                        <input type="text" class="form-control" x-model="form.suffix" placeholder="eg. JR., SR., III" maxlength="1">
                        <p x-text=""></p>
                    </div>
                </div>
            </div>

            <!-- TYPE OF DISABILITY/CAUSE OF DISABILITY -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label fw-semibold">4. TYPE OF DISABILITY</label>
                        <select class="form-select" x-model="form.typeDisability">
                            <template x-for="item in disability" :key="item.id">
                                <option :value="item.id"><span x-text="item.disability"></span></option>
                            </template>
                        </select>
                        <p x-text=""></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">5. CAUSE OF DISABILITY</label>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-select"
                                    x-model="form.causeOfDisability"
                                    @change="causeOf()" required>
                                    <option value="">Select Type</option>
                                    <option value="2">Congenital/Inborn</option>
                                    <option value="1">Acquired</option>
                                </select>
                            </div>

                            <template x-if="cause_title.length">
                                <div class="col-6">
                                    <select class="form-select" x-model="form.cause" required>
                                        <option value="">Select cause</option>
                                        <template x-for="title in cause_title" :key="title.id">
                                            <option :value="title.cause_id" x-text="title.title"></option>
                                        </template>
                                    </select>
                                </div>

                                <p x-text="form.cause"></p>
                            </template>

                            <template x-if="form.cause == 8">
                                <div class="mt-2">
                                    <label class="form-label">Others</label>
                                    <input type="text" x-model="form.other_cause" class="form-control" placeholder="Other cause of disability" required>
                                </div>
                            </template>
                        </div>
                        <p x-text=""></p>
                    </div>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="mb-4">
                <label class="form-label fw-semibold">6. ADDRESS <span style="font-size: smaller;" class="text-muted">(Select Region first)</span></label>
                <div class="row">
                    <!-- REGION -->
                    <div class="col-3">
                        <label class="form-label fw-semibold">REGION</label>
                        <select class="form-select" x-model="form.region" @change="fetchProvinces">
                            <option value="">Select Region</option>
                            <template x-for="r in regions" :key="r.code">
                                <option :value="r.code" x-text="r.name"></option>
                            </template>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <!-- PROVINCE -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">PROVINCE</label>
                        <select class="form-select" x-model="form.province" @change="fetchCities" :disabled="form.region == ''">
                            <option value="">Select Province</option>
                            <template x-for="p in provinces" :key="p.code">
                                <option :value="p.code" x-text="p.name"></option>
                            </template>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <!-- CITY -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">CITY/MUNICIPALITY</label>
                        <select class="form-select" x-model="form.city" @change="fetchBarangays" :disabled="form.province == ''">
                            <option value="">Select City</option>
                            <template x-for="c in cities" :key="c.code">
                                <option :value="c.code" x-text="c.name"></option>
                            </template>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <!-- BARANGAY -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">BARANGAY</label>
                        <template x-if="barangays.length !== 0">
                            <select class="form-select" x-model="form.barangay" required>
                                <option value="">Select Barangay</option>
                                <template x-for="b in barangays" :key="b.code">
                                    <option :value="b.code" x-text="b.name"></option>
                                </template>
                            </select>
                            <p x-text=""></p>
                        </template>

                        <template x-if="barangays.length == 0">
                            <input type="text" class="form-control" :disabled="form.city == ''" placeholder="Enter barangay" x-model="form.barangay" required>
                            <p x-text=""></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="mb-3">
                <label class="form-label fw-semibold">6. CONTACT DETAILS</label>
                <div class="row">
                    <!-- landline -->
                    <div class="col-4">
                        <label class="form-label fw-semibold">LANDLINE</label>
                        <input type="text" x-model="form.landline" class="form-control" placeholder="123-456-789">
                    </div>

                    <!-- mobile number -->
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">MOBILE NUMBER</label>
                        <input type="text" class="form-control" x-model="form.mobile_no" placeholder="09123456789">
                    </div>

                    <!-- CITY -->
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">EMAIL ADDRESS</label>
                        <input type="email" class="form-control" x-model="form.email" placeholder="josemariechan@example.com">
                    </div>
                </div>
            </div>

            <!-- BIRTHDATE -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">8. DATE OF BIRTH</label>
                        <input type="date" x-model="form.birthdate" class="form-control">
                        <p x-text=""></p>
                    </div>

                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">9. SEX</label>
                        <select class="form-select" x-model="form.sex">
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">10. CIVIL STATUS</label>
                        <select class="form-select" x-model="form.civil_status">
                            <option value="0"></option>
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value="4"></option>
                        </select>
                        <p x-text=""></p>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col-2">
                        <label class="form-label fw-semibold">11. EDUCATIONAL ATTAINMENT</label>
                        <select class="form-select" x-model="form.educational_attainment">
                            <option value="0">None</option>
                            <option value="1">Kindergarten</option>
                            <option value="2">Elementary</option>
                            <option value="3">Junior High School</option>
                            <option value="4">Senior High School</option>
                            <option value="5">College</option>
                            <option value="6">Vocational</option>
                            <option value="7">Post Graduate</option>
                        </select>
                        <p x-text=""></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">12. EMPLOYMENT STATUS</label>
                        <select class="form-select" x-model="form.employment_status">
                            <option value="0">Employed</option>
                            <option value="1">Unemployed</option>
                            <option value="2">Self-Employed</option>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <div class="col-2">
                        <label class="form-label fw-semibold">12.1 CATEGORY OF EMPLOYMENT</label>
                        <select class="form-select" x-model="form.category_of_employment">
                            <option value="0">Government</option>
                            <option value="1">Private</option>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <div class="col-2">
                        <label class="form-label fw-semibold">12.2 NATURE OF EMPLOYMENT</label>
                        <select class="form-select" x-model="form.nature_of_employment">
                            <option value="">Select nature of employment</option>
                            <option value="0">Casual</option>
                            <option value="1">Seasonal</option>
                            <option value="2">Emergency</option>
                        </select>
                        <p x-text=""></p>
                    </div>

                    <div class="col-4">
                        <label class="form-label fw-semibold">13. OCCUPATION</label>
                        <select class="form-select" x-model="form.occupation">
                            <template x-for="item in occupation" :key="item.id">
                                <option :value="item.occupation_id"><span x-text="item.occupation_name"></span></option>
                            </template>
                        </select>
                        <p x-text=""></p>

                        <template x-if="form.occupation === 11">
                            <label class="form-label">Other Occupation</label>
                            <input type="text" placeholder="Other Occupation" class="form-control">
                        </template>
                    </div>

                </div>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold">14. BLOOD TYPE</label>
                        <select class="form-select" x-model="form.bloodtype">
                            <option value="">Select Blood Type</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="O+">O+</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="B-">B-</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">15. ORGANIZATION AFFLIATED</label>
                        <div class="mb-2">
                            <label class="form-label">Organization Affliated</label>
                            <input type="text" class="form-control" x-model="form.organization_affliated">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Contact Person</label>
                            <input type="text" class="form-control" x-model="form.contact_person">
                            <p x-text=""></p>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Office Address</label>
                            <input type="text" class="form-control" x-model="form.office_address">
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">16. ID REFERENCE NO.</label>
                        <div class="mb-2">
                            <label class="form-label">SSS NO.</label>
                            <input type="text" class="form-control" x-model="form.sss_no">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">GSIS NO.</label>
                            <input type="text" class="form-control" x-model="form.gsis_no">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">PSN NO.</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">PHILHEALTH NO.</label>
                            <input type="text" class="form-control" x-model="form.philhealth_no">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-2">
                <label for="" class="form-label fw-semibold">17. FAMILY BACKGROUND</label>
                <div class="mb-2">
                    <label class="form-label fw-semibold">FATHER'S NAME</label>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">LAST NAME</label>
                            <input type="text" class="form-control" x-model="form.fathers_lastname">
                        </div>
                        <div class="col-4">
                            <label class="form-label">FIRST NAME</label>
                            <input type="text" class="form-control" x-model="form.fathers_firstname">
                        </div>
                        <div class="col-4">
                            <label class="form-label">MIDDLE NAME</label>
                            <input type="text" class="form-control" x-model="form.fathers_middlename">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold">MOTHER'S NAME</label>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">LAST NAME</label>
                            <input type="text" class="form-control" x-model="form.mothers_lastname">
                        </div>
                        <div class="col-4">
                            <label class="form-label">FIRST NAME</label>
                            <input type="text" class="form-control" x-model="form.mothers_firstname">
                        </div>
                        <div class="col-4">
                            <label class="form-label">MIDDLE NAME</label>
                            <input type="text" class="form-control" x-model="form.mothers_middlename">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <button class="btn btn-dark" type="submit">Submit Form</button>
            </div>
        </form>
    </div>


    <!-- <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">

    </div> -->
</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function addRecordApp() {
        return {
            search: '',
            errors: {},
            cause_title: [],
            disability: [],
            regions: [],
            provinces: [],
            cities: [],
            barangays: [],
            occupation: [],

            form: {
                pwd_no: '',
                date_applied: '',
                lastname: '',
                firstname: '',
                middlename: '',
                suffix: '',
                typeDisability: '',
                causeOfDisability: '',
                cause: '',
                region: '',
                province: '',
                city: '',
                barangay: '',
                landline: '',
                mobile_no: '',
                email: '',
                birthdate: '',
                sex: '',
                civil_status: '',
                educational_attainment: '',
                employment_status: '',
                category_of_employment: '',
                nature_of_employment: '',
                occupation: '',
                other_occupation: '',
                bloodtype: '',
                organization_affliated: '',
                office_address: '',
                contact_person: '',
                sss_no: '',
                gsis_no: '',
                psn_no: '',
                philhealth_no: '',
                fathers_lastname: '',
                fathers_firstname: '',
                fathers_middlename: '',
                mothers_lastname: '',
                mothers_firstname: '',
                mothers_middlename: '',
            },

            init() {
                this.fetchOccupation();
                this.fetchDisability();
                this.fetchRegions();
            },

            addRecord() {
                const formData = new FormData();
                formData.append('pwd_no', this.form.pwd_no);
                formData.append('date_applied', this.form.date_applied);
                formData.append('lastname', this.form.lastname);
                formData.append('firstname', this.form.firstname);
                formData.append('middlename', this.form.middlename);
                formData.append('suffix', this.form.suffix);
                formData.append('type_of_disability', this.form.typeDisability);
                formData.append('cause_of_disability', this.form.causeOfDisability);
                formData.append('cause', this.form.cause);

                console.log(
                    // this.form.pwd_no,
                    // this.form.date_applied,
                    // this.form.lastname,
                    // this.form.firstname,
                    // this.form.middlename,
                    // this.form.suffix,
                    // this.form.typeDisability,
                    // this.form.causeOfDisability,
                    this.form.cause,
                    this.form.other_cause,
                    this.form.region,
                    this.form.province,
                    this.form.city,
                    this.form.barangay,
                    this.form.landline,
                    this.form.mobile_no,
                    this.form.email,
                    this.form.birthdate,
                    this.form.sex,
                    this.form.civil_status,
                    this.form.educational_attainment,
                    this.form.employment_status,
                    this.form.category_of_employment,
                    this.form.nature_of_employment,
                    this.form.occupation,
                    this.form.other_occupation,
                    this.form.bloodtype,
                    this.form.organization_affliated,
                    this.form.office_address,
                    this.form.contact_person,
                    this.form.sss_no,
                    this.form.gsis_no,
                    this.form.psn_no,
                    this.form.philhealth_no,
                    this.form.fathers_lastname,
                    this.form.fathers_firstname,
                    this.form.fathers_middlename,
                    this.form.mothers_lastname,
                    this.form.mothers_firstname,
                    this.form.mothers_middlename,
                );
            },

            async fetchDisability() {
                try {
                    const res = await fetch('<?= base_url('/admin/fetch-disability') ?>');
                    const data = await res.json();
                    if (data.status == 'error') {
                        console.error(data.error);
                    } else {
                        this.disability = data.data;
                    }
                } catch (error) {
                    console.error(error);
                }
            },


            async causeOf() {
                if (!this.form.causeOfDisability) {
                    this.cause_title = [];
                    this.form.cause = '';
                    return;
                }

                try {
                    const url = `<?= base_url('/admin/fetch-cause/') ?>${this.form.causeOfDisability}`;
                    const res = await fetch(url);
                    const data = await res.json();

                    if (data.status === 'success') {
                        this.cause_title = data.cause;
                    }
                } catch (err) {
                    console.error(err);
                }
            },

            async fetchOccupation() {
                try {
                    const res = await fetch('<?= base_url('fetch-occupation') ?>');
                    const data = await res.json();

                    if (data.status == 'error') {
                        console.error(data.errors);
                    }

                    this.occupation = data.data;
                } catch (err) {
                    console.error(err);
                }
            },

            async fetchRegions() {
                const res = await fetch('<?= base_url('/fetch-regions') ?>');
                const regions = await res.json();
                this.regions = regions.regions;
                // console.log(regions);
            },

            async fetchProvinces() {
                this.provinces = [];
                this.cities = [];
                this.barangays = [];

                const res = await fetch(`/fetch-province/${this.form.region}`);
                const data = await res.json();

                // console.log(data.provinces);
                this.provinces = data.provinces;
            },

            async fetchCities() {
                this.cities = [];
                this.barangays = [];

                const res = await fetch(`/fetch-cities/${this.form.province}`);
                const data = await res.json();

                // console.log(data.cities);
                this.cities = data.cities;
            },

            async fetchBarangays() {
                const res = await fetch(`/fetch-barangays/${this.form.city}`);
                const data = await res.json();

                this.barangays = data.barangays;

                // console.log('BARANGAY: ' + this.barangays);
            },

            formatDate(date) {
                return new Date(date.replace(' ', 'T')).toLocaleString('en-SG', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            },


        }
    }
</script>
<?= $this->endSection(); ?>