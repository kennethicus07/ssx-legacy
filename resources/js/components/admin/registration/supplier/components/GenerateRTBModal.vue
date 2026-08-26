<template>
    <div v-if="visible">
        <!-- MODAL -->
        <div class="modal fade show" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <!-- HEADER -->
                    <div class="modal-header">
                        <h5 class="modal-title">Generate RTB</h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="close"
                        ></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body">
                        <p class="mb-2">Generate RTB for:</p>
                        <ul class="mb-3">
                            <li v-for="c in companies" :key="c">{{ c }}</li>
                        </ul>

                        <div class="mb-3">
                            <label class="form-label">Event</label>
                            <select v-model="selectedEvent" class="form-select">
                                <option
                                    v-for="event in events"
                                    :key="event.label"
                                    :value="event"
                                >
                                    {{ event.label }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" @click="close">
                            Cancel
                        </button>

                        <button
                            class="btn btn-success btn-sm"
                            :disabled="loading"
                            @click="submit"
                        >
                            <span v-if="loading">Generating...</span>
                            <span v-else>Generate</span>
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
    name: "GenerateRTBModal",

    props: {
        value: Boolean,
        companies: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            selectedEvent: null,
            loading: false,
            events: [
                {
                    label: "IFEX ft SSX @ WTCMM, 21-23 May 2026",
                    venue: "World Trade Center Metro Manila",
                    event_date: "21-23 May 2026",
                },
                {
                    label: "SSX @ PTTC, 15-17 Oct 2026",
                    venue: "PTTC",
                    event_date: "15-17 October 2026",
                },
            ],
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
                this.selectedEvent = this.events[0]; // default
                this.loading = false;
            }
        },
    },

    methods: {
        close() {
            this.visible = false;
        },

        submit() {
            if (!this.selectedEvent) return;

            this.loading = true;

            this.$emit("submit", {
                venue: this.selectedEvent.venue,
                event_date: this.selectedEvent.event_date,
                done: () => {
                    this.loading = false;
                },
            });
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
