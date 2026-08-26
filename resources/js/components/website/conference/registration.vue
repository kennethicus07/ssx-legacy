<template>
    <div class="section container registration-form" id="regDiv">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <form-wizard
            v-if="this.submittedForm == false"
            title=""
            subtitle=""
            color="#9daa39"
            errorColor="#dc3545"
            stepSize="xs"
            :startIndex="0"
            finish-button-text="Submit"
            @on-loading="onLoad"
            @on-complete="onComplete"
        >
            <tab-content title="Conference Delegates" :before-change="doStep1">
                <step1delegates
                    :step1="step1"
                    :participant="participant"
                    :countries="countries"
                    :discounts="discounts"
                    :currency="currency"
                    :formattedAmount="formattedAmount"
                    :promo_code_temp.sync="promo_code_temp"
                    :promo_code_error="promo_code_error"
                    :participantForm="participantForm"
                    :isIDRequired="isIDRequired"
                    :v="$v"
                    @change-type="onChangeType"
                    @promo-change="onChangePromoCode"
                    @promo-code="checkPromoCode"
                    @toggle-participant="doToggleParticipantDetails"
                    @submit-participant="doSubmitParticipantDetails"
                    @remove-participant="doRemoveParticipant"
                    @file-select="onFileSelect"
                    @before-file-delete="onBeforeFileDelete"
                />
            </tab-content>
            <tab-content
                title="Preferences / Promotion"
                :before-change="doStep2"
            >
                <step2preferences :step2="step2" :v="$v" />
            </tab-content>
            <tab-content title="Billing" :before-change="doStep3">
                <step3billing :step3="step3" :v="$v" />
            </tab-content>
        </form-wizard>
        <div v-else class="row">
            <div class="col-10 col-lg-6 mt-5 mx-auto text-center">
                <h3>
                    Thank you for registering for the Sustainability Solutions
                    Exchange Conference 2026
                </h3>
                <!-- <p>Billing information has been sent to {{ this.step3.company_email }}. <a href="https://citem.gov.ph/services/payment" target="_blank">Click here</a> to learn more about payment options for your registration.</p> -->
                <!-- <p>
                    <a
                        href="https://forms.cloud.microsoft/r/ZPCQQz9E91"
                        target="_blank"
                        rel="noopener noreferrer"
                        >Click here</a
                    >
                    to select your preferred track that you’re most interested
                    in attending.
                </p> -->
                <!-- <p>
                    <h3>Registration No.:&nbsp;{{ this.registration_number }}</h3>
                    Total Amount Due (VAT Inclusive): {{ this.currency }} {{ this.formattedAmount }} 
                </p> -->
            </div>
        </div>
    </div>
</template>
<script>
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import Vuelidate from "vuelidate";
import {
    required,
    email,
    url,
    numeric,
    requiredIf,
    minValue,
} from "vuelidate/lib/validators";
import BlockUI from "vue-blockui";
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

import step1delegates from "./components/step1delegates.vue";
import step2preferences from "./components/step2preferences.vue";
import step3billing from "./components/step3billing.vue";

