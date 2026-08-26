<template>
    <div class="container-sm registration-form">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <transition
            name="animate-loading-transition"
            enter-active-class="animate__animated animate__backInUp"
            leave-active-class="animate__animated animate__backOutDown"
        >
            <div v-if="isShowThankYou">
                <div class="text-center mb-4 mt-4">
                    <h1 class="h3 mb-3 font-weight-normal">Email Validation</h1>
                    <p>
                        We have sent you an email which includes a verification
                        link.
                    </p>
                    <p>
                        Please click the link to complete the registration.
                        <br />Please check your spam folder if you could not
                        find the email in your inbox folder.
                    </p>
                </div>
            </div>
            <div v-else>
                <div class="row justify-content-center">
                    <div class="col-10 col-md-7">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3 font-weight-normal">
                                Email Validation
                            </h1>
                            <p>*Required</p>
                        </div>
                        <div class="form-label-group mb-3">
                            <label
                                for="company_name"
                                class="form-label text-uppercase fw-bold"
                            >
                                Registered Business Name*
                            </label>
                            <input
                                type="text"
                                id="company_name"
                                v-model="company_name"
                                @blur="doCheckBusinessName"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.company_name.$error ||
                                        company_name_error,
                                }"
                                maxlength="150"
                                placeholder="Your complete company name"
                                autofocus
                            />
                            <transition
                                enter-active-class="animate__animated animate__slideInUp"
                                leave-active-class="animate__animated animate__fadeOut"
                            >
                                <div
                                    v-if="
                                        $v.company_name.$error ||
                                        company_name_error
                                    "
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.company_name.required"
                                    >
                                        Registered company name is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="company_name_error"
                                    >
                                        Company name is already used.
                                    </div>
                                </div>
                            </transition>
                            <div
                                v-if="company_name_error_pending"
                                class="text-info mt-1"
                            >
                                <span
                                    class="spinner-border spinner-border-sm"
                                    role="status"
                                    aria-hidden="true"
                                ></span>
                                <span class="fs-12">
                                    Checking company name. Please wait...
                                </span>
                            </div>
                        </div>

                        <div class="form-label-group mb-3">
                            <label
                                for="company_email"
                                class="form-label text-uppercase fw-bold"
                                >Company Email Address*</label
                            >
                            <input
                                type="email"
                                id="company_email"
                                v-model="company_email"
                                class="form-control text-lowercase"
                                :class="isEmailInvalid"
                                placeholder="emailaddress@domain.com"
                                @blur="doCheckEmail"
                                maxlength="200"
                            />
                            <transition
                                enter-active-class="animate__animated animate__slideInUp"
                                leave-active-class="animate__animated animate__fadeOut"
                            >
                                <div
                                    v-if="
                                        $v.company_email.$pending ||
                                        company_email_error_pending
                                    "
                                    class="text-info mt-1"
                                >
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="fs-12"
                                        >Checking company's e-mail address.
                                        Please wait...</span
                                    >
                                </div>
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="company_email_error"
                                >
                                    Company email is already used.
                                </div>
                                <div v-if="$v.company_email.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.company_email.required"
                                    >
                                        Company email is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.company_email.email"
                                    >
                                        Company email is invalid format.
                                    </div>
                                </div>
                            </transition>
                        </div>
                        <div class="form-label-group mb-3">
                            <div class="mb-3">
                                <label
                                    for="password"
                                    class="form-label text-uppercase fw-bold"
                                >
                                    Password*
                                </label>
                                <div class="position-relative">
                                    <input
                                        :type="
                                            showPassword ? 'text' : 'password'
                                        "
                                        id="password"
                                        v-model="password"
                                        class="form-control pe-5"
                                        :class="{
                                            'is-invalid': $v.password.$error,
                                        }"
                                        maxlength="100"
                                        placeholder="Enter password"
                                    />
                                    <i
                                        :class="
                                            showPassword
                                                ? 'fas fa-eye-slash'
                                                : 'fas fa-eye'
                                        "
                                        class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                                        style="cursor: pointer"
                                        @click="showPassword = !showPassword"
                                    ></i>
                                </div>
                            </div>

                            <transition
                                enter-active-class="animate__animated animate__slideInUp"
                                leave-active-class="animate__animated animate__fadeOut"
                            >
                                <div v-if="$v.password.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.password.required"
                                    >
                                        Password is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.password.minLength"
                                    >
                                        Password must be at least 8 characters.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.password.hasUppercase"
                                    >
                                        Must contain at least 1 uppercase
                                        letter.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.password.hasLowercase"
                                    >
                                        Must contain at least 1 lowercase
                                        letter.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.password.hasNumber"
                                    >
                                        Must contain at least 1 number.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.password.hasSpecialChar"
                                    >
                                        Must contain at least 1 special
                                        character.
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <div class="form-label-group mb-3">
                            <div
                                class="form-label-group mb-3 position-relative"
                            >
                                <label
                                    for="password_confirmation"
                                    class="form-label text-uppercase fw-bold"
                                >
                                    Confirm Password*
                                </label>
                                <div class="position-relative">
                                    <input
                                        :type="
                                            showConfirmPassword
                                                ? 'text'
                                                : 'password'
                                        "
                                        id="password_confirmation"
                                        v-model="password_confirmation"
                                        class="form-control pe-5"
                                        :class="{
                                            'is-invalid':
                                                $v.password_confirmation.$error,
                                        }"
                                        maxlength="100"
                                        placeholder="Confirm password"
                                    />
                                    <i
                                        :class="
                                            showConfirmPassword
                                                ? 'fas fa-eye-slash'
                                                : 'fas fa-eye'
                                        "
                                        class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                                        style="cursor: pointer"
                                        @click="
                                            showConfirmPassword =
                                                !showConfirmPassword
                                        "
                                    ></i>
                                </div>
                            </div>

                            <transition
                                enter-active-class="animate__animated animate__slideInUp"
                                leave-active-class="animate__animated animate__fadeOut"
                            >
                                <div v-if="$v.password_confirmation.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.password_confirmation
                                                .sameAsPassword
                                        "
                                    >
                                        Passwords do not match.
                                    </div>
                                </div>
                            </transition>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto mt-4">
                            <div class="link-border">
                                <a
                                    @click="doValidate"
                                    role="button"
                                    class="lightgreen_btn text-center"
                                    :disabled="$v.$pending"
                                    >SEND VALIDATION EMAIL</a
                                >
                            </div>
                        </div>
                        <div class="row justify-content-center pb-5">
                            <div class="col-12 text-center">
                                <div class="form-check form-check-inline mb-3">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        :value="1"
                                        v-model="agree_terms"
                                        :class="{
                                            'is-invalid': $v.agree_terms.$error,
                                        }"
                                        id="agree"
                                        @change="$v.agree_terms.$touch"
                                    />
                                    <label
                                        class="form-check-label align-middle"
                                        for="agree"
                                        >I have read and agree to the
                                        <a
                                            href="javascript:;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#terms"
                                            class="lightgreen"
                                            >Terms and Conditions</a
                                        ></label
                                    >
                                    <transition
                                        enter-active-class="animate__animated animate__slideInUp"
                                        leave-active-class="animate__animated animate__fadeOut"
                                    >
                                        <div v-if="$v.agree_terms.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="!$v.agree_terms.checked"
                                            >
                                                Please agree with the terms and
                                                conditions.
                                            </div>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div
            class="modal fade"
            id="terms"
            tabindex="-1"
            aria-labelledby=""
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header lightgreen-bg">
                        <h4 class="modal-title text-uppercase text-white">
                            General Terms and Conditions
                        </h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-4">
                            <div class="col-12">
                                <p>
                                    By accomplishing the SUSTAINABILITY
                                    SOLUTIONS EXCHANGE (SSX) Online Application
                                    Form, the Company agrees to fully read and
                                    understood the general terms and conditions
                                    governing a participation in SUSTAINABILITY
                                    SOLUTIONS EXCHANGE (SSX) and commits to
                                    abide by the following:
                                </p>
                                <div class="fw-bold">
                                    Article 1 - APPLICATION
                                </div>
                                <p>
                                    I. Any company that wishes to be part of
                                    SUSTAINABILITY SOLUTIONS EXCHANGE (SSX) must
                                    complete an application form online. The
                                    registration of this application form
                                    constitutes a firm and irrevocable
                                    commitment of the company to apply and
                                    submit the necessary documents within the
                                    period set forth by the Organizer.
                                </p>
                                <p>
                                    II. The company must ensure that the details
                                    and information they will use in this
                                    application form are true and correct as
                                    these will be used by the organizer for
                                    company listing and directory. The organizer
                                    cannot be held liable for omissions or
                                    errors in reproduction, typesetting or
                                    other, that may be committed by the
                                    exhibitor during the application process.
                                </p>
                                <p>
                                    III. By submitting this Application Form,
                                    the company hereby gives its consent to the
                                    organizers and its partners to use and
                                    process all data received in accordance with
                                    the requirements of Republic Act No. 10173
                                    or the Data Privacy Act 2012.
                                </p>
                                <div class="fw-bold">
                                    Article 2 - PRIVACY POLICY
                                </div>
                                <p>
                                    When you register with us, we will ask you
                                    for Personal Data. “Personal Data” refers to
                                    information about you and your company that
                                    can be used to contact or individually
                                    identify you. This information will be
                                    stored in our database and will be
                                    pre-filled when you log back in.
                                </p>
                                <div class="fw-bold">
                                    Article 3 - NEWSLETTER OPT-IN
                                </div>
                                <p>
                                    I agree to subscribe to future newsletters,
                                    emails, and other promotional announcements
                                    about SUSTAINABILITY SOLUTIONS EXCHANGE
                                    (SSX) and other relevant updates from the
                                    organizer - CITEM.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vuelidate from "vuelidate";
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";
import BlockUI from "vue-blockui";

