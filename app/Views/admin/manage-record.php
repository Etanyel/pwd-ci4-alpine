<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?><?= $record['lastname'] . " " . $record['firstname'] ?> | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?><?= $record['lastname'] . " " . $record['firstname'] ?><?= $this->endSection(); ?>

<?= $this->section('manage-records-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>

<div class="" x-data="ManageRecordPage()">
    <div x-show="!updateBtn">
        <div class="card shadow-sm mt-3 p-3 border-0">
            <div class="row">
                <div class="col-md-4 border-end">
                    <div class="d-flex justify-content-center">
                        <img :src="record.img ? '<?= base_url() ?>' + record.img : '<?= base_url('img/no_profile.jpg') ?>'" class="rounded border w-100" alt="" style="max-width: 450px;">
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <label class="btn btn-light form-control border d-flex align-items-center justify-content-center">
                            <i class="bi bi-upload me-2"></i>
                            <span x-text="file ? 'Update Photo' : 'Upload Photo'"></span>
                            <input type="file" class="d-none" @change="previewPhoto" accept="image/*">
                        </label>
                    </div>

                    <div class="mt-3 mb-2 border-top"></div>

                    <div class="">
                        <a href="<?= base_url('/admin/print-id/' . $record['id']) ?>" target="_blank" class="btn btn-dark">Print ID Front</a>
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
                            <p x-text="record.middlename ? record.middlename : 'N/A'"></p>
                        </div>

                        <div class="col-md-2 border border-dark">
                            <label for="" class="form-label fw-semibold">SUFFIX NAME</label>
                            <p x-text="record.suffix ? record.suffix : 'N/A'"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-6 border border-dark">
                            <label for="" class="form-label fw-semibold">TYPE OF DISABILITY</label>
                            <p x-text="record.disability == 'Others' ? record.other_disability : record.disability" class="text-uppercase"></p>
                        </div>

                        <div class="col-md-6 border border-dark">
                            <label for="" class="form-label fw-semibold">CAUSE OF DISABILITY</label>
                            <div class="">
                                <span x-text="cause_of.find(e => e.id == record.cause_of)?.label" class="badge text-bg-dark"></span>
                                <p x-text="record.title == 'Others' ? record.other_cause : record.title" class="text-uppercase"></p>
                            </div>
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
                                <span x-text="record.landline ? record.landline : 'N/A'"></span>
                            </div>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <div class="d-flex gap-2">
                                <p class="fw-semibold">MOBILE: </p>
                                <span x-text="record.mobile_no ? record.mobile_no : 'N/A'"></span>
                            </div>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <div class="d-flex gap-2">
                                <p class="fw-semibold">EMAIL: </p>
                                <span x-text="record.email ? record.email : 'N/A'"></span>
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
                            <p x-text="civil_status.find(e => e.id == record.civil_status)?.label"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-4 border border-dark">
                            <label for="" class="form-label fw-semibold">EDUCATIONAL ATTAINMENT</label>
                            <p x-text="educational_attainment.find(e => e.id == record.educational_attainment)?.label"></p>
                        </div>
                        <div class="col-md-4 border border-dark p-0">
                            <div class="p-2 border-bottom border-dark">
                                <label for="" class="form-label fw-semibold">EMPLOYMENT STATUS</label>
                                <p x-text="employment_status.find(e => e.id == record.employment_status)?.label"></p>
                            </div>
                            <div class="border-top border-bottom border-dark p-2">
                                <label for="" class="form-label fw-semibold">CATEGORY OF EMPLOYMENT</label>
                                <p x-text="category_of_employment.find(e => e.id == record.category_of_employment)?.label"></p>
                            </div>
                            <div class="border-top border-bottom border-dark p-2">
                                <label for="" class="form-label fw-semibold">NATURE OF EMPLOYMENT</label>
                                <p x-text="nature_of_employment.find(e => e.id == record.nature_of_employment)?.label"></p>
                            </div>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <label for="" class="form-label fw-semibold">OCCUPATION</label>
                            <p x-text="record.occupation_name == 'Other' ? record.other_occupation : record.occupation_name"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-4 border border-dark">
                            <label for="" class="form-label fw-semibold">BLOOD TYPE</label>
                            <p x-text="record.bloodtype ? record.bloodtype : 'N/A'"></p>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <label for="" class="form-label fw-semibold">ORGANIZATION AFFILIATED</label>
                            <p>Organization Affiliated: <span x-text="record.organization_affiliated ? record.organization_affiliated : 'N/A'"></span></p>
                            <p>Contact Person: <span x-text="record.contact_person ? record.contact_person : 'N/A'"></span></p>
                            <p>Office Address: <span x-text="record.office_address ? record.office_address : 'N/A'"></span></p>
                            <p></p>
                        </div>
                        <div class="col-md-4 border border-dark">
                            <label for="" class="form-label fw-semibold">ID REFERENCE NO.</label>
                            <p>SSS NO.: <span x-text="record.sss_no ? record.sss_no : 'N/A'"></span></p>
                            <p>GSIS NO.: <span x-text="record.gsis_no ? record.gsis_no : 'N/A'"></span></p>
                            <p>PHILHEALTH NO.: <span x-text="record.philhealth_no ? record.philhealth_no : 'N/A'"></span></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-6 border border-dark">
                            <label for="" class="form-label fw-semibold">FATHER'S NAME</label>
                            <p x-text="record.fathers_name ? record.fathers_name : 'N/A'"></p>
                        </div>

                        <div class="col-md-6 border border-dark">
                            <label for="" class="form-label fw-semibold">MOTHER'S NAME</label>
                            <p x-text="record.mothers_name ? record.mothers_name : 'N/A'"></p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-dark" @click="updateBtn = true">Update Information</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Form -->
    <div x-show="updateBtn">
        <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">
            <form @submit.prevent="updateRecord">
                <div class="">
                    <h3 class="text-primary text-center">Update Information</h3>
                    <hr>
                </div>

                <!-- PWD NUMBER -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">1. PWD NUMBER <span :class="form.pwd_no.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="text" x-model="form.pwd_no"
                                class="form-control"
                                :class="errors.pwd_no ? 'border-danger' : ''"
                                placeholder="(RR-PPMM-BBB-NNNNNNNN)" required
                                @input="formatPwdNo" maxlength="20">
                            <p class="text-danger fw-semibold" x-text="errors.pwd_no"></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">2. DATE APPLIED <span :class="form.date_applied.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="date" class="form-control" :class="errors.date_applied ? 'border-danger' : ''" x-model="form.date_applied" required>
                            <p class="text-danger fw-semibold" x-text="errors.date_applied"></p>
                        </div>
                    </div>
                </div>

                <!-- PERSONAL INFO -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">3. LAST NAME <span :class="form.lastname.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="text" class="form-control" x-model="form.lastname" :class="errors.lastname ? 'border-danger' : ''" placeholder="eg. DELA CRUZ" required>
                            <p class="text-danger fw-semibold" x-text="errors.lastname"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">FIRST NAME <span :class="form.firstname.length == 0 ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="text" class="form-control" x-model="form.firstname" :class="errors.firstname ? 'border-danger' : ''" placeholder="eg. JUAN" required>
                            <p class="text-danger fw-semibold" x-text="errors.firstname"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">MIDDLE NAME <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                            <input type="text" class="form-control" x-model="form.middlename" :class="errors.middlename ? 'border-danger' : ''" placeholder="eg. D.">
                            <p class="text-danger fw-semibold" x-text="errors.middlename"></p>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">SUFFIX <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                            <input type="text" class="form-control" x-model="form.suffix" :class="errors.suffix ? 'border-danger' : ''" placeholder="eg. JR., SR., III">
                            <p class="text-danger fw-semibold" x-text="errors.suffix"></p>
                        </div>
                    </div>
                </div>

                <!-- TYPE OF DISABILITY/CAUSE OF DISABILITY -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">4. TYPE OF DISABILITY <span :class="form.type_of_disability == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.type_of_disability" :class="errors.type_of_disability ? 'border-danger' : ''" required>
                                <option value="">Select Disability</option>
                                <template x-for="item in disability" :key="item.id">
                                    <option x-bind:selected="record.cause_of_disability == item.id" :value="item.id"><span x-text="item.disability"></span></option>
                                </template>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.type_of_disability"></p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">5. CAUSE OF DISABILITY <span :class="form.cause_of == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select"
                                x-model="form.cause_of"
                                @change="causeOf()" required
                                :class="errors.cause_of ? 'border-danger' : ''">
                                <option value="">Select Type</option>
                                <option value="0">Congenital/Inborn</option>
                                <option value="1">Acquired</option>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.cause_of"></p>
                        </div>

                        <template x-if="cause_title.length > 0">
                            <div :class="form.cause_of_disability == 8 ? 'col-md-2' : 'col-md-4'">
                                <label for="" class="form-label fw-semibold">CAUSE <span :class="form.cause_of_disability == '' ? 'text-danger' : 'd-none'">*</span></label>
                                <select class="form-select" x-model="form.cause_of_disability" :class="errors.cause_of_disability ? 'border-danger' : ''" required>
                                    <option value="">Select cause</option>
                                    <template x-for="title in cause_title" :key="title.cause_id">
                                        <option :selected="record.cause_of_disability == title.cause_id" :value="title.cause_id"><span x-text="title.title"></span></option>
                                    </template>
                                </select>
                                <p class="text-danger fw-semibold" x-text="errors.cause_of_disability"></p>
                            </div>
                        </template>

                        <template x-if="form.cause_of_disability == 8">
                            <div class="col-md-2">
                                <label class="form-label fw-semibold">Other Cause</label>
                                <input type="text" x-model="form.other_cause" :class="errors.other_cause ? 'border-danger' : ''" class="form-control" placeholder="Other cause of disability">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-2">
                            <label for="" class="form-label fw-semibold">CITY/MUNICIPALITY <span :class="form.city == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.city" :class="errors.city ? 'border-danger' : ''" @change="fetchBarangays" :disabled="form.province == ''">
                                <option value="">Select City</option>
                                <template x-for="c in cities" :key="c.code">
                                    <option :value="c.code" x-text="c.name"></option>
                                </template>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.city"></p>
                        </div>

                        <!-- BARANGAY -->
                        <div class="col-md-2">
                            <label for="" class="form-label fw-semibold">BARANGAY <span :class="form.barangay == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <template x-if="barangays.length !== 0">
                                <select class="form-select" x-model="form.barangay" required :class="errors.barangay ? 'border-danger' : ''">
                                    <option value="">Select Barangay</option>
                                    <template x-for="b in barangays" :key="b.code">
                                        <option :value="b.code" x-text="b.name"></option>
                                    </template>
                                </select>
                            </template>
                            <template x-if="barangays.length == 0">
                                <input type="text" class="form-control" :disabled="form.city == ''" placeholder="Enter barangay" x-model="form.barangay" required>
                            </template>
                            <p class="text-danger fw-semibold" x-text="errors.barangay"></p>
                        </div>

                        <!-- Street Name -->
                        <div class="col-md-2">
                            <label for="" class="form-label fw-semibold">STREET NAME/PUROK <span :class="form.street_name == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="text" class="form-control" x-model="form.street_name" :class="errors.street_name ? 'border-danger' : ''" placeholder="Enter Purok" :disabled="form.barangay == ''">
                            <p class="text-danger fw-semibold" x-text="errors.street_name"></p>
                        </div>
                    </div>
                </div>
                <hr>

                <!-- Contact Details -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">7. CONTACT DETAILS</label>
                    <div class="row">
                        <!-- landline -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">LANDLINE</label>
                            <input type="text" x-model="form.landline" :class="errors.landline ? 'border-danger' : ''" class="form-control" placeholder="123-456-789">
                        </div>

                        <!-- mobile number -->
                        <div class="col-md-4">
                            <label for="" class="form-label fw-semibold">MOBILE NUMBER</label>
                            <input type="text" class="form-control" :class="errors.mobile_no ? 'border-danger' : ''" x-model="form.mobile_no" placeholder="09123456789">
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-4">
                            <label for="" class="form-label fw-semibold">EMAIL ADDRESS</label>
                            <input type="email" class="form-control" :class="errors.email ? 'border-danger' : ''" x-model="form.email" placeholder="example@example.com">
                        </div>
                    </div>
                </div>
                <hr>

                <!-- BIRTHDATE -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="form-label fw-semibold">8. DATE OF BIRTH <span :class="form.birthdate == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <input type="date" x-model="form.birthdate" class="form-control" :class="errors.birthdate ? 'border-danger' : ''">
                            <p class="text-danger fw-semibold" x-text="errors.birthdate"></p>
                        </div>

                        <div class="col-md-2">
                            <label for="" class="form-label fw-semibold">9. SEX <span :class="form.sex == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.sex" :class="errors.sex ? 'border-danger' : ''">
                                <option value="">Select Sex</option>
                                <option value="male">MALE</option>
                                <option value="female">FEMALE</option>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.sex"></p>
                        </div>
                        <div class="col-md-2">
                            <label for="" class="form-label fw-semibold">Age</label>
                            <input type="text" readonly :value="age" class="form-control">
                        </div>

                        <div class="col-md-4">
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
                        <div class="col-md-2">
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
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">12. EMPLOYMENT STATUS <span :class="form.employment_status == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.employment_status" :class="errors.employment_status ? 'border-danger' : ''">
                                <option value="">Select Employment Status</option>
                                <option value="0">Employed</option>
                                <option value="1">Unemployed</option>
                                <option value="2">Self-Employed</option>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.employment_status"></p>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">12.1 CATEGORY OF EMPLOYMENT</label>
                            <select class="form-select" x-model="form.category_of_employment" :class="errors.category_of_employment ? 'border-danger' : ''">
                                <option value="">Select Category</option>
                                <option value="0">Government</option>
                                <option value="1">Private</option>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.category_of_employment"></p>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-semibold">12.2 NATURE OF EMPLOYMENT <span :class="form.nature_of_employment == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.nature_of_employment" :class="errors.nature_of_employment ? 'border-danger' : ''">
                                <option value="">Select nature of employment</option>
                                <option value="0">Casual</option>
                                <option value="1">Seasonal</option>
                                <option value="2">Emergency</option>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.nature_of_employment"></p>
                        </div>

                        <div :class="form.occupation == 11 ? 'col-md-2' : 'col-md-4'">
                            <label class="form-label fw-semibold">13. OCCUPATION <span :class="form.occupation == '' ? 'text-danger' : 'd-none'">*</span></label>
                            <select class="form-select" x-model="form.occupation" :class="errors.occupation ? 'border-danger' : ''">
                                <option value="">Select Occupation</option>
                                <template x-for="item in occupation" :key="item.occupation_id">
                                    <option :value="item.occupation_id"><span x-text="item.occupation_name"></span></option>
                                </template>
                            </select>
                            <p class="text-danger fw-semibold" x-text="errors.occupation"></p>
                        </div>

                        <template x-if="form.occupation == 11">
                            <div class="col-2">
                                <label class="form-label fw-semibold">Other Occupation <span :class="form.other_occupation == '' ? 'text-danger' : 'd-none'">*</span></label>
                                <input type="text" placeholder="Enter other occupation" class="form-control" x-model="form.other_occupation" :class="errors.other_occupation ? 'border-danger' : ''">
                                <p class="text-danger fw-semibold" x-text="errors.other_occupation"></p>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <label for="" class="form-label fw-semibold">15. ORGANIZATION AFFILIATED</label>
                            <div class="mb-2">
                                <label class="form-label">Organization Affiliated</label>
                                <input type="text" class="form-control" x-model="form.organization_affiliated" :class="errors.organization_affiliated ? 'border-danger' : ''">
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
                        <div class="col-md-4">
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
                            <div class="col-md-4">
                                <label class="form-label">LAST NAME</label>
                                <input type="text" class="form-control" x-model="form.fathers_lastname">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">FIRST NAME</label>
                                <input type="text" class="form-control" x-model="form.fathers_firstname">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">MIDDLE NAME</label>
                                <input type="text" class="form-control" x-model="form.fathers_middlename">
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">MOTHER'S NAME</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">LAST NAME</label>
                                <input type="text" class="form-control" x-model="form.mothers_lastname">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">FIRST NAME</label>
                                <input type="text" class="form-control" x-model="form.mothers_firstname">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">MIDDLE NAME</label>
                                <input type="text" class="form-control" x-model="form.mothers_middlename">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button class="btn btn-dark" type="submit">Update Info</button>
                    <button class="btn btn-secondary" type="button" @click="cancelUpdate">Cancel</button>
                </div>
            </form>
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
            record: {},
            updateBtn: false,
            cause_title: [],
            disability: [],
            regions: [],
            provinces: [],
            cities: [],
            barangays: [],
            occupation: [],
            employment_status: [{
                    'id': 0,
                    'label': 'EMPLOYED'
                },
                {
                    'id': 1,
                    'label': 'UNEMPLOYED'
                },
                {
                    'id': 2,
                    'label': 'SELF-EMPLOYED'
                }
            ],
            educational_attainment: [{
                    'id': 0,
                    'label': 'NONE'
                },
                {
                    'id': 1,
                    'label': 'KINDERGARTEN'
                },
                {
                    'id': 2,
                    'label': 'ELEMENTARY'
                },
                {
                    'id': 3,
                    'label': 'JUNIOR HIGH SCHOOL'
                },
                {
                    'id': 4,
                    'label': 'SENIOR HIGH SCHOOL'
                },
                {
                    'id': 5,
                    'label': 'COLLEGE'
                },
                {
                    'id': 6,
                    'label': 'VOCATIONAL'
                },
                {
                    'id': 7,
                    'label': 'POST GRADUATE'
                }
            ],
            category_of_employment: [{
                    'id': 0,
                    'label': 'GOVERNMENT'
                },
                {
                    'id': 1,
                    'label': 'PRIVATE'
                }
            ],
            nature_of_employment: [{
                    'id': 0,
                    'label': 'PERMANENT/REGULAR'
                },
                {
                    'id': 1,
                    'label': 'CASUAL'
                },
                {
                    'id': 2,
                    'label': 'SEASONAL'
                },
                {
                    'id': 3,
                    'label': 'EMERGENCY'
                }
            ],
            civil_status: [{
                    'id': 0,
                    'label': 'SINGLE'
                },
                {
                    'id': 1,
                    'label': 'MARRIED'
                },
                {
                    'id': 2,
                    'label': 'SEPARATED'
                },
                {
                    'id': 3,
                    'label': 'WIDOW/ER'
                },
                {
                    'id': 4,
                    'label': 'COHABITATION (LIVE-IN)'
                }
            ],
            cause_of: [{
                    'id': 0,
                    'label': 'Congenital/Inborn'
                },
                {
                    'id': 1,
                    'label': 'Acquired'
                }
            ],
            id: <?= $record['id'] ?>,
            file: null,

            form: {
                pwd_no: '',
                date_applied: '',
                lastname: '',
                firstname: '',
                middlename: '',
                suffix: '',
                type_of_disability: '',
                cause_of: '',
                cause_of_disability: '',
                other_cause: '',
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
                organization_affiliated: '',
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

            resetForm() {
                this.errors = {};
            },

            cancelUpdate() {
                this.updateBtn = false;
                this.fetchRecord(); // Reload original data
            },

            init() {
                this.fetchRecord();
                this.fetchOccupation();
                this.fetchDisability();
                this.fetchRegions();
            },

            async updateRecord() {
                const formData = new FormData();

                // Append all form fields
                Object.keys(this.form).forEach(key => {
                    if (this.form[key] !== null && this.form[key] !== undefined) {
                        formData.append(key, this.form[key]);
                    }
                });

                formData.append('age', this.age);
                formData.append('id', this.id);

                try {
                    const res = await fetch('/admin/update-record/<?= $record['id'] ?>', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await res.json();

                    if (data.status === 'error') {
                        this.errors = data.errors;
                        await Swal.fire('Error', 'Please check the form for errors', 'error');
                    } else {
                        this.resetForm();
                        await Swal.fire('Success', data.message, 'success');
                        this.updateBtn = false;
                        this.fetchRecord(); // Reload the updated record
                    }
                } catch (error) {
                    console.error('Update error:', error);
                    await Swal.fire('Error', 'Something went wrong!', 'error');
                }
            },

            async fetchDisability() {
                try {
                    const res = await fetch('<?= base_url('/admin/fetch-disability') ?>');
                    const data = await res.json();
                    if (data.status === 'success') {
                        this.disability = data.data;
                    }
                } catch (error) {
                    console.error(error);
                }
            },

            async causeOf() {
                if (!this.form.cause_of && this.form.cause_of !== 0) {
                    this.cause_title = [];
                    this.form.cause_of_disability = '';
                    return;
                }

                try {
                    const url = `<?= base_url('/admin/fetch-cause/') ?>${this.form.cause_of}`;
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
                    if (data.status === 'success') {
                        this.occupation = data.data;
                    }
                } catch (err) {
                    console.error(err);
                }
            },

            async fetchRegions() {
                try {
                    const res = await fetch('<?= base_url('/fetch-regions') ?>');
                    const regions = await res.json();
                    this.regions = regions.regions || [];
                } catch (error) {
                    console.error(error);
                }
            },

            async fetchProvinces() {
                if (!this.form.region) {
                    this.provinces = [];
                    return;
                }

                this.provinces = [];
                this.cities = [];
                this.barangays = [];

                try {
                    const res = await fetch(`/fetch-province/${this.form.region}`);
                    const data = await res.json();
                    this.provinces = data.provinces || [];
                } catch (error) {
                    console.error(error);
                }
            },

            async fetchCities() {
                if (!this.form.province) {
                    this.cities = [];
                    return;
                }

                this.cities = [];
                this.barangays = [];

                try {
                    const res = await fetch(`/fetch-cities/${this.form.province}`);
                    const data = await res.json();
                    this.cities = data.cities || [];
                } catch (error) {
                    console.error(error);
                }
            },

            async fetchBarangays() {
                if (!this.form.city) {
                    this.barangays = [];
                    return;
                }

                try {
                    const res = await fetch(`/fetch-barangays/${this.form.city}`);
                    const data = await res.json();
                    this.barangays = data.barangays || [];
                } catch (error) {
                    console.error(error);
                }
            },

            get age() {
                if (!this.form.birthdate) return '';

                const today = new Date();
                const birthDate = new Date(this.form.birthdate);
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age;
            },

            formatPwdNo(e) {
                let value = e.target.value.replace(/\D/g, '');
                let parts = [];

                if (value.length > 0) parts.push(value.substring(0, 2));
                if (value.length > 2) parts.push(value.substring(2, 6));
                if (value.length > 6) parts.push(value.substring(6, 9));
                if (value.length > 9) parts.push(value.substring(9, 17));

                this.form.pwd_no = parts.join('-');
            },

            async fetchRecord() {
                try {
                    const response = await fetch('/admin/fetch-records/<?= $record['id'] ?>');
                    const data = await response.json();

                    if (data.status === 'success') {
                        this.record = data.data;

                        // Populate form with existing data
                        this.form = {
                            pwd_no: data.data.pwd_no || '',
                            date_applied: data.data.date_applied || '',
                            lastname: data.data.lastname || '',
                            firstname: data.data.firstname || '',
                            middlename: data.data.middlename || '',
                            suffix: data.data.suffix || '',
                            type_of_disability: data.data.type_of_disability || '',
                            cause_of: data.data.cause_of || '',
                            cause_of_disability: data.data.cause_of_disability || '',
                            other_cause: data.data.other_cause || '',
                            region: data.data.region_code || '',
                            province: data.data.province_code || '',
                            city: data.data.city_code || '',
                            barangay: data.data.barangay || '',
                            street_name: data.data.street_name || '',
                            landline: data.data.landline || '',
                            mobile_no: data.data.mobile_no || '',
                            email: data.data.email || '',
                            birthdate: data.data.birthdate || '',
                            sex: data.data.sex || '',
                            civil_status: data.data.civil_status || '',
                            educational_attainment: data.data.educational_attainment || '',
                            employment_status: data.data.employment_status || '',
                            category_of_employment: data.data.category_of_employment || '',
                            nature_of_employment: data.data.nature_of_employment || '',
                            occupation: data.data.occupation || '',
                            other_occupation: data.data.other_occupation || '',
                            bloodtype: data.data.bloodtype || '',
                            organization_affiliated: data.data.organization_affiliated || '',
                            office_address: data.data.office_address || '',
                            contact_person: data.data.contact_person || '',
                            sss_no: data.data.sss_no || '',
                            gsis_no: data.data.gsis_no || '',
                            psn_no: data.data.psn_no || '',
                            philhealth_no: data.data.philhealth_no || '',
                            fathers_lastname: data.data.fathers_lastname || '',
                            fathers_firstname: data.data.fathers_firstname || '',
                            fathers_middlename: data.data.fathers_middlename || '',
                            mothers_lastname: data.data.mothers_lastname || '',
                            mothers_firstname: data.data.mothers_firstname || '',
                            mothers_middlename: data.data.mothers_middlename || ''
                        };

                        // Load cause options if cause_of exists
                        if (this.form.cause_of !== '') {
                            await this.causeOf();
                        }

                        // Load address dropdowns if region exists
                        if (this.form.region) {
                            await this.fetchProvinces();
                            if (this.form.province) {
                                await this.fetchCities();
                                if (this.form.city) {
                                    await this.fetchBarangays();
                                }
                            }
                        }
                    }
                } catch (error) {
                    console.error('Error fetching records:', error);
                }
            },

            previewPhoto(event) {
                const selectedFile = event.target.files[0];
                if (!selectedFile) return;

                if (!selectedFile.type.startsWith('image/')) {
                    Swal.fire('Error', 'Please select an image file.', 'error');
                    return;
                }

                this.file = selectedFile;

                // Preview the image
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.record.img = e.target.result;
                };
                reader.readAsDataURL(selectedFile);

                // Immediately upload to server
                this.uploadPhoto();
            },

            async uploadPhoto() {
                if (!this.file) return;

                const formData = new FormData();
                formData.append('img', this.file);
                formData.append('id', this.id);

                try {
                    const res = await fetch('<?= base_url("admin/upload-person-photo") ?>', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await res.json();

                    if (data.status === 'success') {
                        await Swal.fire('Success', 'Profile photo updated!', 'success');
                        this.fetchRecord();
                    } else {
                        await Swal.fire('Error', data.message || 'Upload failed!', 'error');
                    }
                } catch (err) {
                    console.error(err);
                    await Swal.fire('Error', 'Something went wrong!', 'error');
                }
            },

            formatDate(date) {
                if (!date) return 'N/A';
                return new Date(date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        }
    }
</script>
<?= $this->endSection(); ?>