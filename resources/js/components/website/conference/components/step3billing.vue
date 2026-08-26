<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-left mb-1 mt-4">
                <h1 class="h3">Billing Information</h1>
                <p><span style="color: red">*</span>&nbsp;Required</p>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >Company Name&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.step3.company_name.$error,
                            }"
                            v-model="step3.company_name"
                            maxlength="150"
                        />
                        <div v-if="v.step3.company_name.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.company_name.required"
                            >
                                Company Name is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >Company Address&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <textarea
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.step3.company_address.$error,
                            }"
                            v-model="step3.company_address"
                            @input="
                                step3.company_address =
                                    step3.company_address.slice(0, 200)
                            "
                            rows="4"
                        ></textarea>
                        <div v-if="v.step3.company_address.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.company_address.required"
                            >
                                Company Address is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >Business TIN Number&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-uppercase"
                            :class="{ 'is-invalid': v.step3.tin.$error }"
                            v-model="step3.tin"
                            maxlength="150"
                            @input="
                                step3.tin = step3.tin.replace(/[^0-9-]/g, '')
                            "
                        />
                        <div v-if="v.step3.tin.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.tin.required"
                            >
                                Business TIN number is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold">
                            Salutation&nbsp;
                            <span style="color: red">*</span>
                        </label>

                        <select
                            class="form-control"
                            :class="{
                                'is-invalid':
                                    v.step3.contact_person_salutation.$error,
                            }"
                            v-model="step3.contact_person_salutation"
                        >
                            <option value="" disabled>Select Salutation</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                        </select>

                        <div v-if="v.step3.contact_person_salutation.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="
                                    !v.step3.contact_person_salutation.required
                                "
                            >
                                Salutation is required.
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold">
                            Contact Person&nbsp;
                            <span style="color: red">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.step3.contact_person.$error,
                            }"
                            v-model="step3.contact_person"
                            maxlength="200"
                        />

                        <div v-if="v.step3.contact_person.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.contact_person.required"
                            >
                                Contact Person is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >Company Email Address&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-lowercase"
                            :class="{
                                'is-invalid': v.step3.company_email.$error,
                            }"
                            v-model="step3.company_email"
                            maxlength="200"
                        />
                        <div v-if="v.step3.company_email.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.company_email.required"
                            >
                                Company Email is required.
                            </div>
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.company_email.email"
                            >
                                Invalid email address format.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >Contact Number&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.step3.contact_number.$error,
                            }"
                            v-model="step3.contact_number"
                            maxlength="15"
                            @input="
                                step3.contact_number =
                                    step3.contact_number.replace(/[^0-9-]/g, '')
                            "
                        />
                        <div v-if="v.step3.contact_number.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step3.contact_number.required"
                            >
                                Contact Number is required.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3" style="font-size: 10px">
            <p>
                CITEM respects your right to privacy and is committed to protect
                the confidentiality of your personal information. CITEM is bound
                to comply with the Data Privacy Act of 2012 (RA 10173), its
                Implementing Rules and Regulations (IRR), and relevant issuances
                of the National Privacy Commission (NPC).
            </p>
            <p>
                By filling out this form, you are consenting to our collection
                and use of your information in accordance with this Privacy
                Notice.
            </p>
        </div>

        <div class="mb-5"></div>
    </div>
</template>

<script>
export default {
    name: "Step3Billing",
    props: {
        step3: {
            type: Object,
            required: true,
        },
        v: {
            type: Object,
            required: true,
        },
    },
};
</script>
