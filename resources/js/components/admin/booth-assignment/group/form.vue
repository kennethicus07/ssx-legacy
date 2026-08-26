<template>
    <div>
        <div
            class="modal fade"
            :class="{ show: show }"
            :style="{ display: show ? 'block' : 'none' }"
            tabindex="-1"
            role="dialog"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-dialog-centered modal-lg"
                role="document"
            >
                <div class="modal-content">
                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ isEdit ? "Edit Group" : "Add Group" }}
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            @click="close"
                            :disabled="isLoading"
                        ></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <!-- Fair Code -->
                        <div class="mb-3">
                            <label class="form-label"> Fair Code </label>

                            <input
                                type="text"
                                class="form-control form-control-sm"
                                :value="assignment.fair_code"
                                readonly
                            />
                        </div>

                        <!-- Supplier / Exhibitor -->
                        <div class="mb-3">
                            <label class="form-label">
                                Supplier / Exhibitor
                                <span class="text-danger">*</span>
                            </label>

                            <multiselect
                                v-model="selectedSuppliers"
                                :options="suppliers"
                                :multiple="!isEdit"
                                :searchable="true"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :preserve-search="true"
                                :allow-empty="true"
                                :disabled="isLoading || isEdit"
                                :loading="loadingSuppliers"
                                label="fascia_name"
                                track-by="uid"
                                placeholder="Select Supplier / Exhibitor"
                                :custom-label="supplierDisplayName"
                                :class="{
                                    'is-invalid': errors.exhibitor_id,
                                }"
                            >
                                <!-- Dropdown option -->
                                <template slot="option" slot-scope="props">
                                    <div class="supplier-option">
                                        {{ props.option.co_name }}
                                    </div>
                                </template>

                                <!-- Selected capsules -->
                                <template
                                    slot="selection"
                                    slot-scope="{ values }"
                                >
                                    <span
                                        v-for="supplier in values"
                                        :key="supplier.uid"
                                        class="multiselect__tag"
                                    >
                                        <span>
                                            {{ supplierDisplayName(supplier) }}
                                        </span>
                                        <span
                                            class="multiselect__tag-icon"
                                            @click.stop="
                                                removeSupplier(supplier)
                                            "
                                        ></span>
                                    </span>
                                </template>
                            </multiselect>

                            <div
                                v-if="errors.exhibitor_id"
                                class="text-danger small mt-1"
                            >
                                {{ getError(errors.exhibitor_id) }}
                            </div>

                            <small
                                v-if="
                                    !loadingSuppliers && suppliers.length === 0
                                "
                                class="text-muted"
                            >
                                No suppliers found for this fair.
                            </small>
                        </div>

                        <!-- Booth -->
                        <div class="mb-3">
                            <label class="form-label">
                                Booth
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control form-control-sm"
                                v-model="form.booth"
                                :class="{
                                    'is-invalid': errors.booth,
                                }"
                                :disabled="isLoading"
                                placeholder="Enter booth"
                            />

                            <div v-if="errors.booth" class="invalid-feedback">
                                {{ getError(errors.booth) }}
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-sm btn-secondary"
                            @click="close"
                            :disabled="isLoading"
                        >
                            Cancel
                        </button>

                        <button
                            type="button"
                            class="btn btn-sm btn-warning text-white"
                            @click="save"
                            :disabled="isLoading"
                        >
                            <span
                                v-if="isLoading"
                                class="spinner-border spinner-border-sm me-1"
                                role="status"
                            ></span>

                            {{ isEdit ? "Update Group" : "Save Group" }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div v-if="show" class="modal-backdrop fade show" @click="close"></div>
    </div>
</template>

<script>
import Multiselect from "vue-multiselect";

import "vue-multiselect/dist/vue-multiselect.min.css";

import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

Vue.use(VueToast);

export default {
    name: "BoothSystemAssignmentGroupForm",

    components: {
        Multiselect,
    },

    props: {
        show: {
            type: Boolean,
            default: false,
        },

        assignment: {
            type: Object,
            required: true,
        },

        group: {
            type: Object,
            default: null,
        },
    },

    data() {
        return {
            suppliers: [],

            selectedSuppliers: [],

            isLoading: false,

            loadingSuppliers: false,

            errors: {},

            form: {
                booth: "",
            },

            supplierInfo: null,
        };
    },

    computed: {
        isEdit() {
            return !!this.group;
        },
    },

    watch: {
        show(value) {
            if (value) {
                this.initializeForm();
            }
        },

        group() {
            if (this.show) {
                this.initializeForm();
            }
        },
    },

    methods: {
        /*
        |--------------------------------------------------------------------------
        | Initialize
        |--------------------------------------------------------------------------
        */

        initializeForm() {
            this.errors = {};

            this.supplierInfo = null;

            this.selectedSuppliers = [];

            this.form = {
                booth: this.group ? this.group.booth || "" : "",
            };

            this.getSuppliers();
        },

        /*
        |--------------------------------------------------------------------------
        | Get Suppliers
        |--------------------------------------------------------------------------
        */

        getSuppliers() {
            this.loadingSuppliers = true;

            this.suppliers = [];

            axios
                .get(
                    `/admin/booth-system/assignments/${this.assignment.id}/groups/suppliers`
                )
                .then((response) => {
                    this.suppliers = response.data.suppliers || [];

                    /*
                    |--------------------------------------------------------------------------
                    | Edit Mode
                    |--------------------------------------------------------------------------
                    */

                    if (this.isEdit && this.group && this.group.exhibitor_id) {
                        const supplier = this.suppliers.find(
                            (supplier) =>
                                String(supplier.uid) ===
                                String(this.group.exhibitor_id)
                        );

                        if (supplier) {
                            this.selectedSuppliers = [supplier];
                        }
                    }
                })
                .catch((error) => {
                    console.error("Unable to load suppliers.", error);

                    Vue.$toast.error(
                        error.response?.data?.message ||
                            "Failed to load suppliers.",
                        {
                            position: "top-right",
                        }
                    );
                })
                .finally(() => {
                    this.loadingSuppliers = false;
                });
        },

        /*
        |--------------------------------------------------------------------------
        | Remove Supplier
        |--------------------------------------------------------------------------
        */

        removeSupplier(supplier) {
            this.selectedSuppliers = this.selectedSuppliers.filter(
                (item) => String(item.uid) !== String(supplier.uid)
            );
        },

        /*
        |--------------------------------------------------------------------------
        | Get Supplier Information
        |--------------------------------------------------------------------------
        */

        getSupplierInfo(supplierId) {
            if (!supplierId) {
                this.supplierInfo = null;

                return;
            }

            axios
                .get(
                    `/admin/registration/supplier-information/${supplierId}/${this.assignment.fair_code}`
                )
                .then((response) => {
                    this.supplierInfo = response.data.exhibitor || null;

                    console.log("Supplier information:", response.data);
                })
                .catch((error) => {
                    console.error(
                        "Unable to fetch supplier information.",
                        error
                    );
                });
        },

        /*
        |--------------------------------------------------------------------------
        | Supplier Display Name
        |--------------------------------------------------------------------------
        */

        supplierDisplayName(supplier) {
            return supplier.co_name;
        },

        /*
        |--------------------------------------------------------------------------
        | Validation Error
        |--------------------------------------------------------------------------
        */

        getError(error) {
            if (Array.isArray(error)) {
                return error[0];
            }

            return error;
        },

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        save() {
            this.errors = {};

            /*
            |--------------------------------------------------------------------------
            | Validate Supplier
            |--------------------------------------------------------------------------
            */

            if (
                !this.selectedSuppliers ||
                this.selectedSuppliers.length === 0
            ) {
                this.errors.exhibitor_id =
                    "The supplier / exhibitor field is required.";
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Booth
            |--------------------------------------------------------------------------
            */

            if (!this.form.booth) {
                this.errors.booth = "The booth field is required.";
            }

            if (Object.keys(this.errors).length > 0) {
                return;
            }

            this.isLoading = true;

            /*
            |--------------------------------------------------------------------------
            | Selected Supplier IDs
            |--------------------------------------------------------------------------
            */

            const exhibitorIds = this.selectedSuppliers.map(
                (supplier) => supplier.uid
            );

            /*
            |--------------------------------------------------------------------------
            | Payload
            |--------------------------------------------------------------------------
            */

            const payload = {
                exhibitor_ids: exhibitorIds,

                suppliers: this.selectedSuppliers.map((supplier) => ({
                    uid: supplier.uid,

                    classification: supplier.classification || "EXB",
                    name: supplier.co_name,

                    booth_name: supplier.fascia_name,

                    booth_name_length: supplier.booth_name
                        ? supplier.booth_name.length
                        : supplier.fascia_name
                        ? supplier.fascia_name.length
                        : null,

                    booth_type: supplier.booth_type || "",

                    hall_name: supplier.hall_name || "",
                })),

                booth: this.form.booth,
            };

            let request;

            /*
            |--------------------------------------------------------------------------
            | UPDATE
            |--------------------------------------------------------------------------
            */

            if (this.isEdit) {
                const supplier = this.selectedSuppliers[0];

                payload.exhibitor_id = supplier.uid;

                payload.classification = supplier.classification || "EXB";

                payload.booth_name =
                    supplier.booth_name || supplier.fascia_name || "";

                payload.booth_name_length = payload.booth_name
                    ? payload.booth_name.length
                    : null;

                payload.booth_type = supplier.booth_type || "";

                payload.hall_name = supplier.hall_name || "";

                request = axios.put(
                    `/admin/booth-system/assignments/${this.assignment.id}/groups/${this.group.id}`,
                    payload
                );
            } else {
                /*
                |--------------------------------------------------------------------------
                | CREATE
                |--------------------------------------------------------------------------
                */

                request = axios.post(
                    `/admin/booth-system/assignments/${this.assignment.id}/groups`,
                    payload
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Request
            |--------------------------------------------------------------------------
            */

            request
                .then((response) => {
                    if (response.data.success) {
                        Vue.$toast.success(
                            this.isEdit
                                ? "Assignment group successfully updated."
                                : "Assignment group successfully created.",
                            {
                                position: "top-right",
                            }
                        );

                        this.$emit("saved", response.data);

                        this.close();
                    }
                })
                .catch((error) => {
                    /*
                    |--------------------------------------------------------------------------
                    | Validation
                    |--------------------------------------------------------------------------
                    */

                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors || {};

                        return;
                    }

                    Vue.$toast.error(
                        error.response?.data?.message ||
                            "Failed to save assignment group.",
                        {
                            position: "top-right",
                        }
                    );
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        /*
        |--------------------------------------------------------------------------
        | Close
        |--------------------------------------------------------------------------
        */

        close() {
            if (this.isLoading) {
                return;
            }

            this.$emit("close");
        },
    },
};
</script>

<style scoped>
.modal {
    background: rgba(0, 0, 0, 0.2);
}

.modal-backdrop {
    z-index: 1040;
}

.modal {
    z-index: 1050;
}

.modal-content {
    border-radius: 0.35rem;
}

/*
|--------------------------------------------------------------------------
| Multiselect
|--------------------------------------------------------------------------
*/

.multiselect {
    min-height: 31px;
}

.multiselect__tags {
    min-height: 31px;
    padding: 5px 40px 5px 8px;
    border-radius: 0.25rem;
    border-color: #ced4da;
}

.multiselect__input {
    font-size: 0.875rem;
}

.multiselect__single {
    font-size: 0.875rem;
}

.multiselect__placeholder {
    padding-top: 2px;
    color: #6c757d;
}

/*
|--------------------------------------------------------------------------
| Selected Capsules
|--------------------------------------------------------------------------
*/

.multiselect__tag {
    display: inline-flex;
    align-items: center;
    max-width: 100%;
    margin-right: 5px;
    margin-bottom: 3px;
    padding: 4px 28px 4px 8px;
    border-radius: 999px;
    font-size: 0.75rem;
    line-height: 1.3;
    position: relative;
}

.multiselect__tag-icon {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    cursor: pointer;
    border-radius: 50%;
}

.multiselect__tag-icon:after {
    content: "×";
    font-size: 16px;
    line-height: 18px;
}

.multiselect__tag-icon:hover {
    background: rgba(0, 0, 0, 0.15);
}

.multiselect.is-invalid .multiselect__tags {
    border-color: #dc3545;
}

/*
|--------------------------------------------------------------------------
| Dropdown
|--------------------------------------------------------------------------
*/

.supplier-option {
    padding: 2px 0;
}
</style>
