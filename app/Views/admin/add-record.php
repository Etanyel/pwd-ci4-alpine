<?= $this->extend('Layout/layout'); ?>

<?= $this->section('tab-title'); ?>Add Record | Admin<?= $this->endSection(); ?>

<?= $this->section('nav-title'); ?>Add Record<?= $this->endSection(); ?>

<?= $this->section('add-record-active'); ?>bg-secondary<?= $this->endSection(); ?>

<!-- Content page -->
<?= $this->section('content'); ?>
<div class="" x-data="addRecordApp()">
    <div class="container-fluid card shadow-sm p-3 bg-white bg-gradient border-0 mt-4">
        <form>
            <!-- PWD NUMBER -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label fw-semibold">1. PWD NUMBER</label>
                        <input type="text" class="form-control" placeholder="(RR-PPMM-BB-NNNNNNNN)">
                        <p></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">2. DATE APPLIED</label>
                        <input type="date" class="form-control">
                        <p></p>
                    </div>
                </div>
            </div>

            <!-- PERSONAL INFO -->
            <div class="mb-3">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label fw-semibold">3. LAST NAME</label>
                        <input type="text" class="form-control" placeholder="eg. DELA CRUZ">
                        <p></p>
                    </div>
                    <div class="col-4">
                        <label class="form-label fw-semibold">FIRST NAME</label>
                        <input type="text" class="form-control" placeholder="eg. JUAN">
                        <p></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">MIDDLE NAME <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                        <input type="text" class="form-control" placeholder="eg. D." maxlength="2">
                        <p></p>
                    </div>
                    <div class="col-2">
                        <label class="form-label fw-semibold">SUFFIX <span class="text-muted" style="font-size: 13px;">(optional)</span></label>
                        <input type="text" class="form-control" placeholder="eg. D." maxlength="2">
                        <p></p>
                    </div>
                </div>
            </div>

            <!-- TYPE OF DISABILITY/CAUSE OF DISABILITY -->
            <div class="mb-2">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label fw-semibold">4. TYPE OF DISABILITY</label>
                        <select class="form-select" x-model="form.typeDisability">
                            <template x-for="item in disability" :key="item.id">
                                <option :value="item.id"><span x-text="item.disability"></span></option>
                            </template>
                        </select>
                        <p></p>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">5. CAUSE OF DISABILITY</label>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-select"
                                    x-model="form.causeOfDisability"
                                    @change="causeOf()">
                                    <option value="">Select Type</option>
                                    <option value="2">Congenital/Inborn</option>
                                    <option value="1">Acquired</option>
                                </select>
                            </div>

                            <template x-if="cause_title.length">
                                <div class="col-6">
                                    <select class="form-select" x-model="form.cause">
                                        <option value="">Select cause</option>
                                        <template x-for="title in cause_title" :key="title.id">
                                            <option :value="title.id" x-text="title.title"></option>
                                        </template>
                                    </select>
                                </div>
                            </template>
                        </div>
                        <p></p>
                    </div>
                </div>
            </div>

            <!-- ADDRESS -->
            <div class="mb-2">
                <label class="form-label fw-semibold">6. ADDRESS <span style="font-size: smaller;" class="text-muted">(Choose Region first)</span></label>
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
                    </div>

                    <!-- PROVINCE -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">PROVINCE</label>
                        <select class="form-select" x-model="form.province" @change="fetchCities">
                            <option value="">Select Province</option>
                            <template x-for="p in provinces" :key="p.code">
                                <option :value="p.code" x-text="p.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- CITY -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">CITY/MUNICIPALITY</label>
                        <select class="form-select" x-model="form.city" @change="fetchBarangays">
                            <option value="">Select City</option>
                            <template x-for="c in cities" :key="c.code">
                                <option :value="c.code" x-text="c.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- BARANGAY -->
                    <div class="col-3">
                        <label for="" class="form-label fw-semibold">BARANGAY</label>
                        <select class="form-select" x-model="form.barangay">
                            <option value="">Select Barangay</option>
                            <template x-for="b in barangays" :key="b.code">
                                <option :value="b.code" x-text="b.name"></option>
                            </template>
                        </select>
                    </div>
                </div>
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

            form: {
                typeDisability: '',
                causeOfDisability: '',
                cause: '',
                region: '',
                province: '',
                city: '',
                barangay: '',
            },

            init() {
                this.fetchDisability();
                this.fetchRegions();
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


            async fetchRegions() {
                const res = await fetch('<?= base_url('/fetch-regions') ?>');
                const regions = await res.json();
                this.regions = regions.regions;
                console.log(regions);
            },

            async fetchProvinces() {
                this.provinces = [];
                this.cities = [];
                this.barangays = [];

                const res = await fetch(`/fetch-province/${this.form.region}`);
                const data = await res.json();

                console.log(data.provinces);
                this.provinces = data.provinces;
            },

            async fetchCities() {
                this.cities = [];
                this.barangays = [];

                const res = await fetch(`/fetch-cities/${this.form.province}`);
                const data = await res.json();

                console.log(data.cities);
                this.cities = data.cities;
            },

            async fetchBarangays() {
                const res = await fetch(`/fetch-barangays/${this.form.city}`);
                const data = await res.json();

                console.log(data.barangays);
                this.barangays = data.barangays;
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