Vue.use(Vuelidate);
Vue.use(BlockUI);

const hasUppercase = (value) => /[A-Z]/.test(value);
const hasLowercase = (value) => /[a-z]/.test(value);
const hasNumber = (value) => /[0-9]/.test(value);
const hasSpecialChar = (value) => /[!@#$%^&*(),.?":{}|<>]/.test(value);

export default {
    data() {
        return {
            isLoading: false,
            isShowThankYou: false,
            msg: "Saving record. Please wait...",
            company_name: "",
            company_email: "",
            company_email_error_pending: false,
            company_email_error: false,
            company_name_error: false,
            company_name_error_pending: false,
            agree_terms: false,
            password: "",
            password_confirmation: "",
            showPassword: false, // 👁 toggle for password
            showConfirmPassword: false, // 👁 toggle for confirm password
        };
    },
    validations: {
        company_name: { required },
        company_email: { required, email },
        password: {
            required,
            minLength: minLength(8),
            hasUppercase,
            hasLowercase,
            hasNumber,
            hasSpecialChar,
        },
        password_confirmation: { sameAsPassword: sameAs("password") },
        agree_terms: {
            checked(val) {
                if (val === "") return true;
                return val;
            },
        },
    },
    mounted() {
        //console.log('Component mounted.')
        this.$v.password.$touch();
    },
    computed: {
        isEmailInvalid() {
            return {
                "is-invalid":
                    this.$v.company_email.$error || this.company_email_error,
            };
        },
    },
    methods: {
        // doCheckEmail() {
        //     this.company_email_error_pending = true;
        //     axios
        //         .get(
        //             "/api/check-company-email-unique/" +
        //                 this.company_email +
        //                 "/exhibitor"
        //         )
        //         .then((response) => {
        //             if (response.status === 200) {
        //                 if (response.data === false) {
        //                     this.company_email_error = true;
        //                 } else {
        //                     this.company_email_error = false;
        //                 }
        //                 this.company_email_error_pending = false;
        //             }
        //         });
        // },
        doCheckEmail() {
            // If blank or invalid format, don't check at all
            if (!this.company_email || !this.$v.company_email.email) {
                this.company_email_error = false;
                this.company_email_error_pending = false;
                return;
            }

            this.company_email_error_pending = true;

            axios
                .get(
                    "/api/check-company-email-unique/" +
                        this.company_email +
                        "/exhibitor"
                )
                .then((response) => {
                    if (response.status === 200) {
                        this.company_email_error = response.data === false;
                    }
                    this.company_email_error_pending = false;
                })
                .catch(() => {
                    this.company_email_error_pending = false;
                });
        },
        doCheckBusinessName() {
            if (!this.company_name || !this.company_name.trim()) {
                this.company_name_error = false;
                this.company_name_error_pending = false;
                return;
            }

            this.company_name_error_pending = true;

            axios;
            axios
                .get(
                    "/api/check-business-name-unique/" +
                        encodeURIComponent(this.company_name) +
                        "/exhibitor"
                )
                .then((response) => {
                    if (response.status === 200) {
                        this.company_name_error = response.data === false;
                    }
                    this.company_name_error_pending = false;
                })
                .catch(() => {
                    this.company_name_error_pending = false;
                    this.company_name_error = true;
                });
        },

        doValidate() {
            this.$v.$touch();
            if (
                !this.$v.$invalid &&
                !this.company_email_error &&
                !this.company_email_error_pending
            ) {
                this.isLoading = true;
                let formData = new FormData();
                formData.append("company_name", this.company_name);
                formData.append("company_email", this.company_email);
                formData.append("password", this.password);
                formData.append(
                    "password_confirmation",
                    this.password_confirmation
                );
                axios
                    .post("/registration/supplier/email-validation", formData)
                    .then((response) => {
                        //console.log(response.data);
                        if (response.status === 200) {
                            this.isLoading = false;
                            this.isShowThankYou = true;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
    },
};
</script>
