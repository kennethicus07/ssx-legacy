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
                                >Registered Business Name*</label
                            >
                            <input
                                type="text"
                                id="company_name"
                                v-model="company_name"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid': $v.company_name.$error,
                                }"
                                placeholder="Your complete company name"
                                autofocus
                                v-limit="150"
                            />

                            <transition
                                enter-active-class="animate__animated animate__slideInUp"
                                leave-active-class="animate__animated animate__fadeOut"
                            >
                                <div v-if="$v.company_name.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.company_name.required"
                                    >
                                        Registered company name is required.
                                    </div>
                                </div>
                            </transition>
                        </div>
                        <div class="form-label-group mb-3">
                            <label
                                for="ref_email"
                                class="form-label text-uppercase fw-bold"
                                >E-mail Address*</label
                            >
                            <input
                                type="email"
                                id="ref_email"
                                v-model="ref_email"
                                class="form-control text-lowercase"
                                :class="isEmailInvalid"
                                placeholder="Enter your email address"
                                @blur="doCheckEmail"
                                v-limit="200"
                            />
                            <transition
                                enter-active-class="animate__animated animate__slideInUp"
                                leave-active-class="animate__animated animate__fadeOut"
                            >
                                <div
                                    v-if="
                                        $v.ref_email.$pending ||
                                        ref_email_error_pending
                                    "
                                    class="text-info mt-1"
                                >
                                    <span
                                        class="spinner-border spinner-border-sm"
                                        role="status"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="fs-12"
                                        >Checking e-mail address. Please
                                        wait...</span
                                    >
                                </div>
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="ref_email_error"
                                >
                                    Company email is already used.
                                </div>
                                <div v-if="$v.ref_email.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.ref_email.required"
                                    >
                                        E-mail address is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.ref_email.email"
                                    >
                                        E-mail address is invalid format.
                                    </div>
                                </div>
                            </transition>
                        </div>
                        <div class="d-grid gap-2 col-8 mx-auto">
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
                                        :class="{
                                            'is-invalid': $v.agree_terms.$error,
                                        }"
                                        :value="1"
                                        v-model="agree_terms"
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header lightgreen-bg">
                        <h4 class="modal-title text-uppercase text-white">
                            Terms and Conditions
                        </h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-1">
                            <div class="col">
                                <p>
                                    By clicking "Submit", I hereby consent
                                    DTI-CITEM to use and process all data in
                                    this Application Form for any purpose
                                    related to SSX or the conduct of DTI-CITEM's
                                    business, including, but not limited to,
                                    promotion of relevant products and services
                                    by email, in accordance with the
                                    requirements of trade promotion and Republic
                                    Act No. 10173 otherwise known as the Data
                                    Privacy Act of 2012.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Email Notification Modal -->
        <div
            class="modal fade"
            id="emailNotificationModal"
            tabindex="-1"
            aria-labelledby="emailNotificationModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header lightgreen-bg">
                        <h4
                            class="modal-title text-uppercase text-white"
                            id="emailNotificationModalLabel"
                        >
                            Notification
                        </h4>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-1">
                            <div class="col">
                                <p v-if="showAttendanceUnderReview">
                                    Hi <strong>{{ companyBackend }}</strong
                                    >, your registration for
                                    <strong>{{ eventName }}</strong> is
                                    currently under review.
                                </p>

                                <p v-else-if="showEmailExistsAndAttendance">
                                    Hi <strong>{{ companyBackend }}</strong
                                    >, this email is already linked to an
                                    existing registration. Would you like to
                                    continue your application for
                                    {{ eventName }}?
                                </p>

                                <p v-else-if="showEmailExistsNoAttendance">
                                    Hi <strong>{{ companyBackend }}</strong
                                    >, this email is already in our system.
                                    Would you like to register for
                                    <strong>{{ eventName }}</strong
                                    >?
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- Button for email exists AND has attendance -->
                        <button
                            v-if="showEmailExistsAndAttendance"
                            type="button"
                            class="btn btn-success"
                            @click="continueApplication"
                        >
                            Continue Application
                        </button>

                        <!-- Button for email exists BUT no attendance -->
                        <button
                            v-else-if="showEmailExistsNoAttendance"
                            type="button"
                            class="btn btn-primary"
                            @click="goToRegisterEvent"
                        >
                            Register for Upcoming Event
                        </button>

                        <!-- Close button -->
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vuelidate from "vuelidate";
import { required, email } from "vuelidate/lib/validators";
import BlockUI from "vue-blockui";

