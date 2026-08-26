<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="tab-pane active" id="contact_info" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-12">
                                <h4>Business Owner</h4>
                            </div>
                            <div class="col-5">
                                <label class="form-label text-uppercase fw-bold"
                                    >First Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid': validation.fname.$error,
                                    }"
                                    v-limit="{ max: 95 }"
                                    v-model="contact_info.fname"
                                    :disabled="status !== 0"
                                />
                                <div v-if="validation.fname.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.fname.required"
                                    >
                                        First name is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label text-uppercase fw-bold"
                                    >Last Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid': validation.lname.$error,
                                    }"
                                    v-limit="{ max: 95 }"
                                    v-model="contact_info.lname"
                                    :disabled="status !== 0"
                                />
                                <div v-if="validation.lname.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.lname.required"
                                    >
                                        Last name is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label text-uppercase fw-bold"
                                    >M.I.</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-uppercase"
                                    v-limit="{ max: 4 }"
                                    v-model="contact_info.mi"
                                    :disabled="status !== 0"
                                />
                                <div v-if="validation.mi.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.mi.required"
                                    >
                                        Middle initial is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Designation*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid':
                                            validation.designation.$error,
                                    }"
                                    v-limit="{ max: 95 }"
                                    v-model="contact_info.designation"
                                    :disabled="status !== 0"
                                />
                                <div v-if="validation.designation.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.designation.required"
                                    >
                                        Designation is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Email Address*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    :class="{
                                        'is-invalid': validation.email.$error,
                                    }"
                                    v-model="contact_info.email"
                                    v-limit="{ max: 145 }"
                                    :disabled="status !== 0"
                                />
                                <div v-if="validation.email.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.email.required"
                                    >
                                        Email address is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.email.email"
                                    >
                                        Invalid email address format.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Country Code*</label
                                >
                                <select
                                    class="form-select"
                                    v-model="
                                        contact_info.country_code_mobile_bo
                                    "
                                    :class="{
                                        'is-invalid':
                                            validation.country_code_mobile_bo
                                                .$error,
                                    }"
                                    :disabled="status !== 0"
                                >
                                    <option selected value="">
                                        -- Select --
                                    </option>
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :value="country.dial"
                                    >
                                        {{ country.iso3 }} ({{ country.dial }})
                                    </option>
                                </select>
                                <div
                                    v-if="
                                        validation.country_code_mobile_bo.$error
                                    "
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !validation.country_code_mobile_bo
                                                .required
                                        "
                                    >
                                        Country code is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Mobile No.*</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_info.mobile_no_bo"
                                    :class="{
                                        'is-invalid':
                                            validation.mobile_no_bo.$error,
                                    }"
                                    v-limit="{ max: 12, numeric: true }"
                                    :disabled="status !== 0"
                                    placeholder="Enter a number"
                                />
                                <div v-if="validation.mobile_no_bo.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.mobile_no_bo.required"
                                    >
                                        Mobile no. is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-12">
                                <h4>Business Contact Person</h4>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :value="1"
                                        v-model="contact_info.same_as_bo"
                                        id="same_as_bo"
                                        :disabled="status !== 0"
                                        @change="doSameAsBo"
                                    />
                                    <label
                                        class="form-check-label text-uppercase fw-bold align-middle"
                                        for="same_as_bo"
                                    >
                                        Same as Business Owner
                                    </label>
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label text-uppercase fw-bold"
                                    >First Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid':
                                            validation.bcp_fname.$error,
                                    }"
                                    v-model="contact_info.bcp_fname"
                                    v-limit="{ max: 95 }"
                                    :disabled="disabled_bcp || status !== 0"
                                />
                                <div v-if="validation.bcp_fname.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.bcp_fname.required"
                                    >
                                        First name is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label text-uppercase fw-bold"
                                    >Last Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid':
                                            validation.bcp_lname.$error,
                                    }"
                                    v-model="contact_info.bcp_lname"
                                    v-limit="{ max: 95 }"
                                    :disabled="disabled_bcp || status !== 0"
                                />
                                <div v-if="validation.bcp_lname.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.bcp_lname.required"
                                    >
                                        Last name is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label text-uppercase fw-bold"
                                    >M.I.</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-uppercase"
                                    v-model="contact_info.bcp_mi"
                                    v-limit="{ max: 4 }"
                                    :disabled="disabled_bcp || status !== 0"
                                />
                                <div v-if="validation.bcp_mi.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.bcp_mi.required"
                                    >
                                        Middle initial is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Designation*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid':
                                            validation.bcp_designation.$error,
                                    }"
                                    v-model="contact_info.bcp_designation"
                                    v-limit="{ max: 95 }"
                                    :disabled="disabled_bcp || status !== 0"
                                />
                                <div v-if="validation.bcp_designation.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !validation.bcp_designation.required
                                        "
                                    >
                                        Designation is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Email Address*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    :class="{
                                        'is-invalid':
                                            validation.bcp_email.$error,
                                    }"
                                    v-model="contact_info.bcp_email"
                                    v-limit="{ max: 145 }"
                                    :disabled="disabled_bcp || status !== 0"
                                />
                                <div v-if="validation.bcp_email.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.bcp_email.required"
                                    >
                                        Email address is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.bcp_email.email"
                                    >
                                        Invalid email address format.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Country Code*</label
                                >
                                <select
                                    class="form-select"
                                    v-model="contact_info.bcp_country_code"
                                    :class="{
                                        'is-invalid':
                                            validation.bcp_country_code.$error,
                                    }"
                                    :disabled="disabled_bcp || status !== 0"
                                >
                                    <option selected value="">
                                        -- Select --
                                    </option>
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :value="country.dial"
                                    >
                                        {{ country.iso3 }} ({{ country.dial }})
                                    </option>
                                </select>
                                <div v-if="validation.bcp_country_code.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !validation.bcp_country_code
                                                .required
                                        "
                                    >
                                        Country code is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Mobile No.*</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_info.bcp_mobile_no"
                                    :class="{
                                        'is-invalid':
                                            validation.bcp_mobile_no.$error,
                                    }"
                                    v-limit="{ max: 12, numeric: true }"
                                    :disabled="disabled_bcp || status !== 0"
                                    placeholder="Enter a number"
                                />
                                <div v-if="validation.bcp_mobile_no.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !validation.bcp_mobile_no.required
                                        "
                                    >
                                        Mobile no. is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "ContactInfoCard",
    props: {
        contact_info: { type: Object, required: true },
        countries: { type: Array, default: () => [] },
        disabled_bcp: {
            type: Boolean,
            default: false,
        },
        validation: { type: Object, required: true },
        status: {
            type: Number,
            default: 0,
        },
    },
    emits: ["same-as-bo-changed"],

    methods: {
        doSameAsBo(e) {
            const isChecked = e.target.checked;
            this.$emit("same-as-bo-changed", isChecked);
            if (isChecked) {
                this.contact_info.bcp_fname = this.contact_info.fname;
                this.contact_info.bcp_lname = this.contact_info.lname;
                this.contact_info.bcp_mi = this.contact_info.mi;
                this.contact_info.bcp_designation =
                    this.contact_info.designation;
                this.contact_info.bcp_email = this.contact_info.email;
                this.contact_info.bcp_country_code =
                    this.contact_info.country_code_mobile_bo;
                this.contact_info.bcp_mobile_no =
                    this.contact_info.mobile_no_bo;
            } else {
                this.contact_info.bcp_fname = "";
                this.contact_info.bcp_lname = "";
                this.contact_info.bcp_mi = "";
                this.contact_info.bcp_designation = "";
                this.contact_info.bcp_email = "";
                this.contact_info.bcp_country_code = "";
                this.contact_info.bcp_mobile_no = "";
            }
        },
    },
};
</script>
