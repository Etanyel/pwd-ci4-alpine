<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Add Record | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Add New PWD Record<?= $this->endSection(); ?>

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
                        <input type="text" x-model="form.pwd_no"
                            class="form-control"
                            :class="errors.pwd_no ? 'border-danger' : ''"
                            placeholder="(RR-PPMM-BBB-NNNNNNNN)" required
                            @input="formatPwdNo" maxlength="20">
                        <p class="text-danger fw-semibold" x-text="errors.pwd_no"></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">2. DATE APPLIED <span :class="form.date_applied.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="date" class="form-control" :class="errors.date_applied ? 'border-danger' : ''" x-model="form.date_applied" required>
                        <p class="text-danger fw-semibold" x-text="errors.date_applied"></p>
                    </div>
                </div>
            </div>

            <!-- PERSONAL INFO -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold">3. LAST NAME <span :class="form.lastname.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="text" class="form-control" x-model="form.lastname" :class="errors.lastname ? 'border-danger' : ''" placeholder="eg. DELA CRUZ" required>
                        <p class="text-danger fw-semibold" x-text="errors.lastname"></p>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">FIRST NAME <span :class="form.firstname.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="text" class="form-control" x-model="form.firstname" :class="errors.firstname ? 'border-danger' : ''" placeholder="eg. JUAN" required>
                        <p class="text-danger fw-semibold" x-text="errors.firstname"></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">MIDDLE NAME <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                        <input type="text" class="form-control" x-model="form.middlename" :class="errors.middlename ? 'border-danger' : ''" placeholder="eg. D." maxlength="1">
                        <p class="text-danger fw-semibold" x-text="errors.middlename"></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">SUFFIX <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                        <input type="text" class="form-control" x-model="form.suffix" :class="errors.suffix ? 'border-danger' : ''" placeholder="eg. JR., SR., III" maxlength="1">
                        <p class="text-danger fw-semibold" x-text="errors.suffix"></p>
                    </div>
                </div>
            </div>

            <!-- TYPE OF DISABILITY/CAUSE OF DISABILITY -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold">4. TYPE OF DISABILITY <span :class="form.typeDisability == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.typeDisability" :class="errors.type_of_disability ? 'border-danger' : ''">
                            <template x-for="item in disability" :key="item.id">
                                <option :value="item.id"><span x-text="item.disability"></span></option>
                            </template>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.type_of_disability"></p>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">5. CAUSE OF DISABILITY <span :class="form.causeOfDisability == '' ? 'text-danger' : 'd-none'">*</span></label>

                        <select class="form-select"
                            x-model="form.causeOfDisability"
                            @change="causeOf()" required
                            :class="errors.cause_of_disability ? 'border-danger' : ''">
                            <option value="">Select Type</option>
                            <option value="2">Congenital/Inborn</option>
                            <option value="1">Acquired</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.cause_of_disability"></p>
                    </div>

                    <template x-if="cause_title.length > 0">
                        <div :class="form.cause == 8 ? 'col-2' : 'col-4'">
                            <label for="" class="form-label fw-semibold">CAUSE <span :class="form.cause == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.cause" :class="errors.cause ? 'border-danger' : ''" required>
                                <option value="">Select cause</option>
                                <template x-for="title in cause_title" :key="title.id">
                                    <option :value="title.cause_id"><span x-text="title.title"></span></option>
                                </template>
                            </select>
                        </div>
                    </template>

                    <template x-if="form.cause == 8">
                        <div class="col-2">
                            <label class="form-label fw-semibold">Other Cause</label>
                            <input type="text" x-model="form.other_cause" :class="errors.other_cause ? 'border-danger' : ''" class="form-control" placeholder="Other cause of disability" required>
                            <p class="text-danger fw-semibold" x-text="errors.other_cause"></p>
                        </div>
                    </template>
                </div>
            </div>
            <hr>

            <!-- ADDRESS -->
            <div class="mb-4">
                <label class="form-label fw-semibold">6. ADDRESS <span style="font-size: smaller;" class="text-muted">(Select Region first)</span></label>
                <div class="row">
                    <!-- REGION -->
                    <div class="col-3">
                        <label class="form-label fw-semibold">REGION <span :class="form.region == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.region" @change="fetchProvinces" :class="errors.region ? 'border-danger' : ''">
                            <option value="">Select Region</option>
                            <template x-for="r in regions" :key="r.code">
                                <option :value="r.code" x-text="r.region_name"></option>
                            </template>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.region"></p>
                    </div>

                    <!-- PROVINCE -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">PROVINCE <span :class="form.province == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.province" :class="errors.province ? 'border-danger' : ''" @change="fetchCities" :disabled="form.region == ''">
                            <option value="">Select Province</option>
                            <template x-for="p in provinces" :key="p.code">
                                <option :value="p.code" x-text="p.name"></option>
                            </template>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.province"></p>
                    </div>

                    <!-- CITY -->
                    <div class="col-2">
                        <label for="" class="form-label fw-semibold">CITY/MUNICIPALITY <span :class="form.city == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.city" :class="errors.city_municipality ? 'border-danger' : ''" @change="fetchBarangays" :disabled="form.province == ''">
                            <option value="">Select City</option>
                            <template x-for="c in cities" :key="c.code">
                                <option :value="c.code" x-text="c.name"></option>
                            </template>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.city_municipality"></p>
                    </div>

                    <!-- BARANGAY -->
                    <div class="col-2">
                        <label for="" class="form-label fw-semibold">BARANGAY <span :class="form.barangay == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <template x-if="barangays.length !== 0">
                            <select class="form-select" x-model="form.barangay" required :class="errors.barangay ? 'border-danger' : ''">
                                <option value="">Select Barangay</option>
                                <template x-for="b in barangays" :key="b.code">
                                    <option :value="b.code" x-text="b.name"></option>
                                </template>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.barangay"></p>
                        </template>

                        <template x-if="barangays.length == 0">
                            <input type="text" class="form-control" :disabled="form.city == ''" placeholder="Enter barangay" x-model="form.barangay" required>
                            <p class="text-danger fw-semibold" x-text="errors.barangay"></p>
                        </template>
                    </div>

                    <!-- Street Name -->
                    <div class="col-2">
                        <label for="" class="form-label fw-semibold">STREET NAME/PUROK <span :class="form.street_name == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="text" class="form-control" x-model="form.street_name" :class="errors.street_name ? 'border-danger' : ''" placeholder="Enter Purok" :disabled="form.barangay == ''">
                        <p class="text-danger fw-semibold" x-text="errors.street_name"></p>
                    </div>
                </div>
            </div>
            <hr>

            <!-- Contact Details -->
            <div class="mb-3">
                <label class="form-label fw-semibold">6. CONTACT DETAILS</label>
                <div class="row">
                    <!-- landline -->
                    <div class="col-4">
                        <label class="form-label fw-semibold">LANDLINE</label>
                        <input type="text" x-model="form.landline" :class="errors.landline ? 'border-danger' : ''" class="form-control" placeholder="123-456-789">
                    </div>

                    <!-- mobile number -->
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">MOBILE NUMBER</label>
                        <input type="text" class="form-control" :class="errors.mobile_no ? 'border-danger' : ''" x-model="form.mobile_no" placeholder="09123456789">
                    </div>

                    <!-- Email Address -->
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">EMAIL ADDRESS</label>
                        <input type="email" class="form-control" :class="errors.email ? 'border-danger' : ''" x-model="form.email" placeholder="josemariechan@example.com">
                    </div>
                </div>
            </div>
            <hr>

            <!-- BIRTHDATE -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">8. DATE OF BIRTH <span :class="form.birthdate == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <input type="date" x-model="form.birthdate" class="form-control" :class="errors.birthdate ? 'border-danger' : ''">
                        <p class="text-danger fw-semibold" x-text="errors.birthdate"></p>
                    </div>

                    <div class="col-2">
                        <label for="" class="form-label fw-semibold">9. SEX <span :class="form.sex == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.sex" :class="errors.sex ? 'border-danger' : ''">
                            <option value="">Select Sex</option>
                            <option value="male">MALE</option>
                            <option value="female">FEMALE</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.sex"></p>
                    </div>
                    <div class="col-2">
                        <label for="" class="form-label fw-semibold">Age</label>
                        <input type="text" readonly :value="age" class="form-control" :class="errors.age ? 'border-danger' : ''">
                    </div>

                    <div class="col-4">
                        <label for="" class="form-label fw-semibold">10. CIVIL STATUS <span :class="form.civil_status == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.civil_status" :class="errors.civil_status ? 'border-danger' : ''">
                            <option value="">Select Civil Status</option>
                            <option value="0">Single</option>
                            <option value="1">Married</option>
                            <option value="2">Separated</option>
                            <option value="3">Widow/er</option>
                            <option value="4">Cohabitation (Live-in)</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.civil_status"></p>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col-2">
                        <label class="form-label fw-semibold">11. EDUCATIONAL ATTAINMENT <span :class="form.educational_attainment == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.educational_attainment" :class="errors.educational_attainment ? 'border-danger' : ''">
                            <option value="">Select Educational Attainment</option>
                            <option value="0">None</option>
                            <option value="1">Kindergarten</option>
                            <option value="2">Elementary</option>
                            <option value="3">Junior High School</option>
                            <option value="4">Senior High School</option>
                            <option value="5">College</option>
                            <option value="6">Vocational</option>
                            <option value="7">Post Graduate</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.educational_attainment"></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">12. EMPLOYMENT STATUS <span :class="form.employment_status == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.employment_status" :class="errors.employment_status ? 'border-danger' : ''">
                            <option value="0">Employed</option>
                            <option value="1">Unemployed</option>
                            <option value="2">Self-Employed</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.employment_status"></p>
                    </div>

                    <div class="col-2">
                        <label class="form-label fw-semibold">12.1 CATEGORY OF EMPLOYMENT</label>
                        <select class="form-select" x-model="form.category_of_employment" :class="errors.category_of_employment ? 'border-danger' : ''">
                            <option value="">Select Category</option>
                            <option value="0">Government</option>
                            <option value="1">Private</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.category_of_employment"></p>
                    </div>

                    <div class="col-2">
                        <label class="form-label fw-semibold">12.2 NATURE OF EMPLOYMENT <span :class="form.nature_of_employment == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.nature_of_employment" :class="errors.nature_of_employment ? 'border-danger' : ''">
                            <option value="">Select nature of employment</option>
                            <option value="0">Casual</option>
                            <option value="1">Seasonal</option>
                            <option value="2">Emergency</option>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.nature_of_employment"></p>
                    </div>

                    <div :class="form.occupation == 11 ? 'col-2' : 'col-4'">
                        <label class="form-label fw-semibold">13. OCCUPATION <span :class="form.occupation == '' ? 'text-danger' : 'd-none'">*</span></label>
                        <select class="form-select" x-model="form.occupation" :class="errors.occupation ? 'border-danger' : ''">
                            <option value="">Select Occupation</option>
                            <template x-for="item in occupation" :key="item.id">
                                <option :value="item.occupation_id"><span x-text="item.occupation_name"></span></option>
                            </template>
                        </select>
                        <p class="text-danger fw-semibold" x-text="errors.occupation"></p>
                    </div>

                    <template x-if="form.occupation == 11">
                        <div class="col-2">
                            <label class="form-label fw-semibold">Other Occupation <span :class="form.other_occupation == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="text" placeholder="Enter other occupation" class="form-control" x-model="form.other_occupation" required :class="errors.other_occupation ? 'border-danger' : ''">
                            <p class="text-danger fw-semibold" x-text="errors.other_occupation"></p>
                        </div>
                    </template>

                </div>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold">14. BLOOD TYPE</label>
                        <select class="form-select" x-model="form.bloodtype" :class="errors.bloodtype ? 'border-danger' : ''">
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
                            <input type="text" class="form-control" x-model="form.organization_affliated" :class="errors.organization_affliated ? 'border-danger' : ''">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Contact Person</label>
                            <input type="text" class="form-control" x-model="form.contact_person" :class="errors.contact_person ? 'border-danger' : ''">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Office Address</label>
                            <input type="text" class="form-control" x-model="form.office_address" :class="errors.office_address ? 'border-danger' : ''">
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">16. ID REFERENCE NO.</label>
                        <div class="mb-2">
                            <label class="form-label">SSS NO.</label>
                            <input type="text" class="form-control" x-model="form.sss_no" :class="errors.sss_no ? 'border-danger' : ''">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">GSIS NO.</label>
                            <input type="text" class="form-control" x-model="form.gsis_no" :class="errors.gsis_no ? 'border-danger' : ''">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">PSN NO.</label>
                            <input type="text" class="form-control" x-model="form.psn_no" :class="errors.psn_no ? 'border-danger' : ''">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">PHILHEALTH NO.</label>
                            <input type="text" class="form-control" x-model="form.philhealth_no" :class="errors.philhealth_no ? 'border-danger' : ''">
                        </div>
                    </div>
                </div>
            </div>
            <hr>

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

