<template>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="mdi mdi-information-outline me-2 text-success"></i>

                Additional Information
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Currency -->
                <div class="col-md-3 mb-3">
                    <label class="text-muted small">Currency</label>

                    <div class="fw-bold">
                        {{ conference.currency }}
                    </div>
                </div>

                <!-- Certificate -->
                <div class="col-md-3 mb-3">
                    <label class="text-muted small">Certificate</label>

                    <div class="fw-bold">
                        {{ conference.certificate || "-" }}
                    </div>
                </div>

                <!-- Promotional Email -->
                <div class="col-md-3 mb-3">
                    <label class="text-muted small">Promotional Email</label>

                    <div>
                        <span
                            class="badge"
                            :class="
                                conference.promotional_email === 'Yes'
                                    ? 'bg-success'
                                    : 'bg-secondary'
                            "
                        >
                            {{ conference.promotional_email || "-" }}
                        </span>
                    </div>
                </div>

                <!-- Billing File -->
                <div class="col-md-3 mb-3">
                    <label class="text-muted small">Billing File</label>

                    <div>
                        <a
                            v-if="conference.billing_file"
                            :href="`/conference/billing/${conference.billing_file}`"
                            target="_blank"
                            class="btn btn-sm btn-outline-success"
                        >
                            <i class="mdi mdi-download me-1"></i>
                            Download
                        </a>

                        <span v-else class="text-muted">
                            No file uploaded
                        </span>
                    </div>
                </div>

                <!-- Promotion -->
                <div class="col-12">
                    <hr />

                    <label class="text-muted small d-block mb-2">
                        How did you know about the conference?
                    </label>

                    <div
                        v-if="
                            conference.conference_knowhow &&
                            conference.conference_knowhow.length
                        "
                    >
                        <div
                            v-for="item in conference.conference_knowhow"
                            :key="item.id"
                            class="mb-1"
                        >
                            <i
                                class="mdi mdi-check-circle text-success me-2"
                            ></i>

                            {{
                                item.value === "Other" && item.know_how_other
                                    ? `${item.value}: ${item.know_how_other}`
                                    : item.value
                            }}
                        </div>
                    </div>

                    <div v-else class="text-muted">—</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AdditionalInformation",

    props: {
        conference: {
            type: Object,
            required: true,
        },
    },
};
</script>