Vue.use(BlockUI);
Vue.use(Vuelidate);
Vue.use(VueFileAgent);
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    props: ["params"],
    data() {
        return {
            isLoading: false,
            msg: "Standby...",
            events: [],
            fair_code: "SSXO2026",
            attendee_type: 3,
            conf_id: this.params.id ?? null,
            registration_number: "",
            participantForm: false,
            submittedForm: false,
            countries: [],
            currency: "",
            // base_rate: 0,
            base_total: 0,
            discounts_total: 0,
            discounts: [],
            promo_code_temp: "",
            promo_code_error: "",
            id_file_selected: "",
            participant: {
                p_id: 0,
                salutation: "",
                fname: "",
                lname: "",
                country: "",
                designation: "",
                email: "",
                country_code_mobile: "",
                mobile_no: "",
                addtnl_type: "",
                senior: "",
                pwd: "",
                id_file: "",
                delegate_category: "",
                delegate_category_other: "",
            },
            step1: {
                participant_count: 0,
                type: "",
                participants: [],
            },
            step2: {
                dietary: "",
                dietary_details: "",
                certificate: "",
                knowHow: [],
                knowHow_other: "",
                promotional_email: "",
            },
            step3: {
                company_name: "",
                company_address: "",
                tin: "",
                contact_person_salutation: "",
                contact_person: "",
                company_email: "",
                contact_number: "",
            },
        };
    },
    validations() {
        return {
            participant: {
                salutation: { required },
                fname: { required },
                lname: { required },
                country: { required },
                designation: { required },
                email: { required, email },
                country_code_mobile: { required },
                mobile_no: { required },
                addtnl_type: { required },
                id_file: {
                    required: this.isIDRequired ? required : false,
                },
                delegate_category: { required },
                delegate_category_other: {
                    required: requiredIf(function () {
                        return this.participant.delegate_category == 99;
                    }),
                },
            },
            step1: {
                participant_count: { required, minValue: minValue(1) },
                type: { required },
            },
            step2: {
                // dietary: { required },
                // dietary_details: {
                //     required: (value) => (this.step2.dietary === 'yes' ? required(value) : true)
                // },
                certificate: { required },
                knowHow: {
                    required: (value) =>
                        Array.isArray(value) && value.length > 0,
                },
                knowHow_other: {
                    required: requiredIf(function () {
                        return this.step2.knowHow.includes("Other");
                    }),
                },
                promotional_email: { required },
            },
            step3: {
                company_name: { required },
                company_address: { required },
                tin: { required },
                contact_person_salutation: { required },
                contact_person: { required },
                company_email: { required, email },
                contact_number: { required },
            },
        };
    },
    components: {
        FormWizard,
        TabContent,
        step1delegates,
        step2preferences,
        step3billing,
    },
    mounted() {},
    created() {
        this.getCountries();
        this.getEvents();
    },
    computed: {
        formattedAmount() {
            const result = this.base_total - this.discounts_total;
            return result <= 0 ? "0.00" : result.toFixed(2);
        },
        isIDRequired() {
            return (
                (this.participant.addtnl_type !== "Private" &&
                    this.participant.addtnl_type !== "") ||
                this.participant.senior === true ||
                this.participant.pwd === true
            );
        },
    },
    methods: {
        doStep1() {
            // TEMP
            // return true

            this.$v.step1.$touch();
            // console.log(this.step1.participant_count)
            if (!this.$v.step1.$invalid) {
                return true;
            } else {
                return false;
            }
        },
        doStep2() {
            // TEMP
            // return true

            this.$v.step2.$touch();
            if (!this.$v.step2.$invalid) {
                // console.log(this.step2)
                return true;
            } else {
                return false;
            }
        },
        doStep3() {
            // TEMP
            // return true

            this.$v.step3.$touch();
            if (!this.$v.step3.$invalid) {
                // console.log(this.step3)
                return true;
            } else {
                return false;
            }
        },
        getEvents() {
            axios.get("/api/supplier/events").then((res) => {
                this.events = res.data;

                if (this.events.length) {
                    const latestEvent = [...this.events].sort(
                        (a, b) =>
                            new Date(b.created_at) - new Date(a.created_at)
                    )[0];

                    this.fair_code = latestEvent.fair_code;
                }
            });
        },
        async doSubmitParticipantDetails() {
            this.$v.participant.$touch();

            if (!this.$v.participant.$invalid) {
                this.isLoading = true;

                const formData = new FormData();
                formData.append("conf_id", this.conf_id);
                formData.append("fair_code", this.fair_code);
                formData.append(
                    "participant",
                    JSON.stringify(this.participant)
                );

                if (this.id_file_selected) {
                    formData.append("id_file_selected", this.id_file_selected);
                }

                try {
                    const response = await axios.post(
                        "/conference/registration/participant/add",
                        formData,
                        { headers: { "Content-Type": "multipart/form-data" } }
                    );

                    if (response.status === 200) {
                        this.participant.p_id = response.data.pid;
                        this.step1.participants.push({ ...this.participant });
                        this.doToggleParticipantDetails(false);

                        await this.computeAll(0);
                    }
                } catch (err) {
                    alert(
                        "Something went wrong. Please try again, or contact support if the issue persists."
                    );
                } finally {
                    this.isLoading = false;
                }
            }
        },
        async doRemoveParticipant(index) {
            this.isLoading = true;

            const formData = new FormData();
            formData.append("conf_id", this.conf_id);
            formData.append("fair_code", this.fair_code);
            formData.append("p_id", this.step1.participants[index].p_id);

            try {
                const response = await axios.post(
                    "/conference/registration/participant/delete",
                    formData
                );

                if (response.status === 200) {
                    this.step1.participants.splice(index, 1);
                    this.step1.participant_count -= 1;

                    await this.computeAll(0);
                }
            } catch (err) {
                alert(
                    "Something went wrong. Please try again, or contact support if the issue persists."
                );
            } finally {
                this.isLoading = false;
            }
        },
        doToggleParticipantDetails($state) {
            if ($state == true) {
                $(".wizard-card-footer.clearfix").hide();
            } else {
                this.clearParticipantDetails();
                $(".wizard-card-footer.clearfix").show();
            }
            this.participantForm = $state;
        },
        clearParticipantDetails() {
            this.participant.p_id = 0;
            this.participant.salutation = "";
            this.participant.fname = "";
            this.participant.lname = "";
            this.participant.country = "";
            this.participant.designation = "";
            this.participant.email = "";
            this.participant.country_code_mobile = "";
            this.participant.mobile_no = "";
            this.participant.addtnl_type = "";
            this.participant.senior = "";
            this.participant.pwd = "";
            this.participant.id_file = "";
            this.id_file_selected = "";
            this.participant.delegate_category = "";
            this.participant.delegate_category_other = "";
            this.$v.participant.$reset();
        },
        getCountries() {
            axios
                .get("/api/countries")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.countries = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async checkPromoCode() {
            const promoCode = this.promo_code_temp.trim().toUpperCase();

            if (!promoCode) {
                this.promo_code_error = "Promo code is required";
                return;
            }

            this.promo_code_error = "";
            this.isLoading = true;

            const formData = new FormData();
            formData.append("conf_id", this.conf_id);
            formData.append("fair_code", this.fair_code);
            formData.append("promo_code", promoCode);

            try {
                const response = await axios.post(
                    "/conference/registration/code",
                    formData
                );

                if (response.status === 200) {
                    await this.computeAll(0);
                }
            } catch (err) {
                if (err.response) {
                    this.promo_code_error = err.response.data.message;
                } else {
                    this.promo_code_error = "An unexpected error occurred.";
                }
            } finally {
                this.isLoading = false;
            }
        },
        async computeAll(state) {
            // $state = 0-ongoing, 1-submit

            this.promo_code_temp = "";
            this.promo_code_error = "";
            this.discounts_total = 0;

            this.isLoading = true;

            const formData = new FormData();
            formData.append("state", state);
            formData.append("conf_id", this.conf_id);
            formData.append("fair_code", this.fair_code);
            formData.append("attendee_type", this.attendee_type);
            formData.append("type", this.step1.type);

            try {
                const response = await axios.post(
                    "/conference/registration/compute",
                    formData
                );

                if (response.status === 200) {
                    this.base_total = response.data.base_total;
                    this.discounts_total = response.data.discounts_total;
                    this.step1.participant_count =
                        response.data.participant_count;
                    this.discounts = Array.isArray(response.data.discounts)
                        ? response.data.discounts
                        : [];

                    console.log("Check Response:", response);

                    if (state != 1) {
                        this.isLoading = false;
                    }
                }
            } catch (err) {
                alert(
                    "Something went wrong. Please try again, or contact support if the issue persists."
                );
            }
        },
        onBeforeFileDelete(fileRecord) {
            if (confirm("Are you sure you want to remove this document?")) {
                // this.doDeleteDoc('doc_1')
                this.$refs.vueFileAgent1.deleteFileRecord(fileRecord);
            }
        },
        onFileSelect(file) {
            this.id_file_selected = file[0].file;
        },
        async onChangeType() {
            this.currency = this.step1.type === "foreign" ? "USD" : "PHP";
            await this.computeAll(0);
        },
        onChangePromoCode() {
            this.promo_code_error = "";
        },
        async onComplete() {
            const confirmed = await this.onSubmit();
            if (!confirmed) {
                return false;
            }

            await this.computeAll(1);

            this.isLoading = true;
            let formData = new FormData();
            // formData.append('breakdown', JSON.stringify(this.discounts))
            // formData.append('currency', this.currency)
            // formData.append('base_rate', this.base_rate)
            // formData.append('base_total', this.base_total)
            // formData.append('discounts_total', this.discounts_total)
            // formData.append('step1', JSON.stringify(this.step1))
            formData.append("conf_id", this.conf_id);
            formData.append("fair_code", this.fair_code);
            formData.append("step2", JSON.stringify(this.step2));
            formData.append("step3", JSON.stringify(this.step3));

            axios
                .post("/conference/registration/store", formData)
                .then((response) => {
                    if (response.status === 200) {
                        this.registration_number = response.data.reg_no;
                        this.submittedForm = true;
                        this.isLoading = false;
                        return true;
                    }
                })
                .catch((err) => {
                    this.isLoading = false;
                    alert(
                        "Something went wrong. Please try again, or contact support if the issue persists."
                    );

                    return false;
                });
        },
        async onSubmit() {
            const result = await this.$swal({
                title: "SSX Conference 2026 Registration",
                text: "Would you like to submit the form? To review the form, click cancel.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Submit it!",
                cancelButtonText: "No, Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            });

            return result.isConfirmed;
        },
        onLoad(e) {
            this.isLoading = e;
        },
    },
};
</script>