</div>


<?= $this->endSection(); ?>


<!-- Scripts -->
<?= $this->section('scripts'); ?>
<script>
    function addRecordApp() {
        return {
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
                street_name: '',
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

            async addRecord() {
                const formData = new FormData();
                formData.append('pwd_no', this.form.pwd_no);
                formData.append('date_applied', this.form.date_applied);
                formData.append('lastname', this.form.lastname);
                formData.append('firstname', this.form.firstname);
                formData.append('middlename', this.form.middlename);
                formData.append('suffix', this.form.suffix);
                formData.append('type_of_disability', this.form.typeDisability);
                formData.append('cause', this.form.cause);
                formData.append('other_cause', this.form.other_cause);
                formData.append('region', this.form.region);
                formData.append('province', this.form.province);
                formData.append('city', this.form.city);
                formData.append('barangay', this.form.barangay);
                formData.append('street_name', this.form.street_name);
                formData.append('landline', this.form.landline);
                formData.append('mobile_no', this.form.mobile_no);
                formData.append('email', this.form.email);
                formData.append('birthdate', this.form.birthdate);
                formData.append('age', this.age);
                formData.append('sex', this.form.sex);
                formData.append('civil_status', this.form.civil_status);
                formData.append('educational_attainment', this.form.educational_attainment);
                formData.append('employment_status', this.form.employment_status);
                formData.append('category_of_employment', this.form.category_of_employment);
                formData.append('nature_of_employment', this.form.nature_of_employment);
                formData.append('occupation', this.form.occupation);
                formData.append('other_occupation', this.form.other_occupation);
                formData.append('bloodtype', this.form.bloodtype);
                formData.append('organization_affliated', this.form.organization_affliated);
                formData.append('office_address', this.form.office_address);
                formData.append('contact_person', this.form.contact_person);
                formData.append('sss_no', this.form.sss_no);
                formData.append('gsis_no', this.form.gsis_no);
                formData.append('psn_no', this.form.psn_no);
                formData.append('philhealth_no', this.form.philhealth_no);
                formData.append('fathers_lastname', this.form.fathers_lastname);
                formData.append('fathers_firstname', this.form.fathers_firstname);
                formData.append('fathers_middlename', this.form.fathers_middlename);
                formData.append('mothers_lastname', this.form.mothers_lastname);
                formData.append('mothers_firstname', this.form.mothers_firstname);
                formData.append('mothers_middlename', this.form.mothers_middlename);

                const res = await fetch('/admin/add-record', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (data.status === 'error') {
                    this.errors = data.errors;
                    console.error(data.errors);
                    return;
                } else {
                    this.resetForm();
                    Swal.fire('Added Success', data.message, 'success');
                }
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

            resetForm() {
                this.form.pwd_no = '';
                this.form.date_applied = '';
                this.form.lastname = '';
                this.form.firstname = '';
                this.form.middlename = '';
                this.form.suffix = '';
                this.form.typeDisability = '';
                this.form.causeOfDisability = '';
                this.form.cause = '';
                this.form.region = '';
                this.form.province = '';
                this.form.city = '';
                this.form.barangay = '';
                this.form.street_name = '';
                this.form.landline = '';
                this.form.mobile_no = '';
                this.form.email = '';
                this.form.birthdate = '';
                this.form.sex = '';
                this.form.civil_status = '';
                this.form.educational_attainment = '';
                this.form.employment_status = '';
                this.form.category_of_employment = '';
                this.form.nature_of_employment = '';
                this.form.occupation = '';
                this.form.other_occupation = '';
                this.form.bloodtype = '';
                this.form.organization_affliated = '';
                this.form.office_address = '';
                this.form.contact_person = '';
                this.form.sss_no = '';
                this.form.gsis_no = '';
                this.form.psn_no = '';
                this.form.philhealth_no = '';
                this.form.fathers_lastname = '';
                this.form.fathers_firstname = '';
                this.form.fathers_middlename = '';
                this.form.mothers_lastname = '';
                this.form.mothers_firstname = '';
                this.form.mothers_middlename = '';

                this.errors = {};
            },

            get age() {
                // If no birthdate yet, show empty
                if (!this.form.birthdate) return '';

                const today = new Date(); // current date
                const birthDate = new Date(this.form.birthdate); // user's birthdate

                // Step 1: basic age (year difference)
                let age = today.getFullYear() - birthDate.getFullYear();

                // Step 2: check if birthday already happened this year
                const currentMonth = today.getMonth();
                const birthMonth = birthDate.getMonth();

                const currentDay = today.getDate();
                const birthDay = birthDate.getDate();

                // Step 3: if birthday hasn't happened yet, subtract 1
                if (currentMonth < birthMonth || (currentMonth === birthMonth && currentDay < birthDay)) {
                    age--;
                }

                return age;
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

            formatPwdNo(e) {
                let value = e.target.value.replace(/\D/g, ''); // numbers only

                let parts = [];

                // Pattern: 2-4-3-8
                if (value.length > 0) parts.push(value.substring(0, 2));
                if (value.length > 2) parts.push(value.substring(2, 6));
                if (value.length > 6) parts.push(value.substring(6, 9));
                if (value.length > 9) parts.push(value.substring(9, 17));

                this.form.pwd_no = parts.join('-');
            },


        }
    }
</script>
<?= $this->endSection(); ?>