Vue.use(Vuelidate);
Vue.use(BlockUI);

Vue.directive("limit", {
    bind(el, binding) {
        // Allow shorthand: v-limit="100" or v-limit="{ max: 100, numeric: true }"
        const cfg =
            typeof binding.value === "object" && binding.value !== null
                ? binding.value
                : { max: binding.value };
        const max = parseInt(cfg.max, 10) || 1000;
        const numericOnly = !!cfg.numeric;

        // keep track of composition state (IME) so we don't truncate mid-composition
        el._limit = { composing: false };

        const inputHandler = (e) => {
            if (el._limit.composing) return; // don't interfere while user is composing text (IME)
            let val = el.value || "";
            if (numericOnly) val = val.replace(/\D+/g, "");
            if (val.length > max) val = val.substring(0, max);
            if (el.value !== val) {
                el.value = val;
                // update v-model
                el.dispatchEvent(new Event("input"));
            }
        };

        const pasteHandler = (e) => {
            let paste =
                (e.clipboardData || window.clipboardData).getData("text") || "";
            if (numericOnly) paste = paste.replace(/\D+/g, "");
            const currentVal = el.value || "";
            const availableSpace = max - currentVal.length;
            if (availableSpace <= 0) {
                e.preventDefault();
                return;
            }
            if (paste.length > availableSpace) {
                e.preventDefault();
                el.value = currentVal + paste.substring(0, availableSpace);
                el.dispatchEvent(new Event("input"));
            }
        };

        const onCompositionStart = () => (el._limit.composing = true);
        const onCompositionEnd = (e) => {
            el._limit.composing = false;
            // run a final input check after composition ends
            inputHandler(e);
        };

        el.addEventListener("input", inputHandler);
        el.addEventListener("paste", pasteHandler);
        el.addEventListener("compositionstart", onCompositionStart);
        el.addEventListener("compositionend", onCompositionEnd);

        // Set native maxlength for non-numeric inputs to help mobile/IME UI
        if (!numericOnly && max) {
            try {
                el.setAttribute("maxlength", String(max));
            } catch (e) {
                // ignore if element doesn't support attribute
            }
        }

        // cleanup helper
        el._limit_cleanup = () => {
            el.removeEventListener("input", inputHandler);
            el.removeEventListener("paste", pasteHandler);
            el.removeEventListener("compositionstart", onCompositionStart);
            el.removeEventListener("compositionend", onCompositionEnd);
            delete el._limit;
            delete el._limit_cleanup;
        };
    },
    unbind(el) {
        if (el._limit_cleanup) el._limit_cleanup();
    },
});

