<template>
    <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="mdi mdi-clipboard-text me-2 text-success"></i>

                Registration Summary
            </h5>
        </div>

        <div class="card-body">
            <table class="table table-borderless table-sm mb-0">
                <tbody>
                    <tr>
                        <th width="45%">Registration No.</th>

                        <td>
                            {{ conference.registration_number }}
                        </td>
                    </tr>

                    <tr>
                        <th>Event</th>

                        <td>
                            {{ conference.fair_code }}
                        </td>
                    </tr>

                    <tr>
                        <th>Business Type</th>

                        <td class="text-capitalize">
                            {{ conference.business_type }}
                        </td>
                    </tr>

                    <tr>
                        <th>Delegates</th>

                        <td>
                            {{
                                conference.conference_delegates.filter(
                                    (delegate) => !delegate.is_visitor_buyer
                                ).length
                            }}
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>

                        <td>
                            <span
                                v-if="conference.status == 2"
                                class="badge bg-success"
                            >
                                Registered
                            </span>

                            <span
                                v-else-if="conference.status == 1"
                                class="badge bg-warning"
                            >
                                Pending
                            </span>

                            <span v-else class="badge bg-secondary">
                                Draft
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Created</th>

                        <td>
                            {{ conference.created_at | moment("llll") }}
                        </td>
                    </tr>

                    <tr>
                        <th>Updated</th>

                        <td>
                            {{ conference.updated_at | moment("llll") }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "RegistrationSummary",

    props: {
        conference: {
            type: Object,
            required: true,
        },
    },
};
</script>
