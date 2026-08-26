<template>
    <div class="section container registration-form" id="regDiv">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <form-wizard
            title=""
            subtitle=""
            color="#9daa39"
            errorColor="#dc3545"
            stepSize="xs"
            :startIndex="0"
            finish-button-text="Confirm & Submit"
            @on-loading="onLoad"
            @on-complete="onComplete"
            @on-change="onTabChange"
        >
            <tab-content title="Information" :before-change="doStep1">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Company Information</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
                            <div class="mb-4">
                                <!-- New Supplier/Exhibitor -->
                                <div class="form-check mb-2">
                                    <input
                                    class="form-check-input"
                                    type="radio"
                                    id="exhibitor_type_new"
                                    :value="1"
                                    v-model="step1.exhibitor_type"
                                    />

                                    <label
                                    class="form-check-label"
                                    for="exhibitor_type_new"
                                    >
                                    <span class="form-label text-uppercase fw-bold">New Supplier/Exhibitor</span>
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
                                    v-model="step1.exhibitor_type"
                                    />

                                    <label
                                    class="form-check-label"
                                    for="exhibitor_type_returning"
                                    >
                                    <span class="form-label text-uppercase fw-bold">Returning Supplier/Exhibitor</span>
                                    </label>
                                    <!-- Year -->
                                    <div class="d-flex align-items-center">
                                        <label
                                        for="last_participated"
                                        class=" me-2 mb-0"
                                        >
                                        Year last participated:
                                        </label>

                                    <input
                                        type="number"
                                        id="last_participated"
                                        v-model="step1.last_participated"
                                        class="last-participated-input"
                                        min="1900"
                                        :max="new Date().getFullYear()"
                                        :disabled="Number(step1.exhibitor_type) !== 2"
                                    />

                            <div v-if="$v.step1.last_participated.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!$v.step1.last_participated.required"
                                >
                                    Year last participated is required.
                                </div>
                            </div>
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
                                    v-model="step1.co_name"
                                    readonly
                                />
                            </div>

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
                                    v-model="step1.directory_name"
                                    v-limit="{ max: 95 }"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.directory_name.$error,
                                    }"
                                />
                                <div v-if="$v.step1.directory_name.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.directory_name.required"
                                    >
                                        Directory name is required.
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
                                    v-model="step1.fascia_name"
                                    v-limit="{ max: 95 }"
                                    :class="{
                                        'is-invalid': $v.step1.fascia_name.$error,
                                    }"
                                />

                                <div v-if="$v.step1.fascia_name.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.fascia_name.required"
                                    >
                                        Name to appear on Fascia is required.
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
                                    v-model="step1.co_details"
                                    v-limit="{ max: 2000 }"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.co_details.$error,
                                    }"
                                ></textarea>
                                <div v-if="$v.step1.co_details.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.co_details.required"
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
                                    v-model="step1.mission"
                                    v-limit="{ max: 1000 }"
                                    :class="{
                                        'is-invalid': $v.step1.mission.$error,
                                    }"
                                ></textarea>
                                <div class="form-text fs-12">
                                    What are your business objectives? What is
                                    your approach to reach those objectives?
                                </div>
                                <div v-if="$v.step1.mission.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.mission.required"
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
                                    Programs*</label
                                >
                                <textarea
                                    class="form-control beige-bg"
                                    rows="3"
                                    v-model="step1.env_conservation"
                                    v-limit="{ max: 1000 }"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.env_conservation.$error,
                                    }"
                                ></textarea>
                                <div class="form-text fs-12">
                                    Do you have any projects or programs related
                                    to the environment? Please provide a brief
                                    description for each initiative and mention
                                    the community/ies you are helping.
                                </div>
                                <div v-if="$v.step1.env_conservation.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step1.env_conservation.required
                                        "
                                    >
                                        Environmental/ Sustainability Projects &
                                        Programs is required.
                                    </div>
                                </div>
                            </div>
                            <!--  Phone Number -->
                            <div class="col-md-6">
                            <label
                            for="country_code"
                            class="form-label text-uppercase fw-bold"
                            >
                            Phone Number
                            </label>

                            <div class="row g-2">
                            <!-- Country Code -->
                            <div class="col-md-4">
                            <select
                            class="form-select"
                            id="country_code"
                            v-model="step1.country_code"
                            :class="{ 'is-invalid': $v.step1.country_code.$error }"
                            @blur="$v.step1.country_code.$touch()"
                            >
                            <option value="" disabled>
                            Country code
                            </option>
                            <option
                            v-for="country in countries"
                            :key="country.id"
                            :value="country.dial"
                            >
                            {{ country.iso3 }} ({{ country.dial }})
                            </option>
                            </select>

                            <div
                            v-if="$v.step1.country_code.$error"
                            class="fw-light invalid-feedback d-block"
                            >
                            Country code is required.
                            </div>
                            </div>

                            <!-- Area Code -->
                            <div class="col-md-4">
                            <input
                            type="text"
                            inputmode="numeric"
                            class="form-control"
                            id="area_code"
                            placeholder="Area code"
                            v-model="step1.area_code"
                            v-limit="{ max: 5, numeric: true }"
                            :class="{ 'is-invalid': $v.step1.area_code.$error }"
                            @blur="$v.step1.area_code.$touch()"
                            />

                            <div
                            v-if="$v.step1.area_code.$error"
                            class="fw-light invalid-feedback d-block"
                            >
                            <div v-if="!$v.step1.area_code.required">
                            Area code is required.
                            </div>
                            <div v-else-if="!$v.step1.area_code.numeric">
                            Area code must be numeric.
                            </div>
                            </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="col-md-4">
                            <input
                            type="text"
                            inputmode="numeric"
                            class="form-control"
                            id="phone_no"
                            placeholder="Phone number"
                            v-model="step1.phone_no"
                            v-limit="{ max: 12, numeric: true }"
                            :class="{ 'is-invalid': $v.step1.phone_no.$error }"
                            @blur="$v.step1.phone_no.$touch()"
                            />

                            <div
                            v-if="$v.step1.phone_no.$error"
                            class="fw-light invalid-feedback d-block"
                            >
                            Phone no. is required.
                            </div>
                            </div>
                            </div>
                            </div>
                            <!-- Mobile No -->
                            <div class="col-md-6">
                            <label
                            for="country_code_mobile"
                            class="form-label text-uppercase fw-bold"
                            >
                            Mobile Number*
                            </label>

                            <div class="row g-2">
                            <!-- Country Code -->
                            <div class="col-md-4">
                            <select
                            class="form-select"
                            id="country_code_mobile"
                            v-model="step1.country_code_mobile"
                            :class="{ 'is-invalid': $v.step1.country_code_mobile.$error }"
                            @blur="$v.step1.country_code_mobile.$touch()"
                            >
                            <option value="" disabled>
                            Country code
                            </option>
                            <option
                            v-for="country in countries"
                            :key="country.id"
                            :value="country.dial"
                            >
                            {{ country.iso3 }} ({{ country.dial }})
                            </option>
                            </select>

                            <div
                            v-if="$v.step1.country_code_mobile.$error"
                            class="fw-light invalid-feedback d-block"
                            >
                            Country code is required.
                            </div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="col-md-8">
                            <input
                            type="text"
                            inputmode="numeric"
                            class="form-control"
                            id="mobile_no"
                            placeholder="Mobile number"
                            v-model="step1.mobile_no"
                            v-limit="{ max: 12, numeric: true }"
                            :class="{ 'is-invalid': $v.step1.mobile_no.$error }"
                            @blur="$v.step1.mobile_no.$touch()"
                            />

                            <div
                            v-if="$v.step1.mobile_no.$error"
                            class="fw-light invalid-feedback d-block"
                            >
                            Mobile no. is required.
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
                                    v-model="step1.website"
                                    v-limit="{ max: 195 }"
                                    placeholder="Enter your website link"
                                    :class="{
                                        'is-invalid': $v.step1.website.$error,
                                    }"
                                />
                                <div v-if="$v.step1.website.$error">
                                    <!-- <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.prod_info.store_url.required"
                                    >
                                        Online store link is required.
                                    </div> -->
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.website.url"
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
                                    v-model="step1.co_email"
                                    readonly
                                />
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Company Masthead*
                                    <i
                                        class="mdi mdi-information ms-1 text-muted"
                                        v-tooltip="
                                            'The company masthead is your banner-style visual branding to ensure an accurate brand representation. Please upload the image here.'
                                        "
                                        style="cursor: pointer"
                                    ></i>
                                </label>
                                <VueFileAgent
                                    ref="vueFileAgentMasthead"
                                    :multiple="false"
                                    :deletable="true"
                                    :linkable="true"
                                    :meta="true"
                                    :accept="'image/*'"
                                    :maxSize="'1MB'"
                                    :maxFiles="1"
                                    v-model="step1.masthead"
                                    @beforedelete="onBeforeDelete($event, 10)"
                                    @select="onSelect($event, 10)"
                                ></VueFileAgent>
                                <div class="form-text">
                                    Upload (1440px x 536px) hi-resolution jpg or
                                    png file; max of 1MB only
                                </div>
                                <div v-if="$v.step1.masthead.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.masthead.required"
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
                                    v-model="step1.co_logo"
                                    @beforedelete="onBeforeDelete($event, 9)"
                                    @select="onSelect($event, 9)"
                                ></VueFileAgent>
                                <div class="form-text">
                                    Upload (300px x 300px) hi-resolution jpg or
                                    png file; max of 1MB only
                                </div>
                                <div v-if="$v.step1.co_logo.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.co_logo.required"
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
                                        v-model="step1.facebook"
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
                                        v-model="step1.twitter"
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
                                        v-model="step1.instagram"
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
                                        v-model="step1.linkedin"
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
                                    v-model="step1.other_social"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.other_social.$error,
                                    }"
                                    v-limit="{ max: 195 }"
                                    placeholder="weixin://dl/chat?username"
                                />
                                <div v-if="$v.step1.other_social.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step1.other_social.url"
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
                                                    >Country*</label Mandatory Fee
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="step1.moa_country"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.moa_country
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
                                                    v-if="
                                                        $v.step1.moa_country
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1
                                                                .moa_country
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
                                                        step1.moa_country ===
                                                        148
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
                                                    v-model="step1.moa_street"
                                                    v-limit="{ max: 195 }"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.moa_street
                                                                .$error,
                                                    }"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.moa_street
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.moa_street
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
                                                            $v.step1.moa_city
                                                                .$error,
                                                    }"
                                                    v-model="step1.moa_city"
                                                    v-limit="{ max: 95 }"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.moa_city.$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.moa_city
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
                                                            $v.step1.moa_state
                                                                .$error,
                                                    }"
                                                    v-model="step1.moa_state"
                                                    v-limit="{ max: 95 }"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.moa_state
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.moa_state
                                                                .required
                                                        "
                                                    >
                                                        Province/State is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-6"
                                                v-show="
                                                    step1.moa_country === 148
                                                "
                                            >
                                                <label
                                                    class="form-label text-uppercase fw-bold"
                                                    >Region*</label
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="step1.moa_region"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.moa_region
                                                                .$error,
                                                    }"
                                                >
                                                    <option
                                                        selected
                                                        :value="''"
                                                    >
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
                                                    v-if="
                                                        $v.step1.moa_region
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.moa_region
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
                                                    v-model="step1.moa_zipcode"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.moa_zipcode
                                                                .$error,
                                                    }"
                                                    v-limit="{
                                                        max: 15,
                                                        numeric: true,
                                                    }"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.moa_zipcode
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1
                                                                .moa_zipcode
                                                                .required
                                                        "
                                                    >
                                                        Zipcode is required.
                                                    </div>
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1
                                                                .moa_zipcode
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
                                                            step1.same_as_moa
                                                        "
                                                        id="same_as_moa"
                                                        @change="doSameAsMoa"
                                                        :disabled="
                                                            check_moa_address
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label text-uppercase fw-bold"
                                                        for="same_as_moa"
                                                    >
                                                        Same as Main Office
                                                        Address
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
                                                    v-model="step1.fa_country"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.fa_country
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
                                                    v-if="
                                                        $v.step1.fa_country
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_country
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
                                                    v-if="step1.fa_country"
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
                                                            $v.step1.fa_street
                                                                .$error,
                                                    }"
                                                    v-model="step1.fa_street"
                                                    v-limit="{ max: 195 }"
                                                    :disabled="disabled_fa"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.fa_street
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_street
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
                                                            $v.step1.fa_city
                                                                .$error,
                                                    }"
                                                    v-model="step1.fa_city"
                                                    v-limit="{ max: 95 }"
                                                    :disabled="disabled_fa"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.fa_city.$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_city
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
                                                            $v.step1.fa_state
                                                                .$error,
                                                    }"
                                                    v-model="step1.fa_state"
                                                    v-limit="{ max: 95 }"
                                                    :disabled="disabled_fa"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.fa_state.$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_state
                                                                .required
                                                        "
                                                    >
                                                        Province/State is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-6"
                                                v-show="
                                                    step1.fa_country === 148
                                                "
                                            >
                                                <label
                                                    class="form-label text-uppercase fw-bold"
                                                    >Region*</label
                                                >
                                                <select
                                                    class="form-select"
                                                    v-model="step1.fa_region"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.fa_region
                                                                .$error,
                                                    }"
                                                    :disabled="disabled_fa"
                                                >
                                                    <option
                                                        selected
                                                        :value="''"
                                                    >
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
                                                    v-if="
                                                        $v.step1.fa_region
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_region
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
                                                            $v.step1.fa_zipcode
                                                                .$error,
                                                    }"
                                                    v-model="step1.fa_zipcode"
                                                    v-limit="{
                                                        max: 15,
                                                        numeric: true,
                                                    }"
                                                    :disabled="disabled_fa"
                                                />
                                                <div
                                                    v-if="
                                                        $v.step1.fa_zipcode
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_zipcode
                                                                .required
                                                        "
                                                    >
                                                        Zipcode is required.
                                                    </div>
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step1.fa_zipcode
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
                    <div class="mb-5"></div>
                </div>
            </tab-content>
 <tab-content
    title="Product/Service Information"
    :before-change="doSaveProducts"
>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- =========================================================
                 PAGE HEADER
            ========================================================== -->
            <div class="text-left mb-3 mt-4">

                <h1 class="h3">
                    Product/Service Information
                </h1>

                <p>
                    *Required
                </p>

                <!-- General instruction -->
                <div
                    class="alert alert-info d-flex align-items-start gap-2 mb-0"
                    role="note"
                    aria-label="Product and service information"
                >
                    <i
                        class="fas fa-info-circle mt-1 flex-shrink-0"
                        aria-hidden="true"
                    ></i>

                    <div>
                        <strong>
                            Please add your products or services individually.
                        </strong>

                        <div>
                            If your company offers multiple products or
                            services, add each one separately using the
                            <strong>Add product/service</strong> button below.
                        </div>
                    </div>
                </div>

            </div>


            <!-- =========================================================
                 PRODUCT FORM
            ========================================================== -->
            <div class="row g-3">

                <!-- =====================================================
                     PRODUCT / SERVICE NAME
                ====================================================== -->
                <div class="col-md-12">

                    <label
                        class="form-label text-uppercase fw-bold"
                        for="prod_name"
                    >
                        Product/Service Name*
                    </label>

                    <input
                        id="prod_name"
                        type="text"
                        class="form-control text-capitalize"
                        :class="{
                            'is-invalid':
                                $v.prod_info.prod_name.$error,
                        }"
                        v-model="prod_info.prod_name"
                        v-limit="{ max: 95 }"
                    />

                    <div
                        v-if="$v.prod_info.prod_name.$error"
                    >
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="
                                !$v.prod_info.prod_name.required
                            "
                        >
                            Product name is required.
                        </div>
                    </div>

                </div>


                <!-- =====================================================
                     PRODUCT / SERVICE DESCRIPTION
                ====================================================== -->
                <div class="col-md-12">

                    <label
                        class="form-label text-uppercase fw-bold"
                        for="prod_details"
                    >
                        Brief Product/Service Description*
                    </label>

                    <textarea
                        id="prod_details"
                        class="form-control beige-bg"
                        rows="3"
                        v-model="prod_info.prod_details"
                        v-limit="{ max: 500 }"
                        :class="{
                            'is-invalid':
                                $v.prod_info.prod_details.$error,
                        }"
                    ></textarea>

                    <div
                        v-if="$v.prod_info.prod_details.$error"
                    >
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="
                                !$v.prod_info.prod_details.required
                            "
                        >
                            Product description is required.
                        </div>
                    </div>

                </div>


                <!-- =====================================================
                     PRODUCT / SERVICE PHOTOS
                ====================================================== -->
                <div class="col-12">

                    <label
                        class="form-label text-uppercase fw-bold"
                    >
                        Product/Service Photo(s)*
                    </label>

                    <VueFileAgent
                        ref="vueFileAgentProducts"
                        :multiple="true"
                        :deletable="true"
                        :linkable="false"
                        :meta="false"
                        :accept="'image/*'"
                        :maxSize="'1MB'"
                        :maxFiles="5"
                        :helpText="'Choose product images'"
                        v-model="prod_info.prod_images"
                        @beforedelete="
                            onBeforeDeleteProduct($event)
                        "
                        @select="onSelectProduct($event)"
                        @delete="productImageDeleted($event)"
                    ></VueFileAgent>

                    <div class="form-text">
                        Please upload up to five (5) clear photos of
                        your product. Preferably 1080x1080 px (1:1
                        ratio) with max. of 1MB per file.
                    </div>

                    <div
                        v-if="$v.prod_info.prod_images.$error"
                    >
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="
                                !$v.prod_info.prod_images.required
                            "
                        >
                            Please upload a product/service photo.
                        </div>
                    </div>

                </div>


                <!-- =====================================================
                     PRODUCT / SERVICE PROFILE
                ====================================================== -->
                <div class="col-12">

                    <h4>
                        Product/Service Profile*
                    </h4>

                    <div
                        v-if="$v.prod_info.prod_profiles.$error"
                    >
                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="
                                !$v.prod_info.prod_profiles.required
                            "
                        >
                            Product profile is required.
                        </div>
                    </div>

                </div>


                <!-- =====================================================
                     PRODUCT CATEGORIES / SUBCATEGORIES
                ====================================================== -->
                <div class="col-12">

                    <div class="row g-3">

                        <div
                            class="col-md-12"
                            v-for="category in categories"
                            :key="category.id"
                        >

                            <div
                                class="card m-0 h-100 beige-bg custom-border-radius"
                            >

                                <div class="card-body">

                                    <h4>
                                        {{ category.name }}
                                    </h4>

                                    <div
                                        class="form-check"
                                        v-for="
                                            subcategory
                                            in category.sub_categories
                                        "
                                        :key="subcategory.id"
                                    >

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            :id="
                                                'prod_sub_categories_' +
                                                subcategory.id
                                            "
                                            :value="subcategory.id"
                                            v-model="
                                                prod_info.prod_profiles
                                            "
                                        />

                                        <label
                                            class="form-check-label align-middle"
                                            :for="
                                                'prod_sub_categories_' +
                                                subcategory.id
                                            "
                                        >
                                            {{ subcategory.name }}
                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     CERTIFICATIONS
                ====================================================== -->
                <div class="col-12">

                    <div
                        class="card m-0 h-100 beige-bg custom-border-radius"
                    >

                        <div class="card-body">

                            <div class="row justify-content-start">

                                <div class="col-12">

                                    <h4>
                                        Certifications*
                                    </h4>

                                    <div
                                        v-if="
                                            $v.prod_info.prod_certs
                                                .$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !$v.prod_info
                                                    .prod_certs
                                                    .required
                                            "
                                        >
                                            Certifications is required.
                                        </div>
                                    </div>

                                    <div
                                        v-if="
                                            $v.prod_info
                                                .certs_others.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !$v.prod_info
                                                    .certs_others
                                                    .required
                                            "
                                        >
                                            Please specify other
                                            certification.
                                        </div>
                                    </div>

                                </div>


                                <!-- Certifications -->
                                <div
                                    class="col-md-4"
                                    v-for="cert in certifications"
                                    :key="cert.id"
                                >

                                    <div class="form-check">

                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            v-model="
                                                prod_info.prod_certs
                                            "
                                            :value="cert.id"
                                            :id="
                                                'prod_certification_' +
                                                cert.id
                                            "
                                        />


                                        <!-- Other Certification -->
                                        <div
                                            v-if="cert.id === 14"
                                        >

                                            <div
                                                class="d-flex align-items-center"
                                            >

                                                <label
                                                    class="form-check-label m-0 p-0 align-middle"
                                                    :for="
                                                        'prod_certification_' +
                                                        cert.id
                                                    "
                                                >
                                                    Others,&nbsp;
                                                </label>

                                                <input
                                                    id="certs_others"
                                                    class="form-control form-control-sm w-75 border-bottom"
                                                    :class="{
                                                        'is-invalid':
                                                            $v
                                                                .prod_info
                                                                .certs_others
                                                                .$error,
                                                    }"
                                                    type="text"
                                                    placeholder="please specify"
                                                    v-limit="{
                                                        max: 95,
                                                    }"
                                                    v-model="
                                                        prod_info.certs_others
                                                    "
                                                    :readonly="
                                                        check_prod_cert_others
                                                    "
                                                />

                                            </div>

                                        </div>


                                        <!-- Regular Certification -->
                                        <label
                                            v-else
                                            class="form-check-label mb-0 align-middle"
                                            :for="
                                                'prod_certification_' +
                                                cert.id
                                            "
                                        >
                                            {{ cert.name }}
                                        </label>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     ONLINE STORE LINK
                ====================================================== -->
                <div class="col-md-12">

                    <label
                        class="form-label text-uppercase fw-bold"
                        for="store_url"
                    >
                        Online Store Link
                    </label>

                    <input
                        id="store_url"
                        type="text"
                        class="form-control text-lowercase"
                        v-limit="{ max: 200 }"
                        :class="{
                            'is-invalid':
                                $v.prod_info.store_url.$error,
                        }"
                        v-model="prod_info.store_url"
                        placeholder="https://www.lazada.com.ph/shop/storename"
                    />

                    <div
                        v-if="$v.prod_info.store_url.$error"
                    >

                        <div
                            class="fw-light invalid-feedback d-block"
                            v-if="
                                !$v.prod_info.store_url.url
                            "
                        >
                            Invalid online store link.
                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     ADD / UPDATE PRODUCT BUTTON
                ====================================================== -->
                <div
                    class="col-12 d-flex justify-content-end mt-3"
                >

                    <!-- UPDATE -->
                    <button
                        v-if="product_id"
                        type="button"
                        class="btn btn-outline-dark px-4"
                        @click="doAddProduct"
                        aria-label="Update this product or service"
                    >

                        <i
                            class="far fa-edit me-1"
                            aria-hidden="true"
                        ></i>

                        Update product/service

                    </button>


                    <!-- ADD -->
                    <button
                        v-else
                        type="button"
                        class="btn btn-primary px-4"
                        @click="doAddProduct"
                        aria-label="Add this product or service to the list"
                    >

                        <i
                            class="fas fa-plus me-1"
                            aria-hidden="true"
                        ></i>

                        Add product/service

                    </button>

                </div>

            </div>


            <!-- =========================================================
                 IMPORTANT — ADDED PRODUCTS SECTION
            ========================================================== -->
            <div
                class="mt-5 mb-5"
                style="
                    border: 2px solid #dc3545;
                    border-radius: 10px;
                    background-color: #fff8f8;
                    overflow: hidden;
                "
            >

                <!-- =====================================================
                     ATTENTION HEADER
                ====================================================== -->
                <div
                    class="px-4 py-3"
                    style="
                        background-color: #dc3545;
                        color: #ffffff;
                    "
                    role="note"
                    aria-label="Important product information"
                >

                    <div class="d-flex align-items-center">

                        <i
                            class="fas fa-exclamation-triangle me-2"
                            aria-hidden="true"
                        ></i>

                        <strong>
                            IMPORTANT: Add all your products/services
                        </strong>

                    </div>

                </div>


                <!-- =====================================================
                     INSTRUCTION
                ====================================================== -->
                <div class="px-4 pt-4">

                    <div class="d-flex align-items-start">

                        <i
                            class="fas fa-list-ul text-danger me-3 mt-1"
                            aria-hidden="true"
                        ></i>

                        <div>

                            <h4 class="mb-2">
                                Your Products/Services
                            </h4>

                            <p class="mb-2">
                                Please add
                                <strong>each product or service separately</strong>.
                            </p>

                            <p class="mb-0">
                                If your company offers multiple products,
                                do not combine them into one entry.
                                Click
                                <strong>Add product/service</strong>
                                after completing each product, then add
                                your next product.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     PRODUCT COUNT
                ====================================================== -->
                <div
                    class="px-4 pt-3"
                    v-if="products.length > 0"
                >

                    <div
                        class="alert alert-warning mb-0"
                        role="status"
                    >

                        <i
                            class="fas fa-check-circle me-2"
                            aria-hidden="true"
                        ></i>

                        <strong>
                            {{ products.length }}
                        </strong>

                        product/service
                        <span v-if="products.length !== 1">
                            entries
                        </span>
                        <span v-else>
                            entry
                        </span>
                        added.

                        <span class="ms-1">
                            You can continue adding more products/services.
                        </span>

                    </div>

                </div>


                <!-- =====================================================
                     PRODUCT TABLE
                ====================================================== -->
                <div class="px-4 py-4">

                    <div class="table-responsive">

                        <table
                            class="table table-striped table-hover align-middle mb-0"
                        >

                            <thead>

                                <tr>

                                    <th scope="col">
                                        Product/Service Name
                                    </th>

                                    <th
                                        scope="col"
                                        class="text-end"
                                    >
                                        Actions
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                <!-- =================================================
                                     PRODUCTS
                                ================================================== -->
                                <tr
                                    v-for="product in products"
                                    :key="product.id"
                                >

                                    <td class="text-capitalize">

                                        <strong>
                                            {{ product.name }}
                                        </strong>

                                    </td>


                                    <td>

                                        <div
                                            class="d-grid gap-2 d-md-flex justify-content-md-end"
                                        >

                                            <!-- EDIT -->
                                            <button
                                                class="btn btn-outline-warning me-md-2 btn-sm"
                                                type="button"
                                                :disabled="
                                                    product_id ===
                                                    product.id
                                                "
                                                @click="
                                                    doProductEdit(
                                                        product.id
                                                    )
                                                "
                                                :aria-label="
                                                    'Edit ' +
                                                    product.name
                                                "
                                            >

                                                <i
                                                    class="far fa-edit"
                                                    aria-hidden="true"
                                                ></i>

                                                Edit

                                            </button>


                                            <!-- DELETE -->
                                            <button
                                                class="btn btn-outline-danger btn-sm"
                                                type="button"
                                                @click="
                                                    doProductDelete(
                                                        product.id
                                                    )
                                                "
                                                :aria-label="
                                                    'Delete ' +
                                                    product.name
                                                "
                                            >

                                                <i
                                                    class="far fa-trash-alt"
                                                    aria-hidden="true"
                                                ></i>

                                                Delete

                                            </button>

                                        </div>

                                    </td>

                                </tr>


                                <!-- =================================================
                                     EMPTY STATE
                                ================================================== -->
                                <tr
                                    v-if="
                                        products.length <= 0
                                    "
                                >

                                    <td
                                        colspan="2"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="fas fa-box-open fa-2x text-danger mb-3"
                                            aria-hidden="true"
                                        ></i>

                                        <div
                                            class="fw-bold text-danger"
                                        >
                                            No products/services added yet.
                                        </div>

                                        <div
                                            class="form-text mt-1"
                                        >
                                            Please add each product or
                                            service separately using the
                                            <strong>
                                                Add product/service
                                            </strong>
                                            button above.
                                        </div>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>