export default {
    data() {
        return {
            isLoading: false,
            isShowThankYou: false,
            msg: "Saving record. Please wait...",
            company_name: "",
            companyBackend: "",
            ref_email: "",
            ref_email_error_pending: false,
            ref_email_error: false,
            agree_terms: false,
            showEmailModal: false, // control modal visibility
            emailMessage: "", // message from backend
            emailExists: false, // store the exists value
            eventName: "",
            attendanceStatus: null,
            hasAttendance: false,
        };
    },
    validations: {
        company_name: { required },
        ref_email: { required, email },
        agree_terms: {
            checked(val) {
                if (val === "") return true;
                return val;
            },
        },
    },
    mounted() {
        //console.log('Component mounted.')
    },
    computed: {
        isEmailInvalid() {
            return {
                "is-invalid": this.$v.ref_email.$error || this.ref_email_error,
            };
        },
        showAttendanceUnderReview() {
            return this.attendanceStatus === 2;
        },
        showEmailExistsAndAttendance() {
            return (
                this.emailExists &&
                this.hasAttendance &&
                this.attendanceStatus !== 2
            );
        },
        showEmailExistsNoAttendance() {
            return (
                this.emailExists &&
                !this.hasAttendance &&
                this.attendanceStatus !== 2
            );
        },

        isBuyer() {
            return Number(this.user_group) === 3;
        },
    },
    methods: {
        showEmailNotificationModal() {
            const modalEl = document.getElementById("emailNotificationModal");
            const modal = new bootstrap.Modal(modalEl, {
                backdrop: "static",
                keyboard: false,
            });
            modal.show();
        },

        closeEmailModal() {
            const modalEl = document.getElementById("emailNotificationModal");
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        },
        doCheckEmail() {
            // console.log("Checking email:", this.ref_email);
            this.ref_email_error_pending = true;
            // Only check if email is not empty and has valid format
            if (!this.ref_email || !this.$v.ref_email.email) {
                this.ref_email_error = false;
                this.ref_email_error_pending = false;
                return;
            }
            this.ref_email_error_pending = true;
            axios
                .get(
                    "/api/check-company-email-exist/" +
                        this.ref_email +
                        "/buyer"
                )
                .then((response) => {
                    const data = response.data;
                    // console.log("API response:", data);

                    this.emailExists = data.exists;
                    this.hasAttendance = data.has_attendance;
                    this.attendanceStatus = data.attendance_status;
                    this.eventName = data.event_name;
                    this.companyBackend = data.company_name;
                    this.user_group = data.user_group;
                    // console.log("emailExists:", this.emailExists);
                    // console.log("hasAttendance:", this.hasAttendance);

                    // EMAIL EXISTS → show modal
                    // If email exists AND user is buyer → show modal
                    if (data.exists && Number(data.user_group) === 3) {
                        console.log("Buyer email exists → show modal");
                        this.$nextTick(() => {
                            const modalEl = document.getElementById(
                                "emailNotificationModal"
                            );
                            if (modalEl) {
                                const modal = new bootstrap.Modal(modalEl, {
                                    backdrop: "static",
                                    keyboard: false,
                                });
                                modal.show();
                            }
                        });
                        this.ref_email_error = true;
                    } else {
                        // Email exists but NOT buyer → show red error only, no modal
                        if (data.exists) {
                            // console.log(
                            //     "Email exists but not buyer → NO modal"
                            // );
                            this.ref_email_error = true;
                        } else {
                            this.ref_email_error = false;
                        }
                    }

                    this.ref_email_error_pending = false;
                })
                .catch((err) => {
                    console.error("API error:", err);
                    this.ref_email_error_pending = false;
                });
        },
        doValidate() {
            this.$v.$touch();
            if (
                !this.$v.$invalid &&
                !this.$v.$pending &&
                !this.ref_email_error &&
                !this.ref_email_error_pending
            ) {
                this.isLoading = true;
                let formData = new FormData();
                formData.append("company_name", this.company_name);
                formData.append("ref_email", this.ref_email);
                axios
                    .post("/registration/purchaser/email-validation", formData)
                    .then((response) => {
                        //console.log(response.data);
                        if (response.status === 200) {
                            this.isLoading = false;
                            this.isShowThankYou = true;
                        }
                    })
                    .catch((err) => {
                        // console.log(err);
                    });
            }
        },
        goToRegisterEvent() {
            this.showEmailModal = false;
            this.isLoading = true;
            this.closeEmailModal();
            let formData = new FormData();
            formData.append("ref_email", this.ref_email);

            axios
                .post("/registration/purchaser/email-validation", formData)
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        this.isShowThankYou = true;
                    }
                })
                .catch((err) => {
                    console.error(err);
                    this.isLoading = false;
                });
        },

        continueApplication() {
            this.showEmailModal = false;
            this.isLoading = true;
            this.closeEmailModal();
            let formData = new FormData();
            formData.append("ref_email", this.ref_email);

            axios
                .post("/registration/purchaser/email-validation", formData)
                .then((response) => {
                    if (response.status === 200) {
                        this.isLoading = false;
                        this.isShowThankYou = true;
                    }
                })
                .catch((err) => {
                    console.error(err);
                    this.isLoading = false;
                });
        },
    },
};
</script>
