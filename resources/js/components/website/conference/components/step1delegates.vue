<template>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="text-left mb-1 mt-4">
                <h1 class="h3">Delegates</h1>
                <p><span style="color: red">*</span>&nbsp;Required</p>
            </div>
            <div class="col-12" v-if="this.participantForm === false">
                <div class="row">
                    <div class="col-12">
                        <label class="form-label text-uppercase fw-bold"
                            >Business Type&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <br />
                        <input
                            type="radio"
                            class="form-check-input"
                            v-model="step1.type"
                            value="local"
                            id="typeLocal"
                            @change="$emit('change-type')"
                        />
                        <label
                            class="form-check-label mb-0 align-middle"
                            for="typeLocal"
                            >Local</label
                        >
                        <br />
                        <input
                            type="radio"
                            class="form-check-input"
                            v-model="step1.type"
                            value="foreign"
                            id="typeForeign"
                            @change="$emit('change-type')"
                        />
                        <label
                            class="form-check-label mb-0 align-middle"
                            for="typeForeign"
                            >Foreign</label
                        >
                        <br />
                        <div v-if="v.step1.type.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.step1.type.required"
                            >
                                Business Type is required.
                            </div>
                        </div>
                    </div>
                    <!-- <div
                        v-if="
                            this.step1.participant_count > 0 &&
                            this.step1.participant_count < 6
                        "
                        class="col-12 col-lg-6 mt-5"
                    >
                        <label class="form-label text-uppercase fw-bold"
                            >Promo Code</label
                        >

                        <input
                            type="text"
                            class="form-control text-uppercase"
                            v-model="promoCode"
                            maxlength="100"
                        />
                        <div v-if="promo_code_error != ''">
                            <div class="fw-light invalid-feedback d-block">
                                {{ promo_code_error }}
                            </div>
                        </div>
                        <div class="text-end mt-2">
                            <button
                                type="button"
                                class="btn btn-outline-dark btn-sm"
                                @click="$emit('promo-code')"
                            >
                                Add Promo Code
                            </button>
                        </div>
                    </div> -->
                    <div v-if="step1.participant_count > 0" class="col-12 mt-5">
                        <table class="table">
                            <thead>
                                <th>Delegates</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(participant, index) in this.step1
                                        .participants"
                                    :key="index"
                                >
                                    <td width="80%">
                                        {{ participant.fname }}&nbsp;{{
                                            participant.lname
                                        }}
                                    </td>
                                    <td width="20%">
                                        <i
                                            class="fas fa-trash text-red-500 cursor-pointer"
                                            @click="
                                                $emit(
                                                    'remove-participant',
                                                    index
                                                )
                                            "
                                        ></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="col-12 mt-5"
                        v-if="
                            this.step1.type !== '' &&
                            this.step1.participant_count < 6
                        "
                    >
                        <button
                            type="button"
                            class="btn btn-outline-dark btn-sm"
                            @click="$emit('toggle-participant', true)"
                        >
                            Add Delegate
                        </button>
                        <br />
                        <div v-if="v.step1.participant_count.$error">
                            <div class="fw-light invalid-feedback d-block">
                                At least 1 Delegate is required.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12" v-else>
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="h3">Add Delegate Details</h1>
                    </div>
                    <div class="col-6 col-lg-3 mt-3">
                        <label class="form-label text-uppercase fw-bold"
                            >Salutation&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select"
                            v-model="participant.salutation"
                            :class="{
                                'is-invalid': v.participant.salutation.$error,
                            }"
                        >
                            <option :value="''">-- Select --</option>
                            <option :value="'Mr'">Mr</option>
                            <option :value="'Ms'">Ms</option>
                            <!-- <option :value="'Dr'">Dr</option>
                                        <option :value="'Prof'">Prof</option>
                                        <option :value="'Atty'">Atty</option> -->
                        </select>
                        <div v-if="v.participant.salutation.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.salutation.required"
                            >
                                Salutation is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >First Name&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.participant.fname.$error,
                            }"
                            v-model="participant.fname"
                            maxlength="100"
                        />
                        <div v-if="v.participant.fname.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.fname.required"
                            >
                                First name is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-4">
                        <label class="form-label text-uppercase fw-bold"
                            >Last Name&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.participant.lname.$error,
                            }"
                            v-model="participant.lname"
                            maxlength="100"
                        />
                        <div v-if="v.participant.lname.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.lname.required"
                            >
                                Last name is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label class="form-label text-uppercase fw-bold"
                            >Nationality/Country&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <select
                            class="form-select"
                            v-model="participant.country"
                            :class="{
                                'is-invalid': v.participant.country.$error,
                            }"
                        >
                            <option :value="''">-- Select --</option>
                            <option
                                v-for="country in countries"
                                :key="country.id"
                                :value="country.name"
                            >
                                {{ country.name }}
                            </option>
                        </select>
                        <div v-if="v.participant.country.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.country.required"
                            >
                                Country is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label class="form-label text-uppercase fw-bold"
                            >Designation&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            :class="{
                                'is-invalid': v.participant.designation.$error,
                            }"
                            v-model="participant.designation"
                            maxlength="100"
                        />
                        <div v-if="v.participant.designation.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.designation.required"
                            >
                                Designation is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <label class="form-label text-uppercase fw-bold"
                            >Email Address&nbsp;<span style="color: red"
                                >*</span
                            ></label
                        >
                        <input
                            type="text"
                            class="form-control text-lowercase"
                            :class="{
                                'is-invalid': v.participant.email.$error,
                            }"
                            v-model="participant.email"
                            maxlength="150"
                        />
                        <div v-if="v.participant.email.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.email.required"
                            >
                                Email address is required.
                            </div>
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.email.email"
                            >
                                Invalid email address format.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mt-3">
                        <div class="row g-2">
                            <div class="col-5">
                                <label
                                    for="country_code_mobile"
                                    class="form-label text-uppercase fw-bold"
                                    >Mobile Number*</label
                                >
                                <select
                                    class="form-select"
                                    id="country_code_mobile"
                                    v-model="participant.country_code_mobile"
                                    :class="{
                                        'is-invalid':
                                            v.participant.country_code_mobile
                                                .$error,
                                    }"
                                >
                                    <option :value="''">Country code</option>
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
                                        v.participant.country_code_mobile.$error
                                    "
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !v.participant.country_code_mobile
                                                .required
                                        "
                                    >
                                        Country code is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <label for="mobile_no" class="form-label"
                                    >&nbsp;</label
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    placeholder="Mobile number"
                                    id="mobile_no"
                                    v-model="participant.mobile_no"
                                    :class="{
                                        'is-invalid':
                                            v.participant.mobile_no.$error,
                                    }"
                                    pattern="[0-9\-]+"
                                />
                                <div v-if="v.participant.mobile_no.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!v.participant.mobile_no.required"
                                    >
                                        Mobile no. is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="row g-2">
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Delegate type:&nbsp;<span
                                        style="color: red"
                                        >*</span
                                    ></label
                                >
                                <br />
                                <input
                                    type="radio"
                                    class="form-check-input"
                                    v-model="participant.addtnl_type"
                                    value="Private"
                                    id="typePrivate"
                                />
                                <label
                                    class="form-check-label mb-0 align-middle"
                                    for="typePrivate"
                                    >Private</label
                                >
                                <br />
                                <input
                                    type="radio"
                                    class="form-check-input"
                                    v-model="participant.addtnl_type"
                                    value="Government"
                                    id="typeGov"
                                />
                                <label
                                    class="form-check-label mb-0 align-middle"
                                    for="typeGov"
                                    >Government</label
                                >
                                <br />
                                <input
                                    type="radio"
                                    class="form-check-input"
                                    v-model="participant.addtnl_type"
                                    value="AcademeStudent"
                                    id="typeAcad"
                                />
                                <label
                                    class="form-check-label mb-0 align-middle"
                                    for="typeAcad"
                                    >Academe/ Student</label
                                >
                                <br />
                                <div v-if="v.participant.addtnl_type.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !v.participant.addtnl_type.required
                                        "
                                    >
                                        Delegate Type is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-3">
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="senior_check"
                                        value="yes"
                                        v-model="participant.senior"
                                    />
                                    <label
                                        class="form-check-label align-middle"
                                        for="senior_check"
                                        >Senior Citizen</label
                                    >
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="pwd_check"
                                        value="yes"
                                        v-model="participant.pwd"
                                    />
                                    <label
                                        class="form-check-label align-middle"
                                        for="pwd_check"
                                        >Person with Disability</label
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="row g-2">
                            <div class="col-12">
                                <label
                                    class="form-label text-uppercase fw-bold"
                                >
                                    Delegate Category:&nbsp;<span
                                        style="color: red"
                                        >*</span
                                    >
                                </label>
                                <br />

                                <input
                                    type="radio"
                                    class="form-check-input"
                                    v-model="participant.delegate_category"
                                    :value="1"
                                    id="categoryDecisionMaker"
                                />
                                <label
                                    class="form-check-label mb-0 align-middle"
                                    for="categoryDecisionMaker"
                                >
                                    Decision-maker
                                </label>
                                <br />

                                <input
                                    type="radio"
                                    class="form-check-input"
                                    v-model="participant.delegate_category"
                                    :value="2"
                                    id="categoryRecommendingOfficer"
                                />
                                <label
                                    class="form-check-label mb-0 align-middle"
                                    for="categoryRecommendingOfficer"
                                >
                                    Recommending Officer
                                </label>
                                <br />

                                <input
                                    type="radio"
                                    class="form-check-input"
                                    v-model="participant.delegate_category"
                                    :value="3"
                                    id="categoryTechnicalRepresentative"
                                />
                                <label
                                    class="form-check-label mb-0 align-middle"
                                    for="categoryTechnicalRepresentative"
                                >
                                    Technical Representative
                                </label>
                                <br />

                                <div
                                    class="mt-2"
                                    v-if="participant.delegate_category == 99"
                                >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="
                                            participant.delegate_category_other
                                        "
                                        :class="{
                                            'is-invalid':
                                                v.participant
                                                    .delegate_category_other
                                                    .$error,
                                        }"
                                        placeholder="Please specify"
                                        maxlength="255"
                                    />

                                    <div
                                        v-if="
                                            v.participant
                                                .delegate_category_other.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !v.participant
                                                    .delegate_category_other
                                                    .required
                                            "
                                        >
                                            Please specify the delegate
                                            category.
                                        </div>
                                    </div>
                                </div>

                                <div
                                    v-if="
                                        v.participant.delegate_category.$error
                                    "
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !v.participant.delegate_category
                                                .required
                                        "
                                    >
                                        Delegate Category is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3" v-if="this.isIDRequired">
                        <label class="form-label text-uppercase fw-bold"
                            >Proof of Identification (Government, Student,
                            Senior Citizen, or PWD):&nbsp;<span
                                style="color: red"
                                >*</span
                            ></label
                        >
                        <VueFileAgent
                            ref="vueFileAgent1"
                            :multiple="false"
                            :deletable="true"
                            :linkable="true"
                            :meta="true"
                            :accept="'image/*,.pdf'"
                            :maxSize="'1MB'"
                            :maxFiles="1"
                            :theme="'list'"
                            v-model="participant.id_file"
                            @beforedelete="$emit('before-file-delete', $event)"
                            @select="$emit('file-select', $event)"
                        ></VueFileAgent>
                        <div id="emailHelp" class="form-text">
                            Max size of 1MB and accept image and pdf document
                            only.
                        </div>
                        <div v-if="v.participant.id_file.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!v.participant.id_file.required"
                            >
                                Please upload a valid proof of identification
                                (Government ID, Student ID, Senior Citizen ID,
                                or PWD ID).
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5 text-end">
                        <button
                            type="button"
                            class="btn btn-outline-dark btn-sm"
                            @click="$emit('submit-participant')"
                        >
                            Submit
                        </button>
                        &nbsp;
                        <button
                            type="button"
                            class="btn btn-outline-dark btn-sm"
                            @click="$emit('toggle-participant', false)"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="this.step1.type != ''" class="col-4 mt-4">
            <div class="row">
                <div class="col-12 text-end">
                    <span style="font-weight: bold; font-size: 18px">
                        {{ this.currency }}&nbsp;{{ formattedAmount }}
                    </span>
                </div>
                <div
                    v-if="this.step1.participant_count > 0"
                    class="col-12 text-end"
                >
                    <small
                        >{{ this.step1.participant_count }} x Delegates</small
                    >
                </div>
                <div v-if="this.discounts.length > 0" class="col-12 text-end">
                    <div
                        v-for="(discount, index) in discounts"
                        :key="index"
                        class="w-100"
                    >
                        <small>
                            {{ discount.count }} x {{ discount.desc }}
                        </small>
                    </div>
                </div>

                <div class="col-12 text-end">
                    <div class="mt-1">
                        <small class="text-muted">
                            Participation fees for
                            <span
                                class="text-decoration-underline"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Subject to qualification, evaluation, and approval of CITEM"
                                style="cursor: help"
                            >
                                eligible delegates
                            </span>
                            are fully subsidized.
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-5"></div>
    </div>
