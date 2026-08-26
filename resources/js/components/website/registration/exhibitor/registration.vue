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
            finish-button-text="Submit"
            @on-loading="onLoad"
            @on-complete="onComplete"
        >
            <tab-content title="Company Information" :before-change="doStep1">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Company Information</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
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
                                    >Brand Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    id="directory_name"
                                    :class="{
                                        'is-invalid':
                                            $v.step1.directory_name.$error,
                                    }"
                                    v-model="step1.directory_name"
                                    maxlength="100"
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
                                    for="co_name"
                                    class="form-label text-uppercase fw-bold"
                                    >Brief Company Profile*</label
                                >
                                <textarea
                                    class="form-control beige-bg"
                                    rows="3"
                                    v-model="step1.co_details"
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
                                    Programs</label
                                >
                                <textarea
                                    class="form-control beige-bg"
                                    rows="3"
                                    v-model="step1.env_conservation"
                                ></textarea>
                                <div class="form-text fs-12">
                                    Do you have any projects or programs related
                                    to the environment? Please provide a brief
                                    description for each initiative and mention
                                    the community/ies you are helping.
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
                                            v-model="step1.country_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.country_code
                                                        .$error,
                                            }"
                                        >
                                            <option :value="''">
                                                Country code
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
                                            v-if="$v.step1.country_code.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.country_code
                                                        .required
                                                "
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
                                            type="number"
                                            class="form-control"
                                            id="area_code"
                                            placeholder="Area code"
                                            v-model="step1.area_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.area_code.$error,
                                            }"
                                            maxlength="10"
                                        />
                                        <div v-if="$v.step1.area_code.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.area_code.required
                                                "
                                            >
                                                Area code is required.
                                            </div>
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.area_code.numeric
                                                "
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
                                            type="number"
                                            class="form-control"
                                            id="phone_no"
                                            placeholder="Phone number"
                                            v-model="step1.phone_no"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.phone_no.$error,
                                            }"
                                            pattern="[0-9\-]+"
                                        />
                                        <div v-if="$v.step1.phone_no.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.phone_no.required
                                                "
                                            >
                                                Phone no. is required.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-5">
                                        <label
                                            for="country_code_mobile"
                                            class="form-label text-uppercase fw-bold"
                                            >Mobile Number*</label
                                        >
                                        <select
                                            class="form-select"
                                            id="country_code_mobile"
                                            v-model="step1.country_code_mobile"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.country_code_mobile
                                                        .$error,
                                            }"
                                        >
                                            <option :value="''">
                                                Country code
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
                                                $v.step1.country_code_mobile
                                                    .$error
                                            "
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1
                                                        .country_code_mobile
                                                        .required
                                                "
                                            >
                                                Country code is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <label
                                            for="mobile_no"
                                            class="form-label"
                                            >&nbsp;</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control"
                                            placeholder="Mobile number"
                                            id="mobile_no"
                                            v-model="step1.mobile_no"
                                            :class="{
                                                'is-invalid':
                                                    $v.step1.mobile_no.$error,
                                            }"
                                            pattern="[0-9\-]+"
                                        />
                                        <div v-if="$v.step1.mobile_no.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step1.mobile_no.required
                                                "
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
                                    v-model="step1.website"
                                    placeholder="companyname.com"
                                    maxlength="200"
                                />
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
                                    >Company Masthead*</label
                                >
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
                                    @beforedelete="onBeforeDelete($event, 7)"
                                    @select="onSelect($event, 7)"
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
                                    @beforedelete="onBeforeDelete($event, 8)"
                                    @select="onSelect($event, 8)"
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
                                    <span class="input-group-text text-white"
                                        >https://www.facebook.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.facebook"
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
                                    <span class="input-group-text text-white"
                                        >https://www.twitter.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.twitter"
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
                                    <span class="input-group-text text-white"
                                        >https://www.instagram.com/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.instagram"
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
                                    <span class="input-group-text text-white"
                                        >https://www.linked.com/in/</span
                                    >
                                    <input
                                        type="text"
                                        class="form-control text-lowercase"
                                        v-model="step1.linkedin"
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
                                    placeholder="weixin://dl/chat?username"
                                />
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
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.moa_street
                                                                .$error,
                                                    }"
                                                    maxlength="100"
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
                                                    maxlength="100"
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
                                                    maxlength="100"
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
                                                    maxlength="20"
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
                                                    v-if="
                                                        step1.fa_country === 148
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
                                                            $v.step1.fa_street
                                                                .$error,
                                                    }"
                                                    v-model="step1.fa_street"
                                                    maxlength="100"
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
                                                    maxlength="100"
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
                                                    maxlength="100"
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
                                                    type="number"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            $v.step1.fa_zipcode
                                                                .$error,
                                                    }"
                                                    v-model="step1.fa_zipcode"
                                                    maxlength="20"
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
                title="Product Information"
                :before-change="doSaveProducts"
            >
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Product/s Information</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Product/Service Name*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-capitalize"
                                    :class="{
                                        'is-invalid':
                                            $v.prod_info.prod_name.$error,
                                    }"
                                    v-model="prod_info.prod_name"
                                    maxlength="100"
                                />
                                <div v-if="$v.prod_info.prod_name.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.prod_info.prod_name.required"
                                    >
                                        Product name is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Brief Product Description*</label
                                >
                                <textarea
                                    class="form-control beige-bg"
                                    rows="3"
                                    v-model="prod_info.prod_details"
                                    :class="{
                                        'is-invalid':
                                            $v.prod_info.prod_details.$error,
                                    }"
                                ></textarea>
                                <div v-if="$v.prod_info.prod_details.$error">
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
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Product/Service Photo/s*</label
                                >
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
                                    Please upload upto five (5) clear photos of
                                    your product. Preferably 1080x1080 px (1:1
                                    ratio) with max. of 1MB per file.
                                </div>
                                <div v-if="$v.prod_info.prod_images.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="
                                            !$v.prod_info.prod_images.required
                                        "
                                    >
                                        Please upload a product photo.
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h4>Product Profile*</h4>
                                <div v-if="$v.prod_info.prod_profiles.$error">
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
                            <div class="col-12">
                                <div class="row g-3">
                                    <div
                                        class="col-md-4"
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <div class="card m-0 h-100 beige-bg">
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
                                                        >{{
                                                            subcategory.name
                                                        }}</label
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <div class="row justify-content-start">
                                            <div class="col-12">
                                                <h4>Certifications*</h4>
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
                                                        Certifications is
                                                        required.
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
                                                        certfication.
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-4"
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
                                                    <div v-if="cert.id === 14">
                                                        <div
                                                            class="d-flex align-items-center"
                                                        >
                                                            <label
                                                                class="form-check-label m-0 p-0 align-middle"
                                                                :for="
                                                                    'prod_certification_' +
                                                                    cert.id
                                                                "
                                                                >Others,&nbsp;</label
                                                            >
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
                                                                v-model="
                                                                    prod_info.certs_others
                                                                "
                                                                :readonly="
                                                                    check_prod_cert_others
                                                                "
                                                            />
                                                        </div>
                                                    </div>
                                                    <label
                                                        v-else
                                                        class="form-check-label mb-0 align-middle"
                                                        :for="
                                                            'prod_certification_' +
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
                            <div class="col-md-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Online Store Link*</label
                                >
                                <input
                                    type="text"
                                    class="form-control text-lowercase"
                                    :class="{
                                        'is-invalid':
                                            $v.prod_info.store_url.$error,
                                    }"
                                    v-model="prod_info.store_url"
                                    placeholder="https://www.lazada.com.ph/shop/storename"
                                />
                                <div v-if="$v.prod_info.store_url.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.prod_info.store_url.required"
                                    >
                                        Online store link is required.
                                    </div>
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.prod_info.store_url.url"
                                    >
                                        Invalid online store link.
                                    </div>
                                </div>
                            </div>
                            <div
                                class="d-grid gap-2 d-md-flex justify-content-md-end"
                            >
                                <button
                                    v-if="product_id"
                                    type="button"
                                    class="btn btn-outline-dark btn-sm"
                                    @click="doAddProduct"
                                >
                                    <i class="far fa-edit"></i> Update product
                                </button>
                                <button
                                    v-else
                                    type="button"
                                    class="btn btn-outline-dark btn-sm"
                                    @click="doAddProduct"
                                >
                                    <i class="fas fa-plus"></i> Add product
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-4 mb-5">
                            <div class="col-12">
                                <h4>Added Product/s</h4>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table
                                        class="table table-striped table-hover align-middle"
                                    >
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    Product Name
                                                </th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="product in products"
                                                :key="product.id"
                                            >
                                                <td class="text-capitalize">
                                                    {{ product.name }}
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-grid gap-2 d-md-flex justify-content-md-end"
                                                    >
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
                                                        >
                                                            <i
                                                                class="far fa-edit"
                                                            ></i>
                                                            Edit
                                                        </button>
                                                        <button
                                                            class="btn btn-outline-danger btn-sm"
                                                            type="button"
                                                            @click="
                                                                doProductDelete(
                                                                    product.id
                                                                )
                                                            "
                                                        >
                                                            <i
                                                                class="far fa-trash-alt"
                                                            ></i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-if="products.length <= 0">
                                                <td
                                                    colspan="2"
                                                    class="text-center"
                                                >
                                                    No product found.
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
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <h4>Business Owner</h4>
                                    </div>
                                    <div class="col-5">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >First Name*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.fname.$error,
                                            }"
                                            v-model="step2.fname"
                                            maxlength="100"
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
                                    <div class="col-5">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Last Name*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.lname.$error,
                                            }"
                                            v-model="step2.lname"
                                            maxlength="100"
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
                                    <div class="col-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >M.I.</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            v-model="step2.mi"
                                            maxlength="1"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Designation*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.designation.$error,
                                            }"
                                            v-model="step2.designation"
                                            maxlength="100"
                                        />
                                        <div v-if="$v.step2.designation.$error">
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step2.designation
                                                        .required
                                                "
                                            >
                                                Designation is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Email Address*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.email.$error,
                                            }"
                                            v-model="step2.email"
                                            maxlength="150"
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
                                    <div class="col-md-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Country Code*</label
                                        >
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
                                                $v.step2.country_code_mobile_bo
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
                                    <div class="col-md-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Mobile No.*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="step2.mobile_no_bo"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.mobile_no_bo
                                                        .$error,
                                            }"
                                            maxlength="20"
                                            placeholder="9274469034"
                                        />
                                        <div
                                            v-if="$v.step2.mobile_no_bo.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step2.mobile_no_bo
                                                        .required
                                                "
                                            >
                                                Mobile no. is required.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <h4>Business Contact Person</h4>
                                    </div>
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
                                    <div class="col-5">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >First Name*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.bcp_fname.$error,
                                            }"
                                            v-model="step2.bcp_fname"
                                            maxlength="100"
                                            :disabled="disabled_bcp"
                                        />
                                        <div v-if="$v.step2.bcp_fname.$error">
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
                                    <div class="col-5">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Last Name*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.bcp_lname.$error,
                                            }"
                                            v-model="step2.bcp_lname"
                                            maxlength="100"
                                            :disabled="disabled_bcp"
                                        />
                                        <div v-if="$v.step2.bcp_lname.$error">
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
                                    <div class="col-2">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >M.I.</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-uppercase"
                                            v-model="step2.bcp_mi"
                                            maxlength="1"
                                            :disabled="disabled_bcp"
                                        />
                                    </div>
                                    <div class="col-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Designation*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-capitalize"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.bcp_designation
                                                        .$error,
                                            }"
                                            v-model="step2.bcp_designation"
                                            maxlength="100"
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
                                    <div class="col-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Email Address*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control text-lowercase"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.bcp_email.$error,
                                            }"
                                            v-model="step2.bcp_email"
                                            maxlength="150"
                                            :disabled="disabled_bcp"
                                        />
                                        <div v-if="$v.step2.bcp_email.$error">
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
                                                v-if="!$v.step2.bcp_email.email"
                                            >
                                                Invalid email address format.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Country Code*</label
                                        >
                                        <select
                                            class="form-select"
                                            v-model="step2.bcp_country_code"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.bcp_country_code
                                                        .$error,
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
                                    <div class="col-md-12">
                                        <label
                                            class="form-label text-uppercase fw-bold"
                                            >Mobile No.*</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            v-model="step2.bcp_mobile_no"
                                            :class="{
                                                'is-invalid':
                                                    $v.step2.bcp_mobile_no
                                                        .$error,
                                            }"
                                            maxlength="20"
                                            :disabled="disabled_bcp"
                                            placeholder="9274469034"
                                        />
                                        <div
                                            v-if="$v.step2.mobile_no_bo.$error"
                                        >
                                            <div
                                                class="fw-light invalid-feedback d-block"
                                                v-if="
                                                    !$v.step2.bcp_mobile_no
                                                        .required
                                                "
                                            >
                                                Mobile no. is required.
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
                                <div class="card m-0 h-100 beige-bg">
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
                            <div class="col-md-4">
                                <div class="card m-0 h-100 beige-bg">
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
                                <div class="card m-0 h-100 beige-bg">
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
                                <div class="card m-0 h-100 beige-bg">
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
                            <div class="col-6 mt-0">
                                <label
                                    for="direct"
                                    class="form-label text-uppercase fw-bold"
                                    >Direct</label
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    id="direct"
                                    v-model="step3.direct"
                                />
                            </div>
                            <div class="col-6 mt-0">
                                <label
                                    for="indirect"
                                    class="form-label text-uppercase fw-bold"
                                    >Indirect/Subcontractors</label
                                >
                                <input
                                    type="number"
                                    class="form-control"
                                    id="indirect"
                                    v-model="step3.indirect"
                                />
                            </div>
                            <div class="col-md-12">
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Nature of Business*</h4>
                                                <p class="fs-12">
                                                    Note: Select all applies
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
                                                class="col-6"
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
                                                    <label
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
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Target Buyer & Intent*</h4>
                                                <p class="fs-12">
                                                    Note: Select all applies
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
                                                class="col-6"
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
                            <div class="col-8">
                                <div class="card m-0 h-100 beige-bg">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>Certification/s*</h4>
                                                <p class="fs-12">
                                                    Note: Select all applies
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
                                                class="col-6"
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
                            <div class="col-4">
                                <div class="card m-0 h-100 beige-bg">
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
                                <h4>Supplier Profile*</h4>
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
                                    class="col-md-4"
                                    v-for="category in categories"
                                    :key="category.id"
                                >
                                    <div class="card m-0 h-100 beige-bg">
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
                                <div class="col-12 mt-3">
                                    <div class="card m-0 h-100 beige-bg">
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
                                <!-- ON PRODUCTION PROCESS: -->
                                <div class="col-12 mt-3">
                                    <div class="card m-0 h-100 beige-bg">
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
                                                class="form-check"
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
                                </div>
                                <!-- /ON PRODUCTION PROCESS: -->

                                <!-- SUSTAINABILITY IS MULTIFACETED, WHICH OF THE TOPICS BELOW DO YOU THINK THE SHOW SHOULD FOCUS ON? -->
                                <div class="col-12 mt-3">
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <p class="bg-light text-wrap mb-1">
                                                Please rank the following: (1
                                                being the greatest focus.)
                                            </p>
                                            <h4>
                                                SUSTAINABILITY IS MULTIFACETED,
                                                WHICH OF THE TOPICS BELOW DO YOU
                                                THINK THE SHOW SHOULD FOCUS ON?*
                                            </h4>
                                            <div v-if="$v.step3.ranking.$error">
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step3.ranking
                                                            .isRequired
                                                    "
                                                >
                                                    Please rank all data.
                                                </div>
                                                <div
                                                    class="fw-light invalid-feedback d-block"
                                                    v-if="
                                                        !$v.step3.ranking
                                                            .isUnique
                                                    "
                                                >
                                                    Rank value must be unique.
                                                </div>
                                            </div>
                                            <div
                                                class="row"
                                                v-for="topic in topics"
                                                :key="topic.id"
                                            >
                                                <label
                                                    class="col-sm-10 col-form-label form-check-label"
                                                    >{{ topic.name }}</label
                                                >
                                                <div class="col-sm-2">
                                                    <select
                                                        class="form-select form-select-sm border border-secondary"
                                                        v-model="
                                                            step3.ranking[
                                                                topic.id
                                                            ]
                                                        "
                                                        :class="{
                                                            'is-invalid':
                                                                $v.step3.ranking
                                                                    .$error,
                                                        }"
                                                    >
                                                        <option
                                                            v-for="rank in topics.length"
                                                            :key="rank"
                                                            :value="rank"
                                                        >
                                                            {{ rank }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /SUSTAINABILITY IS MULTIFACETED, WHICH OF THE TOPICS BELOW DO YOU THINK THE SHOW SHOULD FOCUS ON? -->
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
                        <div class="col-12" v-if="$v.step4.banner_size.$error">
                            <div
                                class="fw-light invalid-feedback d-block"
                                v-if="!$v.step4.banner_size.required"
                            >
                                Banner size is required.
                            </div>
                        </div>
                        <div class="row g-3">
                            <div
                                class="col-md-4"
                                v-for="banner in banner_sizes"
                                :key="banner.id"
                            >
                                <div class="card h-100 beige-bg">
                                    <div
                                        class="card-header fw-bold text-uppercase"
                                    >
                                        <div class="form-check">
                                            <input
                                                type="radio"
                                                class="form-check-input"
                                                :id="
                                                    'banner_' + banner.item_code
                                                "
                                                v-model="step4.banner_size"
                                                :value="banner.id"
                                            />
                                            <label
                                                class="form-check-label mb-0"
                                                :for="
                                                    'banner_' + banner.item_code
                                                "
                                                >{{ banner.name }}</label
                                            >
                                        </div>
                                    </div>
                                    <div
                                        class="card-body"
                                        v-html="banner.description"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
            </tab-content>
            <tab-content title="Upload Requirements">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="text-left mb-1 mt-4">
                            <h1 class="h3">Upload Requirements</h1>
                            <p>*Required</p>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Copy of registration from DTI or SEC (with
                                    complete Articles of Incorporation)*</label
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
                                    @beforedelete="onBeforeDelete($event, 1)"
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
                                        from dti or sec (with complete articles
                                        of incorporation).
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Copy of registration from BIR (Form
                                    2303)*</label
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
                                    @beforedelete="onBeforeDelete($event, 2)"
                                    @select="onSelect($event, 2)"
                                ></VueFileAgent>
                                <div id="emailHelp" class="form-text">
                                    Max size of 1MB and accept image and pdf
                                    document only.
                                </div>
                                <div class="mt-1" v-if="$v.step5.doc2.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step5.doc2.required"
                                    >
                                        Please upload a copy of registration
                                        from bir (form 2303).
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Copy of valid License to Operate
                                    (LTO)*</label
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
                                    @beforedelete="onBeforeDelete($event, 3)"
                                    @select="onSelect($event, 3)"
                                ></VueFileAgent>
                                <div id="emailHelp" class="form-text">
                                    Max size of 1MB and accept image and pdf
                                    document only.
                                </div>
                                <div class="mt-1" v-if="$v.step5.doc3.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step5.doc3.required"
                                    >
                                        Please upload a copy of license to
                                        operate (lto).
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Copy of valid Certificate of Product
                                    Registration (CPR)*</label
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
                                    @beforedelete="onBeforeDelete($event, 4)"
                                    @select="onSelect($event, 4)"
                                ></VueFileAgent>
                                <div id="emailHelp" class="form-text">
                                    Max size of 1MB and accept image and pdf
                                    document only.
                                </div>
                                <div class="mt-1" v-if="$v.step5.doc4.$error">
                                    <div
                                        class="fw-light invalid-feedback d-block"
                                        v-if="!$v.step5.doc4.required"
                                    >
                                        Please upload a copy of certificate of
                                        product registration (cpr).
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Copy of valid food/ environmental
                                    certifications such as Fairtrade, FSC, Green
                                    Choice, HACCP, Halal, ISO, etc.</label
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
                                    @beforedelete="onBeforeDelete($event, 5)"
                                    @select="onSelect($event, 5)"
                                ></VueFileAgent>
                                <div id="emailHelp" class="form-text">
                                    Max size of 1MB and accept image and pdf
                                    document only.
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label text-uppercase fw-bold"
                                    >Institutional brochure/catalog includes
                                    company profile, product photos, and
                                    map/site sketch of the company
                                    location</label
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
                            </div>
                        </div>
                    </div>
                    <div class="mb-5"></div>
                </div>
            </tab-content>
        </form-wizard>
    </div>
</template>
<script>
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

Vue.use(BlockUI);
Vue.use(Vuelidate);
Vue.use(VueFileAgent);
Vue.use(VueSweetalert2);
Vue.use(VueToast);

export default {
    props: ["params"],
    data() {
        return {
            isLoading: false,
            msg: "Saving record. Please wait...",
            user_id: "",
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
            production_processes: [],
            topics: [],
            banner_sizes: [],
            products: [],
            disabled_fa: false,
            disabled_bcp: false,
            product_id: "",
            step1: {
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
                fname: "",
                lname: "",
                mi: "",
                designation: "",
                email: "",
                country_code_mobile_bo: "",
                mobile_no_bo: "",
                same_as_bo: "",
                bcp_fname: "",
                bcp_lname: "",
                bcp_mi: "",
                bcp_designation: "",
                bcp_email: "",
                bcp_country_code: "",
                bcp_mobile_no: "",
            },
            step3: {
                business_type: "",
                company_size: "",
                annual_sales_volume: "",
                direct: "",
                indirect: "",
                organization_type: "",
                nature_business: [],
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
                input_ouput: [],
                production_process: [],
                production_process_others: "",
                topic: [],
                ranking: [],
            },
            step4: {
                banner_size: 1,
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
    },
    validations: {
        step1: {
            directory_name: { required },
            co_details: { required },
            mission: { required },
            country_code: { required },
            area_code: { required, numeric },
            phone_no: { required },
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
                required: requiredIf(function () {
                    if (this.step1.fa_country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
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
                required: requiredIf(function () {
                    if (this.step1.moa_country === 148) {
                        return true;
                    } else {
                        return false;
                    }
                }),
            },
        },
        step2: {
            fname: { required },
            lname: { required },
            designation: { required },
            email: { required, email },
            country_code_mobile_bo: { required },
            mobile_no_bo: { required },
            bcp_fname: { required },
            bcp_lname: { required },
            bcp_designation: { required },
            bcp_email: { required, email },
            bcp_country_code: { required },
            bcp_mobile_no: { required },
        },
        step3: {
            business_type: { required },
            company_size: { required },
            annual_sales_volume: { required },
            organization_type: { required },
            nature_business: { required },
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
            input_ouput: { required },
            production_process: { required },
            production_process_others: {
                required: requiredIf(function () {
                    return this.step3.production_process.includes(3);
                }),
            },
            ranking: {
                isRequired() {
                    const rank = this.step3.ranking.filter(Number);
                    if (rank.length < this.topics.length) {
                        return false;
                    } else {
                        return true;
                    }
                },
                isUnique() {
                    const allUnique = !this.step3.ranking.some(
                        (v, i) => this.step3.ranking.indexOf(v) < i
                    );
                    return allUnique;
                },
            },
        },
        step4: {
            banner_size: { required },
        },
        step5: {
            doc1: { required },
            doc2: { required },
            doc3: { required },
            doc4: { required },
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
            store_url: { required, url },
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
    },
    mounted() {
        this.getUserInfo();
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
        this.getCategories();
        this.getTargetBuyers();
        this.getInputOuputs();
        this.getProductionProcesses();
        this.getRankTopics();
        this.getBannerSizes();
    },
    methods: {
        getUserInfo() {
            axios
                .get("/api/user-information/" + Number(this.params))
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.user_id = response.data.id;
                        this.token = response.data.reg_token;
                        //STEP 1
                        this.step1.co_name = response.data.exhibitor.co_name;
                        this.step1.co_email = response.data.exhibitor.co_email;
                        this.step1.co_details =
                            response.data.exhibitor.co_details;
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
                        this.step1.mobile_no =
                            response.data.exhibitor.mobile_no;
                        this.step1.website = response.data.exhibitor.website;
                        this.step1.facebook = response.data.exhibitor.facebook;
                        this.step1.twitter = response.data.exhibitor.twitter;
                        this.step1.instagram =
                            response.data.exhibitor.instagram;
                        this.step1.linkedin = response.data.exhibitor.linkedin;
                        this.step1.other_social =
                            response.data.exhibitor.other_social;
                        this.step1.fa_country = response.data.exhibitor
                            .fa_country
                            ? response.data.exhibitor.fa_country
                            : "";
                        this.step1.fa_state = response.data.exhibitor.fa_state;
                        this.step1.fa_city = response.data.exhibitor.fa_city;
                        this.step1.fa_zipcode =
                            response.data.exhibitor.fa_zipcode;
                        this.step1.fa_region = response.data.exhibitor.fa_region
                            ? response.data.exhibitor.fa_region
                            : "";
                        this.step1.fa_street =
                            response.data.exhibitor.fa_street;
                        this.step1.same_as_moa =
                            response.data.exhibitor.fa_same_as_moa;
                        if (response.data.exhibitor.fa_same_as_moa === 1) {
                            this.disabled_fa = true;
                        }
                        this.step1.moa_country = response.data.exhibitor
                            .moa_country
                            ? response.data.exhibitor.moa_country
                            : "";
                        this.step1.moa_state =
                            response.data.exhibitor.moa_state;
                        this.step1.moa_city = response.data.exhibitor.moa_city;
                        this.step1.moa_zipcode =
                            response.data.exhibitor.moa_zipcode;
                        this.step1.moa_region = response.data.exhibitor
                            .moa_region
                            ? response.data.exhibitor.moa_region
                            : "";
                        this.step1.moa_street =
                            response.data.exhibitor.moa_street;
                        if (response.data.masthead) {
                            this.step1.masthead = [
                                {
                                    name: response.data.masthead.basename,
                                    url:
                                        "/storage/exhibitors/mastheads/" +
                                        response.data.masthead.basename,
                                    size: 1234,
                                    type:
                                        "image/" +
                                        response.data.masthead.extension,
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
                                    type:
                                        "image/" + response.data.logo.extension,
                                    ext: response.data.logo.extension,
                                },
                            ];
                        }
                        //STEP 2
                        this.products = response.data.products;
                        if (response.data.business_owner) {
                            this.step2.fname =
                                response.data.business_owner.fname;
                            this.step2.lname =
                                response.data.business_owner.lname;
                            this.step2.mi = response.data.business_owner.mi;
                            this.step2.designation =
                                response.data.business_owner.designation;
                            this.step2.email =
                                response.data.business_owner.email;
                            this.step2.country_code_mobile_bo =
                                response.data.business_owner.country_code;
                            this.step2.mobile_no_bo =
                                response.data.business_owner.mobile_no;
                        }
                        if (response.data.business_contact_person) {
                            if (
                                response.data.business_contact_person
                                    .same_as_bo === 1
                            ) {
                                this.disabled_bcp = true;
                            }
                            this.step2.same_as_bo =
                                response.data.business_contact_person.same_as_bo;
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
                        this.step3.company_size =
                            response.data.exhibitor.company_size_id;
                        this.step3.annual_sales_volume =
                            response.data.exhibitor.annual_sales_volume_id;
                        this.step3.direct =
                            response.data.exhibitor.direct_workers;
                        this.step3.indirect =
                            response.data.exhibitor.indirect_workers;
                        this.step3.organization_type =
                            response.data.exhibitor.organization_type_id;
                        for (
                            var n = 0;
                            n < response.data.nature_business.length;
                            n++
                        ) {
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
                                response.data.target_buyer[t][
                                    "target_buyer_id"
                                ] === 6
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
                                response.data.certification[c][
                                    "certification_id"
                                ]
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
                        }
                        for (
                            var i = 0;
                            i < response.data.on_input_output.length;
                            i++
                        ) {
                            this.step3.input_ouput.push(
                                response.data.on_input_output[i][
                                    "input_output_id"
                                ]
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
                        if (response.data.topic_rank.length >= 6) {
                            this.step3.ranking.push(0);
                            for (
                                var r = 0;
                                r < response.data.topic_rank.length;
                                r++
                            ) {
                                this.step3.ranking.push(
                                    response.data.topic_rank[r]["rank"]
                                );
                            }
                        }
                        //STEP 4
                        this.step4.banner_size = response.data.exhibitor
                            .banner_size_id
                            ? response.data.exhibitor.banner_size_id
                            : 1;
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
                    }
                })
                .catch((error) => {
                    console.log(error);
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
                .get("/api/business_types")
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
        getCategories() {
            axios
                .get("/api/categories")
                .then((response) => {
                    //console.log(response.data)
                    if (response.status === 200) {
                        this.categories = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
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
                .get("/api/rank_topics")
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
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("product_id", this.product_id);
                formData.append("step", "add_product");
                formData.append("prod_info", JSON.stringify(this.prod_info));
                return axios
                    .post("/registration/supplier/store", formData)
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
                formData.append("token", this.token);
                formData.append("step", "save_product");
                return axios
                    .post("/registration/supplier/store", formData)
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
            if (!this.$v.step1.$invalid) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", Number(1));
                formData.append("step1_data", JSON.stringify(this.step1));
                formData.append("masthead", this.step1.masthead_selected);
                formData.append("logo", this.step1.co_logo_selected);
                return axios
                    .post("/registration/supplier/store", formData)
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
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", Number(2));
                formData.append("step2_data", JSON.stringify(this.step2));
                return axios
                    .post("/registration/supplier/store", formData)
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
        doStep3() {
            this.scrollToTop();
            this.$v.step3.$touch();
            if (!this.$v.step3.$invalid) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", Number(3));
                formData.append("step3_data", JSON.stringify(this.step3));
                return axios
                    .post("/registration/supplier/store", formData)
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
        doStep4() {
            this.scrollToTop();
            this.$v.step4.$touch();
            if (!this.$v.step4.$invalid) {
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", Number(4));
                formData.append("step4_data", JSON.stringify(this.step4));
                return axios
                    .post("/registration/supplier/store", formData)
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
        onComplete() {
            this.scrollToTop();
            this.$v.step5.$touch();
            if (!this.$v.step5.$invalid) {
                this.isLoading = true;
                let formData = new FormData();
                formData.append("user_id", this.user_id);
                formData.append("token", this.token);
                formData.append("step", "finish");
                formData.append("doc1", this.step5.doc1_selected);
                formData.append("doc2", this.step5.doc2_selected);
                formData.append("doc3", this.step5.doc3_selected);
                formData.append("doc4", this.step5.doc4_selected);
                formData.append("doc5", this.step5.doc5_selected);
                formData.append("doc6", this.step5.doc6_selected);
                axios
                    .post("/registration/supplier/store", formData)
                    .then((response) => {
                        if (response.status === 200) {
                            this.isLoading = false;
                            window.location.href =
                                "/registration/supplier/" +
                                this.token +
                                "/thank-you";
                        }
                    })
                    .catch((err) => {
                        return false;
                    });
            } else {
                return false;
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
                this.step2.bcp_fname = this.step2.fname;
                this.step2.bcp_lname = this.step2.lname;
                this.step2.bcp_mi = this.step2.mi;
                this.step2.bcp_designation = this.step2.designation;
                this.step2.bcp_email = this.step2.email;
                this.step2.bcp_country_code = this.step2.country_code_mobile_bo;
                this.step2.bcp_mobile_no = this.step2.mobile_no_bo;
            } else {
                this.disabled_bcp = false;
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
                        "Are you sure you want to delete this product photo?"
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
                this.step1.masthead_selected = file[0].file;
            } else {
                this.step1.co_logo_selected = file[0].file;
            }
        },
        onBeforeDelete(fileRecord, doc) {
            if (doc === 1) {
                if (confirm("Are you sure you want to remove this document?")) {
                    this.doDeleteDoc("doc_1");
                    this.$refs.vueFileAgent1.deleteFileRecord(fileRecord);
                }
            } else if (doc === 2) {
                if (confirm("Are you sure you want to remove this document?")) {
                    this.doDeleteDoc("doc_2");
                    this.$refs.vueFileAgent2.deleteFileRecord(fileRecord);
                }
            } else if (doc === 3) {
                if (confirm("Are you sure you want to remove this document?")) {
                    this.doDeleteDoc("doc_3");
                    this.$refs.vueFileAgent3.deleteFileRecord(fileRecord);
                }
            } else if (doc === 4) {
                if (confirm("Are you sure you want to remove this document?")) {
                    this.doDeleteDoc("doc_4");
                    this.$refs.vueFileAgent4.deleteFileRecord(fileRecord);
                }
            } else if (doc === 5) {
                if (confirm("Are you sure you want to remove this document?")) {
                    this.doDeleteDoc("doc_5");
                    this.$refs.vueFileAgent5.deleteFileRecord(fileRecord);
                }
            } else if (doc === 6) {
                if (confirm("Are you sure you want to remove this document?")) {
                    this.doDeleteDoc("doc_6");
                    this.$refs.vueFileAgent6.deleteFileRecord(fileRecord);
                }
            } else if (doc === 7) {
                if (confirm("Are you sure you want to remove this masthead?")) {
                    this.doDeleteDoc("masthead");
                    this.$refs.vueFileAgentMasthead.deleteFileRecord(
                        fileRecord
                    );
                }
            } else {
                if (
                    confirm(
                        "Are you sure you want to remove this company logo?"
                    )
                ) {
                    this.doDeleteDoc("company_logo");
                    this.$refs.vueFileAgentCompanyLogo.deleteFileRecord(
                        fileRecord
                    );
                }
            }
        },
        onLoad(e) {
            this.isLoading = e;
        },
    },
};
</script>
