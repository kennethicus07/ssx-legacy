<template>
    <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="mdi mdi-office-building me-2 text-success"></i>

                Company Information
            </h5>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="text-muted small"> Company Name </label>

                    <div class="fw-bold">
                        {{ conference.company_name }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted small"> Contact Person </label>

                    <div class="fw-bold">
                        {{ conference.contact_person_salutation }}
                        {{ conference.contact_person }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted small"> Company Email </label>

                    <div class="fw-bold">
                        {{ conference.company_email }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="text-muted small"> Contact Number </label>

                    <div class="fw-bold">
                        {{ conference.contact_number }}
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label class="text-muted small"> Company Address </label>

                    <div class="fw-bold">
                        {{ conference.company_address }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="text-muted small"> TIN </label>

                    <div class="fw-bold">
                        {{ conference.tin }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CompanyInformation",

    props: {
        conference: {
            type: Object,
            required: true,
        },
    },
};
</script>