</tab-content>
   <tab-content title="Contact Information" :before-change="doStep2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-left mb-1 mt-4">
                <h1 class="h3">Contact Information</h1>
                <p>*Required</p>
            </div>

            <div class="row">
                <!-- ===================================================== -->
                <!-- BUSINESS OWNER -->
                <!-- ===================================================== -->
                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-12">
                            <h4>Business Owner</h4>
                        </div>

                        <!-- Salutation -->
                        <div class="col-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Salutation*
                            </label>

                            <select
                                class="form-select"
                                v-model="step2.salutation"
                                :class="{
                                    'is-invalid':
                                        $v.step2.salutation.$error,
                                }"
                            >
                                <option value="">-- Select --</option>
                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                            </select>

                            <div v-if="$v.step2.salutation.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!$v.step2.salutation.required"
                                >
                                    Salutation is required.
                                </div>
                            </div>
                        </div>

                        <!-- First Name -->
                        <div class="col-5">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                First Name*
                            </label>

                            <input
                                type="text"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.step2.fname.$error,
                                }"
                                v-limit="{ max: 95 }"
                                v-model="step2.fname"
                            />

                            <div v-if="$v.step2.fname.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!$v.step2.fname.required"
                                >
                                    First name is required.
                                </div>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-5">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Last Name*
                            </label>

                            <input
                                type="text"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.step2.lname.$error,
                                }"
                                v-limit="{ max: 95 }"
                                v-model="step2.lname"
                            />

                            <div v-if="$v.step2.lname.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!$v.step2.lname.required"
                                >
                                    Last name is required.
                                </div>
                            </div>
                        </div>

                        <!-- M.I. -->
                        <div class="col-2">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                M.I.
                            </label>

                            <input
                                type="text"
                                class="form-control text-uppercase"
                                v-limit="{ max: 4 }"
                                v-model="step2.mi"
                            />
                        </div>

                        <!-- Designation -->
                        <div class="col-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Designation*
                            </label>

                            <input
                                type="text"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.step2.designation.$error,
                                }"
                                v-limit="{ max: 95 }"
                                v-model="step2.designation"
                            />

                            <div v-if="$v.step2.designation.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.designation.required
                                    "
                                >
                                    Designation is required.
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Email Address*
                            </label>

                            <input
                                type="text"
                                class="form-control text-lowercase"
                                :class="{
                                    'is-invalid':
                                        $v.step2.email.$error,
                                }"
                                v-model="step2.email"
                                v-limit="{ max: 145 }"
                            />

                            <div v-if="$v.step2.email.$error">
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!$v.step2.email.required"
                                >
                                    Email address is required.
                                </div>

                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="!$v.step2.email.email"
                                >
                                    Invalid email address format.
                                </div>
                            </div>
                        </div>

                        <!-- Country Code -->
                        <div class="col-md-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Country Code*
                            </label>

                            <select
                                class="form-select"
                                v-model="
                                    step2.country_code_mobile_bo
                                "
                                :class="{
                                    'is-invalid':
                                        $v.step2
                                            .country_code_mobile_bo
                                            .$error,
                                }"
                            >
                                <option selected value="">
                                    -- Select --
                                </option>

                                <option
                                    v-for="country in countries"
                                    :key="country.id"
                                    :value="country.dial"
                                >
                                    {{ country.iso3 }} ({{
                                        country.dial
                                    }})
                                </option>
                            </select>

                            <div
                                v-if="
                                    $v.step2
                                        .country_code_mobile_bo
                                        .$error
                                "
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2
                                            .country_code_mobile_bo
                                            .required
                                    "
                                >
                                    Country code is required.
                                </div>
                            </div>
                        </div>

                        <!-- Mobile No. -->
                        <div class="col-md-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Mobile No.*
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                v-model="step2.mobile_no_bo"
                                :class="{
                                    'is-invalid':
                                        $v.step2.mobile_no_bo.$error,
                                }"
                                v-limit="{
                                    max: 12,
                                    numeric: true,
                                }"
                                placeholder="Enter Mobile Number"
                            />

                            <div
                                v-if="$v.step2.mobile_no_bo.$error"
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.mobile_no_bo.required
                                    "
                                >
                                    Mobile no. is required.
                                </div>

                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.mobile_no_bo.numeric
                                    "
                                >
                                    Mobile number must contain
                                    digits only.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ===================================================== -->
                <!-- BUSINESS CONTACT PERSON -->
                <!-- ===================================================== -->
                <div class="col-md-6">
                    <div class="row g-2">
                        <div class="col-12">
                            <h4>Business Contact Person</h4>
                        </div>

                        <!-- Same as Business Owner -->
                        <div class="col-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    :value="1"
                                    v-model="step2.same_as_bo"
                                    id="same_as_bo"
                                    @change="doSameAsBO"
                                    :disabled="check_same_as_bo"
                                />

                                <label
                                    class="form-check-label text-uppercase fw-bold align-middle"
                                    for="same_as_bo"
                                >
                                    Same as Business Owner
                                </label>
                            </div>
                        </div>

                        <!-- Salutation -->
                        <div class="col-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Salutation*
                            </label>

                            <select
                                class="form-select"
                                v-model="step2.bcp_salutation"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_salutation.$error,
                                }"
                                :disabled="disabled_bcp"
                            >
                                <option value="">
                                    -- Select --
                                </option>

                                <option value="Mr">Mr</option>
                                <option value="Ms">Ms</option>
                            </select>

                            <div
                                v-if="
                                    $v.step2.bcp_salutation.$error
                                "
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_salutation.required
                                    "
                                >
                                    Salutation is required.
                                </div>
                            </div>
                        </div>

                        <!-- First Name -->
                        <div class="col-5">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                First Name*
                            </label>

                            <input
                                type="text"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_fname.$error,
                                }"
                                v-model="step2.bcp_fname"
                                v-limit="{ max: 95 }"
                                :disabled="disabled_bcp"
                            />

                            <div
                                v-if="$v.step2.bcp_fname.$error"
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_fname.required
                                    "
                                >
                                    First name is required.
                                </div>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-5">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Last Name*
                            </label>

                            <input
                                type="text"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_lname.$error,
                                }"
                                v-model="step2.bcp_lname"
                                v-limit="{ max: 95 }"
                                :disabled="disabled_bcp"
                            />

                            <div
                                v-if="$v.step2.bcp_lname.$error"
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_lname.required
                                    "
                                >
                                    Last name is required.
                                </div>
                            </div>
                        </div>

                        <!-- M.I. -->
                        <div class="col-2">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                M.I.
                            </label>

                            <input
                                type="text"
                                class="form-control text-uppercase"
                                v-model="step2.bcp_mi"
                                v-limit="{ max: 4 }"
                                :disabled="disabled_bcp"
                            />
                        </div>

                        <!-- Designation -->
                        <div class="col-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Designation*
                            </label>

                            <input
                                type="text"
                                class="form-control text-capitalize"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_designation.$error,
                                }"
                                v-model="step2.bcp_designation"
                                v-limit="{ max: 95 }"
                                :disabled="disabled_bcp"
                            />

                            <div
                                v-if="
                                    $v.step2.bcp_designation.$error
                                "
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_designation
                                            .required
                                    "
                                >
                                    Designation is required.
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Email Address*
                            </label>

                            <input
                                type="text"
                                class="form-control text-lowercase"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_email.$error,
                                }"
                                v-model="step2.bcp_email"
                                v-limit="{ max: 145 }"
                                :disabled="disabled_bcp"
                            />

                            <div
                                v-if="$v.step2.bcp_email.$error"
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_email.required
                                    "
                                >
                                    Email address is required.
                                </div>

                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_email.email
                                    "
                                >
                                    Invalid email address format.
                                </div>
                            </div>
                        </div>

                        <!-- Country Code -->
                        <div class="col-md-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Country Code*
                            </label>

                            <select
                                class="form-select"
                                v-model="step2.bcp_country_code"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_country_code.$error,
                                }"
                                :disabled="disabled_bcp"
                            >
                                <option selected value="">
                                    -- Select --
                                </option>

                                <option
                                    v-for="country in countries"
                                    :key="country.id"
                                    :value="country.dial"
                                >
                                    {{ country.iso3 }} ({{
                                        country.dial
                                    }})
                                </option>
                            </select>

                            <div
                                v-if="
                                    $v.step2.bcp_country_code.$error
                                "
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_country_code
                                            .required
                                    "
                                >
                                    Country code is required.
                                </div>
                            </div>
                        </div>

                        <!-- Mobile No. -->
                        <div class="col-md-12">
                            <label
                                class="form-label text-uppercase fw-bold"
                            >
                                Mobile No.*
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                v-model="step2.bcp_mobile_no"
                                :class="{
                                    'is-invalid':
                                        $v.step2.bcp_mobile_no.$error,
                                }"
                                v-limit="{
                                    max: 12,
                                    numeric: true,
                                }"
                                :disabled="disabled_bcp"
                                placeholder="Enter Mobile Number"
                            />

                            <div
                                v-if="
                                    $v.step2.bcp_mobile_no.$error
                                "
                            >
                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_mobile_no.required
                                    "
                                >
                                    Mobile no. is required.
                                </div>

                                <div
                                    class="fw-light invalid-feedback d-block"
                                    v-if="
                                        !$v.step2.bcp_mobile_no.numeric
                                    "
                                >
                                    Mobile number must contain
                                    digits only.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5"></div>
    </div>
