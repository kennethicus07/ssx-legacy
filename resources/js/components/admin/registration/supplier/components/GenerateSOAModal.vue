<template>
    <div v-if="visible">
        <!-- MODAL -->
        <div class="modal fade show" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <h5 class="modal-title">Mark SOA Status</h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="close"
                        ></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body">
                        <p class="mb-2">
                            Update SOA status for the following companies:
                        </p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Current SOA Status</th>
                                    <th>Mark As</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(c, index) in companiesWithStatus"
                                    :key="c.id"
                                >
                                    <td>{{ c.co_name }}</td>
                                    <td>
                                        <span
                                            :class="
                                                statusBadgeClass(
                                                    c.is_soa_generated
                                                )
                                            "
                                        >
                                            {{
                                                c.is_soa_generated
                                                    ? "SOA Generated"
                                                    : "SOA Not Generated"
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <select
                                            v-model="c.new_status"
                                            class="form-select form-select-sm"
                                        >
                                            <option :value="1">
                                                SOA Generated
                                            </option>
                                            <option :value="0">
                                                SOA Not Generated
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" @click="close">
                            Cancel
                        </button>

                        <button
                            class="btn btn-primary btn-sm"
                            :disabled="loading"
                            @click="submit"
                        >
                            <span v-if="loading">Updating...</span>
                            <span v-else>Update SOA Status</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- BACKDROP -->
        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
export default {
    name: "GenerateSOAModal",

    props: {
        value: Boolean,
        companies: {
            type: Array,
            required: true, // should be objects { id, co_name, is_soa_generated }
        },
    },

    data() {
        return {
            loading: false,
            companiesWithStatus: [],
        };
    },

    computed: {
        visible: {
            get() {
                return this.value;
            },
            set(val) {
                this.$emit("input", val);
            },
        },
    },

    watch: {
        value(newVal) {
            if (newVal) {
                // Reset loading
                this.loading = false;

                // Initialize local copy with current SOA status and new_status field
                this.companiesWithStatus = this.companies.map((c) => ({
                    ...c,
                    new_status: c.is_soa_generated ? 0 : 1, // default to current
                }));
            }
        },
    },

    methods: {
        close() {
            this.visible = false;
        },

        submit() {
            const updates = this.companiesWithStatus.map((c) => ({
                id: c.id,
                new_status: c.new_status,
            }));

            this.loading = true;

            this.$emit("submit", {
                updates, // array of { id, new_status }
                done: () => {
                    this.loading = false;
                },
            });
        },

        statusBadgeClass(status) {
            return status ? "badge bg-success" : "badge bg-secondary";
        },
    },
};
</script>

<style scoped>
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
}

.modal.fade.show {
    display: block;
    z-index: 1050;
}
</style>
