<template>
    <transition name="fade">
        <div v-if="show" class="modal-backdrop-custom">
            <div class="modal-card modal-xl">
                <div class="card shadow-lg border-0">
                    <!-- Header -->
                    <div
                        class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                    >
                        <div>
                            <h4 class="mb-1">
                                <i class="fas fa-user-plus me-2"></i>
                                Add Delegate
                            </h4>

                            <small class="text-white-50">
                                Register a conference delegate manually.
                            </small>
                        </div>

                        <button
                            class="btn btn-light btn-sm"
                            @click="$emit('close')"
                        >
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>

                    <!-- Body -->

                    <div class="card-body">
                        <div class="row">
                            <!-- LEFT -->

                            <div class="col-lg-8">
                                <!-- PERSONAL INFORMATION -->

                                <div class="card shadow-sm mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">
                                            Personal Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">
                                                    Salutation
                                                </label>

                                                <select
                                                    class="form-select"
                                                    v-model="
                                                        delegate.salutation
                                                    "
                                                >
                                                    <option value="">
                                                        Select
                                                    </option>

                                                    <option value="Mr">
                                                        Mr.
                                                    </option>

                                                    <option value="Ms">
                                                        Ms.
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">
                                                    First Name
                                                </label>

                                                <input
                                                    class="form-control"
                                                    v-model="delegate.fname"
                                                />
                                            </div>

                                            <div class="col-md-5 mb-3">
                                                <label class="form-label">
                                                    Last Name
                                                </label>

                                                <input
                                                    class="form-control"
                                                    v-model="delegate.lname"
                                                />
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Nationality
                                                </label>

                                                <select
                                                    class="form-select"
                                                    v-model="delegate.country"
                                                >
                                                    <option value="">
                                                        Select Country
                                                    </option>

                                                    <option
                                                        v-for="country in countries"
                                                        :key="country.id"
                                                        :value="country.name"
                                                    >
                                                        {{ country.name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Designation
                                                </label>

                                                <input
                                                    class="form-control"
                                                    v-model="
                                                        delegate.designation
                                                    "
                                                />
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">
                                                    Email Address
                                                </label>

                                                <input
                                                    class="form-control"
                                                    type="email"
                                                    v-model="delegate.email"
                                                />
                                            </div>

                                            <div class="col-md-2 mb-3">
                                                <label class="form-label">
                                                    Code
                                                </label>

                                                <select
                                                    class="form-select"
                                                    v-model="
                                                        delegate.country_code_mobile
                                                    "
                                                >
                                                    <option value="">
                                                        Code
                                                    </option>

                                                    <option
                                                        v-for="country in countries"
                                                        :key="country.id"
                                                        :value="country.dial"
                                                    >
                                                        {{ country.dial }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">
                                                    Mobile Number
                                                </label>

                                                <input
                                                    class="form-control"
                                                    v-model="delegate.mobile_no"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delegate Information -->

                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">
                                            Delegate Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <hr />

                                        <div class="mb-4">
                                            <label class="fw-bold">
                                                Delegate Type
                                            </label>

                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="Private"
                                                        v-model="
                                                            delegate.addtnl_type
                                                        "
                                                    />

                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Private
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="Government"
                                                        v-model="
                                                            delegate.addtnl_type
                                                        "
                                                    />

                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Government
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        value="AcademeStudent"
                                                        v-model="
                                                            delegate.addtnl_type
                                                        "
                                                    />

                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Academe / Student
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        <!-- Delegate Category -->
                                        <div>
                                            <label class="fw-bold">
                                                Delegate Category
                                            </label>

                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :value="1"
                                                        v-model="
                                                            delegate.delegate_category
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Decision-maker
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :value="2"
                                                        v-model="
                                                            delegate.delegate_category
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Recommending Officer
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :value="3"
                                                        v-model="
                                                            delegate.delegate_category
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Technical Representative
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input
                                                        class="form-check-input"
                                                        type="radio"
                                                        :value="99"
                                                        v-model="
                                                            delegate.delegate_category
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label"
                                                    >
                                                        Other
                                                    </label>
                                                </div>
                                            </div>

                                            <div
                                                class="mt-3"
                                                v-if="
                                                    delegate.delegate_category ==
                                                    99
                                                "
                                            >
                                                <input
                                                    class="form-control"
                                                    placeholder="Specify Category"
                                                    v-model="
                                                        delegate.delegate_category_other
                                                    "
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT -->
                            <div class="col-lg-4">
                                <!-- Delegate Classification -->
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">Classification</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                v-model="
                                                    delegate.is_visitor_buyer
                                                "
                                            />

                                            <label class="form-check-label">
                                                Visitor / Buyer
                                            </label>
                                        </div>

                                        <small class="text-muted d-block mt-2">
                                            Mark this delegate as a visitor or
                                            buyer.
                                        </small>
                                    </div>
                                </div>

                                <!-- Discounts & Eligibility -->
                                <div class="card shadow-sm mb-4">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">
                                            Discounts & Eligibility
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                v-model="delegate.senior"
                                            />

                                            <label class="form-check-label">
                                                Senior Citizen
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                v-model="delegate.pwd"
                                            />

                                            <label class="form-check-label">
                                                Person with Disability (PWD)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Supporting Documents -->
                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">
                                            Supporting Documents
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <VueFileAgent
                                            ref="vueFileAgent"
                                            :multiple="false"
                                            :deletable="true"
                                            :meta="true"
                                            accept="image/*,.pdf"
                                            :maxFiles="1"
                                            maxSize="1MB"
                                            theme="list"
                                            v-model="delegate.id_file"
                                            @select="onFileSelected"
                                            @beforedelete="onBeforeFileDelete"
                                        />

                                        <small class="text-muted">
                                            Government ID, Student ID, Senior
                                            Citizen ID or PWD ID.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="card-footer bg-white d-flex justify-content-end"
                    >
                        <button
                            class="btn btn-light me-2"
                            @click="$emit('close')"
                        >
                            Cancel
                        </button>

                        <button
                            class="btn btn-success text-white"
                            :disabled="loading"
                            @click="saveDelegate"
                        >
                            <span
                                v-if="loading"
                                class="spinner-border spinner-border-sm me-2"
                            ></span>

                            <i v-else class="fas fa-save me-2"></i>

                            Save Delegate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import Vuelidate from "vuelidate";
import { required, email, requiredIf } from "vuelidate/lib/validators";

import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

Vue.use(Vuelidate);
Vue.use(VueFileAgent);
Vue.use(VueSweetalert2);

export default {
    name: "AddDelegateModal",

    props: {
        show: Boolean,

        conferenceId: {
            type: Number,
            required: true,
        },

        fairCode: {
            type: String,
            default: "",
        },

        editData: {
            type: Object,
            default: null,
        },
    },

    data() {
        return {
            loading: false,

            countries: [],

            uploadedFile: null,

            delegate: {
                salutation: "",
                fname: "",
                lname: "",
                country: "",
                designation: "",
                email: "",
                country_code_mobile: "",
                mobile_no: "",
                business_type: "local",
                addtnl_type: "",
                is_visitor_buyer: false,
                senior: false,
                pwd: false,
                delegate_category: "",
                delegate_category_other: "",
                id_file: [],
            },
        };
    },

    validations() {
        return {
            delegate: {
                salutation: { required },
                fname: { required },
                lname: { required },
                country: { required },
                designation: { required },
                email: { required, email },
                country_code_mobile: { required },
                mobile_no: { required },
                addtnl_type: { required },
                delegate_category: { required },

                delegate_category_other: {
                    required: requiredIf(
                        () => this.delegate.delegate_category == 99
                    ),
                },

                id_file: {
                    required: requiredIf(() => this.isIDRequired),
                },
            },
        };
    },

    computed: {
        isIDRequired() {
            return (
                this.delegate.addtnl_type !== "Private" ||
                this.delegate.senior ||
                this.delegate.pwd
            );
        },
    },

    mounted() {
        this.loadCountries();

        if (this.editData) {
            this.populateForm();
        }
    },

    watch: {
        show(val) {
            if (!val) {
                this.resetForm();
            }
        },
    },

    methods: {
        loadCountries() {
            axios
                .get("/api/countries")
                .then((response) => {
                    this.countries = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        populateForm() {
            this.delegate = {
                ...this.delegate,
                ...this.editData,
            };
        },

        onFileSelected(files) {
            if (files.length) {
                this.uploadedFile = files[0].file;
            }
        },

        onBeforeFileDelete(fileRecord) {
            if (confirm("Remove uploaded file?")) {
                this.$refs.vueFileAgent.deleteFileRecord(fileRecord);

                this.uploadedFile = null;
            }
        },

        resetForm() {
            this.delegate = {
                salutation: "",
                fname: "",
                lname: "",
                country: "",
                designation: "",
                email: "",
                country_code_mobile: "",
                mobile_no: "",
                business_type: "local",
                addtnl_type: "",
                is_visitor_buyer: false,
                senior: false,
                pwd: false,
                delegate_category: "",
                delegate_category_other: "",
                id_file: [],
            };

            this.uploadedFile = null;

            if (this.$refs.vueFileAgent) {
                this.$refs.vueFileAgent.deleteFileRecord();
            }

            this.$v.$reset();
        },

        async saveDelegate() {
            this.$v.$touch();

            if (this.$v.$invalid) {
                this.$toast.error("Please complete the required fields.", {
                    position: "top-right",
                });

                return;
            }

            this.loading = true;

            const formData = new FormData();
            formData.append(
                "is_visitor_buyer",
                this.delegate.is_visitor_buyer ? 1 : 0
            );
            formData.append("salutation", this.delegate.salutation);
            formData.append("fname", this.delegate.fname);
            formData.append("lname", this.delegate.lname);
            formData.append("country", this.delegate.country);
            formData.append("designation", this.delegate.designation);
            formData.append("email", this.delegate.email);
            formData.append(
                "country_code_mobile",
                this.delegate.country_code_mobile
            );
            formData.append("mobile_no", this.delegate.mobile_no);
            formData.append("business_type", this.delegate.business_type);
            formData.append("addtnl_type", this.delegate.addtnl_type);
            formData.append(
                "delegate_category",
                this.delegate.delegate_category
            );
            formData.append(
                "delegate_category_other",
                this.delegate.delegate_category_other || ""
            );

            // Send as tinyint (0/1)
            formData.append("senior", this.delegate.senior ? 1 : 0);
            formData.append("pwd", this.delegate.pwd ? 1 : 0);

            if (this.uploadedFile) {
                formData.append("id_file", this.uploadedFile);
            }

            try {
                const response = await axios.post(
                    `/admin/registration/delegates/${this.conferenceId}/add-delegate`,
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                this.$toast.success("Delegate added successfully.", {
                    position: "top-right",
                });

                this.$emit("saved", response.data);
                this.$emit("close");

                this.resetForm();
            } catch (error) {
                console.error(error);

                this.$toast.error(
                    error.response?.data?.message || "Unable to save delegate.",
                    {
                        position: "top-right",
                    }
                );
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.modal-backdrop-custom {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    overflow-y: auto;
    padding: 2rem;
}

.modal-card {
    width: 100%;
    max-width: 1200px;
}

.fade-enter-active,
.fade-leave-active {
    transition: all 0.2s ease;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
    transform: scale(0.98);
}
</style>