</tab-content>
            <tab-content title="Business Information" :before-change="doStep3">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Business Information</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Business Registration*</h4>
                                                <div
                                                    v-if="
                                                        $v.step3.business_type
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .business_type
                                                                .required
                                                        "
                                                    >
                                                        Business registration is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    class="form-check"
                                                    v-for="btype in business_types"
                                                    :key="btype.id"
                                                >
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.business_type
                                                        "
                                                        :value="btype.id"
                                                        :id="
                                                            'business_type_' +
                                                            btype.id
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label align-middle"
                                                        :for="
                                                            'business_type_' +
                                                            btype.id
                                                        "
                                                        >{{ btype.name }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <!-- Start up -->
                                        <div class="row">
                                            <div class="col-12"></div>

                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        id="start_up"
                                                        v-model="step3.start_up"
                                                        :true-value="1"
                                                        :false-value="0"
                                                        :disabled="
                                                            step3.startUpDisabled
                                                        "
                                                    />

                                                    <label
                                                        class="form-check-label d-block"
                                                        for="start_up"
                                                    >
                                                        Are you a start up
                                                        company?
                                                    </label>

                                                    <ul>
                                                        <li
                                                            class="fw-bold text-uppercase"
                                                        >
                                                            Eligibility
                                                        </li>
                                                        <ol>
                                                            <li>
                                                                <strong
                                                                    >Age of the
                                                                    Business</strong
                                                                >
                                                                <ul
                                                                    type="circle"
                                                                >
                                                                    <li>
                                                                        Less
                                                                        than 5
                                                                        years
                                                                        old.
                                                                    </li>
                                                                    <li>
                                                                        Still in
                                                                        the
                                                                        early or
                                                                        growing
                                                                        stages
                                                                        of
                                                                        development
                                                                        and
                                                                        market
                                                                        establishment.
                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li>
                                                                <strong
                                                                    >Funding
                                                                    Readiness</strong
                                                                >
                                                                <ul
                                                                    type="circle"
                                                                >
                                                                    <li>
                                                                        May be
                                                                        self-funded,
                                                                        grant-awardee,
                                                                        or in
                                                                        early
                                                                        stages
                                                                        of
                                                                        investor
                                                                        engagement.
                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li>
                                                                <strong
                                                                    >Team
                                                                    Capacity &
                                                                    Commitment</strong
                                                                >
                                                                <ul
                                                                    type="circle"
                                                                >
                                                                    <li>
                                                                        Should
                                                                        have a
                                                                        dedicated
                                                                        founding
                                                                        or
                                                                        management
                                                                        team
                                                                        with the
                                                                        skills,
                                                                        knowledge,
                                                                        and
                                                                        commitment
                                                                        to drive
                                                                        both the
                                                                        business
                                                                        and
                                                                        sustainability
                                                                        goals.
                                                                    </li>
                                                                </ul>
                                                            </li>

                                                            <li>
                                                                <strong
                                                                    >Innovation
                                                                    &
                                                                    Impact</strong
                                                                >
                                                                <ul
                                                                    type="circle"
                                                                >
                                                                    <li>
                                                                        Offers a
                                                                        novel
                                                                        product,
                                                                        service,
                                                                        or
                                                                        business
                                                                        model
                                                                        that
                                                                        directly
                                                                        addresses
                                                                        environmental
                                                                        and/or
                                                                        social
                                                                        challenges.
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        </ol>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Company Size*</h4>
                                                <div
                                                    v-if="
                                                        $v.step3.company_size
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .company_size
                                                                .required
                                                        "
                                                    >
                                                        Company size is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    class="form-check"
                                                    v-for="compsize in company_sizes"
                                                    :key="compsize.id"
                                                >
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.company_size
                                                        "
                                                        :value="compsize.id"
                                                        :id="
                                                            'company_size_' +
                                                            compsize.id
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'company_size_' +
                                                            compsize.id
                                                        "
                                                        >{{
                                                            compsize.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Annual Sales Volume*</h4>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .annual_sales_volume
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .annual_sales_volume
                                                                .required
                                                        "
                                                    >
                                                        Annual sales volume is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    class="form-check"
                                                    v-for="annual_sales in annual_sales_volumes"
                                                    :key="annual_sales.id"
                                                >
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.annual_sales_volume
                                                        "
                                                        :value="annual_sales.id"
                                                        :id="
                                                            'annual_sales' +
                                                            annual_sales.id
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'annual_sales' +
                                                            annual_sales.id
                                                        "
                                                        >{{
                                                            annual_sales.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Type of Organization*</h4>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .organization_type
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .organization_type
                                                                .required
                                                        "
                                                    >
                                                        Type of organization is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div
                                                    class="form-check"
                                                    v-for="orgtype in organization_types"
                                                    :key="orgtype.id"
                                                >
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.organization_type
                                                        "
                                                        :value="orgtype.id"
                                                        :id="
                                                            'organization_type_' +
                                                            orgtype.id
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'organization_type_' +
                                                            orgtype.id
                                                        "
                                                        >{{
                                                            orgtype.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-3">
                                <h4>Number of Workers</h4>
                            </div>
                            <div class="col-md-6 mt-0">
                                <label
                                    for="direct"
                                    class="form-label text-uppercase fw-bold"
                                    >Direct*</label
                                >
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control"
                                    id="direct"
                                    v-model="step3.direct"
                                    :class="{
                                        'is-invalid': $v.step3.direct.$error,
                                    }"
                                    v-limit="{ max: 5, numeric: true }"
                                />
                            </div>
                            <div class="col-md-6 mt-0">
                                <label
                                    for="indirect"
                                    class="form-label text-uppercase fw-bold"
                                    >Indirect/Subcontractors*</label
                                >
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    class="form-control"
                                    id="indirect"
                                    :class="{
                                        'is-invalid': $v.step3.indirect.$error,
                                    }"
                                    v-limit="{ max: 5, numeric: true }"
                                    v-model="step3.indirect"
                                />
                            </div>
                            <div class="col-md-12">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Nature of Business*</h4>
                                                <p class="fs-12">
                                                    Note: Select all that
                                                    applies
                                                </p>
                                                <div
                                                    v-if="
                                                        $v.step3.nature_business
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .nature_business
                                                                .required
                                                        "
                                                    >
                                                        Nature of business is
                                                        required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-6"
                                                v-for="nbusiness in nature_businesses"
                                                :key="nbusiness.id"
                                            >
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.nature_business
                                                        "
                                                        :value="nbusiness.id"
                                                        :id="
                                                            'nature_business' +
                                                            nbusiness.id
                                                        "
                                                    />

                                                    <div
                                                        v-if="
                                                            nbusiness.id === 16
                                                        "
                                                    >
                                                        <div
                                                            class="d-flex align-items-center"
                                                        >
                                                            <label
                                                                class="form-check-label m-0 p-0"
                                                                :for="
                                                                    'target' +
                                                                    nbusiness.id
                                                                "
                                                                >Others,&nbsp;</label
                                                            >
                                                            <input
                                                                id="nature_business_others"
                                                                class="form-control form-control-sm w-75 border-bottom"
                                                                :class="{
                                                                    'is-invalid':
                                                                        $v.step3
                                                                            .nature_business_others
                                                                            .$error,
                                                                }"
                                                                type="text"
                                                                placeholder="please specify"
                                                                v-limit="{
                                                                    max: 95,
                                                                }"
                                                                v-model="
                                                                    step3.nature_business_others
                                                                "
                                                                :readonly="
                                                                    check_nature_business_others
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                    <label
                                                        v-else
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'nature_business' +
                                                            nbusiness.id
                                                        "
                                                        >{{
                                                            nbusiness.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Target Buyer & Intent*</h4>
                                                <p class="fs-12">
                                                    Note: Select all that
                                                    applies
                                                </p>
                                                <div
                                                    v-if="
                                                        $v.step3.target_buyer
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .target_buyer
                                                                .required
                                                        "
                                                    >
                                                        Target buyers is
                                                        required.
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .target_buyer_others
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .target_buyer_others
                                                                .required
                                                        "
                                                    >
                                                        Please specify other
                                                        target buyers.
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-6"
                                                v-for="target in target_buyers"
                                                :key="target.id"
                                            >
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.target_buyer
                                                        "
                                                        :value="target.id"
                                                        :id="
                                                            'target' + target.id
                                                        "
                                                    />
                                                    <div v-if="target.id === 6">
                                                        <div
                                                            class="d-flex align-items-center"
                                                        >
                                                            <label
                                                                class="form-check-label m-0 p-0"
                                                                :for="
                                                                    'target' +
                                                                    target.id
                                                                "
                                                                >Others,&nbsp;</label
                                                            >
                                                            <input
                                                                id="target_buyer_others"
                                                                class="form-control form-control-sm w-75 border-bottom"
                                                                :class="{
                                                                    'is-invalid':
                                                                        $v.step3
                                                                            .target_buyer_others
                                                                            .$error,
                                                                }"
                                                                type="text"
                                                                placeholder="please specify"
                                                                v-limit="{
                                                                    max: 95,
                                                                }"
                                                                v-model="
                                                                    step3.target_buyer_others
                                                                "
                                                                :readonly="
                                                                    check_target_others
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                    <label
                                                        v-else
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'target' + target.id
                                                        "
                                                        >{{
                                                            target.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-uppercase fw-bold"
                                    >Target Countries for Export (Top 3)*</label
                                >
                                <div v-if="$v.step3.target_country_1.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step3.target_country_1.isUnique
                                        "
                                    >
                                        Target country for export duplicate
                                        entry.
                                    </div>
                                </div>
                                <select
                                    class="form-select form-select-sm mb-2"
                                    v-model="step3.target_country_1"
                                    :class="{
                                        'is-invalid':
                                            $v.step3.target_country_1.$error,
                                    }"
                                >
                                    <option :value="''">-- Top 1 --</option>
                                    <option
                                        v-for="tc_top1 in countries"
                                        :key="tc_top1.id"
                                        :value="tc_top1.id"
                                    >
                                        {{ tc_top1.name }}
                                    </option>
                                </select>
                                <div v-if="$v.step3.target_country_1.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step3.target_country_1.required
                                        "
                                    >
                                        Target country for export (Top 1) is
                                        required.
                                    </div>
                                </div>
                                <select
                                    class="form-select form-select-sm mb-2"
                                    v-model="step3.target_country_2"
                                    :class="{
                                        'is-invalid':
                                            $v.step3.target_country_2.$error,
                                    }"
                                >
                                    <option :value="''">-- Top 2 --</option>
                                    <option
                                        v-for="tc_top2 in countries"
                                        :key="tc_top2.id"
                                        :value="tc_top2.id"
                                    >
                                        {{ tc_top2.name }}
                                    </option>
                                </select>
                                <div v-if="$v.step3.target_country_2.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step3.target_country_2.required
                                        "
                                    >
                                        Target country for export (Top 2) is
                                        required.
                                    </div>
                                </div>
                                <select
                                    class="form-select form-select-sm"
                                    v-model="step3.target_country_3"
                                    :class="{
                                        'is-invalid':
                                            $v.step3.target_country_3.$error,
                                    }"
                                >
                                    <option :value="''">-- Top 3 --</option>
                                    <option
                                        v-for="tc_top3 in countries"
                                        :key="tc_top3.id"
                                        :value="tc_top3.id"
                                    >
                                        {{ tc_top3.name }}
                                    </option>
                                </select>
                                <div v-if="$v.step3.target_country_3.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step3.target_country_3.required
                                        "
                                    >
                                        Target country for export (Top 3) is
                                        required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Certification/s*</h4>
                                                <p class="fs-12">
                                                    Note: Select all that
                                                    applies
                                                </p>
                                                <div
                                                    v-if="
                                                        $v.step3.certification
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .certification
                                                                .required
                                                        "
                                                    >
                                                        Certification is
                                                        required.
                                                    </div>
                                                </div>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .certification_others
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .certification_others
                                                                .required
                                                        "
                                                    >
                                                        Please specify other
                                                        certfication.
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-md-6"
                                                v-for="cert in certifications"
                                                :key="cert.id"
                                            >
                                                <div class="form-check">
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.certification
                                                        "
                                                        :value="cert.id"
                                                        :id="
                                                            'certification_' +
                                                            cert.id
                                                        "
                                                    />
                                                    <div v-if="cert.id === 14">
                                                        <div
                                                            class="d-flex align-items-center"
                                                        >
                                                            <label
                                                                class="form-check-label m-0 p-0 align-middle"
                                                                :for="
                                                                    'certification_' +
                                                                    cert.id
                                                                "
                                                                >Others,&nbsp;</label
                                                            >
                                                            <input
                                                                id="certification_others"
                                                                class="form-control form-control-sm w-75 border-bottom"
                                                                :class="{
                                                                    'is-invalid':
                                                                        $v.step3
                                                                            .certification_others
                                                                            .$error,
                                                                }"
                                                                type="text"
                                                                placeholder="please specify"
                                                                v-limit="{
                                                                    max: 95,
                                                                }"
                                                                v-model="
                                                                    step3.certification_others
                                                                "
                                                                :readonly="
                                                                    check_certification_others
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                    <label
                                                        v-else
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'certification_' +
                                                            cert.id
                                                        "
                                                        >{{ cert.name }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card m-0 h-100 beige-bg custom-border-radius">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                    Industry Representation*
                                                </h4>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .industry_representation
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .industry_representation
                                                                .required
                                                        "
                                                    >
                                                        Industry representation
                                                        is required.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.industry_representation
                                                        "
                                                        :value="1"
                                                        id="industry_representation1"
                                                        @change="
                                                            onChangeIndustryRep
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label mb-0 align-middle"
                                                        for="industry_representation1"
                                                        >With Export
                                                        Experience</label
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-check">
                                                    <input
                                                        type="radio"
                                                        class="form-check-input"
                                                        v-model="
                                                            step3.industry_representation
                                                        "
                                                        :value="2"
                                                        id="industry_representation2"
                                                        @change="
                                                            onChangeIndustryRep
                                                        "
                                                    />
                                                    <label
                                                        class="form-check-label mb-0 align-middle"
                                                        for="industry_representation2"
                                                        >Without Export
                                                        Experience</label
                                                    >
                                                </div>
                                            </div>
                                            <div
                                                class="col-12"
                                                v-if="
                                                    step3.industry_representation ===
                                                    1
                                                "
                                            >
                                                <label
                                                    class="form-label text-uppercase fw-bold"
                                                    >Countries Exporting To (Top
                                                    3)*</label
                                                >
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .exporting_country_1
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .exporting_country_1
                                                                .isUnique
                                                        "
                                                    >
                                                        Country exporting
                                                        duplicate entry.
                                                    </div>
                                                </div>
                                                <select
                                                    class="form-select form-select-sm mb-2 border border-secondary"
                                                    v-model="
                                                        step3.exporting_country_1
                                                    "
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step3
                                                                .exporting_country_1
                                                                .$error,
                                                    }"
                                                >
                                                    <option :value="''">
                                                        -- Top 1 --
                                                    </option>
                                                    <option
                                                        v-for="ce_top1 in countries"
                                                        :key="ce_top1.id"
                                                        :value="ce_top1.id"
                                                    >
                                                        {{ ce_top1.name }}
                                                    </option>
                                                </select>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .exporting_country_1
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .exporting_country_1
                                                                .required
                                                        "
                                                    >
                                                        Country exporting (Top
                                                        1) is required.
                                                    </div>
                                                </div>
                                                <select
                                                    class="form-select form-select-sm mb-2 border border-secondary"
                                                    v-model="
                                                        step3.exporting_country_2
                                                    "
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step3
                                                                .exporting_country_2
                                                                .$error,
                                                    }"
                                                >
                                                    <option :value="''">
                                                        -- Top 2 --
                                                    </option>
                                                    <option
                                                        v-for="ce_top2 in countries"
                                                        :key="ce_top2.id"
                                                        :value="ce_top2.id"
                                                    >
                                                        {{ ce_top2.name }}
                                                    </option>
                                                </select>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .exporting_country_2
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .exporting_country_2
                                                                .required
                                                        "
                                                    >
                                                        Country exporting (Top
                                                        2) is required.
                                                    </div>
                                                </div>
                                                <select
                                                    class="form-select form-select-sm border border-secondary"
                                                    v-model="
                                                        step3.exporting_country_3
                                                    "
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step3
                                                                .exporting_country_3
                                                                .$error,
                                                    }"
                                                >
                                                    <option :value="''">
                                                        -- Top 3 --
                                                    </option>
                                                    <option
                                                        v-for="ce_top3 in countries"
                                                        :key="ce_top3.id"
                                                        :value="ce_top3.id"
                                                    >
                                                        {{ ce_top3.name }}
                                                    </option>
                                                </select>
                                                <div
                                                    v-if="
                                                        $v.step3
                                                            .exporting_country_3
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !$v.step3
                                                                .exporting_country_3
                                                                .required
                                                        "
                                                    >
                                                        Country exporting (Top
                                                        3) is required.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Specific Products and/or Services
                                    Offered:*</label
                                >
                                <textarea
                                    class="form-control beige-bg"
                                    rows="3"
                                    v-model="step3.product_promoted"
                                    :class="{
                                        'is-invalid':
                                            $v.step3.product_promoted.$error,
                                    }"
                                    v-limit="{ max: 400 }"
                                ></textarea>
                                <div v-if="$v.step3.product_promoted.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.step3.product_promoted.required
                                        "
                                    >
                                        Please specify products to be promoted.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 pt-3">
                                <h4>Supplier/Exhibitor Profile*</h4>
                                <p>
                                    Please indicate if your company is offering
                                    the following (check all that applies):
                                </p>
                            </div>
                            <div class="row">
                                <div v-if="$v.step3.category.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step3.category.required"
                                    >
                                        Exhibitor profile is required.
                                    </div>
                                </div>
                                <div
                                    class="col-md-12 mt-3 mt-md-0"
                                    v-for="category in categories"
                                    :key="category.id"
                                >
                                    <div class="card m-0 h-100 beige-bg custom-border-radius">
                                        <div class="card-body">
                                            <h4>{{ category.name }}</h4>
                                            <div
                                                class="form-check"
                                                v-for="subcategory in category.sub_categories"
                                                :key="subcategory.id"
                                            >
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :id="
                                                        'sub_categories_' +
                                                        subcategory.id
                                                    "
                                                    :value="subcategory.id"
                                                    v-model="step3.category"
                                                />
                                                <label
                                                    class="form-check-label align-middle"
                                                    :for="
                                                        'sub_categories_' +
                                                        subcategory.id
                                                    "
                                                    >{{
                                                        subcategory.name
                                                    }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                                                <div class="col-12 mt-5">
                                    <div class="card m-0 h-100 beige-bg custom-border-radius">
                                        <div class="card-body">
                                            <p class="bg-light text-wrap mb-1">
                                                Check only the goals directly supported by your current business practices, products, services, or certifications.
                                            </p>
                                            <h4>Sustainable Development Goals (SDG) Alignment:*</h4>
                                            <div
                                                v-if="
                                                    $v.step3.sdg.$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step3.sdg
                                                            .required
                                                    "
                                                >
                                                    Sustainable Development Goals  is required.
                                                </div>
                                            </div>
                                            <div
                                                class="form-check"
                                                v-for="sdg in sdgs"
                                                :key="sdg.id"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="step3.sdg"
                                                    :value="sdg.id"
                                                    :id="
                                                        'sdg_' +
                                                        sdg.id
                                                    "
                                                />
                                                <label
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'sdg_' +
                                                        sdg.id
                                                    "
                                                    >{{ sdg.name }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12 mt-5">
                                    <div class="card m-0 h-100 beige-bg custom-border-radius">
                                        <div class="card-body">
                                            <p class="bg-light text-wrap mb-1">
                                                Please indicate if your company
                                                has the following
                                                characteristics (check all that
                                                applies):
                                            </p>
                                            <h4>ON INPUT / OUTPUT:*</h4>
                                            <div
                                                v-if="
                                                    $v.step3.input_ouput.$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step3.input_ouput
                                                            .required
                                                    "
                                                >
                                                    On input/output is required.
                                                </div>
                                            </div>
                                            <div
                                                class="form-check"
                                                v-for="inout in inputs_outputs"
                                                :key="inout.id"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="step3.input_ouput"
                                                    :value="inout.id"
                                                    :id="
                                                        'input_ouput_' +
                                                        inout.id
                                                    "
                                                />
                                                <label
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'input_ouput_' +
                                                        inout.id
                                                    "
                                                    >{{ inout.name }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="card m-0 h-100 beige-bg custom-border-radius">
                                        <div class="card-body">
                                            <h4>ON PRODUCTION PROCESS:*</h4>
                                            <div
                                                v-if="
                                                    $v.step3.production_process
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step3
                                                            .production_process
                                                            .required
                                                    "
                                                >
                                                    On production process is
                                                    required.
                                                </div>
                                            </div>
                                            <div
                                                class="form-check mb-2 mb-md-0"
                                                v-for="prod_process in production_processes"
                                                :key="prod_process.id"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="
                                                        step3.production_process
                                                    "
                                                    :value="prod_process.id"
                                                    :id="
                                                        'on_production_process_' +
                                                        prod_process.id
                                                    "
                                                />
                                                <div
                                                    v-if="prod_process.id === 3"
                                                >
                                                    <div>
                                                        <label
                                                            class="form-check-label m-0 p-0"
                                                            :for="
                                                                'on_production_process_' +
                                                                prod_process.id
                                                            "
                                                            >{{
                                                                prod_process.name
                                                            }}</label
                                                        >
                                                        <input
                                                            id="production_process_others"
                                                            class="form-control form-control-sm border-bottom"
                                                            :class="{
                                                                'is-invalid':
                                                                    $v.step3
                                                                        .production_process_others
                                                                        .$error,
                                                            }"
                                                            type="text"
                                                            placeholder="Please specify certification/s"
                                                            v-limit="{
                                                                max: 95,
                                                            }"
                                                            v-model="
                                                                step3.production_process_others
                                                            "
                                                            :readonly="
                                                                check_production_process_others
                                                            "
                                                        />
                                                        <div
                                                            v-if="
                                                                $v.step3
                                                                    .production_process_others
                                                                    .$error
                                                            "
                                                        >
                                                            <div
                                                                class="fw-light invalid-feedback d-block"
                                                                v-if="
                                                                    !$v.step3
                                                                        .production_process_others
                                                                        .required
                                                                "
                                                            >
                                                                Please specify
                                                                certification/s.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <label
                                                    v-else
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'on_production_process_' +
                                                        prod_process.id
                                                    "
                                                    >{{
                                                        prod_process.name
                                                    }}</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- SUSTAINABILITY IS MULTIFACETED -->
                                <div
                                    class="col-12 mt-3"
                                    v-if="topics.length > 0"
                                >
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <p class="bg-light text-wrap mb-1">
                                                Please indicate which
                                                sustainability topics the show
                                                should focus on (check all that
                                                apply):
                                            </p>
                                            <h4>
                                                SUSTAINABILITY IS MULTIFACETED,
                                                WHICH OF THE TOPICS BELOW DO YOU
                                                THINK THE SHOW SHOULD FOCUS ON?*
                                            </h4>

                                      

                                            <div
                                                class="form-check"
                                                v-for="topic in topics"
                                                :key="topic.id"
                                            >
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    v-model="
                                                        step3.sustainability_topics
                                                    "
                                                    :value="topic.id"
                                                    :id="
                                                        'sustainability_topic_' +
                                                        topic.id
                                                    "
                                                />
                                                <label
                                                    class="form-check-label mb-0 align-middle"
                                                    :for="
                                                        'sustainability_topic_' +
                                                        topic.id
                                                    "
                                                >
                                                    {{ topic.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /SUSTAINABILITY IS MULTIFACETED -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
            </tab-content>
            <tab-content title="Order Information" :before-change="doStep4">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Order Information</h1>
                            <p>&nbsp;</p>
                        </div>

                        <!-- PARTICIPATION TYPE -->
                        <div class="col-md-12 mb-3">
                            <div class="card m-0 h-100 beige-bg custom-border-radius">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Participation Type*</h4>
                                            <div
                                                v-if="
                                                    $v.step4.participation_type
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step4
                                                            .participation_type
                                                            .required
                                                    "
                                                >
                                                    Participation type is
                                                    required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="participation_individual"
                                                    :value="1"
                                                    v-model="
                                                        step4.participation_type
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="participation_individual"
                                                >
                                                    Individual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="participation_group"
                                                    :value="2"
                                                    v-model="
                                                        step4.participation_type
                                                    "
                                                    :disabled="
                                                        step3.start_up === 1
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="participation_group"
                                                >
                                                    Group
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END PARTICIPATION TYPE -->

                        <div class="accordion" id="accordionPackages">
                            <div
                                class="accordion-spaces-item mb-3 border border-2"
                                v-for="(pkg, index) in step4.packages"
                                :key="pkg.id"
                                v-if="
                                    pkg.participation_booth_spaces &&
                                    pkg.participation_booth_spaces.length
                                "
                            >
                                <div class="accordion-spaces-item">
                                    <h2
                                        class="accordion-header"
                                        :id="`heading${index}`"
                                    >
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            :data-bs-target="`#collapse${index}`"
                                            aria-expanded="false"
                                            :aria-controls="`collapse${index}`"
                                            @click="togglePackage(pkg.id)"
                                        >
                                            {{ pkg.title }} -
                                            {{ pkg.sub_title }}
                                        </button>
                                    </h2>

                                    <div
                                        :id="`collapse${index}`"
                                        class="accordion-collapse collapse"
                                        :aria-labelledby="`heading${index}`"
                                        data-bs-parent="#accordionPackages"
                                    >
                                        <div class="accordion-body">
                                            <!-- Booth spaces -->
                                            <div
                                                class="row text-center g-3 align-items-stretch justify-content-center"
                                            >
                                                <div
                                                    class="col-md-4 d-flex"
                                                    v-for="space in pkg.participation_booth_spaces"
                                                    :key="space.id"
                                                >
                                                    <div
                                                        class="card border border-2 w-100 d-flex flex-column p-4"
                                                        :class="{
                                                            'border-primary bg-light':
                                                                step4
                                                                    .packageState[
                                                                    pkg.id
                                                                ] &&
                                                                step4
                                                                    .packageState[
                                                                    pkg.id
                                                                ]
                                                                    .selected_space_id ===
                                                                    space.id,
                                                        }"
                                                    >
                                                        <h5 class="card-title">
                                                            {{ space.name }}
                                                            Space
                                                        </h5>
                                                        <p
                                                            class="card-text mb-2"
                                                        >
                                                            {{ space.currency }}
                                                            {{
                                                                formatNumber(
                                                                    space.cost_per_sqm
                                                                )
                                                            }}
                                                            / sqm
                                                        </p>
                                                        <div class="mt-auto">
                                                            <button
                                                                class="btn btn-outline-primary w-100"
                                                                @click="
                                                                    toggleCart(
                                                                        pkg.id,
                                                                        space.id
                                                                    )
                                                                "
                                                            >
                                                                Select
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Space Details (shows when a space is selected) -->
                                            <!-- <div
                                                v-if="isCartVisible(pkg.id)"
                                                class="row mt-3"
                                            >
                                                <div class="col-md-10 mx-auto">
                                        
                                                    <div
                                                        v-if="
                                                            selectedSpace(pkg)
                                                        "
                                                        class="p-3 bg-white rounded shadow-sm border"
                                                    >
                                                
                                                        <div
                                                            v-if="
                                                                selectedSpace(
                                                                    pkg
                                                                ).amenities
                                                            "
                                                            class="mb-3"
                                                        >
                                                            <h6 class="fw-bold">
                                                                Amenities
                                                            </h6>
                                                            <div
                                                                v-html="
                                                                    selectedSpace(
                                                                        pkg
                                                                    ).amenities
                                                                "
                                                            ></div>
                                                        </div>

                                                
                                                        <div
                                                            v-if="
                                                                selectedSpace(
                                                                    pkg
                                                                ).other_benefits
                                                            "
                                                        >
                                                            <h6 class="fw-bold">
                                                                Other Benefits
                                                            </h6>
                                                            <div
                                                                v-html="
                                                                    selectedSpace(
                                                                        pkg
                                                                    )
                                                                        .other_benefits
                                                                "
                                                            ></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- Booth Details -->
                                            <div class="col-md-10 mx-auto">
                                                <div
                                                    class="p-3 bg-white rounded shadow-sm border"
                                                >
                                                    <div
                                                        v-if="pkg.booth_details"
                                                        class="mt-4"
                                                    >
                                                        <div
                                                            v-html="
                                                                pkg.booth_details
                                                            "
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>

                                     
                                            <!-- Cart input -->
                                            <div
                                                v-if="isCartVisible(pkg.id)"
                                                class="row mt-4"
                                            >
                                             <div
                                                    class="row justify-content-center align-items-center g-2"
                                                >
                                                    <!-- Booth size -->
                                                    <div
                                                        :class="
                                                            step4.participation_type ==
                                                            2
                                                                ? 'col-12 col-md-3'
                                                                : 'col-12 col-md-6'
                                                        "
                                                    >
                                                        <select
                                                            class="form-select border-secondary"
                                                            v-model="
                                                                step4
                                                                    .packageState[
                                                                    pkg.id
                                                                ]
                                                                    .selected_size_id
                                                            "
                                                        >
                                                            <option
                                                                :value="null"
                                                                disabled
                                                            >
                                                                Select booth
                                                                size
                                                            </option>
                                                            <option
                                                                v-for="size in getFilteredSizes(
                                                                    pkg
                                                                )"
                                                                :key="size.id"
                                                                :value="size.id"
                                                            >
                                                                {{ size.name }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <!-- Quantity (type 2 only) -->
                                                    <div
                                                        v-if="step4.participation_type == 2"
                                                        class="col-12 col-md-auto pe-md-4 pe-0"
                                                    >
                                                        <div
                                                            class="input-group"
                                                            :class="{
                                                                'opacity-50 pointer-events-none': !step4.packageState[pkg.id].selected_size_id
                                                            }"
                                                        >
                                                            <!-- Decrease button -->
                                                            <button
                                                                :class="{
                                                            
                                                                'border-end-0': step4.packageState[pkg.id].selected_size_id
                                                                }"
                                                                class="btn btn-outline-secondary "
                                                              
                                                                type="button"
                                                                :disabled="!step4.packageState[pkg.id].selected_size_id"
                                                                @click="decreaseQty(pkg.id)"
                                                                
                                                            >
                                                                <span class="mdi mdi-minus"></span>
                                                            </button>

                                                            <!-- Quantity input -->
                                                            <!-- <input
                                                                type="number"
                                                                class="form-control text-center qty-input border border-secondary"
                                                                 :class="{
                                                                'border-secondary border-end-0 border-start-0': !step4.packageState[pkg.id].selected_size_id
                                                            }"
                                                                v-model.number="step4.packageState[pkg.id].qty"
                                                                :min="getQtyRules(pkg).min"
                                                                :max="getQtyRules(pkg).max"
                                                                :disabled="!step4.packageState[pkg.id].selected_size_id"
                                                                style="max-width: 70px;"
                                                                placeholder="0"
                                                            /> -->
                                                            <input
    type="number"
    class="form-control text-center qty-input border border-secondary"
    :class="{
        'border-secondary border-end-0 border-start-0':
            !step4.packageState[pkg.id].selected_size_id
    }"
    v-model.number="step4.packageState[pkg.id].qty"
    :disabled="!step4.packageState[pkg.id].selected_size_id"
    style="max-width: 70px;"
    placeholder="0"
