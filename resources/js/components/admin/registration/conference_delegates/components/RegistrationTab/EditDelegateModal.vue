<template>
    <transition name="fade">
        <div v-if="show" class="modal-backdrop-custom">
            <div class="modal-card modal-xl">
                <div class="card shadow-lg border-0">
                    <!-- HEADER -->
                    <div
                        class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                    >
                        <div>
                            <h4 class="mb-1">
                                <i class="fas fa-user-edit me-2"></i>
                                Edit Delegate
                            </h4>

                            <!-- <small class="text-white-50">
                                Update conference delegate information.
                            </small> -->
                        </div>

                        <button
                            class="btn btn-light btn-sm"
                            @click="$emit('close')"
                        >
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">
                        <div class="row">
                            <!-- LEFT -->
                            <div class="col-lg-8">
                                <!-- PERSONAL -->
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
                                                    Email
                                                </label>

                                                <input
                                                    class="form-control"
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
                                                    Mobile
                                                </label>

                                                <input
                                                    class="form-control"
                                                    v-model="delegate.mobile_no"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- DELEGATE INFORMATION -->

                                <div class="card shadow-sm">
                                    <div class="card-header bg-white">
                                        <h5 class="mb-0">
                                            Delegate Information
                                        </h5>
                                    </div>

                                    <div class="card-body">
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

                                                <label class="form-check-label">
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

                                                <label class="form-check-label">
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

                                                <label class="form-check-label">
                                                    Academe / Student
                                                </label>
                                            </div>
                                        </div>

                                        <hr />

                                        <label class="fw-bold">
                                            Delegate Category
                                        </label>

                                        <div class="mt-2">
                                            <div
                                                v-for="cat in categories"
                                                :key="cat.id"
                                                class="form-check"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    :value="cat.id"
                                                    v-model="
                                                        delegate.delegate_category
                                                    "
                                                />

                                                <label class="form-check-label">
                                                    {{ cat.label }}
                                                </label>
                                            </div>
                                        </div>

                                        <div
                                            v-if="
                                                delegate.delegate_category == 99
                                            "
                                            class="mt-3"
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

                            <!-- RIGHT -->

                            <div class="col-lg-4">
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

                                        <div class="form-check mt-3">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                v-model="delegate.is_speaker"
                                            />

                                            <label class="form-check-label">
                                                Speaker
                                            </label>
                                        </div>

                                        <small class="text-muted d-block mt-2">
                                            Mark this delegate as a speaker.
                                        </small>
                                    </div>
                                </div>
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
                                                PWD
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- FILE -->

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
                                            theme="list"
                                            v-model="files"
                                            @select="onFileSelected"
                                            @beforedelete="onBeforeFileDelete"
                                        />

                                        <small class="text-muted">
                                            Upload replacement ID if needed.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER -->

                    <div class="card-footer bg-white text-end">
                        <button
                            class="btn btn-light me-2"
                            @click="$emit('close')"
                        >
                            Cancel
                        </button>

                        <button
                            class="btn btn-success text-white"
                            :disabled="loading"
                            @click="updateDelegate"
                        >
                            <span
                                v-if="loading"
                                class="spinner-border spinner-border-sm me-2"
                            ></span>

                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";

Vue.use(VueFileAgent);

export default {
    name: "EditDelegateModal",

    props: {
        show: Boolean,

        conferenceId: {
            type: Number,
            required: true,
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

            files: [],

            delegate: {},
            removeExistingFile: false,
        };
    },

    computed: {
        categories() {
            return [
                {
                    id: 1,
                    label: "Decision-maker",
                },

                {
                    id: 2,
                    label: "Recommending Officer",
                },

                {
                    id: 3,
                    label: "Technical Representative",
                },

                {
                    id: 99,
                    label: "Other",
                },
            ];
        },
    },

    watch: {
        show(value) {
            if (value) {
                this.loadCountries();

                if (this.editData) {
                    this.delegate = {
                        ...this.editData,
                    };

                    if (this.editData.id_file) {
                        this.files = [
                            {
                                name: this.editData.id_file,
                                type: this.getFileType(this.editData.id_file),
                                size: 0,
                                url: `/storage/conf_uploads/${this.editData.id_file}`,
                                file: null,
                                isUploaded: true,
                            },
                        ];
                    } else {
                        this.files = [];
                    }

                    // Reset temporary state every time modal opens
                    this.uploadedFile = null;
                    this.removeExistingFile = false;
                }
            } else {
                // Clean temporary state when modal closes
                this.files = [];
                this.uploadedFile = null;
                this.removeExistingFile = false;
            }
        },

        editData: {
            immediate: true,
            deep: true,
            handler(value) {
                if (!value) return;

                this.delegate = {
                    ...value,
                };

                if (this.show) {
                    if (value.id_file) {
                        this.files = [
                            {
                                name: value.id_file,
                                type: this.getFileType(value.id_file),
                                size: 0,
                                url: `/storage/conf_uploads/${value.id_file}`,
                                file: null,
                                isUploaded: true,
                            },
                        ];
                    } else {
                        this.files = [];
                    }
                }
            },
        },
        "delegate.is_visitor_buyer"(value) {
            if (value) {
                this.delegate.is_speaker = false;
            }
        },

        "delegate.is_speaker"(value) {
            if (value) {
                this.delegate.is_visitor_buyer = false;
            }
        },
    },

    methods: {
        populateDelegate() {
            this.delegate = { ...this.editData };

            this.files = this.editData?.id_file
                ? [
                      {
                          name: this.editData.id_file,
                          type: this.getFileType(this.editData.id_file),
                          size: 0,
                          url: `/storage/conf_uploads/${this.editData.id_file}`,
                          file: null,
                          isUploaded: true,
                      },
                  ]
                : [];

            this.uploadedFile = null;
            this.removeExistingFile = false;
        },
        loadCountries() {
            axios.get("/api/countries").then((res) => {
                this.countries = res.data;
            });
        },

        onFileSelected(files) {
            if (files.length) {
                this.uploadedFile = files[0].file;
            }
        },
        getFileType(filename) {
            const extension = filename.split(".").pop().toLowerCase();

            if (extension === "pdf") {
                return "application/pdf";
            }

            return `image/${extension}`;
        },
        onBeforeFileDelete(fileRecord) {
            this.files = [];
            this.uploadedFile = null;

            // Optional - needed if you want to remove it from DB
            this.removeExistingFile = true;

            return true;
        },

        async updateDelegate() {
            this.loading = true;

            let formData = new FormData();

            Object.keys(this.delegate).forEach((key) => {
                if (key !== "id" && key !== "id_file") {
                    formData.append(key, this.delegate[key] ?? "");
                }
            });
            formData.append("is_speaker", this.delegate.is_speaker ? 1 : 0);

            formData.append(
                "is_visitor_buyer",
                this.delegate.is_visitor_buyer ? 1 : 0
            );

            formData.append("senior", this.delegate.senior ? 1 : 0);
            formData.append("pwd", this.delegate.pwd ? 1 : 0);

            if (this.uploadedFile) {
                formData.append("id_file", this.uploadedFile);
            }

            formData.append("_method", "PUT");

            try {
                const response = await axios.post(
                    `/admin/registration/delegates/${this.delegate.id}/update`,

                    formData,

                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                this.$toast.success("Delegate updated successfully.", {
                    position: "top-right",
                });

                this.$emit("saved", response.data);

                this.$emit("close");
            } catch (error) {
                this.$toast.error(
                    error.response?.data?.message ||
                        "Unable to update delegate."
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
    transition: 0.2s ease;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;

    transform: scale(0.98);
}
</style>
