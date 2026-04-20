function ManageRecordPage() {
        return {
            errors: {},
            record: [],
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
                    'label': 'Employed'
                },
                {
                    'id': 1,
                    'label': 'Employed'
                },
                {
                    'id': 2,
                    'label': 'Self-Emlpoyed'
                },
            ],


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

            resetForm() {
                this.errors = {};
            },

            init() {
                this.fetchRecord();
                this.fetchOccupation();
                this.fetchDisability();
                this.fetchRegions();
            },

            async updateRecord() {
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

                const res = await fetch('/admin/update-record/', {
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

            async fetchRecord() {
                try {
                    const response = await fetch('/admin/fetch-records/<?= $record['id'] ?>');
                    const data = await response.json();

                    if (data.status === 'error') {
                        console.error(data.errors);
                        return;
                    }

                    this.record = data.data;
                    this.form = {
                        ...data.data
                    }; // populate form with existing data
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