/>

                                                            <!-- Increase button -->
                                                            <button
                                                                   :class="{
                                                               
                                                                'border-start-0': step4.packageState[pkg.id].selected_size_id
                                                                }"
                                                                class="btn btn-outline-secondary "
                                                                type="button"
                                                                :disabled="!step4.packageState[pkg.id].selected_size_id"
                                                                @click="increaseQty(pkg.id)"
                                                            >
                                                                <span class="mdi mdi-plus"></span>
                                                            </button>
                                                        </div>
                                                    </div>


                                                    <!-- Add to Cart -->
                                                    <div
                                                        class="col-12 col-md-auto"
                                                    >
                                                        <button
                                                            class="btn btn-success w-100 text-light"
                                                            @click="
                                                                addToCart(
                                                                    pkg.id
                                                                )
                                                            "
                                                        >
                                                            Add Package to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- OPTIONAL ADD ON -->

                        <div
                            class="add-on-container p-4 mb-3"
                        v-if="step4.addOns && step4.addOns.length && step3.start_up === 1"
                        >
                            <p class="text-uppercase mb-3">Optional Add-On</p>
                            <div
                                class="accordion add-on-accordion mx-auto w-50 w-md-75 w-lg-50"
                                id="accordionExample"
                            >
                                <div v-for="(addOn, idx) in step4.addOns" :key="addOn.id">
                                    <!-- 🎤 Pitching Competition -->
                                    <div v-if="addOn.id === 5">
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" :id="`headingAddOn${idx}`">
                                                <button
                                                    class="accordion-button"
                                                    :class="{ collapsed: openAddOnIdx !== idx }"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    :data-bs-target="`#collapseAddOn${idx}`"
                                                    :aria-expanded="openAddOnIdx === idx ? 'true' : 'false'"
                                                    :aria-controls="`collapseAddOn${idx}`"
                                                    @click="toggleAddOnAccordion(idx)"
                                                >
                                                    <div class="d-flex flex-column">
                                                        <p class="fw-bold mb-0">{{ addOn.name }}</p>
                                                        <p class="mb-0 small">
                                                            <!-- No cost, just empty text -->
                                                            <span>Free of charge</span>

                                                            <!-- Max per exhibitor -->
                                                        
                                                        </p>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div
                                                :id="`collapseAddOn${idx}`"
                                                class="accordion-collapse collapse"
                                                :aria-labelledby="`headingAddOn${idx}`"
                                                data-bs-parent="#accordionExample"
                                            >
                                                <div class="accordion-body row g-3 align-items-center">
                                                    <p>{{addOn.notes}}</p>

                                                    <!-- 🎤 Pitching Competition Categories -->
                                                <div class="mb-3">
                                                    <label class="fw-bold mb-1">Select Pitching Categories:</label>
                                                    <div class="d-flex flex-column">
                                                        <div
                                                            v-for="category in addOn.pitching_session_categories"
                                                            :key="category.id"
                                                            class="form-check"
                                                        >
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                :id="`pitchingCat${category.id}`"
                                                                 v-model="step4.pitching_competition_selection"
                                                                :value="category.id"
                                                            />
                                                            <label
                                                                class="form-check-label"
                                                                :for="`pitchingCat${category.id}`"
                                                            >
                                                                {{ category.value }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <div class="col-md-12 d-flex justify-content-start align-items-start gap-3">
                                          

                                                        <!-- Add to Cart button -->
                                                        <button
                                                            class="btn btn-light text-success fw-bold h-100"
                                                            @click="addPitchingAddOnToCart(addOn, idx)"
                                                        >
                                                        Confirm 
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 🛒 Default add-ons -->
                                    <div v-else>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" :id="`headingAddOn${idx}`">
                                                <button
                                                    class="accordion-button"
                                                    :class="{ collapsed: openAddOnIdx !== idx }"
                                                    type="button"
                                                    data-bs-toggle="collapse"
                                                    :data-bs-target="`#collapseAddOn${idx}`"
                                                    :aria-expanded="openAddOnIdx === idx ? 'true' : 'false'"
                                                    :aria-controls="`collapseAddOn${idx}`"
                                                    @click="toggleAddOnAccordion(idx)"
                                                >
                                                    <div class="d-flex flex-column">
                                                        <p class="fw-bold mb-0">{{ addOn.name }}</p>
                                                        <p class="mb-0 small">
                                                            {{ addOn.rates && addOn.rates.length ? addOn.rates[0].currency : "" }}
                                                            <span
                                                                v-if="addOn.rates && addOn.rates.length && addOn.rates[0].cost !== null"
                                                            >
                                                                {{ addOn.rates[0].cost.toLocaleString() }}
                                                            </span>
                                                            {{ addOn.unit ? "/" + addOn.unit : "" }}

                                                            <!-- Max per exhibitor -->
                                                            <span v-if="addOn.limit_per_exhibitor">
                                                                — max {{ addOn.limit_per_exhibitor }}
                                                            </span>
                                                        </p>
                                                    </div>
                                                </button>
                                            </h2>

                                            <div
                                                :id="`collapseAddOn${idx}`"
                                                class="accordion-collapse collapse"
                                                :aria-labelledby="`headingAddOn${idx}`"
                                                data-bs-parent="#accordionExample"
                                            >
                                                <div class="accordion-body row g-3 align-items-center">
                                                    <div class="col-md-12 d-flex justify-content-start align-items-start gap-3">

                                                        <!-- Quantity input -->
                                                        <div class="w-50">
                                                            <div class="input-group">
                                                                <input
                                                                    type="text"
                                                                    class="form-control"
                                                                    placeholder="Enter quantity"
                                                                    v-model.number="addOn.selectedQty"
                                                                    v-limit="{ max: 15, numeric: true }"
                                                                    :max="addOn.limit_per_exhibitor"
                                                                    min="1"
                                                                />
                                                                <span class="input-group-text">
                                                                    {{ addOn.unit ? addOn.unit : "" }}
                                                                </span>
                                                            </div>
                                                            <small
                                                                class="text-light d-block mt-1"
                                                                v-if="addOn.limit_per_exhibitor"
                                                            >
                                                                Max: {{ addOn.limit_per_exhibitor }} {{ addOn.unit }}{{ addOn.limit_per_exhibitor > 1 ? "s" : "" }}
                                                            </small>
                                                        </div>

                                                        <!-- Add to Cart button -->
                                                        <button
                                                            class="btn btn-light text-success fw-bold h-100"
                                                            @click="addAddOnToCart(addOn, idx)"
                                                        >
                                                            <span class="mdi mdi-cart-outline"></span>
                                                            Add to Cart
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- END OPTIONAL ADD ON -->

                        <!-- CONFERENCE -->
                        <div class="col-md-12 mb-3">
                            <div class="card m-0 h-100 beige-bg custom-border-radius">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Conference*</h4>
                                            <p>Are you interested in participating in the SSX Conference?</p>
                                            <div
                                                v-if="
                                                    $v.step4.conference_response
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step4
                                                            .conference_response
                                                            .required
                                                    "
                                                >
                                                    Conference is
                                                    required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="conference_response_yes"
                                                    :value="1"
                                                    v-model="
                                                        step4.conference_response
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="conference_response_yes"
                                                >
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="conference_response_no"
                                                    :value="0"
                                                    v-model="
                                                        step4.conference_response
                                                    "
                                                   
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="conference_response_no"
                                                >
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END CONFERENCE -->

                          <!-- SPONSORSHIP  -->
                        <div class="col-md-12 mb-3">
                            <div class="card m-0 h-100 beige-bg custom-border-radius">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>Sponsorship*</h4>
                                            <p>Are you interested in becoming a sponsor for SSX 2026?</p>
                                            <div
                                                v-if="
                                                    $v.step4.sponsorship_response
                                                        .$error
                                                "
                                            >
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step4
                                                            .sponsorship_response
                                                            .required
                                                    "
                                                >
                                                    Sponsorship is
                                                    required.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="sponsorship_response_yes"
                                                    :value="1"
                                                    v-model="
                                                        step4.sponsorship_response
                                                    "
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="sponsorship_response_yes"
                                                >
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="radio"
                                                    id="sponsorship_response_no"
                                                    :value="0"
                                                    v-model="
                                                        step4.sponsorship_response
                                                    "
                                                   
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="sponsorship_response_no"
                                                >
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END SPONSORSHIP -->
                            
                        <div v-if="showParticipationWarning" class="alert alert-danger mt-4">
                            <p class="mb-0 fw-semibold">
                                *Please clear your cart, then select a booth size based on your participation type.
                            </p>
                        </div>

                        <div class="my-4">
                            <h6 class="fw-bold text-uppercase">
                                {{ step1.co_name }}
                            </h6>

                            <!-- Wrap table inside a slider div -->
                            <div class="table-slider">
                                <table
                                    class="table table-sm align-middle text-center mb-0"
                                    style="min-width: 1200px"
                                >
                                    <thead class="table-light">
                                        <tr class="fw-bold">
                                            <td>Package</td>
                                            <td>Package Details</td>
                                            <td>Booth Cost</td>
                                            <td>Discount</td>
                                            <td>Booth Size</td>
                                            <td>Participation Fee</td>
                                            <td>Total</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in cart" :key="item.id">
                                            <td class="text-start">
                                                {{ item.package_title }} -
                                                {{ item.space_name }}
                                            </td>
                                            <td>
                                                {{ item.package_sub_title }}
                                            </td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.booth_amount
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                <p style="margin-bottom: 0px">
                                                    {{
                                                        item.discount
                                                            ? formatNumber(
                                                                  item.discount
                                                              )
                                                            : "—"
                                                    }}
                                                </p>
                                                <p
                                                    style="margin-bottom: 0px"
                                                    v-if="item.discount_remarks"
                                                >
                                                    <small class="">{{
                                                        item.discount_remarks
                                                    }}</small>
                                                </p>
                                            </td>
                                            <td>{{ item.booth_size_name }}  <span
                                                    class="mdi mdi-window-close"
                                                ></span>
                                                {{ item.qty }}</td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.total_participation
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.total_amount_due
                                                    )
                                                }}
                                            </td>
                                            <td>
                                                <div class="mt-1">
                                                    <button
                                                        class="btn btn-sm btn-outline-danger me-1"
                                                        @click="
                                                            deleteCartItem(
                                                                item.id
                                                            )
                                                        "
                                                    >
                                                        <i
                                                            class="far fa-trash-alt"
                                                        ></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- ADD-ONS SECTION -->
                                        <tr
                                            v-if="addonCart.length"
                                            class="fw-bold table-light"
                                        >
                                            <td>ADD ONS:</td>
                                            <td>Name</td>
                                            <td>Quantity</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td></td>
                                            <td></td>
                                        </tr>

                                        <tr
                                            v-for="(item, index) in addonCart"
                                            :key="item.id"
                                        >
                                            <td></td>
                                            <!-- Add-on Name -->
                                           <td>
                                               
                                                <div v-if="item.addon_id === 5">
                                                    {{ item.addon_name }}
                                                </div>

                                             
                                                <div v-else>
                                                    {{ item.addon_name }}:
                                                    {{ item.currency }}
                                                    {{ formatNumber(item.rate_cost) }}/{{ item.unit }}
                                                </div>
                                            </td>
                                            <!-- Qty -->
                                            <td>
                                                {{ item.qty }}
                                            </td>
                                            <!-- Total Amount -->
                                            <td></td>
                                            <td
                                                colspan="2"
                                                class="text-end"
                                            ></td>
                                            <td>

                                                <div v-if="item.addon_id === 5">
                                              —
                                                </div>

                                                  <div v-else>
                                                   {{ item.currency }}
                                                {{
                                                    formatNumber(
                                                        item.total_amount_due
                                                    )
                                                }}
                                                </div>
                                                
                                            </td>

                                            <!-- Optional delete button -->
                                            <td>
                                                <button
                                                    class="btn btn-sm btn-outline-danger me-1"
                                                    @click="
                                                        deleteAddOnToCart(
                                                            item.id
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="far fa-trash-alt"
                                                    ></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Fallback row if cart is empty -->
                                        <tr
                                            v-if="
                                                cart.length === 0 &&
                                                addonCart.length === 0
                                            "
                                        >
                                            <td
                                                colspan="8"
                                                class="text-center text-muted py-4"
                                            >
                                                Your
                                                <span
                                                    class="mdi mdi-cart"
                                                ></span>
                                                cart is empty — please select a
                                                package to continue.
                                            </td>
                                        </tr>
                                        <!-- Summary Rows -->
                                        <tr class="table-light fw-bold"  v-if="
                                                    mandatory &&
                                                    mandatory.is_required
                                                ">
                                            <td colspan="6" class="text-end">
                                                SSX Mandatory Fee:
                                            </td>
                                            <td
                                               
                                            >
                                                {{ mandatory.currency }}
                                                {{
                                                    formatNumber(
                                                        mandatory.price
                                                    )
                                                }}
                                            </td>

                                           
                                            <td></td>
                                        </tr>
                                        <tr class="table-secondary fw-bold">
                                            <td colspan="6" class="text-end">
                                                Estimated Total Amount Due:
                                            </td>
                                            <td>
                                                {{ mandatory.currency }}
                                                {{ formatNumber(grandTotal) }}
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div
                                class="mt-2"
                                v-if="mandatory && mandatory.is_required"
                            >
                                <p class="mb-0 small">
                                    {{ mandatory.details }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
         
            </tab-content> 
            <tab-content title="Upload Requirements"  :before-change="doStep5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Upload Requirements</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
                            <!-- Local -->
                            <div v-if="step3.business_type !== 3">
                                <!-- Copy of registration from DTI or SEC
                                        (with complete Articles of
                                        Incorporation) -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of registration from DTI or SEC
                                        (with complete Articles of
                                        Incorporation) <span v-if="isDoc1Required" class="text-danger">*</span></label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent1"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc1"
                                        @beforedelete="
                                            onBeforeDelete($event, 1)
                                        "
                                        @select="onSelect($event, 1)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div v-if="$v.step5.doc1.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc1.required"
                                        >
                                            Please upload a copy of registration
                                            from dti or sec (with complete
                                            articles of incorporation).
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <!-- BIR -->
                                <div class="col-12">    
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of registration from BIR (Form
                                        2303) <span v-if="isDoc2Required" class="text-danger">*</span></label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent2"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc2"
                                        @beforedelete="
                                            onBeforeDelete($event, 2)
                                        "
                                        @select="onSelect($event, 2)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div
                                        class="mt-1"
                                        v-if="$v.step5.doc2.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc2.required"
                                        >
                                            Please upload a copy of registration
                                            from bir (form 2303).
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <!-- LTO -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of valid License to Operate (LTO)
                                        (or equivalent document, if not
                                        applicable) <span v-if="isDoc3Required" class="text-danger">*</span></label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent3"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc3"
                                        @beforedelete="
                                            onBeforeDelete($event, 3)
                                        "
                                        @select="onSelect($event, 3)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div
                                        class="mt-1"
                                        v-if="$v.step5.doc3.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc3.required"
                                        >
                                            Please upload a copy of valid
                                            License to Operate (LTO) (or
                                            equivalent document, if not
                                            applicable)*
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <!-- CPR -->
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of valid Certificate of Product
                                        Registration (CPR) (or equivalent
                                        document, if not applicable)</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent4"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc4"
                                        @beforedelete="
                                            onBeforeDelete($event, 4)
                                        "
                                        @select="onSelect($event, 4)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <!-- <div
                                        class="mt-1"
                                        v-if="$v.step5.doc4.$error"
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc4.required"
                                        >
                                            Please upload a copy of valid
                                            Certificate of Product Registration
                                            (CPR) (or equivalent document, if
                                            not applicable)*
                                        </div>
                                    </div> -->
                                </div>
                                <!-- Copy of valid food/ environmental
                                        certifications such as Fairtrade, FSC,
                                        Green Choice, HACCP, Halal, ISO,
                                        etc -->
                                <br />
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of valid food/ environmental
                                        certifications such as Fairtrade, FSC,
                                        Green Choice, HACCP, Halal, ISO,
                                        etc.</label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent5"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc5"
                                        @beforedelete="
                                            onBeforeDelete($event, 5)
                                        "
                                        @select="onSelect($event, 5)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <!-- <div
                                        v-if="
                                            $v.step5.doc5 &&
                                            $v.step5.doc5.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc5.required"
                                        >
                                            Please upload a copy of valid food/
                                            environmental certifications such as
                                            Fairtrade, FSC, Green Choice, HACCP,
                                            Halal, ISO, etc.
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- /Local -->

                            <!-- Foreign -->
                            <div v-if="step3.business_type === 3">
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Copy of business certification/
                                        license<span class="text-danger">*</span></label
                                    >
                                    <VueFileAgent
                                        ref="vueFileAgent7"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc7"
                                        @beforedelete="
                                            onBeforeDelete($event, 7)
                                        "
                                        @select="onSelect($event, 7)"
                                    ></VueFileAgent>

                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <div
                                        v-if="
                                            $v.step5.doc7 &&
                                            $v.step5.doc7.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc7.required"
                                        >
                                            Please upload a copy of business
                                            certification/license.
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="col-12">
                                    <label class="form-label fw-bold">
                                        Copy of valid food/environmental
                                        certification/s issued by 3rd party
                                        certification bodies (i.e. BRC, EcoCert,
                                        Green Choice, Fairtrade, FSC, HACCP,
                                        HALAL, ISO, Kosher, USDA)
                                    </label>
                                    <VueFileAgent
                                        ref="vueFileAgent8"
                                        :multiple="false"
                                        :deletable="true"
                                        :linkable="true"
                                        :meta="true"
                                        :accept="'image/*,.pdf'"
                                        :maxSize="'1MB'"
                                        :maxFiles="1"
                                        :theme="'list'"
                                        v-model="step5.doc8"
                                        @beforedelete="
                                            onBeforeDelete($event, 8)
                                        "
                                        @select="onSelect($event, 8)"
                                    ></VueFileAgent>
                                    <div id="emailHelp" class="form-text">
                                        Max size of 1MB and accept image and pdf
                                        document only.
                                    </div>
                                    <!-- <div
                                        v-if="
                                            $v.step5.doc8 &&
                                            $v.step5.doc8.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!$v.step5.doc8.required"
                                        >
                                            Please upload a copy of valid
                                            food/environmental certification/s
                                            issued by 3rd party certification
                                            bodies.
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <!-- /Foreign -->
                            <!-- Local/Foreign -->
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Institutional brochure/catalog includes
                                    company profile, product/service photos, and
                                    map/site sketch of the company
                                    location  <span class="text-danger">*</span></label
                                >
                                <VueFileAgent
                                    ref="vueFileAgent6"
                                    :multiple="false"
                                    :deletable="true"
                                    :linkable="true"
                                    :meta="true"
                                    :accept="'image/*,.pdf'"
                                    :maxSize="'1MB'"
                                    :maxFiles="1"
                                    :theme="'list'"
                                    v-model="step5.doc6"
                                    @beforedelete="onBeforeDelete($event, 6)"
                                    @select="onSelect($event, 6)"
                                ></VueFileAgent>
                                <div id="emailHelp" class="form-text">
                                    Max size of 1MB and accept image and pdf
                                    document only.
                                </div>
                                <div
                                    v-if="$v.step5.doc6 && $v.step5.doc6.$error"
                                >
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step5.doc6.required"
                                    >
                                        Please upload a copy of valid
                                        institutional brochure/catalog.
                                    </div>
                                </div>
                            </div>
                            <!-- /Local/Foreign -->
                        </div>
                    </div>

                 

                    <div class="mb-5"></div>
                </div>
            </tab-content>
          <tab-content title="Summary of Application">
    <summary-of-application-card
        :event_info="event_info"
        :company_info="step1"
        :products="products"
        :contact_info="step2"
        :business_info="step3"
        :order_info="step4"
        :docs="step5"
        :business_types="business_types"
        :company_sizes="company_sizes"
        :annual_sales_volumes="annual_sales_volumes"
        :organization_types="organization_types"
        :nature_businesses="nature_businesses"
        :target_buyers="target_buyers"
        :countries="countries"
        :certifications="certifications"
        :categories="categories"
        :inputs_outputs="inputs_outputs"
        :sdgs="sdgs"
        :production_processes="production_processes"
        :packages="step4.packages"
        :format-number-fn="formatNumber"
        :cart="cart"
        :addOns="step4.addOns"
        :addonCart="addonCart"
        :mandatory="mandatory"
    />

<div class="card mb-4 shadow-sm custom-border-radius" > 
    <div class="card-header bg-light" style="border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">
        <h4 class="fw-bold mb-0" style="color: #9daa39;">
            Please read and acknowledge the following terms and conditions for your application:
        </h4>
    </div>

    <div class="card-body p-3" style="line-height: 1.6; text-align: left;">
        <!-- Agreement 3 -->
        <div class="d-flex flex-column mb-4">
            <div class="d-flex align-items-center">
                <input
                    class="form-check-input me-2"
                    type="checkbox"
                    v-model="agreementPolicyChecked"
                />
                <span
                    class="flex-grow-1"
                    style="color: #9daa39; cursor: pointer;"
                    @click="dropdownPolicyPrivacyOpen = !dropdownPolicyPrivacyOpen"
                >
                    <h5 class="mb-0">
                        {{ agreement3.checkbox_title || 'No Policy Privacy' }}
                        <span class="text-danger">*</span>
                    </h5>
                </span>

                <i
                    :class="dropdownPolicyPrivacyOpen ? 'mdi mdi-chevron-up' : 'mdi mdi-chevron-down'"
                    style="font-size: 1.5rem; cursor: pointer; color: #9daa39;"
                    @click="dropdownPolicyPrivacyOpen = !dropdownPolicyPrivacyOpen"
                ></i>
            </div>

            <div
                class="border rounded bg-light p-3 mt-2"
                v-show="dropdownPolicyPrivacyOpen"
                v-html="agreement3.description || '<p>No agreement found.</p>'"
                style="font-size: 0.9rem;"
            ></div>
        </div>

        <!-- Agreement 4 -->
        <div class="d-flex flex-column mb-4">
            <div class="d-flex align-items-center">
                <input
                    class="form-check-input me-2"
                    type="checkbox"
                    v-model="agreementInformationSharingChecked"
                />
                <span
                    class="flex-grow-1"
                    style="color: #9daa39; cursor: pointer;"
                    @click="dropdownInformationSharingOpen = !dropdownInformationSharingOpen"
                >
                    <h5 class="mb-0">
                        {{ agreement4.checkbox_title || 'No Policy Privacy' }}
                    </h5>
                </span>

                <i
                    :class="dropdownInformationSharingOpen ? 'mdi mdi-chevron-up' : 'mdi mdi-chevron-down'"
                    style="font-size: 1.5rem; cursor: pointer; color: #9daa39;"
                    @click="dropdownInformationSharingOpen = !dropdownInformationSharingOpen"
                ></i>
            </div>

            <div
                class="border rounded bg-light p-3 mt-2"
                v-show="dropdownInformationSharingOpen"
                v-html="agreement4.description || '<p>No agreement found.</p>'"
                style="font-size: 0.9rem;"
            ></div>
        </div>

        <!-- Agreement 1 -->
        <div class="d-flex flex-column mb-2">
            <div class="d-flex align-items-center">
                <input
                    class="form-check-input me-2"
                    type="checkbox"
                    v-model="agreementChecked"
                />
                <span
                    class="flex-grow-1"
                    style="color: #9daa39; cursor: pointer;"
                    @click="dropdownRegistrationOpen = !dropdownRegistrationOpen"
                >
                    <h5 class="mb-0">
                        {{ agreement1.checkbox_title || 'No Policy Privacy' }}
                        <span class="text-danger">*</span>
                    </h5>
                </span>

                <i
                    :class="dropdownRegistrationOpen ? 'mdi mdi-chevron-up' : 'mdi mdi-chevron-down'"
                    style="font-size: 1.5rem; cursor: pointer; color: #9daa39;"
                    @click="dropdownRegistrationOpen = !dropdownRegistrationOpen"
                ></i>
            </div>

            <div
                class="border rounded bg-light p-3 mt-2"
                v-show="dropdownRegistrationOpen"
                v-html="agreement1.description || '<p>No agreement found.</p>'"
                style="font-size: 0.9rem;"
            ></div>
        </div>
    </div>
</div>


              
            </tab-content>
        </form-wizard>
    </div>
</template>
<script>
import SummaryOfApplicationCard from "./cards/SummaryOfApplication.vue";
import { FormWizard, TabContent } from "vue-form-wizard";
import "vue-form-wizard/dist/vue-form-wizard.min.css";
import Vuelidate from "vuelidate";
import {
    required,
    email,
    url,
    numeric,
    requiredIf,
} from "vuelidate/lib/validators";
import BlockUI from "vue-blockui";
import VueFileAgent from "vue-file-agent";
import "vue-file-agent/dist/vue-file-agent.css";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
Vue.use(require("vue-moment"));
Vue.use(BlockUI);
Vue.use(Vuelidate);
Vue.use(VueFileAgent);
Vue.use(VueSweetalert2);
Vue.use(VueToast);

// In a main JS file or inside your component registration
Vue.directive("limit", {
    bind(el, binding) {
        // Allow shorthand: v-limit="100" or v-limit="{ max: 100, numeric: true }"
        const cfg =
            typeof binding.value === "object" && binding.value !== null
                ? binding.value
                : { max: binding.value };
        const max = parseInt(cfg.max, 10) || 1000;
        const numericOnly = !!cfg.numeric;

        // keep track of composition state (IME) so we don't truncate mid-composition
        el._limit = { composing: false };

        const inputHandler = (e) => {
            if (el._limit.composing) return; // don't interfere while user is composing text (IME)
            let val = el.value || "";
            if (numericOnly) val = val.replace(/\D+/g, "");
            if (val.length > max) val = val.substring(0, max);
            if (el.value !== val) {
                el.value = val;
                // update v-model
                el.dispatchEvent(new Event("input"));
            }
        };

        const pasteHandler = (e) => {
            let paste =
                (e.clipboardData || window.clipboardData).getData("text") || "";
            if (numericOnly) paste = paste.replace(/\D+/g, "");
            const currentVal = el.value || "";
            const availableSpace = max - currentVal.length;
            if (availableSpace <= 0) {
                e.preventDefault();
                return;
            }
            if (paste.length > availableSpace) {
                e.preventDefault();
                el.value = currentVal + paste.substring(0, availableSpace);
                el.dispatchEvent(new Event("input"));
            }
        };

        const onCompositionStart = () => (el._limit.composing = true);
        const onCompositionEnd = (e) => {
            el._limit.composing = false;
            // run a final input check after composition ends
            inputHandler(e);
        };

        el.addEventListener("input", inputHandler);
        el.addEventListener("paste", pasteHandler);
        el.addEventListener("compositionstart", onCompositionStart);
        el.addEventListener("compositionend", onCompositionEnd);

        // Set native maxlength for non-numeric inputs to help mobile/IME UI
        if (!numericOnly && max) {
            try {
                el.setAttribute("maxlength", String(max));
            } catch (e) {
                // ignore if element doesn't support attribute
            }
        }

        // cleanup helper
        el._limit_cleanup = () => {
            el.removeEventListener("input", inputHandler);
            el.removeEventListener("paste", pasteHandler);
            el.removeEventListener("compositionstart", onCompositionStart);
            el.removeEventListener("compositionend", onCompositionEnd);
            delete el._limit;
            delete el._limit_cleanup;
        };
    },
    unbind(el) {
        if (el._limit_cleanup) el._limit_cleanup();
    },
});

export default {
    props: ["params"],
    data() {
        return {

            isLoading: false,
            showParticipationWarning: false,
            //for async and watcher custom
            isInitialLoad: true,
            
          
            

            activeTab: null,
            msg: "Saving record. Please wait...",
            user_id: "",
            event_info: {
                id: "",
                event_name: "",
                fair_code: "",
            },
            agreement: {
                id: "",
                type: "",
                title: "",
                status: "",
                description: "",
            },
            agreements: [],
            dropdownRegistrationOpen: true,
            dropdownPolicyPrivacyOpen: true,
            dropdownInformationSharingOpen: true,
            agreementChecked: false,
            agreementPolicyChecked: false,
            agreementInformationSharingChecked: false,
            agreementScrolledToBottom: false,
            cart: [],
            mandatory: {},
            addonCart: [],
            openAddOnIdx: null,
            token: "",
            countries: [],
            regions: [],
            business_types: [],
            company_sizes: [],
            annual_sales_volumes: [],
            organization_types: [],
            nature_businesses: [],
            certifications: [],
            categories: [],
            target_buyers: [],
            inputs_outputs: [],
            sdgs: [],
            production_processes: [],
            topics: [],
            banner_sizes: [],
            products: [],
            disabled_fa: false,
            disabled_bcp: false,
            product_id: "",
            step1: {
                exhibitor_type: 1,
                last_participated: null,
                fascia_name: "",
                co_name: "",
                co_email: "",
                co_details: "",
                mission: "",
                env_conservation: "",
                directory_name: "",
                country_code: "",
                area_code: "",
                phone_no: "",
                country_code_mobile: "",
                mobile_no: "",
                website: "",
                masthead: "",
                co_logo: "",
                facebook: "",
                twitter: "",
                instagram: "",
                linkedin: "",
                other_social: "",
                fa_country: "",
                fa_state: "",
                fa_city: "",
                fa_zipcode: "",
                fa_region: "",
                fa_street: "",
                same_as_moa: "",
                moa_country: "",
                moa_state: "",
                moa_city: "",
                moa_zipcode: "",
                moa_region: "",
                moa_street: "",
                masthead_selected: "",
                co_logo_selected: "",
            },
            step2: {
                salutation: "",
                fname: "",
                lname: "",
                mi: "",
                designation: "",
                email: "",
                country_code_mobile_bo: "",
                mobile_no_bo: "",
                same_as_bo: "",
                bcp_salutation: "",
                bcp_fname: "",
                bcp_lname: "",
                bcp_mi: "",
                bcp_designation: "",
                bcp_email: "",
                bcp_country_code: "",
                bcp_mobile_no: "",
            },
            step3: {
                startUpDisabled: false,
                business_type: "",
                prevBusinessType: "",
                start_up: 0,
                prevStartUp: 0,
                company_size: "",
                annual_sales_volume: "",
                direct: "",
                indirect: "",
                organization_type: "",
                nature_business: [],
                nature_business_others: "",
                industry_representation: "",
                exporting_country_1: "",
                exporting_country_2: "",
                exporting_country_3: "",
                target_country_1: "",
                target_country_2: "",
                target_country_3: "",
                target_buyer: [],
                target_buyer_others: "",
                certification: [],
                certification_others: "",
                product_promoted: "",
                category: [],
                sdg: [],
                input_ouput: [],
                production_process: [],
                production_process_others: "",
                topic: [],
                sustainability_topics: [],
            },
            step4: {
                banner_size: 1,
                packages: [],
                addOns: [],
                packageState: {},
                participation_type: null,
                conference_response: null,
                sponsorship_response: null,
                pitching_competition_selection: [],
            },
            step5: {
                doc1: "",
                doc1_selected: "",
                doc2: "",
                doc2_selected: "",
                doc3: "",
                doc3_selected: "",
                doc4: "",
                doc4_selected: "",
                doc5: "",
                doc5_selected: "",
                doc6: "",
                doc6_selected: "",
                doc7: "",
                doc7_selected: "",
                doc8: "",
                doc8_selected: "",
            },
            step6: {
                agree: "",
            },
            prod_info: {
                prod_name: "",
                prod_details: "",
                prod_images: [],
                prod_images_for_upload: [],
                prod_profiles: [],
                prod_certs: [],
                store_url: "",
                certs_others: "",
            },
        };
    },
    computed: {
        //registration
        agreement1() {
            return this.agreements.find((a) => a.id === 1) || {};
        },
        // Policy Privacy
        agreement3() {
            return this.agreements.find((a) => a.id === 3) || {};
        },

        //Information Sharing
        agreement4() {
            return this.agreements.find((a) => a.id === 4) || {};
        },

        check_moa_address() {
            if (
                this.step1.moa_country &&
                this.step1.moa_state &&
                this.step1.moa_city &&
                this.step1.moa_zipcode
            ) {
                return false;
            } else {
                return true;
            }
        },
        check_same_as_bo() {
            if (
                this.step2.fname &&
                this.step2.lname &&
                this.step2.designation &&
                this.step2.email &&
                this.step2.country_code_mobile_bo &&
                this.step2.mobile_no_bo
            ) {
                return false;
            } else {
                return true;
            }
        },
        check_target_others() {
            if (this.step3.target_buyer.includes(6) === true) {
                this.$nextTick(() => {
                    document.getElementById("target_buyer_others").focus();
                });
                return false;
            } else {
                this.step3.target_buyer_others = "";
                return true;
            }
        },

        check_nature_business_others() {
            if (this.step3.nature_business.includes(16) === true) {
                this.$nextTick(() => {
                    document.getElementById("nature_business_others").focus();
                });
                return false;
            } else {
                this.step3.nature_business_others = "";
                return true;
            }
        },
        check_certification_others() {
            if (this.step3.certification.includes(14) === true) {
                this.$nextTick(() => {
                    document.getElementById("certification_others").focus();
                });
                return false;
            } else {
                this.step3.certification_others = "";
                return true;
            }
        },
        check_production_process_others() {
            if (this.step3.production_process.includes(3) === true) {
                this.$nextTick(() => {
                    document
                        .getElementById("production_process_others")
                        .focus();
                });
                return false;
            } else {
                this.step3.production_process_others = "";
                return true;
            }
        },
        check_prod_cert_others() {
            if (this.prod_info.prod_certs.includes(14) === true) {
                this.$nextTick(() => {
                    document.getElementById("certs_others").focus();
                });
                return false;
            } else {
                this.prod_info.certs_others = "";
                return true;
            }
        },
        cartTotal() {
            // Sum booth/package total + add-on total
            const boothTotal = this.cart.reduce(
                (sum, item) => sum + (item.total_amount_due || 0),
                0
            );
            const addOnTotal = this.addonCart.reduce(
                (sum, item) => sum + (item.total_amount_due || 0),
                0
            );
            return boothTotal + addOnTotal;
        },
        grandTotal() {
            const mandatoryPrice =
                this.mandatory && this.mandatory.is_required
                    ? this.mandatory.price
                    : 0;

            return this.cartTotal + mandatoryPrice;
        },
        isDoc1Required() {
        return !this.step3.start_up && this.step3.business_type !== 3;
        },
        isDoc2Required() {
            return !this.step3.start_up && this.step3.business_type !== 3;
        },
        isDoc3Required() {
            return !this.step3.start_up && this.step3.business_type !== 3;
        },

    },
    validations: {
        step1: {
            exhibitor_type: { required },
           last_participated: {
                required: requiredIf(function () {
                    return Number(this.step1.exhibitor_type) === 2;
                }),
            },
            fascia_name: { required,},
            directory_name: { required },
            website: { url },
            other_social: { url },
            co_details: { required },
            mission: { required },
            env_conservation: { required },
            country_code: {  },
            area_code: {  numeric },
            phone_no: {  },
            country_code_mobile: { required },
            mobile_no: { required },
            masthead: { required },
            co_logo: { required },
            fa_country: { required },
            fa_state: { required },
            fa_city: { required },
            fa_zipcode: { required, numeric },
            fa_region: {
                required: requiredIf(function () {
                    if (this.step1.fa_country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            fa_street: {
                required,
            },
            moa_country: { required },
            moa_state: { required },
            moa_city: { required },
            moa_zipcode: { required, numeric },
            moa_region: {
                required: requiredIf(function () {
                    if (
                        this.step1.moa_country === 148 &&
                        this.disabled_moa === false
                    ) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            moa_street: {
                required,
            },
        },

        step2: {
            salutation: { required, },
            fname: { required },
            lname: { required },
            designation: { required },
            email: { required, email },
            country_code_mobile_bo: { required },
            mobile_no_bo: { required, numeric },
            bcp_salutation: { required },
            bcp_fname: { required },
            bcp_lname: { required },
            bcp_designation: { required },
            bcp_email: { required, email },
            bcp_country_code: { required },
            bcp_mobile_no: { required, numeric },
        },
        step3: {
            business_type: { required },
            company_size: { required },
            annual_sales_volume: { required },
            organization_type: { required },
            // Number of workers (direct) must be required and numeric
            direct: { required },
            // Number of workers (indirect) should be numeric if provided
            indirect: { required },
            nature_business: { required },
            nature_business_others: {
                required: requiredIf(function () {
                    return this.step3.nature_business.includes(16);
                }),
            },
            industry_representation: { required },
            exporting_country_1: {
                required: requiredIf(function () {
                    if (this.step3.industry_representation === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
                isUnique() {
                    if (this.step3.industry_representation === 1) {
                        const arr_exporting_country = [
                            this.step3.exporting_country_1,
                            this.step3.exporting_country_2,
                            this.step3.exporting_country_3,
                        ];
                        const allUnique = !arr_exporting_country.some(
                            (v, i) => arr_exporting_country.indexOf(v) < i
                        );
                        return allUnique;
                    } else {
                        return true;
                    }
                },
            },
            exporting_country_2: {
                required: requiredIf(function () {
                    if (this.step3.industry_representation === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            exporting_country_3: {
                required: requiredIf(function () {
                    if (this.step3.industry_representation === 1) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
            target_country_1: {
                required,
                isUnique() {
                    const arr_target_country = [
                        this.step3.target_country_1,
                        this.step3.target_country_2,
                        this.step3.target_country_3,
                    ];
                    const allUnique = !arr_target_country.some(
                        (v, i) => arr_target_country.indexOf(v) < i 
                    );
                    return allUnique;
                },
            },
            target_country_2: { required },
            target_country_3: { required },
            target_buyer: { required },
            target_buyer_others: {
                required: requiredIf(function () {
                    return this.step3.target_buyer.includes(6);
                }),
            },
            certification: { required },
            certification_others: {
                required: requiredIf(function () {
                    return this.step3.certification.includes(14);
                }),
            },
            product_promoted: { required },
            category: { required },
            sdg: { required },
            // input_ouput: { required },
            // production_process: { required },
            // production_process_others: {
            //     required: requiredIf(function () {
            //         return this.step3.production_process.includes(3);
            //     }),
            // },
          
        },
        step4: {
            banner_size: { required },
            participation_type: { required },
            conference_response: { required },
            sponsorship_response: { required },
            cart_not_empty: {
                required: function () {
                    // Custom validator: cart must not be empty
                    return this.cart && this.cart.length > 0;
                },
            },
        },
        step5: {
            // Only required when NOT start-up and NOT business type 3
            doc1: {
                required: requiredIf(function () {
                    return (
                        !this.step3.start_up && this.step3.business_type !== 3
                    );
                }),
            },
            doc2: {
                required: requiredIf(function () {
                    return (
                        !this.step3.start_up && this.step3.business_type !== 3
                    );
                }),
            },
            doc3: {
                required: requiredIf(function () {
                    return (
                        !this.step3.start_up && this.step3.business_type !== 3
                    );
                }),
            },

            // Only depends on business_type
            // doc4: {
            //     required: requiredIf(function () {
            //         return this.step3.business_type !== 3;
            //     }),
            // },
            // doc5: {
            //     required: requiredIf(function () {
            //         return this.step3.business_type !== 3;
            //     }),
            // },

            doc6: { required },

            // Required only when business_type = 3
            doc7: {
                required: requiredIf(function () {
                    return this.step3.business_type === 3;
                }),
            },
            // doc8: {
            //     required: requiredIf(function () {
            //         return this.step3.business_type === 3;
            //     }),
            // },
        },
        step6: {
            agree: { required },
        },
        prod_info: {
            prod_name: { required },
            prod_details: { required },
            prod_images: { required },
            prod_profiles: { required },
            prod_certs: { required },
            store_url: { url },
            certs_others: {
                required: requiredIf(function () {
                    return this.prod_info.prod_certs.includes(14);
                }),
            },
        },
    },
    components: {
        FormWizard,
        TabContent,
        SummaryOfApplicationCard,
    },
    async mounted() {
        this.isLoading = true; // Start loading indicator

        try {
            await this.getEventInfo();
            await this.getUserInfo();
            await this.getCategories();
        } catch (e) {
            console.error("Init error:", e);
        } finally {
            this.isInitialLoad = false;
            this.isLoading = false; // Loading done
        }
    },
    created() {
        this.getCountries();
        this.getRegions();
        this.getBusinessTypes();
        this.getCompanySizes();
        this.getAnnualSalesVolumes();
        this.getOrganizationTypes();
        this.getNatureBusinesses();
        this.getCertifications();
        this.getTargetBuyers();
        this.getSdgs();
        this.getInputOuputs();
        this.getProductionProcesses();
        this.getRankTopics();
        this.getBannerSizes();
        this.getUserAgreement();
    },
    methods: {
        formatNumber(value) {
            if (!value) return "0";
            return new Intl.NumberFormat("en-US", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(value);
        },
        getEventInfo() {
            return axios
                .get(`/api/supplier/events/${this.params.event_id}`)
                .then(({ data }) => {
                    // console.log("Fetched event data:", data);
                    Object.assign(this.event_info, data);
                })
                .catch((error) => {
                    console.error("Failed to fetch event:", error);
                });
        },
        getUserAgreement() {
            axios
                .get("/api/supplier/user-agreement/registration")
                .then(({ data }) => {
                    this.agreements = data.filter((a) => a.status === 1); // only active
                });
        },
        async getUserInfo() {
            try {
                const response = await axios.get(
                    `/api/supplier/user-information/${this.params.id}/${this.event_info.fair_code}`
                );

                //console.log(response.data)
                if (response.status === 200) {
                    this.user_id = response.data.id;
                    this.token = response.data.reg_token;
                      //STEP 1
                      this.step1.fascia_name = response.data.fascia_name;
                    this.step1.exhibitor_type = response.data.exhibitor_type ?? 1;
                    this.step1.last_participated = response.data.last_participated ?? null;
                    this.step1.co_name = response.data.exhibitor.co_name;
                    this.step1.co_email = response.data.exhibitor.co_email;
                    this.step1.co_details = response.data.exhibitor.co_details;
                    this.step1.selling_proposition =
                        response.data.exhibitor.selling_proposition;
                    this.step1.mission =
                        response.data.exhibitor.mission_statement;
                    this.step1.env_conservation =
                        response.data.exhibitor.env_conservation;
                    this.step1.directory_name =
                        response.data.exhibitor.directory_name;
                    this.step1.country_code = response.data.exhibitor
                        .phone_country_code
                        ? response.data.exhibitor.phone_country_code
                        : "";
                    this.step1.area_code =
                        response.data.exhibitor.phone_area_code;
                    this.step1.phone_no = response.data.exhibitor.phone_no;
                    this.step1.country_code_mobile = response.data.exhibitor
                        .mobile_country_code
                        ? response.data.exhibitor.mobile_country_code
                        : "";
                    this.step1.mobile_no = response.data.exhibitor.mobile_no;
                    this.step1.website = response.data.exhibitor.website;
                    this.step1.facebook = response.data.exhibitor.facebook;
                    this.step1.twitter = response.data.exhibitor.twitter;
                    this.step1.instagram = response.data.exhibitor.instagram;
                    this.step1.linkedin = response.data.exhibitor.linkedin;
                    this.step1.other_social =
                        response.data.exhibitor.other_social;
                    this.step1.fa_country = response.data.exhibitor.fa_country
                        ? response.data.exhibitor.fa_country
                        : "";
                    this.step1.fa_state = response.data.exhibitor.fa_state;
                    this.step1.fa_city = response.data.exhibitor.fa_city;
                    this.step1.fa_zipcode = response.data.exhibitor.fa_zipcode;
                    this.step1.fa_region = response.data.exhibitor.fa_region
                        ? response.data.exhibitor.fa_region
                        : "";
                    this.step1.fa_street = response.data.exhibitor.fa_street;
                    this.step1.same_as_moa =
                        response.data.exhibitor.fa_same_as_moa;
                    if (response.data.exhibitor.fa_same_as_moa === 1) {
                        this.disabled_fa = true;
                    }
                    this.step1.moa_country = response.data.exhibitor.moa_country
                        ? response.data.exhibitor.moa_country
                        : "";
                    this.step1.moa_state = response.data.exhibitor.moa_state;
                    this.step1.moa_city = response.data.exhibitor.moa_city;
                    this.step1.moa_zipcode =
                        response.data.exhibitor.moa_zipcode;
                    this.step1.moa_region = response.data.exhibitor.moa_region
                        ? response.data.exhibitor.moa_region
                        : "";
                    this.step1.moa_street = response.data.exhibitor.moa_street;
                    if (response.data.masthead) {
                        this.step1.masthead = [
                            {
                                name: response.data.masthead.basename,
                                url:
                                    "/storage/exhibitors/mastheads/" +
                                    response.data.masthead.basename,
                                size: 1234,
                                type:
                                    "image/" + response.data.masthead.extension,
                                ext: response.data.masthead.extension,
                            },
                        ];
                    }
                    if (response.data.logo) {
                        this.step1.co_logo = [
                            {
                                name: response.data.logo.basename,
                                url:
                                    "/storage/exhibitors/logos/" +
                                    response.data.logo.basename,
                                size: 1234,
                                type: "image/" + response.data.logo.extension,
                                ext: response.data.logo.extension,
                            },
                        ];
                    }
                    //STEP 2
                    this.products = response.data.products;
                    if (response.data.business_owner) {
                        this.step2.salutation =
                            response.data.business_owner.salutation;
                        this.step2.fname = response.data.business_owner.fname;
                        this.step2.lname = response.data.business_owner.lname;
                        this.step2.mi = response.data.business_owner.mi;
                        this.step2.designation =
                            response.data.business_owner.designation;
                        this.step2.email = response.data.business_owner.email;
                        this.step2.country_code_mobile_bo =
                            response.data.business_owner.country_code;
                        this.step2.mobile_no_bo =
                            response.data.business_owner.mobile_no;
                    }
                    if (response.data.business_contact_person) {
                        if (
                            response.data.business_contact_person.same_as_bo ===
                            1
                        ) {
                            this.disabled_bcp = true;
                        }
                        this.step2.same_as_bo =
                            response.data.business_contact_person.same_as_bo;
                        this.step2.bcp_salutation =
                            response.data.business_contact_person.salutation;
                        this.step2.bcp_fname =
                            response.data.business_contact_person.fname;
                        this.step2.bcp_lname =
                            response.data.business_contact_person.lname;
                        this.step2.bcp_mi =
                            response.data.business_contact_person.mi;
                        this.step2.bcp_designation =
                            response.data.business_contact_person.designation;
                        this.step2.bcp_email =
                            response.data.business_contact_person.email;
                        this.step2.bcp_country_code =
                            response.data.business_contact_person.country_code;
                        this.step2.bcp_mobile_no =
                            response.data.business_contact_person.mobile_no;
                    }
                    //STEP 3
                    this.step3.business_type =
                        response.data.exhibitor.business_type_id;
                    this.step3.start_up = response.data.exhibitor.start_up;
                    this.step3.prevBusinessType = this.step3.business_type;
                    this.step3.prevStartUp = this.step3.start_up;
                    this.step3.company_size =
                        response.data.exhibitor.company_size_id;
                    this.step3.annual_sales_volume =
                        response.data.exhibitor.annual_sales_volume_id;
                    this.step3.direct = response.data.exhibitor.direct_workers;
                    this.step3.indirect =
                        response.data.exhibitor.indirect_workers;
                    this.step3.organization_type =
                        response.data.exhibitor.organization_type_id;
                    for (
                        var n = 0;
                        n < response.data.nature_business.length;
                        n++
                    ) {
                        if (
                            response.data.nature_business[n][
                                "nature_business_id"
                            ] === 16
                        ) {
                            this.step3.nature_business_others =
                                response.data.nature_business[n]["remarks"];
                        }

                        this.step3.nature_business.push(
                            response.data.nature_business[n][
                                "nature_business_id"
                            ]
                        );
                    }
                    this.step3.industry_representation =
                        response.data.exhibitor.industry_rep;

                    this.step3.exporting_country_1 = response.data.exhibitor
                        .ir_country_exporting_1
                        ? response.data.exhibitor.ir_country_exporting_1
                        : "";
                    this.step3.exporting_country_2 = response.data.exhibitor
                        .ir_country_exporting_2
                        ? response.data.exhibitor.ir_country_exporting_2
                        : "";
                    this.step3.exporting_country_3 = response.data.exhibitor
                        .ir_country_exporting_3
                        ? response.data.exhibitor.ir_country_exporting_3
                        : "";
                    this.step3.target_country_1 = response.data.exhibitor
                        .target_country_export_1
                        ? response.data.exhibitor.target_country_export_1
                        : "";
                    this.step3.target_country_2 = response.data.exhibitor
                        .target_country_export_2
                        ? response.data.exhibitor.target_country_export_2
                        : "";
                    this.step3.target_country_3 = response.data.exhibitor
                        .target_country_export_3
                        ? response.data.exhibitor.target_country_export_3
                        : "";
                    for (
                        var t = 0;
                        t < response.data.target_buyer.length;
                        t++
                    ) {
                        if (
                            response.data.target_buyer[t]["target_buyer_id"] ===
                            6
                        ) {
                            this.step3.target_buyer_others =
                                response.data.target_buyer[t]["remarks"];
                        }
                        this.step3.target_buyer.push(
                            response.data.target_buyer[t]["target_buyer_id"]
                        );
                    }
                    this.step3.product_promoted =
                        response.data.exhibitor.product_promoted;
                    for (
                        var c = 0;
                        c < response.data.certification.length;
                        c++
                    ) {
                        if (
                            response.data.certification[c][
                                "certification_id"
                            ] === 14
                        ) {
                            this.step3.certification_others =
                                response.data.certification[c]["remarks"];
                        }
                        this.step3.certification.push(
                            response.data.certification[c]["certification_id"]
                        );
                    }
                    for (
                        var s = 0;
                        s < response.data.category_subcategory.length;
                        s++
                    ) {
                        this.step3.category.push(
                            response.data.category_subcategory[s][
                                "sub_category_id"
                            ]
                        );
                        // k;
                    }
               
                    for (
                        var i = 0;
                        i < response.data.sdg.length;
                        i++
                    ) {
                        this.step3.sdg.push(
                            response.data.sdg[i]["sdg_id"]
                        );
                    }
                    for (
                        var i = 0;
                        i < response.data.on_input_output.length;
                        i++
                    ) {
                        this.step3.input_ouput.push(
                            response.data.on_input_output[i]["input_output_id"]
                        );
                    }
                    for (
                        var p = 0;
                        p < response.data.on_production_process.length;
                        p++
                    ) {
                        if (
                            response.data.on_production_process[p][
                                "production_process_id"
                            ] === 3
                        ) {
                            this.step3.production_process_others =
                                response.data.on_production_process[p][
                                    "other_certification"
                                ];
                        }
                        this.step3.production_process.push(
                            response.data.on_production_process[p][
                                "production_process_id"
                            ]
                        );
                    }
                    // if (response.data.topic_rank.length >= 6) {
                    //     this.step3.ranking.push(0);
                    //     for (
                    //         var r = 0;
                    //         r < response.data.topic_rank.length;
                    //         r++
                    //     ) {
                    //         this.step3.ranking.push(
                    //             response.data.topic_rank[r]["rank"]
                    //         );
                    //     }
                    // }
                    this.step3.sustainability_topics = response.data.topic_pick
                        ? response.data.topic_pick.map((tp) => tp.topic_id)
                        : [];

                    //STEP 4
                    this.step4.banner_size = response.data.exhibitor
                        .banner_size_id
                        ? response.data.exhibitor.banner_size_id
                        : 1;

                    this.step4.participation_type =
                        response.data.step4 &&
                        response.data.step4.participation_type
                            ? response.data.step4.participation_type
                            : null;
                            
                this.step4.conference_response =
    response.data.step4 && response.data.step4.conference_response !== undefined && response.data.step4.conference_response !== null
        ? response.data.step4.conference_response
        : null;

                            
           this.step4.sponsorship_response =
    response.data.step4 && response.data.step4.sponsorship_response !== undefined && response.data.step4.sponsorship_response !== null
        ? response.data.step4.sponsorship_response
        : null;

        this.step4.pitching_competition_selection =
    response.data.step4.pitching_competition_selection || [];
                    //STEP 5
                    if (response.data.doc1) {
                        this.step5.doc1 = [
                            {
                                name: response.data.doc1.basename,
                                url: response.data.doc1_url,
                                size: response.data.doc1_filesize,
                                type:
                                    response.data.doc1.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc1.extension,
                                ext: response.data.doc1.extension,
                            },
                        ];
                    }
                    if (response.data.doc2) {
                        this.step5.doc2 = [
                            {
                                name: response.data.doc2.basename,
                                url: response.data.doc2_url,
                                size: response.data.doc2_filesize,
                                type:
                                    response.data.doc2.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc2.extension,
                                ext: response.data.doc2.extension,
                            },
                        ];
                    }
                    if (response.data.doc3) {
                        this.step5.doc3 = [
                            {
                                name: response.data.doc3.basename,
                                url: response.data.doc3_url,
                                size: response.data.doc3_filesize,
                                type:
                                    response.data.doc3.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc3.extension,
                                ext: response.data.doc3.extension,
                            },
                        ];
                    }
                    if (response.data.doc4) {
                        this.step5.doc4 = [
                            {
                                name: response.data.doc4.basename,
                                url: response.data.doc4_url,
                                size: response.data.doc4_filesize,
                                type:
                                    response.data.doc4.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc4.extension,
                                ext: response.data.doc4.extension,
                            },
                        ];
                    }
                    if (response.data.doc5) {
                        this.step5.doc5 = [
                            {
                                name: response.data.doc5.basename,
                                url: response.data.doc5_url,
                                size: response.data.doc5_filesize,
                                type:
                                    response.data.doc5.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc5.extension,
                                ext: response.data.doc5.extension,
                            },
                        ];
                    }
                    if (response.data.doc6) {
                        this.step5.doc6 = [
                            {
                                name: response.data.doc6.basename,
                                url: response.data.doc6_url,
                                size: response.data.doc6_filesize,
                                type:
                                    response.data.doc6.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc6.extension,
                                ext: response.data.doc6.extension,
                            },
                        ];
                    }
                    if (response.data.doc7) {
                        this.step5.doc7 = [
                            {
                                name: response.data.doc7.basename,
                                url: response.data.doc7_url,
                                size: response.data.doc7_filesize,
                                type:
                                    response.data.doc7.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc7.extension,
                                ext: response.data.doc7.extension,
                            },
                        ];
                    }
                    if (response.data.doc8) {
                        this.step5.doc8 = [
                            {
                                name: response.data.doc8.basename,
                                url: response.data.doc8_url,
                                size: response.data.doc8_filesize,
                                type:
                                    response.data.doc8.extension === "pdf"
                                        ? "application/pdf"
                                        : "image/" +
                                          response.data.doc8.extension,
                                ext: response.data.doc8.extension,
                            },
                        ];
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        // async fetchPackages() {
        //     try {
        //         const { data, status } = await axios.get(
        //             "/api/supplier/packages"
        //         );

        //         if (status === 200) {
        //             console.log("✅ Packages fetched:", data);

        //             // Optional: detailed view
        //             data.forEach((pkg) => {
        //                 console.log(`📦 Package: ${pkg.title} (ID: ${pkg.id})`);

        //                 pkg.participation_booth_spaces.forEach((space) => {
        //                     console.log(
        //                         `  🏢 Space ID ${space.id} [${space.booth_min_size}-${space.booth_max_size}]`
        //                     );

        //                     if (
        //                         space.filtered_sizes &&
        //                         space.filtered_sizes.length > 0
        //                     ) {
        //                         console.table(space.filtered_sizes);
        //                     } else {
        //                         console.warn(
        //                             `  ⚠️ No filtered sizes for space ${space.id}`
        //                         );
        //                     }
        //                 });
        //             });

        //             this.packages = data;
        //             this.initializePackageState();
        //         }
        //     } catch (error) {
        //         console.error(" Error fetching packages:", error);
        //     }
        // },

async fetchPackages() {
    try {
        const { data, status } = await axios.get(
            "/api/supplier/packages",
            {
                params: {
                    user_id: this.user_id,
                    is_startup: this.step3.start_up,
                    business_type: this.step3.business_type,

                    // NEW
                    participation_type:
                        this.step4.participation_type,
                },
            }
        );

        if (status === 200) {

            this.$set(
                this.step4,
                "packages",
                data
            );

            this.initializePackageState();
        }

    } catch (error) {
        console.error(
            "❌ Error fetching packages:",
            error
        );
    }
},

        async fetchAddOnRates() {
            const businessTypeId = this.step3.business_type;
            const fairCode = this.event_info.fair_code;
            try {
                const response = await axios.get(
                    `/api/supplier/addon-rates/${businessTypeId}/${fairCode}`
                );

                const mappedAddOns = response.data.add_on_rates.map((rate) => ({
                    id: rate.add_on.id,
                    name: rate.add_on.name,
                    unit: rate.add_on.unit,
                    limit_per_exhibitor: rate.add_on.limit_per_exhibitor,
                    notes: rate.add_on.notes,
                    status: rate.add_on.status,
                    rates: [
                        {
                            id: rate.id,
                            currency: rate.currency,
                            cost: rate.cost,
                            status: rate.status,
                        },
                    ],
                    pitching_session_categories: rate.pitching_session_categories || [],
                    selectedCategories: [], 
                }));

                // store under step4.addOns reactively
                this.$set(this.step4, "addOns", mappedAddOns);

                // 🧾 Log as a table for debugging
                // console.table(
                //     (this.step4.addOns || []).map((addOn) => ({
                //         AddOn_ID: addOn.id,
                //         Rate_ID: addOn.rates[0].id, //participation_add_on_rates.id
                //         Name: addOn.name,
                //         Unit: addOn.unit,
                //         Limit: addOn.limit_per_exhibitor,
                //         Currency: addOn.rates[0].currency,
                //         Cost: addOn.rates[0].cost,
                //         Status: addOn.status,
                //     }))
                // );
            } catch (err) {
                console.error("Failed to fetch add-ons", err);
            }
        },

        initializePackageState() {
            this.step4.packageState = {};
            // iterate the packages stored on step4
            (this.step4.packages || []).forEach((pkg) => {
                this.$set(this.step4.packageState, pkg.id, {
                    showCart: false,
                    selected_size_id: null,
                    selected_space_id: null,
                    qty: null,
                });
            });
        },


        // getFilteredSizes(pkg) {
        //     const pkgState = this.step4.packageState[pkg.id];
        //     if (!pkgState || !pkgState.selected_space_id) return [];

        //     const selectedSpace = pkg.participation_booth_spaces.find(
        //         (space) => space.id === pkgState.selected_space_id
        //     );
        //     if (!selectedSpace || !selectedSpace.filtered_sizes) return [];

        //     // Apply filter only for Individual + start_up = 0
        //     if (
        //         this.step4.participation_type == 1 &&
        //         this.step3.start_up == 0
        //     ) {
        //         return selectedSpace.filtered_sizes.filter((size) => {
        //             const sqm = parseInt(size.name); // "4sqm" → 4
        //             return sqm >= 4 && sqm <= 8;
        //         });
        //     }

        //     return selectedSpace.filtered_sizes;
        // },

        
        // getFilteredSizes(pkg) {
        //     const pkgState = this.step4.packageState[pkg.id];
        //     if (!pkgState || !pkgState.selected_space_id) return [];

        //     const selectedSpace = pkg.participation_booth_spaces.find(
        //         (space) => space.id === pkgState.selected_space_id
        //     );
        //     if (!selectedSpace || !selectedSpace.filtered_sizes) return [];

        //     // Participation type 1 (existing rule)
        //     if (
        //         this.step4.participation_type == 1 &&
        //         this.step3.start_up == 0
        //     ) {
        //         return selectedSpace.filtered_sizes.filter((size) => {
        //             const sqm = size.code; // "4sqm" -> 4
        //             return sqm >= 4 && sqm <= 8;
        //         });
        //     }

        //     // Participation type 2 → only 4sqm and 6sqm
        //     if (this.step4.participation_type == 2) {
        //         return selectedSpace.filtered_sizes.filter((size) => {
        //             const sqm = size.code;
        //             return sqm === 4 || sqm === 6;
        //         });
        //     }

        //     return selectedSpace.filtered_sizes;
        // },

    getFilteredSizes(pkg) {
        const pkgState = this.step4.packageState[pkg.id];

        if (!pkgState || !pkgState.selected_space_id) {
            return [];
        }

        const selectedSpace = pkg.participation_booth_spaces.find(
            (space) => space.id == pkgState.selected_space_id
        );

        if (!selectedSpace || !selectedSpace.filtered_sizes) {
            return [];
        }

        // Group participation
        if (this.step4.participation_type == 2) {

            // Startup space:
            // use filtered_sizes as-is
            if (selectedSpace.type === "startup") {
                return selectedSpace.filtered_sizes;
            }

            // Regular/default space:
            // only 4sqm and 6sqm
            return selectedSpace.filtered_sizes.filter((size) => {
                const sqm = Number(size.code);

                return sqm === 4 || sqm === 6;
            });
        }

        // Regular / startup participation
        return selectedSpace.filtered_sizes;
    },
        

        toggleCart(pkgId, spaceId) {
            // Check if participation type is selected
            if (!this.step4.participation_type) {
                // Show toast error
                Vue.$toast.error("Participation type is required.", {
                    position: "top-right",
                });
                return; // Stop further execution
            }

            // Proceed to toggle cart
            const state = this.step4.packageState[pkgId];
            state.showCart = true;
            state.selected_size_id = null;
            state.selected_space_id = spaceId;
        },

        togglePackage(pkgId) {
            const state = this.step4.packageState[pkgId];
            if (state) {
                state.showCart = false;
                state.selected_space_id = null;
                state.selected_size_id = null;
                state.qty = null;
            }
            // console.log("Reset state for package:", pkgId);
        },

        isCartVisible(pkgId) {
            return this.step4.packageState[pkgId]?.showCart;
        },

addToCart(pkgId) {
    const state = this.step4.packageState[pkgId];

    if (!state.selected_size_id) {
        Vue.$toast.error(
            "Please select a booth size before adding to cart.",
            { position: "top-right" }
        );
        return;
    }

    const pkg = this.step4.packages.find(
        (pkg) => pkg.id == pkgId
    );

    if (!pkg) {
        Vue.$toast.error("Package not found.", {
            position: "top-right",
        });
        return;
    }

    const selectedSpace = pkg.participation_booth_spaces.find(
        (space) => space.id == state.selected_space_id
    );

    if (!selectedSpace) {
        Vue.$toast.error("Please select a booth space.", {
            position: "top-right",
        });
        return;
    }

    const payload = {
        user_id: this.user_id,
        package_id: pkgId,
        space_id: state.selected_space_id,
        size_id: state.selected_size_id,
        qty: state.qty,
        fair_code: this.event_info.fair_code,
        start_up: this.step3.start_up,
        participation_type: this.step4.participation_type,

        // Important: send the actual space type
        space_type: selectedSpace.type,
    };

    this.isLoading = true;

    axios
        .post("/supplier/cart/add", payload)
        .then(async (response) => {
            this.isLoading = false;

            if (!response.data.success) {
                Vue.$toast.error(response.data.message, {
                    position: "top-right",
                });
                return;
            }

            if (response.data.cart) {
                const selections =
                    response.data.cart.participation_selections || [];

                this.cart = selections.map((item) => ({
                    id: item.id,
                    booth_size_name: item.booth_size_name,
                    booth_amount: item.booth_amount,
                    currency: item.currency,
                    discount: item.discount,
                    discount_remarks: item.discount_remarks,
                    package_title: item.package?.title || "",
                    qty: item.booth_qty,
                    package_sub_title:
                        item.package?.sub_title || "",
                    package_id: item.package_id,
                    space_name: item.space?.name || "",
                    total_participation:
                        item.total_participation,
                    total_amount_due:
                        item.total_amount_due,
                }));
            } else {
                await this.getCart();
            }

            if (response.data.mandatory) {
                this.mandatory = response.data.mandatory;
            } else {
                await this.fetchMandatory();
            }

            Vue.$toast.success("Item added to cart.", {
                position: "top-right",
            });
        })
        .catch((err) => {
            this.isLoading = false;

            let backendMessage =
                "Failed to add item to cart.";

            if (
                err.response &&
                err.response.data &&
                err.response.data.message
            ) {
                backendMessage = err.response.data.message;
            }

            Vue.$toast.error(backendMessage, {
                position: "top-right",
            });
        });

    // Reset after add
    state.selected_space_id = null;
    state.selected_size_id = null;
    state.showCart = false;
    state.qty = null;
},
        increaseQty(pkgId) {
            const state = this.step4.packageState[pkgId];
            if (!state.qty) {
                this.$set(state, "qty", 1);
            }
            state.qty++;
        },

        decreaseQty(pkgId) {
            const state = this.step4.packageState[pkgId];
            if (!state.qty || state.qty <= 1) {
                state.qty = 1;
                return;
            }
            state.qty--;
        },

        getCart() {
            return axios
                .get(
                    `/api/supplier/cart/fetch/${this.user_id}/${this.event_info.fair_code}`
                )
                .then((response) => {
                    if (response.data.success) {
                        // console.log("Cart fetched successfully!");
                        const selections =
                            response.data.cart.participation_selections || [];
                        // Always assign a new array to trigger reactivity
                        this.cart = selections.map((item) => ({
                            id: item.id,
                            booth_size_code: item.booth_size_code,
                            booth_size_name: item.booth_size_name,
                            package_id: item.package_id,
                            booth_amount: item.booth_amount,
                            currency: item.currency,
                            discount: item.discount,
                            discount_remarks: item.discount_remarks,
                            package_title: item.package?.title || "",
                            qty: item.booth_qty,
                            package_sub_title: item.package?.sub_title || "",
                            space_name: item.space?.name || "",
                            total_participation: item.total_participation,
                            total_amount_due: item.total_amount_due,
                        }));
                        // console.table(this.cart, [
                        //     "id",
                        //     "package_title",
                        //     "package_sub_title",
                        //     "space_name",
                        //     "currency",
                        //     "booth_amount",
                        //     "discount",
                        //     "discount_remarks",
                        //     "booth_size_name",
                        //     "total_participation",
                        //     "total_amount_due",
                        // ]);
                    } else {
                        // If cart is empty or fetch failed, clear the cart array
                        this.cart = [];
                        // console.info("Cart:", response.data.message);
                    }
                })
                .catch((err) => {
                    // On error, also clear the cart array to avoid stale data
                    this.cart = [];
                    // console.error("❌ Error fetching cart:", err);
                });
        },

        selectedSpace(pkg) {
            const pkgState = this.step4.packageState[pkg.id];
            if (!pkgState || !pkgState.selected_space_id) return null;

            return pkg.participation_booth_spaces.find(
                (s) => s.id === pkgState.selected_space_id
            );
        },

        deleteCartItem(cartItemId) {
            if (!cartItemId) return;
            this.isLoading = true;
            axios
                .post("/supplier/cart/delete", {
                    cart_item_id: cartItemId,
                    user_id: this.user_id,
                    fair_code: this.event_info.fair_code,
                })
                .then(async (response) => {
                    if (response.data.success) {
                        // Always refresh cart and mandatory fee after delete
                        await Promise.all([
                            this.getCart(),
                            this.fetchMandatory(),
                        ]);
                        Vue.$toast.success("Item removed from cart.", {
                            position: "top-right",
                        });
                    }
                })
                .catch(() => {
                    this.$toast.open({
                        message: "Error deleting cart item.",
                        type: "error",
                    });
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        addAddOnToCart(addOn, idx) {
            if (!addOn.selectedQty || addOn.selectedQty < 1) {
                this.$toast.error("Please enter a valid quantity.", {
                    position: "top-right",
                });
                return;
            }

            // ✅ No optional chaining — classic check for Vue 2
            const rateId =
                addOn.rates && addOn.rates.length && addOn.rates[0].id
                    ? addOn.rates[0].id
                    : null;

            if (!rateId) {
                this.$toast.error("Add-on rate not found.");
                return;
            }

            const payload = {
                user_id: this.user_id,
                participation_addon_rate_id: rateId,
                fair_code: this.event_info.fair_code,
                quantity: addOn.selectedQty,
            };

            this.isLoading = true;
            axios
                .post("/supplier/addon-selection/add", payload)
                .then(async (response) => {
                    this.isLoading = false;

                    if (!response.data.success) {
                        this.$toast.error(response.data.message, {
                            position: "top-right",
                        });
                        return; // stop further processing
                    }

                    if (response.data.success) {
                        this.$toast.success("Add-on added to cart!", {
                            position: "top-right",
                        });

                        await this.getAddOnToCart();
                        addOn.selectedQty = null;

                        // update our local index state so button class updates
                        this.openAddOnIdx = null;

                        // also programmatically collapse the Bootstrap collapse element
                        // because Bootstrap's JS toggles the 'show' class itself and
                        // changing Vue state alone won't remove it.
                        this.$nextTick(() => {
                            try {
                                const collapseEl = document.getElementById(
                                    `collapseAddOn${idx}`
                                );
                                if (collapseEl) {
                                    const bsCollapse =
                                        bootstrap.Collapse.getInstance(
                                            collapseEl
                                        ) || new bootstrap.Collapse(collapseEl);
                                    bsCollapse.hide();
                                }
                            } catch (e) {
                                // ignore if bootstrap is not available or something fails
                                console.warn(
                                    "Could not programmatically hide add-on collapse",
                                    e
                                );
                            }
                        });
                    }
                })
                .catch((err) => {
                    this.isLoading = false;

                    // ✅ Check if backend sent a message
                    if (
                        err.response &&
                        err.response.data &&
                        err.response.data.message
                    ) {
                        this.$toast.error(err.response.data.message, {
                            position: "top-right",
                        });
                        // console.info(
                        //     "⚠️ Add-on request warning:",
                        //     message,
                        //     "\nFull response:",
                        //     err.response
                        // );
                    } else {
                        this.$toast.error("Failed to add add-on.", {
                            position: "top-right",
                        });

                        // Log error details for debugging
                        console.warn("❌ Unexpected add-on error:", err);
                    }

                    console.error(err);
                });
        },

        toggleAddOnAccordion(idx) {
            if (this.openAddOnIdx === idx) {
                // Closing the currently open accordion
                this.openAddOnIdx = null;
                if (this.step4.addOns && this.step4.addOns[idx])
                    this.step4.addOns[idx].selectedQty = null;
            } else {
                // Opening a new accordion, reset all others
                (this.step4.addOns || []).forEach((addOn, i) => {
                    if (i !== idx) addOn.selectedQty = null;
                });
                this.openAddOnIdx = idx;
            }
        },

        isAddOnAccordionOpen(idx) {
            return this.openAddOnIdx === idx;
        },

        getAddOnToCart() {
            return axios
                .get(
                    `/api/supplier/addon-cart/fetch/${this.user_id}/${this.event_info.fair_code}`
                )
                .then((response) => {
                    if (response.data.success) {
                        // Save to a new data property, e.g. this.addonCart
                        this.addonCart = response.data.addon_cart || [];
                        // Optionally, log for debugging
                        // console.table(this.addonCart);
                    } else {
                        this.addonCart = [];
                        console.warn(
                            "⚠️ Add-on cart fetch failed:",
                            response.data.message
                        );
                    }
                })
                .catch((err) => {
                    this.addonCart = [];
                    console.error("❌ Error fetching add-on cart:", err);
                });
        },

        deleteAddOnToCart(addonCartItemId) {
            if (!addonCartItemId) return;
            this.isLoading = true;
            axios
                .post("/supplier/addon-cart/delete", {
                    addon_cart_item_id: addonCartItemId,
                    user_id: this.user_id,
                    fair_code: this.event_info.fair_code,
                })
                .then(async (response) => {
                    this.isLoading = false;
                    if (response.data.success) {
                        this.$toast.success("Add-on removed from cart.", {
                            position: "top-right",
                        });
                        
                        await this.getAddOnToCart();
                           this.step4.pitching_competition_selection = [];
                    }
                })
                .catch(() => {
                    this.isLoading = false;
                    this.$toast.error("Error deleting add-on cart item.");
                });
        },

        async deleteAllCartItems() {
            // this.isLoading = true;
            try {
                await axios.post("/supplier/cart/delete-all", {
                    user_id: this.user_id,
                    fair_code: this.event_info.fair_code,
                });
                await Promise.all([this.getCart(), this.fetchMandatory()]);
                // Vue.$toast.success("All cart items deleted.", {
                //     position: "top-right",
                // });
            } catch (e) {
                Vue.$toast.error("Failed to delete all cart items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },

        async deleteAllAddOnCartItems() {
            // this.isLoading = true;
            try {
                const response = await axios.post(
                    "/supplier/addon-cart/delete-all",
                    {
                        user_id: this.user_id,
                        fair_code: this.event_info.fair_code,
                    }
                );
                if (response.data.success) {
                    await this.getAddOnToCart();
                    // Vue.$toast.success("All add-on cart items deleted.", {
                    //     position: "top-right",
                    // });

                    this.step4.pitching_competition_selection = [];
                } else {
                    Vue.$toast.error(
                        response.data.message ||
                            "Failed to delete all add-on cart items.",
                        {
                            position: "top-right",
                        }
                    );
                }
            } catch (e) {
                Vue.$toast.error("Failed to delete all add-on cart items.", {
                    position: "top-right",
                });
            } finally {
                // this.isLoading = false;
            }
        },

        async deleteAllDocuments() {
            try {
                await axios.post("/api/supplier/upload-documents/delete-all", {
                    user_id: this.user_id,
                    fair_code: this.event_info.fair_code,
                });

                // Reset frontend state
            this.step5 = {
                doc1: "",
                doc1_selected: "",
                doc2: "",
                doc2_selected: "",
                doc3: "",
                doc3_selected: "",
                doc4: "",
                doc4_selected: "",
                doc5: "",
                doc5_selected: "",
                doc6: "",
                doc6_selected: "",
                doc7: "",
                doc7_selected: "",
                doc8: "",
                doc8_selected: "",
            };

            } catch (e) {
                Vue.$toast.error("Failed to delete all documents.", {
                    position: "top-right",
                });
            }
        },

        fetchMandatory() {
            return axios
                .get(
                    `/api/supplier/mandatory/fetch/${this.user_id}/${this.event_info.fair_code}`
                )
                .then((response) => {
                    if (response.data.success) {
                        this.mandatory = response.data.mandatory;
                    }
                })
                .catch((err) => {
                    console.error("❌ Error fetching mandatory:", err);
                });
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

        getRegions() {
            axios
                .get("/api/regions")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.regions = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getBusinessTypes() {
            axios
                .get("/api/active_business_types")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.business_types = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCompanySizes() {
            axios
                .get("/api/company_sizes")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.company_sizes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getAnnualSalesVolumes() {
            axios
                .get("/api/annual_sales_volumes")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.annual_sales_volumes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getOrganizationTypes() {
            axios
                .get("/api/organization_types")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.organization_types = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getNatureBusinesses() {
            axios
                .get("/api/nature_businesses")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.nature_businesses = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCertifications() {
            axios
                .get("/api/certifications")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.certifications = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getCategories() {
            try {
                const response = await axios.get("/api/categories/is-startup", {
                    params: { is_startup: this.step3.start_up },
                });

                if (response.status === 200) {
                    this.categories = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        getInputOuputs() {
            axios
                .get("/api/on_input_output")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.inputs_outputs = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getSdgs(){
            axios
                .get("/api/sdg")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.sdgs = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },


  

        getProductionProcesses() {
            axios
                .get("/api/on_production_process")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.production_processes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTargetBuyers() {
            axios
                .get("/api/target_buyers")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.target_buyers = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getRankTopics() {
            axios
                .get("/api/supplier/pick_topics")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.topics = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getBannerSizes() {
            axios
                .get("/api/banner_sizes")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.banner_sizes = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        doProductEdit(id) {
            this.msg = "Checking product. Please wait...";
            this.isLoading = true;
            this.prod_info.prod_images = [];
            this.prod_info.prod_profiles = [];
            this.prod_info.prod_certs = [];
            axios
                .get("/api/product-information/" + id)
                .then((response) => {
                    //console.log(response.data)
                    this.scrollToTop();
                    this.isLoading = false;
                    this.product_id = response.data.id;
                    this.prod_info.prod_name = response.data.name;
                    this.prod_info.prod_details = response.data.description;
                    this.prod_info.store_url = response.data.store_url;
                    for (
                        var certs = 0;
                        certs < response.data.product_certifications.length;
                        certs++
                    ) {
                        if (
                            response.data.product_certifications[certs][
                                "certification_id"
                            ] === 14
                        ) {
                            this.prod_info.certs_others =
                                response.data.product_certifications[certs][
                                    "remarks"
                                ];
                        }
                        this.prod_info.prod_certs.push(
                            response.data.product_certifications[certs][
                                "certification_id"
                            ]
                        );
                    }
                    for (
                        var profile = 0;
                        profile < response.data.product_profiles.length;
                        profile++
                    ) {
                        this.prod_info.prod_profiles.push(
                            response.data.product_profiles[profile][
                                "sub_category_id"
                            ]
                        );
                    }
                    for (
                        var prod_image = 0;
                        prod_image < response.data.product_images.length;
                        prod_image++
                    ) {
                        this.prod_info.prod_images.push({
                            id: response.data.product_images[prod_image]["id"],
                            name: response.data.product_images[prod_image][
                                "image"
                            ],
                            url:
                                "/storage/exhibitors/products/" +
                                response.data.product_images[prod_image][
                                    "image"
                                ],
                            size: response.data.product_images[prod_image][
                                "img_size"
                            ],
                            type: response.data.product_images[prod_image][
                                "img_type"
                            ],
                            ext: response.data.product_images[prod_image][
                                "img_ext"
                            ],
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        doAddProduct() {
            this.scrollToTop();
            this.$v.prod_info.$touch();
            if (!this.$v.prod_info.$invalid) {
                this.msg = "Saving product. Please wait...";
                this.isLoading = true;
                let formData = new FormData();
                formData.append("event_fair_code", this.event_info.fair_code);
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("product_id", this.product_id);
                formData.append("step", "add_product");
                formData.append("prod_info", JSON.stringify(this.prod_info));
                return axios
                    .post("/supplier/registration/store", formData)
                    .then((response) => {
                        this.isLoading = false;
                        Vue.$toast.success("Product successfully saved.", {
                            position: "top-right",
                            onDismiss: this.clearProductForm(),
                        });
                        return true;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },
        
        doProductDelete(id) {
            this.$swal({
                title: "Are you sure you want to delete this product?",
                icon: "question",
                showCancelButton: true,
                customClass: {
                    title: "fs-5",
                    confirmButton: "btn btn-sm btn-success text-white m-1",
                    cancelButton: "btn btn-sm btn-secondary m-1",
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        axios
                            .delete("/api/product/delete/" + id)
                            .then((response) => {
                                if (response.status === 200) {
                                    Vue.$toast.success(
                                        "Product successfully deleted.",
                                        {
                                            position: "top-right",
                                            onDismiss: this.clearProductForm(),
                                        }
                                    );
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                },
            });
        },
        
        doSaveProducts() {
            this.scrollToTop();
            if (!this.product_id && this.products.length >= 1) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("event_fair_code", this.event_info.fair_code);
                formData.append("token", this.token);
                formData.append("step", "save_product");
                return axios
                    .post("/supplier/registration/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return true;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                Vue.$toast.error("Please add/update product", {
                    position: "top-right",
                });
                return false;
            }
        },
        
        clearProductForm() {
            this.prod_info.prod_name = "";
            this.prod_info.prod_details = "";
            this.prod_info.prod_images = [];
            this.prod_info.prod_images_for_upload = [];
            this.prod_info.prod_profiles = [];
            this.prod_info.prod_certs = [];
            this.prod_info.store_url = "";
            this.prod_info.certs_others = "";
            this.product_id = "";
            this.$v.prod_info.$reset();
            this.getUserInfo();
        },
        
        doStep1() {
            this.scrollToTop();
            this.$v.step1.$touch();
         
            if (
                !this.$v.step1.$invalid
            ) {
                let formData = new FormData();
                formData.append("event_fair_code", this.event_info.fair_code);
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", Number(1));
                formData.append("step1_data", JSON.stringify(this.step1));
                formData.append("masthead", this.step1.masthead_selected);
                formData.append("logo", this.step1.co_logo_selected);
          
                return axios
                    .post("/supplier/registration/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return true;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },
        
        doStep2() {
            this.scrollToTop();
            this.$v.step2.$touch();
            if (!this.$v.step2.$invalid) {
                let formData = new FormData();
                formData.append("event_fair_code", this.event_info.fair_code);
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", Number(2));
                formData.append("step2_data", JSON.stringify(this.step2));
                return axios
                    .post("/supplier/registration/store", formData)
                    .then((response) => {
                        //console.log(response.data);
                        return true;
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
            }
        },

        async onTabChange(prevIndex, nextIndex) {
            // console.log(`Moved from ${prevIndex} ➝ ${nextIndex}`);
            // Clear cart if moving back from step 4 → step 3
            // if (prevIndex === 4 && nextIndex === 3) {
            //     console.log("🗑 Clearing cart because user went back to step 3");
            //     await Promise.all([
            //         this.deleteAllCartItems(),
            //         this.deleteAllAddOnCartItems(),
            //     ]);
            // }
            // this.activeTab = nextIndex;
        },

        async doStep3() {
            this.scrollToTop();
            this.$v.step3.$touch();

            if (this.$v.step3.$invalid) return false;

            let formData = new FormData();
            formData.append("user_id", this.user_id);
            formData.append("event_fair_code", this.event_info.fair_code);
            formData.append("token", this.token);
            formData.append("step", 3);
            formData.append("step3_data", JSON.stringify(this.step3));

            this.isLoading = true;

            try {
                const response = await axios.post(
                    "/supplier/registration/store",
                    formData
                );

                const savedBusinessType = response.data.business_type;
                const savedStartUp = response.data.start_up;
                const savedParticipationType = response.data.participation_type;

                // ✔ Compare using previous values
                const changedBusinessType =
                    this.step3.prevBusinessType !== savedBusinessType;

                const changedStartUp = this.step3.prevStartUp !== savedStartUp;

                if (changedBusinessType || changedStartUp) {
                    await Promise.all([
                        this.deleteAllCartItems(),
                        this.deleteAllAddOnCartItems(),
                        this.deleteAllDocuments(),
                    ]);

                    // ✔ Update current + previous values
                    this.step3.business_type = savedBusinessType;
                    this.step3.start_up = savedStartUp;
                    this.step3.prevBusinessType = savedBusinessType;
                    this.step3.prevStartUp = savedStartUp;
                    this.step4.participation_type = savedParticipationType;
                    await Promise.all([
                        this.getCart(),
                        this.fetchPackages(),
                        this.fetchMandatory(),
                        this.fetchAddOnRates(),
                        this.getAddOnToCart(),
                    ]);
                } else {
                    // light reload
                    await Promise.all([
                        this.getCart(),
                        this.fetchPackages(),
                        this.fetchMandatory(),
                        this.fetchAddOnRates(),
                        this.getAddOnToCart(),
                    ]);
                }

                return true;
            } catch (err) {
                console.error("doStep3 error:", err);
                return false;
            } finally {
                this.isLoading = false;
            }
        },

        //for debug
        //         async doStep3() {
        //     this.scrollToTop();

        //     // ✅ Frontend validation
        //     if (!this.$v.step3) {
        //         console.error("Validation object step3 is undefined!");
        //         return false;
        //     }

        //     this.$v.step3.$touch();

        //     console.log("Step3 validation object:", this.$v.step3);
        //     console.log("Is step3 invalid?", this.$v.step3.$invalid);

        //     if (this.$v.step3.$invalid) {
        //         console.warn("Frontend validation failed.");
        //         return false;
        //     }

        //     // Prepare form data
        //     let formData = new FormData();
        //     formData.append("user_id", this.user_id);
        //     formData.append("event_fair_code", this.event_info.fair_code);
        //     formData.append("token", this.token);
        //     formData.append("step", 3);
        //     formData.append("step3_data", JSON.stringify(this.step3));

        //     console.log("Sending step3_data:", formData.get("step3_data"));

        //     this.isLoading = true;

        //     try {
        //         const response = await axios.post("/supplier/registration/store", formData);

        //         console.log("Backend response:", response.data);

        //         const savedBusinessType = response.data.business_type;
        //         const savedStartUp = response.data.start_up;
        //         const savedParticipationType = response.data.participation_type;

        //         const changedBusinessType = this.step3.prevBusinessType !== savedBusinessType;
        //         const changedStartUp = this.step3.prevStartUp !== savedStartUp;

        //         if (changedBusinessType || changedStartUp) {
        //             await Promise.all([
        //                 this.deleteAllCartItems(),
        //                 this.deleteAllAddOnCartItems(),
        //                 this.deleteAllDocuments(),
        //             ]);

        //             this.step3.business_type = savedBusinessType;
        //             this.step3.start_up = savedStartUp;
        //             this.step3.prevBusinessType = savedBusinessType;
        //             this.step3.prevStartUp = savedStartUp;
        //             this.step4.participation_type = savedParticipationType;

        //             await Promise.all([
        //                 this.getCart(),
        //                 this.fetchPackages(),
        //                 this.fetchMandatory(),
        //                 this.fetchAddOnRates(),
        //                 this.getAddOnToCart(),
        //             ]);
        //         } else {
        //             await Promise.all([
        //                 this.getCart(),
        //                 this.fetchPackages(),
        //                 this.fetchMandatory(),
        //                 this.fetchAddOnRates(),
        //                 this.getAddOnToCart(),
        //             ]);
        //         }

        //         return true;
        //     } catch (err) {
        //         // ✅ Backend validation errors
        //         if (err.response && err.response.status === 422) {
        //             console.warn("Backend validation errors:", err.response.data.errors);
        //         } else {
        //             console.error("doStep3 error:", err);
        //         }
        //         return false;
        //     } finally {
        //         this.isLoading = false;
        //     }
        // },

        async doStep4() {
            this.scrollToTop();
            this.showParticipationWarning = false;
            this.$v.step4.$touch();
            this.$v.step4.cart_not_empty.$touch();

            if (this.$v.step4.cart_not_empty.$invalid) {
                Vue.$toast.error(
                    "You must add at least one booth/package to your cart before proceeding.",
                    { position: "top-right" }
                );
                return false;
            }

            if (this.$v.step4.$invalid) {
                return false;
            }

            const participationType = this.step4.participation_type;
            const startup = this.step3.start_up;

            // ✅ If group participation, check booth size min
            if (participationType === 2) {
                await this.getCart();

                try {
                    const payload = this.cart.map((item) => ({
                        id: item.id,
                        booth_size_code: item.booth_size_code,
                        qty: item.qty,
                    }));

                    const res = await axios.post(
                        "/api/supplier/check-group-cart-booth-sizes",
                        { cart: payload }
                    );

                    if (res.data.has_invalid) {
                        if (
                            ["invalid_size"].includes(res.data.reason)
                        ) {
                            this.showParticipationWarning = true;
                        }

                        switch (res.data.reason) {
                            case "empty_cart":
                                Vue.$toast.error("Your cart is empty.", {
                                    position: "top-right",
                                });
                                break;

                            case "invalid_size":
                                Vue.$toast.error("Invalid booth size.", {
                                    position: "top-right",
                                });
                                break;

                            default:
                                Vue.$toast.error(
                                    "Group participation validation failed.",
                                    { position: "top-right" }
                                );
                        }

                        return false;
                    }
                } catch (err) {
                    Vue.$toast.error(
                        "Failed to validate booth sizes. Please try again.",
                        { position: "top-right" }
                    );

                    return false;
                }
            }

            if (participationType === 1 && startup === 0) {
                await this.getCart(); // make sure cart is up-to-date

                try {
                    const payload = this.cart.map((item) => ({
                        id: item.id,
                        booth_size_code: item.booth_size_code,
                        qty: item.qty,
                    }));

                    const res = await axios.post(
                        "/api/supplier/check-cart-booth-sizes",
                        { cart: payload }
                    );

                    if (res.data.has_invalid) {

                    if (
                        ["only_one", "invalid_size", "invalid_quantity"].includes(res.data.reason)
                    ) {
                        this.showParticipationWarning = true;
                    }

                    if (res.data.reason === "only_one") {
                        Vue.$toast.error("Only 1 booth/package allowed.", {
                            position: "top-right",
                        });
                    } else if (res.data.reason === "invalid_size") {
                        Vue.$toast.error("Selected booth is invalid.", {
                            position: "top-right",
                        });
                    } else if (res.data.reason === "invalid_quantity") {
                        Vue.$toast.error("Booth quantity must be 1.", {
                            position: "top-right",
                        });
                    } else {
                        Vue.$toast.error("Your selection is invalid.", {
                            position: "top-right",
                        });
                    }
                    return false; // validation failed
                }

                } catch (err) {
                    Vue.$toast.error(
                        "Failed to validate booth sizes. Please try again.",
                        { position: "top-right" }
                    );
                    return false;
                }
            }
            

            // ✅ Proceed to submit form
            try {
                const formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", 4);
                formData.append("event_fair_code", this.event_info.fair_code);
                formData.append("step4_data", JSON.stringify(this.step4));

                const response = await axios.post(
                    "/supplier/registration/store",
                    formData
                );
                return true;
            } catch (err) {
                Vue.$toast.error("Failed to submit Step 4. Please try again.", {
                    position: "top-right",
                });
                return false;
            }
        },

        async getDocs() {
    if (!this.user_id || !this.event_info.fair_code) return;

    try {
        const response = await axios.get(
            `/api/supplier/user-docs/${this.user_id}/${this.event_info.fair_code}`
        );

        if (response.status === 200 && response.data) {
            // STEP 5 documents
            if (response.data.doc1) {
                this.step5.doc1 = [
                    {
                        name: response.data.doc1.basename,
                        url: response.data.doc1_url,
                        size: response.data.doc1_filesize,
                        type:
                            response.data.doc1.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc1.extension,
                        ext: response.data.doc1.extension,
                    },
                ];
            }

            if (response.data.doc2) {
                this.step5.doc2 = [
                    {
                        name: response.data.doc2.basename,
                        url: response.data.doc2_url,
                        size: response.data.doc2_filesize,
                        type:
                            response.data.doc2.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc2.extension,
                        ext: response.data.doc2.extension,
                    },
                ];
            }

            if (response.data.doc3) {
                this.step5.doc3 = [
                    {
                        name: response.data.doc3.basename,
                        url: response.data.doc3_url,
                        size: response.data.doc3_filesize,
                        type:
                            response.data.doc3.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc3.extension,
                        ext: response.data.doc3.extension,
                    },
                ];
            }

            if (response.data.doc4) {
                this.step5.doc4 = [
                    {
                        name: response.data.doc4.basename,
                        url: response.data.doc4_url,
                        size: response.data.doc4_filesize,
                        type:
                            response.data.doc4.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc4.extension,
                        ext: response.data.doc4.extension,
                    },
                ];
            }

            if (response.data.doc5) {
                this.step5.doc5 = [
                    {
                        name: response.data.doc5.basename,
                        url: response.data.doc5_url,
                        size: response.data.doc5_filesize,
                        type:
                            response.data.doc5.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc5.extension,
                        ext: response.data.doc5.extension,
                    },
                ];
            }

            if (response.data.doc6) {
                this.step5.doc6 = [
                    {
                        name: response.data.doc6.basename,
                        url: response.data.doc6_url,
                        size: response.data.doc6_filesize,
                        type:
                            response.data.doc6.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc6.extension,
                        ext: response.data.doc6.extension,
                    },
                ];
            }

            if (response.data.doc7) {
                this.step5.doc7 = [
                    {
                        name: response.data.doc7.basename,
                        url: response.data.doc7_url,
                        size: response.data.doc7_filesize,
                        type:
                            response.data.doc7.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc7.extension,
                        ext: response.data.doc7.extension,
                    },
                ];
            }

            if (response.data.doc8) {
                this.step5.doc8 = [
                    {
                        name: response.data.doc8.basename,
                        url: response.data.doc8_url,
                        size: response.data.doc8_filesize,
                        type:
                            response.data.doc8.extension === "pdf"
                                ? "application/pdf"
                                : "image/" + response.data.doc8.extension,
                        ext: response.data.doc8.extension,
                    },
                ];
            }

            // console.log("Documents fetched successfully", this.step5);
        }
    } catch (error) {
        console.error("Failed to fetch documents", error);
    }
        },

         async doStep5() {
    this.scrollToTop();
    this.$v.step5.$touch();

    if (this.$v.step5.$invalid) {
        Vue.$toast.error(
            "Please complete all required fields before proceeding.",
            { position: "top-right" }
        );
        return false;
    }

    this.isLoading = true;

    let formData = new FormData();
    formData.append("event_fair_code", this.event_info.fair_code);
    formData.append("user_id", this.user_id);
    formData.append("token", this.token);
    formData.append("step", 5); // optional, just for backend reference

    // Attach selected documents
    for (let i = 1; i <= 8; i++) {
        if (this.step5[`doc${i}_selected`]) {
            formData.append(`doc${i}`, this.step5[`doc${i}_selected`]);
        }
    }
//   await this.fetchPackages();
    try {
        const response = await axios.post(
            "/supplier/registration/store",
            formData
        );
        if (response.status === 200) {
            Vue.$toast.success("Documents uploaded successfully!", {
                position: "top-right",
            });
            await this.getDocs();  
            return true;
        }
    } catch (err) {
        Vue.$toast.error(
            "Failed to upload documents. Please try again later.",
            { position: "top-right" }
        );
        return false;
    } finally {
        this.isLoading = false;
    }
        },
      
        onComplete() {
    if (!this.agreementChecked || !this.agreementPolicyChecked) {
        Vue.$toast.error("Please review and accept the required agreements.", {
            position: "top-right",
        });
        return;
    }

    this.submitAfterAgreement();
},


        async submitAfterAgreement() {
            if (!this.agreementChecked || !this.agreementPolicyChecked) {
                Vue.$toast.error("You must agree before submitting.", {
                    position: "top-right",
                });
                return;
            }

            this.isLoading = true;

            let formData = new FormData();
            formData.append("event_fair_code", this.event_info.fair_code);
            formData.append("user_id", this.user_id);
            formData.append("token", this.token);
            formData.append("step", "finish");

            // Append the selected agreement ID
            if (
                this.agreement1 &&
                this.agreement1.id &&
                this.agreementChecked
            ) {
                formData.append(
                    "registration_agreement_id",
                    this.agreement1.id
                );
            }

            // Privacy policy agreement
            if (
                this.agreement3 &&
                this.agreement3.id &&
                this.agreementPolicyChecked
            ) {
                formData.append("privacy_policy_id", this.agreement3.id);
            }

            // Information Sharing
            if (
                this.agreement4 &&
                this.agreement4.id &&
                this.agreementInformationSharingChecked
            ) {
                formData.append("information_sharing_id", this.agreement4.id);
            }

           

            try {
                const response = await axios.post(
                    "/supplier/registration/store",
                    formData
                );
                if (response.status === 200) {
                    Vue.$toast.success("Application submitted successfully!", {
                        position: "top-right",
                    });
                    setTimeout(() => {
                        window.location.href = `/supplier/registration/thankyou/${this.user_id}/${this.event_info.fair_code}`;
                    }, 1500);
                }
            } catch (err) {
                Vue.$toast.error("Submission failed. Please try again later.", {
                    position: "top-right",
                });
            } finally {
                this.isLoading = false;
            }
        },

        doSameAsMoa(e) {
            if (e.target.checked) {
                this.disabled_fa = true;
                this.step1.fa_country = this.step1.moa_country;
                this.step1.fa_state = this.step1.moa_state;
                this.step1.fa_city = this.step1.moa_city;
                this.step1.fa_zipcode = this.step1.moa_zipcode;
                this.step1.fa_region = this.step1.moa_region;
                this.step1.fa_street = this.step1.moa_street;
            } else {
                this.disabled_fa = false;
                this.step1.fa_country = "";
                this.step1.fa_state = "";
                this.step1.fa_city = "";
                this.step1.fa_zipcode = "";
                this.step1.fa_region = "";
                this.step1.fa_street = "";
            }
        },

        doSameAsBO(e) {
            if (e.target.checked) {
                this.disabled_bcp = true;
                this.step2.bcp_salutation = this.step2.salutation;
                this.step2.bcp_fname = this.step2.fname;
                this.step2.bcp_lname = this.step2.lname;
                this.step2.bcp_mi = this.step2.mi;
                this.step2.bcp_designation = this.step2.designation;
                this.step2.bcp_email = this.step2.email;
                this.step2.bcp_country_code = this.step2.country_code_mobile_bo;
                this.step2.bcp_mobile_no = this.step2.mobile_no_bo;
            } else {
                this.disabled_bcp = false;
                this.step2.bcp_salutation = "";
                this.step2.bcp_fname = "";
                this.step2.bcp_lname = "";
                this.step2.bcp_mi = "";
                this.step2.bcp_designation = "";
                this.step2.bcp_email = "";
                this.step2.bcp_country_code = "";
                this.step2.bcp_mobile_no = "";
            }
        },

        onChangeFaCountry(e) {
            if (!e.target.checked) {
                if (Number(e.target.value) === 148) {
                    this.step1.fa_region = "";
                }
            }
        },

        onChangeMoaCountry(e) {
            if (!e.target.checked) {
                if (Number(e.target.value) === 148) {
                    this.step1.moa_region = "";
                }
            }
        },

        onChangeIndustryRep(e) {
            if (e.target.value !== 1) {
                this.step3.exporting_country_1 = "";
                this.step3.exporting_country_2 = "";
                this.step3.exporting_country_3 = "";
                this.$v.step3.exporting_country_1.$reset();
                this.$v.step3.exporting_country_2.$reset();
                this.$v.step3.exporting_country_3.$reset();
            }
        },
        
        scrollToTop() {
            window.scroll({ top: 150, behavior: "smooth" });
        },

        doDeleteDoc($doc) {
            let formData = new FormData();
            formData.append("user_id", this.user_id);
            formData.append("doc", $doc);
            axios
                .post("/api/document/delete", formData)
                .then((response) => {
                    if (response.status === 200) {
                        return true;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        onSelectProduct(fileRecordsNewlySelected) {
            var validFileRecords = fileRecordsNewlySelected.filter(
                (fileRecord) => !fileRecord.error
            );
            this.prod_info.prod_images_for_upload =
                this.prod_info.prod_images_for_upload.concat(validFileRecords);
        },

        onBeforeDeleteProduct(fileRecord) {
            //console.log(fileRecord);
            var i = this.prod_info.prod_images_for_upload.indexOf(fileRecord);
            //console.log(i)
            if (i !== -1) {
                // queued file, not yet uploaded. Just remove from the arrays
                this.prod_info.prod_images_for_upload.splice(i, 1);
                var k = this.prod_info.prod_images.indexOf(fileRecord);
                if (k !== -1) this.prod_info.prod_images.splice(k, 1);
            } else {
                if (
                    confirm(
                        "Are you sure you want to delete this product/service photo?"
                    )
                ) {
                    this.$refs.vueFileAgentProducts.deleteFileRecord(
                        fileRecord
                    ); // will trigger 'delete' event
                }
            }
        },

        productImageDeleted(fileRecord) {
            //console.log(fileRecord)
            if (fileRecord.id) {
                axios
                    .delete("/api/product/photo/delete/" + fileRecord.id)
                    .then((response) => {
                        if (response.status === 200) {
                            return true;
                        }
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },

        onSelect(file, doc) {
            if (doc === 1) {
                this.step5.doc1_selected = file[0].file;
            } else if (doc === 2) {
                this.step5.doc2_selected = file[0].file;
            } else if (doc === 3) {
                this.step5.doc3_selected = file[0].file;
            } else if (doc === 4) {
                this.step5.doc4_selected = file[0].file;
            } else if (doc === 5) {
                this.step5.doc5_selected = file[0].file;
            } else if (doc === 6) {
                this.step5.doc6_selected = file[0].file;
            } else if (doc === 7) {
                this.step5.doc7_selected = file[0].file;
            } else if (doc === 8) {
                this.step5.doc8_selected = file[0].file;
            } else if (doc === 9) {
                this.step1.co_logo_selected = file[0].file;
            } else if (doc === 10) {
                this.step1.masthead_selected = file[0].file;
            }
        },

        onBeforeDelete(fileRecord, doc) {
            if (doc === 1) {
                // this.doDeleteDoc("doc_1");
                this.$refs.vueFileAgent1.deleteFileRecord(fileRecord);
            } else if (doc === 2) {
                // this.doDeleteDoc("doc_2");
                this.$refs.vueFileAgent2.deleteFileRecord(fileRecord);
            } else if (doc === 3) {
                // this.doDeleteDoc("doc_3");
                this.$refs.vueFileAgent3.deleteFileRecord(fileRecord);
            } else if (doc === 4) {
                // this.doDeleteDoc("doc_4");
                this.$refs.vueFileAgent4.deleteFileRecord(fileRecord);
            } else if (doc === 5) {
                // this.doDeleteDoc("doc_5");
                this.$refs.vueFileAgent5.deleteFileRecord(fileRecord);
            } else if (doc === 6) {
                // this.doDeleteDoc("doc_6");
                this.$refs.vueFileAgent6.deleteFileRecord(fileRecord);
            } else if (doc === 7) {
                // this.doDeleteDoc("doc7");
                this.$refs.vueFileAgent7.deleteFileRecord(fileRecord);
            } else if (doc === 8) {
                // this.doDeleteDoc("doc8");
                this.$refs.vueFileAgent8.deleteFileRecord(fileRecord);
            } else if (doc === 9) {
                // this.doDeleteDoc("company_logo");
                this.$refs.vueFileAgentCompanyLogo.deleteFileRecord(fileRecord);
            } else if (doc === 10) {
                // this.doDeleteDoc("masthead");
                this.$refs.vueFileAgentMasthead.deleteFileRecord(fileRecord);
            }
        },

        onLoad(e) {
            this.isLoading = e;
        },

        addPitchingAddOnToCart(addOn, idx) {
    // ✅ Quantity = number of checked categories
    const selected = this.step4.pitching_competition_selection || [];
    const qty = selected.length;

    if (qty < 1) {
        this.$toast.error("Please select at least one category.", {
            position: "top-right",
        });
        return;
    }

    // ✅ Get rate ID safely (Vue 2, no optional chaining)
    const rateId =
        addOn.rates && addOn.rates.length && addOn.rates[0].id
            ? addOn.rates[0].id
            : null;

    if (!rateId) {
        this.$toast.error("Add-on rate not found.");
        return;
    }

    const payload = {
        user_id: this.user_id,
        participation_addon_rate_id: rateId,
        fair_code: this.event_info.fair_code,
        quantity: qty, // checkbox count
        selected_categories: selected, // category IDs
    };

    this.isLoading = true;

    axios
        .post(
            "/supplier/addon-pitching-competition-selection/add",
            payload
        )
        .then(async (response) => {
            this.isLoading = false;

            if (!response.data.success) {
                this.$toast.error(response.data.message, {
                    position: "top-right",
                });
                return;
            }

            this.$toast.success("Pitching competition saved!", {
                position: "top-right",
            });

            await this.getAddOnToCart();

            // ✅ Reset only this special add-on state
            // this.step4.pitching_competition_selection = [];
            this.openAddOnIdx = null;

            // Collapse accordion safely
            this.$nextTick(() => {
                try {
                    const collapseEl = document.getElementById(
                        `collapseAddOn${idx}`
                    );
                    if (collapseEl) {
                        const bsCollapse =
                            bootstrap.Collapse.getInstance(collapseEl) ||
                            new bootstrap.Collapse(collapseEl);
                        bsCollapse.hide();
                    }
                } catch (e) {
                    console.warn("Accordion collapse failed", e);
                } 
            });
        })
        .catch((err) => {
            this.isLoading = false;

            if (err.response && err.response.data && err.response.data.message) {
                this.$toast.error(err.response.data.message, {
                    position: "top-right",
                });
            } else {
                this.$toast.error("Failed to save pitching competition.", {
                    position: "top-right",
                });
                console.error("❌ Pitching add-on error:", err);
            }
        });
},
// getQtyRules(pkg) {
//             const state = this.step4.packageState[pkg.id];

//             // Guard (qty input is already hidden if not type 2)
//             if (
//                 this.step4.participation_type != 2 ||
//                 !state?.selected_size_id
//             ) {
//                 return {};
//             }

//             const selectedSize = this.getFilteredSizes(pkg).find(
//                 (size) => size.id === state.selected_size_id
//             );

//             if (!selectedSize) return {};

//             const sqm = selectedSize.code; // 4 or 6

//             if (sqm === 4) {
//                 return { min: 4, max: 15 };
//             }

//             if (sqm === 6) {
//                 return { min: 3, max: 10 };
//             }

//             return {};
//         },

    getQtyRules(pkg) {
        const state = this.step4.packageState[pkg.id];

        if (
            this.step4.participation_type != 2 ||
            !state?.selected_size_id
        ) {
            return {};
        }

        return {};
    },

    },
    watch: {

    "step1.exhibitor_type"(value) {
        if (Number(value) === 1) {
            this.step1.last_participated = null;
        }
    },
        "step3.business_type": {
            handler(newVal) {
                if (newVal === 3) {
                    this.step3.start_up = 0; // uncheck
                    this.step3.startUpDisabled = true; // disable
                } else {
                    this.step3.startUpDisabled = false; // enable
                }
            },
            immediate: true,
        },

     "step3.start_up"(newVal, oldVal) {

    if (this.isInitialLoad) return;

    if (newVal !== oldVal) {

        this.step3.category = [];

        this.getCategories();

        // Reload spaces
        this.fetchPackages();
    }
},
 "step4.participation_type": {
    handler: function (newVal, oldVal) {

        if (this.isInitialLoad) return;

        if (newVal === oldVal) return;

        this.showParticipationWarning = false;

        Object.keys(
            this.step4.packageState
        ).forEach((pkgId) => {

            this.step4.packageState[pkgId]
                .selected_space_id = null;

            this.step4.packageState[pkgId]
                .selected_size_id = null;

            this.step4.packageState[pkgId]
                .qty = null;
        });

        // Reload spaces
        this.fetchPackages();
    },

    immediate: false,
},
        //  "step4.packageState": {
        //     deep: true,
        //     handler() {
        //         Object.keys(this.step4.packageState).forEach((pkgId) => {
        //             const state = this.step4.packageState[pkgId];

        //             // Reset qty if no size selected
        //             if (!state.selected_size_id) {
        //                 state.qty = null;
        //                 return; // skip clamping
        //             }

        //             const pkg = this.step4.packages.find((p) => p.id == pkgId);
        //             if (!pkg) return;

        //             const rules = this.getQtyRules(pkg);
        //             if (!rules.min || !rules.max) return;

        //             // Clamp qty within min/max
        //             if (state.qty < rules.min) state.qty = rules.min;
        //             if (state.qty > rules.max) state.qty = rules.max;
        //         });
        //     },
        // },
        "step4.packageState": {
    deep: true,
    handler() {
        Object.keys(this.step4.packageState).forEach((pkgId) => {
            const state = this.step4.packageState[pkgId];

            // Reset qty if no size selected
            if (!state.selected_size_id) {
                state.qty = null;
            }
        });
    },
},
            cart() {
        this.showParticipationWarning = false;
    },
    },
};
</script>
<style scoped>
.form-check-label p {
    margin-bottom: 0px !important;
    display: inline;
}
.form-check-input {
    margin-top: 0px !important;
}
.last-participated-input {
    width: 240px;
    height: 27px;
    border: none;
    border-bottom: 2px solid #222;
    border-radius: 0;
    background: #f5f5f5;
    padding: 0px 8px;
    font-size: 16px;
    outline: none;
}

.last-participated-input:focus {
    border-bottom: 2px solid #222;
    box-shadow: none;
}

.last-participated-input:disabled {
    background: #f5f5f5;
    cursor: not-allowed;
    opacity: 0.6;
}
</style>
