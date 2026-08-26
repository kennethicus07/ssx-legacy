<template>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="text-left mb-1 mt-4">
                <h1 class="h3">Preferences / Promotion</h1>
                <p><span style="color: red">*</span>&nbsp;Required</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-12 mt-5">
                    <h4>Preferences</h4>
                </div>
                <!-- <div class="col-12 mt-2">
                                <label class="form-label text-uppercase fw-bold">Do you have any dietary restrictions we need to consider?&nbsp;<span style="color: red;">*</span></label>
                                <br>

                                <input type="radio" class="form-check-input" v-model="step2.dietary" value="yes" id="dietaryYes">
                                <label class="form-check-label mb-0 align-middle" for="dietaryYes">Yes</label>
                                <br>
                                <input type="radio" class="form-check-input" v-model="step2.dietary" value="No" id="dietaryNo">
                                <label class="form-check-label mb-0 align-middle" for="dietaryNo">No</label>
                                <br>
                                <div v-if="v.step2.dietary.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!v.step2.dietary.required">Dietary Restrictions is required.</div>
                                </div>
                                <br>
                                <input v-if="this.step2.dietary === 'yes'" type="text" class="form-control text-capitalize" :class="{ 'is-invalid': v.step2.dietary_details.$error }" v-model="step2.dietary_details" maxlength="100">
                                <div v-if="this.step2.dietary === 'yes' && v.step2.dietary_details.$error">
                                    <div class="fw-light invalid-feedback d-block" v-if="!v.step2.dietary_details.required">Dietary Restrictions is required.</div>
                                </div>
                            </div> -->
                <div class="col-12 mt-2">
                    <label class="form-label text-uppercase fw-bold"
                        >Preferred certificate&nbsp;<span style="color: red"
                            >*</span
                        ></label
                    >
                    <br />
                    <input
                        type="radio"
                        class="form-check-input"
                        v-model="step2.certificate"
                        value="digital"
                        id="certificateDigital"
                    />
                    <label
                        class="form-check-label mb-0 align-middle"
                        for="certificateDigital"
                        >Digital copy</label
                    >
                    <br />
                    <input
                        type="radio"
                        class="form-check-input"
                        v-model="step2.certificate"
                        value="physical"
                        id="certificatePhysical"
                    />
                    <label
                        class="form-check-label mb-0 align-middle"
                        for="certificatePhysical"
                        >Physical Copy</label
                    >
                    <br />
                    <div v-if="v.step2.certificate.$error">
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="!v.step2.certificate.required"
                        >
                            Preferred certificate is required.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-12 mt-5">
                    <h4>Promotion</h4>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label text-uppercase fw-bold"
                        >How did you know about the conference?&nbsp;<span
                            style="color: red"
                            >*</span
                        ></label
                    >
                    <br />
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="knowHow_email"
                            value="Email Invitation"
                            v-model="step2.knowHow"
                        />
                        <label
                            class="form-check-label align-middle"
                            for="knowHow_email"
                            >By email invitation</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="knowHow_online"
                            value="Online Search"
                            v-model="step2.knowHow"
                        />
                        <label
                            class="form-check-label align-middle"
                            for="knowHow_online"
                            >Online Search</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="knowHow_social"
                            value="Social Media"
                            v-model="step2.knowHow"
                        />
                        <label
                            class="form-check-label align-middle"
                            for="knowHow_social"
                            >Social Media</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="knowHow_affiliation"
                            value="Affiliation/ Friend"
                            v-model="step2.knowHow"
                        />
                        <label
                            class="form-check-label align-middle"
                            for="knowHow_affiliation"
                            >Through affiliation/ friend</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="knowHow_other"
                            value="Other"
                            v-model="step2.knowHow"
                        />
                        <label
                            class="form-check-label align-middle"
                            for="knowHow_other"
                            >Other</label
                        >
                        <div
                            class="mt-2"
                            v-if="step2.knowHow.includes('Other')"
                        >
                            <input
                                type="text"
                                class="form-control"
                                v-model="step2.knowHow_other"
                                :class="{
                                    'is-invalid': v.step2.knowHow_other.$error,
                                }"
                                placeholder="Please specify"
                                maxlength="255"
                            />

                            <div v-if="v.step2.knowHow_other.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!v.step2.knowHow_other.required"
                                >
                                    Please specify.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="v.step2.knowHow.$error">
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="!v.step2.knowHow.required"
                        >
                            At least one selection is required.
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <label class="form-label text-uppercase fw-bold"
                        >Do you prefer to receive promotional/ communication
                        related to the event via email?&nbsp;<span
                            style="color: red"
                            >*</span
                        ></label
                    >
                    <br />
                    <input
                        type="radio"
                        class="form-check-input"
                        v-model="step2.promotional_email"
                        value="Yes"
                        id="promotionalYes"
                    />
                    <label
                        class="form-check-label mb-0 align-middle"
                        for="promotionalYes"
                        >Yes</label
                    >
                    <br />
                    <input
                        type="radio"
                        class="form-check-input"
                        v-model="step2.promotional_email"
                        value="No"
                        id="promotionalNo"
                    />
                    <label
                        class="form-check-label mb-0 align-middle"
                        for="promotionalNo"
                        >No</label
                    >
                    <br />
                    <div v-if="v.step2.promotional_email.$error">
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="!v.step2.promotional_email.required"
                        >
                            Required field.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5"></div>
    </div>
</template>
<script>
export default {
    name: "Step2Preferences",

    props: {
        step2: {
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