</template>

<script>
import { computed } from "vue";

export default {
    name: "Step1Delegates",

    props: {
        step1: {
            type: Object,
            required: true,
        },
        participant: {
            type: Object,
            required: true,
        },
        countries: {
            type: Array,
            default: () => [],
        },
        discounts: {
            type: Array,
            default: () => [],
        },
        currency: {
            type: String,
            default: "",
        },
        formattedAmount: {
            type: String,
            default: "",
        },
        promo_code_temp: {
            type: String,
            default: "",
        },
        promo_code_error: {
            type: String,
            default: "",
        },
        participantForm: {
            type: Boolean,
            default: false,
        },
        isIDRequired: {
            type: Boolean,
            default: false,
        },
        v: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        this.initTooltips();
    },

    updated() {
        this.initTooltips();
    },

    methods: {
        initTooltips() {
            const tooltipTriggerList = [].slice.call(
                document.querySelectorAll('[data-bs-toggle="tooltip"]')
            );

            tooltipTriggerList.forEach((el) => {
                if (!bootstrap.Tooltip.getInstance(el)) {
                    new bootstrap.Tooltip(el);
                }
            });
        },
    },
    computed: {
        promoCode: {
            get() {
                return this.promo_code_temp;
            },
            set(value) {
                this.$emit("update:promo_code_temp", value);
                this.$emit("promo-change");
            },
        },
    },
};
</script>
