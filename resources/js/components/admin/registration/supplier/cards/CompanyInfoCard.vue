<!-- Company information Card -->
<template>
    <div class="card shadow-sm">
        <!-- <div class="card-header bg-primary text-white">Company Information</div> -->
        <div class="card-body">
            <div class="tab-pane active" id="company_info" role="tabpanel">
                <div class="row g-3">
                    <div class="mb-4">
                        <!-- New Supplier/Exhibitor -->
                        <div class="form-check mb-2">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="exhibitor_type_new"
                                :value="1"
                                v-model="company_info.exhibitor_type"
                            />

                            <label
                                class="form-check-label"
                                for="exhibitor_type_new"
                            >
                                <span class="form-label text-uppercase fw-bold"
                                    >New Supplier/Exhibitor</span
                                >
                            </label>

                            <div class=" ">
                                (First time participant/Under new company name)
                            </div>
                        </div>

                        <!-- Returning Supplier/Exhibitor -->
                        <div class="form-check mb-1">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="exhibitor_type_returning"
                                :value="2"
                                v-model="company_info.exhibitor_type"
                            />

                            <label
                                class="form-check-label"
                                for="exhibitor_type_returning"
                            >
                                <span class="form-label text-uppercase fw-bold"
                                    >Returning Supplier/Exhibitor</span
                                >
                            </label>
                            <!-- Year -->
                            <div class="d-flex align-items-center">
                                <label
                                    for="last_participated"
                                    class="me-2 mb-0"
                                >
                                    Year last participated:
                                </label>

                                <input
                                    type="number"
                                    id="last_participated"
                                    v-model="company_info.last_participated"
                                    class="last-participated-input"
                                    min="1900"
                                    :max="new Date().getFullYear()"
                                    :disabled="
                                        Number(company_info.exhibitor_type) !==
                                        2
                                    "
                                />

                                <div v-if="validation.last_participated.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !validation.last_participated
                                                .required
                                        "
                                    >
                                        Year last participated is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label
                            for="fascia_name"
                            class="form-label text-uppercase fw-bold"
                        >
                            Name to appear on Fascia*
                        </label>

                        <input
                            type="text"
                            class="form-control text-capitalize"
                            id="fascia_name"
                            v-model="company_info.fascia_name"
                            v-limit="{ max: 95 }"
                            :class="{
                                'is-invalid': validation.fascia_name.$error,
                            }"
                        />

                        <div v-if="validation.fascia_name.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.fascia_name.required"
                            >
                                Name to appear on Fascia is required.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label
                            for="co_name"
                            class="form-label text-uppercase fw-bold"
                            >Registered Business Name*</label
                        >
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            id="co_name"
                            v-model="company_info.co_name"
                            readonly
                        />
                    </div>
                    <!-- <div class="col-md-3">
                                <label
                                    for="event_id"
                                    class="form-label text-uppercase fw-bold"
                                    >Event ID</label
                                >
                                <input
                                    id="event_info_fair_code"
                                    v-model="event_info.fair_code"
                                    readonly
                                />
                            </div> -->

                    <div class="col-md-6">
                        <label
                            for="directory_name"
                            class="form-label text-uppercase fw-bold"
                        >
                            Brand Name*
                        </label>
                        <input
                            type="text"
                            class="form-control text-capitalize"
                            id="directory_name"
                            v-model="company_info.directory_name"
                            v-limit="{ max: 95 }"
                            :class="{
                                'is-invalid': validation.directory_name.$error,
                            }"
                        />
                        <div v-if="validation.directory_name.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.directory_name.required"
                            >
                                Directory name is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label
                            for="co_name"
                            class="form-label text-uppercase fw-bold"
                            >Brief Company Profile*</label
                        >
                        <textarea
                            class="form-control beige-bg"
                            rows="3"
                            v-model="company_info.co_details"
                            v-limit="{ max: 2000 }"
                            :class="{
                                'is-invalid': validation.co_details.$error,
                            }"
                        ></textarea>
                        <div v-if="validation.co_details.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.co_details.required"
                            >
                                Company description is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label
                            for="co_name"
                            class="form-label text-uppercase fw-bold"
                            >Mission Statement*</label
                        >
                        <textarea
                            class="form-control beige-bg"
                            rows="3"
                            v-model="company_info.mission"
                            v-limit="{ max: 1000 }"
                            :class="{
                                'is-invalid': validation.mission.$error,
                            }"
                        ></textarea>
                        <div class="form-text fs-12">
                            What are your business objectives? What is your
                            approach to reach those objectives?
                        </div>
                        <div v-if="validation.mission.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.mission.required"
                            >
                                Mission statement is required.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label
                            for="co_name"
                            class="form-label text-uppercase fw-bold"
                            >Environmental/ Sustainability Projects &
                            Programs</label
                        >
                        <textarea
                            class="form-control beige-bg"
                            rows="3"
                            v-model="company_info.env_conservation"
                            v-limit="{ max: 1000 }"
                        ></textarea>
                        <div class="form-text fs-12">
                            Do you have any projects or programs related to the
                            environment? Please provide a brief description for
                            each initiative and mention the community/ies you
                            are helping.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label
                                    for="country_code"
                                    class="form-label text-uppercase fw-bold"
                                    >Phone Number*</label
                                >
                                <select
                                    class="form-select"
                                    id="country_code"
                                    v-model="company_info.country_code"
                                    :class="{
                                        'is-invalid':
                                            validation.country_code.$error,
                                    }"
                                >
                                    <option :value="''">Country code</option>
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :value="country.dial"
                                    >
                                        {{ country.iso3 }} ({{ country.dial }})
                                    </option>
                                </select>
                                <div v-if="validation.country_code.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.country_code.required"
                                    >
                                        Country code is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label
                                    for="area_code"
                                    class="form-label text-uppercase fw-bold"
                                    >&nbsp;</label
                                >
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control"
                                    id="area_code"
                                    placeholder="Area code"
                                    v-model="company_info.area_code"
                                    v-limit="{ max: 5, numeric: true }"
                                    :class="{
                                        'is-invalid':
                                            validation.area_code.$error,
                                    }"
                                />
                                <div v-if="validation.area_code.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.area_code.required"
                                    >
                                        Area code is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.area_code.numeric"
                                    >
                                        Area code must be numeric.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label
                                    for="phone_no"
                                    class="form-label text-uppercase fw-bold"
                                    >&nbsp;</label
                                >
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control"
                                    id="phone_no"
                                    placeholder="Phone number"
                                    v-model="company_info.phone_no"
                                    v-limit="{ max: 12, numeric: true }"
                                    :class="{
                                        'is-invalid':
                                            validation.phone_no.$error,
                                    }"
                                />
                                <div v-if="validation.phone_no.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.phone_no.required"
                                    >
                                        Phone no. is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label
                                    for="country_code_mobile"
                                    class="form-label text-uppercase fw-bold"
                                    >Mobile Number*</label
                                >
                                <select
                                    class="form-select"
                                    id="country_code_mobile"
                                    v-model="company_info.country_code_mobile"
                                    :class="{
                                        'is-invalid':
                                            validation.country_code_mobile
                                                .$error,
                                    }"
                                >
                                    <option :value="''">Country code</option>
                                    <option
                                        v-for="country in countries"
                                        :key="country.id"
                                        :value="country.dial"
                                    >
                                        {{ country.iso3 }} ({{ country.dial }})
                                    </option>
                                </select>
                                <div
                                    v-if="validation.country_code_mobile.$error"
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !validation.country_code_mobile
                                                .required
                                        "
                                    >
                                        Country code is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label for="mobile_no" class="form-label"
                                    >&nbsp;</label
                                >
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control"
                                    id="mobile_no"
                                    placeholder="Mobile number"
                                    v-model="company_info.mobile_no"
                                    :class="{
                                        'is-invalid':
                                            validation.mobile_no.$error,
                                    }"
                                    v-limit="{ max: 12, numeric: true }"
                                />
                                <div v-if="validation.mobile_no.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!validation.mobile_no.required"
                                    >
                                        Mobile no. is required.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label
                            for="website"
                            class="form-label text-uppercase fw-bold"
                            >Website</label
                        >
                        <input
                            type="text"
                            class="form-control text-lowercase"
                            id="website"
                            v-model="company_info.website"
                            v-limit="{ max: 200 }"
                            placeholder="Enter your website link"
                        />
                        <div v-if="validation.website.$error">
                            <!-- <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.prod_info.store_url.required"
                                    >
                                        Online store link is required.
                                    </div> -->
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.website.url"
                            >
                                Invalid website link
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-uppercase fw-bold"
                            >Company Email Address*</label
                        >
                        <input
                            type="text"
                            class="form-control text-lowercase"
                            v-model="company_info.co_email"
                            readonly
                        />
                    </div>
                    <div class="col-12">
                        <label class="form-label text-uppercase fw-bold"
                            >Company Masthead*<i
                                class="mdi mdi-information ms-1 text-muted"
                                v-tooltip="
                                    'Upload a 1440px x 536px hi-resolution JPG/PNG max 1MB.'
                                "
                                style="cursor: pointer"
                            ></i
                        ></label>
                        <VueFileAgent
                            ref="vueFileAgentMasthead"
                            :multiple="false"
                            :deletable="true"
                            :linkable="true"
                            :meta="true"
                            :accept="'image/*'"
                            :maxSize="'1MB'"
                            :maxFiles="1"
                            v-model="company_info.masthead"
                            @beforedelete="onBeforeDeleteMasthead($event)"
                            @select="onSelectMasthead($event)"
                        ></VueFileAgent>
                        <div class="form-text">
                            Upload (1440px x 536px) hi-resolution jpg or png
                            file; max of 1MB only
                        </div>
                        <div v-if="validation.masthead.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.masthead.required"
                            >
                                Please upload a company masthead.
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-uppercase fw-bold"
                            >Company Logo*</label
                        >
                        <VueFileAgent
                            ref="vueFileAgentCompanyLogo"
                            :multiple="false"
                            :deletable="true"
                            :linkable="true"
                            :meta="true"
                            :accept="'image/*'"
                            :maxSize="'1MB'"
                            :maxFiles="1"
                            v-model="company_info.co_logo"
                            @beforedelete="onBeforeDeleteLogo($event)"
                            @select="onSelectLogo($event)"
                        ></VueFileAgent>
                        <div class="form-text">
                            Upload (300px x 300px) hi-resolution jpg or png
                            file; max of 1MB only
                        </div>
                        <div v-if="validation.co_logo.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.co_logo.required"
                            >
                                Please upload a company logo.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <h4>Corporate Social Media Account</h4>
                    </div>
                    <div class="col-md-6">
                        <label
                            for="facebook"
                            class="form-label text-uppercase fw-bold"
                            >Facebook</label
                        >
                        <div class="input-group">
                            <span class="input-group-text text-dark"
                                >https://www.facebook.com/</span
                            >
                            <input
                                type="text"
                                class="form-control text-lowercase"
                                v-model="company_info.facebook"
                                v-limit="{ max: 195 }"
                                placeholder="Username"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label
                            for="instagram"
                            class="form-label text-uppercase fw-bold"
                            >Twitter</label
                        >
                        <div class="input-group">
                            <span class="input-group-text text-dark"
                                >https://www.twitter.com/</span
                            >
                            <input
                                type="text"
                                class="form-control text-lowercase"
                                v-model="company_info.twitter"
                                v-limit="{ max: 195 }"
                                placeholder="Username"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label
                            for="instagram"
                            class="form-label text-uppercase fw-bold"
                            >Instagram</label
                        >
                        <div class="input-group">
                            <span class="input-group-text text-dark"
                                >https://www.instagram.com/</span
                            >
                            <input
                                type="text"
                                class="form-control text-lowercase"
                                v-model="company_info.instagram"
                                v-limit="{ max: 195 }"
                                placeholder="Username"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label
                            for="instagram"
                            class="form-label text-uppercase fw-bold"
                            >Linkedin</label
                        >
                        <div class="input-group">
                            <span class="input-group-text text-dark"
                                >https://www.linked.com/in/</span
                            >
                            <input
                                type="text"
                                class="form-control text-lowercase"
                                v-model="company_info.linkedin"
                                v-limit="{ max: 195 }"
                                placeholder="Username"
                            />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label
                            for="instagram"
                            class="form-label text-uppercase fw-bold"
                            >Others, please specify</label
                        >
                        <input
                            type="text"
                            class="form-control text-lowercase"
                            v-model="company_info.other_social"
                            :class="{
                                'is-invalid': validation.other_social.$error,
                            }"
                            v-limit="{ max: 195 }"
                            placeholder="weixin://dl/chat?username"
                        />
                        <div v-if="validation.other_social.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!validation.other_social.url"
                            >
                                Invalid website link
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12 mt-5">
                                        <h4>Main Office Address</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Country*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="company_info.moa_country"
                                            :class="{
                                                'is-invalid':
                                                    validation.moa_country
                                                        .$error,
                                            }"
                                        >
                                            <option :value="''">
                                                -- Select --
                                            </option>
                                            <option
                                                v-for="country in countries"
                                                :key="country.id"
                                                :value="country.id"
                                            >
                                                {{ country.name }}
                                            </option>
                                        </select>
                                        <div
                                            v-if="validation.moa_country.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_country
                                                        .required
                                                "
                                            >
                                                Country is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            v-if="
                                                company_info.moa_country === 148
                                            "
                                            >No. and Street/Road*</label
                                        >
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            v-else
                                            >No. and Street/Road</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            v-model="company_info.moa_street"
                                            v-limit="{ max: 195 }"
                                            :class="{
                                                'is-invalid':
                                                    validation.moa_street
                                                        .$error,
                                            }"
                                        />
                                        <div
                                            v-if="validation.moa_street.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_street
                                                        .required
                                                "
                                            >
                                                Street is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >City/Town*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    validation.moa_city.$error,
                                            }"
                                            v-model="company_info.moa_city"
                                            v-limit="{ max: 95 }"
                                        />
                                        <div v-if="validation.moa_city.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_city
                                                        .required
                                                "
                                            >
                                                City/Town is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Province/State*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    validation.moa_state.$error,
                                            }"
                                            v-model="company_info.moa_state"
                                            v-limit="{ max: 95 }"
                                        />
                                        <div v-if="validation.moa_state.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_state
                                                        .required
                                                "
                                            >
                                                Province/State is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-6"
                                        v-show="
                                            company_info.moa_country === 148
                                        "
                                    >
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Region*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="company_info.moa_region"
                                            :class="{
                                                'is-invalid':
                                                    validation.moa_region
                                                        .$error,
                                            }"
                                        >
                                            <option selected :value="''">
                                                -- Region --
                                            </option>
                                            <option
                                                v-for="region in regions"
                                                :key="region.id"
                                                :value="region.name"
                                            >
                                                {{ region.name }}
                                            </option>
                                        </select>
                                        <div
                                            v-if="validation.moa_region.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_region
                                                        .required
                                                "
                                            >
                                                Region is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Zipcode*</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control"
                                            v-model="company_info.moa_zipcode"
                                            :class="{
                                                'is-invalid':
                                                    validation.moa_zipcode
                                                        .$error,
                                            }"
                                            v-limit="{ max: 15, numeric: true }"
                                        />
                                        <div
                                            v-if="validation.moa_zipcode.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_zipcode
                                                        .required
                                                "
                                            >
                                                Zipcode is required.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.moa_zipcode
                                                        .numneric
                                                "
                                            >
                                                Invalid zipcode.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12 mt-5">
                                        <h4>Factory Address</h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                :value="1"
                                                v-model="
                                                    company_info.same_as_moa
                                                "
                                                id="same_as_moa"
                                                @change="doSameAsMoa"
                                                :disabled="check_moa_address"
                                            />
                                            <label
                                                class="form-check-label text-uppercase fw-bold"
                                                for="same_as_moa"
                                            >
                                                Same as Main Office Address
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Country*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="company_info.fa_country"
                                            :class="{
                                                'is-invalid':
                                                    validation.fa_country
                                                        .$error,
                                            }"
                                            @change="onChangeFaCountry"
                                            :disabled="disabled_fa"
                                        >
                                            <option :value="''">
                                                -- Select --
                                            </option>
                                            <option
                                                v-for="country in countries"
                                                :key="country.id"
                                                :value="country.id"
                                            >
                                                {{ country.name }}
                                            </option>
                                        </select>
                                        <div
                                            v-if="validation.fa_country.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_country
                                                        .required
                                                "
                                            >
                                                Country is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            v-if="
                                                company_info.fa_country === 148
                                            "
                                            >NO. AND STREET/ROAD*</label
                                        >
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            v-else
                                            >NO. AND STREET/ROAD</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    validation.fa_street.$error,
                                            }"
                                            v-model="company_info.fa_street"
                                            v-limit="{ max: 195 }"
                                            :disabled="disabled_fa"
                                        />
                                        <div v-if="validation.fa_street.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_street
                                                        .required
                                                "
                                            >
                                                Street is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >City/Town*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    validation.fa_city.$error,
                                            }"
                                            v-model="company_info.fa_city"
                                            v-limit="{ max: 95 }"
                                            :disabled="disabled_fa"
                                        />
                                        <div v-if="validation.fa_city.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_city.required
                                                "
                                            >
                                                City/Town is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Province/State*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    validation.fa_state.$error,
                                            }"
                                            v-model="company_info.fa_state"
                                            v-limit="{ max: 95 }"
                                            :disabled="disabled_fa"
                                        />
                                        <div v-if="validation.fa_state.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_state
                                                        .required
                                                "
                                            >
                                                Province/State is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="col-6"
                                        v-show="company_info.fa_country === 148"
                                    >
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Region*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="company_info.fa_region"
                                            :class="{
                                                'is-invalid':
                                                    validation.fa_region.$error,
                                            }"
                                            :disabled="disabled_fa"
                                        >
                                            <option selected :value="''">
                                                -- Region --
                                            </option>
                                            <option
                                                v-for="region in regions"
                                                :key="region.id"
                                                :value="region.name"
                                            >
                                                {{ region.name }}
                                            </option>
                                        </select>
                                        <div v-if="validation.fa_region.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_region
                                                        .required
                                                "
                                            >
                                                Region is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Zipcode*</label
                                        >
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    validation.fa_zipcode
                                                        .$error,
                                            }"
                                            v-model="company_info.fa_zipcode"
                                            v-limit="{
                                                max: 15,
                                                numeric: true,
                                            }"
                                            :disabled="disabled_fa"
                                        />
                                        <div
                                            v-if="validation.fa_zipcode.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_zipcode
                                                        .required
                                                "
                                            >
                                                Zipcode is required.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !validation.fa_zipcode
                                                        .numneric
                                                "
                                            >
                                                Invalid zipcode.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "CompanyInfoCard",
    props: {
        company_info: {
            type: Object,
            required: true,
        },
        countries: {
            type: Array,
            default: () => [],
        },
        regions: {
            type: Array,
            default: () => [],
        },
        disabled_fa: {
            type: Boolean,
            default: false,
        },
        check_moa_address: {
            type: Boolean,
            default: false,
        },
        validation: { type: Object, required: true },
    },
    emits: ["same-as-moa-changed"],
    methods: {
        onSelectMasthead(file) {
            this.company_info.masthead_selected = file[0].file;
        },
        onSelectLogo(file) {
            this.company_info.co_logo_selected = file[0].file;
        },
        onBeforeDeleteMasthead(fileRecord) {
            this.$refs.vueFileAgentMasthead.deleteFileRecord(fileRecord);
        },
        onBeforeDeleteLogo(fileRecord) {
            this.$refs.vueFileAgentCompanyLogo.deleteFileRecord(fileRecord);
        },
        doSameAsMoa(e) {
            const isChecked = e.target.checked;
            this.$emit("same-as-moa-changed", isChecked); // notify parent

            if (isChecked) {
                this.company_info.fa_country = this.company_info.moa_country;
                this.company_info.fa_state = this.company_info.moa_state;
                this.company_info.fa_city = this.company_info.moa_city;
                this.company_info.fa_zipcode = this.company_info.moa_zipcode;
                this.company_info.fa_region = this.company_info.moa_region;
                this.company_info.fa_street = this.company_info.moa_street;
            } else {
                this.company_info.fa_country = "";
                this.company_info.fa_state = "";
                this.company_info.fa_city = "";
                this.company_info.fa_zipcode = "";
                this.company_info.fa_region = "";
                this.company_info.fa_street = "";
            }
        },
    },
};
</script>
