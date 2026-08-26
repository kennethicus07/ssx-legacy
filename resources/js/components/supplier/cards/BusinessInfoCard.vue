<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="tab-pane active" id="business_info" role="tabpanel">
                <div class="row">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4>
                                                        Business Registration*
                                                    </h4>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .business_type
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .business_type
                                                                    .required
                                                            "
                                                        >
                                                            Business
                                                            registration is
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
                                                                business_info.business_type
                                                            "
                                                            :value="btype.id"
                                                            :id="
                                                                'business_type_' +
                                                                btype.id
                                                            "
                                                            :disabled="
                                                                !canAction
                                                            "
                                                        />
                                                        <label
                                                            class="form-check-label align-middle"
                                                            :for="
                                                                'business_type_' +
                                                                btype.id
                                                            "
                                                            >{{
                                                                btype.name
                                                            }}</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <!-- Start up -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input"
                                                            id="start_up"
                                                            v-model="
                                                                business_info.start_up
                                                            "
                                                            :true-value="1"
                                                            :false-value="0"
                                                            :disabled="
                                                                business_info.startUpDisabled ||
                                                                status !== 0
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
                                                                        >Age of
                                                                        the
                                                                        Business</strong
                                                                    >
                                                                    <ul
                                                                        type="circle"
                                                                    >
                                                                        <li>
                                                                            Less
                                                                            than
                                                                            5
                                                                            years
                                                                            old.
                                                                        </li>
                                                                        <li>
                                                                            Still
                                                                            in
                                                                            the
                                                                            early
                                                                            or
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
                                                                            May
                                                                            be
                                                                            self-funded,
                                                                            grant-awardee,
                                                                            or
                                                                            in
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
                                                                        Capacity
                                                                        &
                                                                        Commitment</strong
                                                                    >
                                                                    <ul
                                                                        type="circle"
                                                                    >
                                                                        <li>
                                                                            Should
                                                                            have
                                                                            a
                                                                            dedicated
                                                                            founding
                                                                            or
                                                                            management
                                                                            team
                                                                            with
                                                                            the
                                                                            skills,
                                                                            knowledge,
                                                                            and
                                                                            commitment
                                                                            to
                                                                            drive
                                                                            both
                                                                            the
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
                                                                            Offers
                                                                            a
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
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4>Company Size*</h4>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .company_size
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                                business_info.company_size
                                                            "
                                                            :value="compsize.id"
                                                            :id="
                                                                'company_size_' +
                                                                compsize.id
                                                            "
                                                            :disabled="
                                                                status !== 0
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
                                                    <h4>
                                                        Annual Sales Volume*
                                                    </h4>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .annual_sales_volume
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .annual_sales_volume
                                                                    .required
                                                            "
                                                        >
                                                            Annual sales volume
                                                            is required.
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
                                                                business_info.annual_sales_volume
                                                            "
                                                            :value="
                                                                annual_sales.id
                                                            "
                                                            :id="
                                                                'annual_sales' +
                                                                annual_sales.id
                                                            "
                                                            :disabled="
                                                                status !== 0
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
                                                    <h4>
                                                        Type of Organization*
                                                    </h4>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .organization_type
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .organization_type
                                                                    .required
                                                            "
                                                        >
                                                            Type of organization
                                                            is required.
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
                                                                business_info.organization_type
                                                            "
                                                            :value="orgtype.id"
                                                            :id="
                                                                'organization_type_' +
                                                                orgtype.id
                                                            "
                                                            :disabled="
                                                                status !== 0
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
                                        >Direct</label
                                    >
                                    <input
                                        type="text"
                                        inputmode="numeric"
                                        class="form-control"
                                        id="direct"
                                        v-model="business_info.direct"
                                        :class="{
                                            'is-invalid':
                                                validation.direct.$error,
                                        }"
                                        v-limit="{ max: 5, numeric: true }"
                                        :disabled="status !== 0"
                                    />
                                </div>
                                <div class="col-md-6 mt-0">
                                    <label
                                        for="indirect"
                                        class="form-label text-uppercase fw-bold"
                                        >Indirect/Subcontractors</label
                                    >
                                    <input
                                        type="text"
                                        inputmode="numeric"
                                        class="form-control"
                                        id="indirect"
                                        :class="{
                                            'is-invalid':
                                                validation.indirect.$error,
                                        }"
                                        v-limit="{ max: 5, numeric: true }"
                                        v-model="business_info.indirect"
                                        :disabled="status !== 0"
                                    />
                                </div>
                                <div class="col-md-12">
                                    <div class="card m-0 h-100 beige-bg">
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
                                                            validation
                                                                .nature_business
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .nature_business
                                                                    .required
                                                            "
                                                        >
                                                            Nature of business
                                                            is required.
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
                                                                business_info.nature_business
                                                            "
                                                            :value="
                                                                nbusiness.id
                                                            "
                                                            :id="
                                                                'nature_business' +
                                                                nbusiness.id
                                                            "
                                                            :disabled="
                                                                status !== 0
                                                            "
                                                        />
                                                        <div
                                                            v-if="
                                                                nbusiness.id ===
                                                                16
                                                            "
                                                        >
                                                            <div
                                                                class="d-flex align-items-center"
                                                            >
                                                                <label
                                                                    class="form-check-label m-0 p-0"
                                                                    :for="
                                                                        'nature_business' +
                                                                        nbusiness.id
                                                                    "
                                                                    >Others,&nbsp;</label
                                                                >
                                                                <input
                                                                    id="nature_business_others"
                                                                    class="form-control form-control-sm w-75 border-bottom"
                                                                    :class="{
                                                                        'is-invalid':
                                                                            validation
                                                                                .nature_business_others
                                                                                .$error,
                                                                    }"
                                                                    type="text"
                                                                    placeholder="please specify"
                                                                    v-limit="{
                                                                        max: 95,
                                                                    }"
                                                                    v-model="
                                                                        business_info.nature_business_others
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
                                    <div class="card m-0 h-100 beige-bg">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4>
                                                        Target
                                                        Purchasers/Buyers*
                                                    </h4>
                                                    <p class="fs-12">
                                                        Note: Select all that
                                                        applies
                                                    </p>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .target_buyer
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .target_buyer
                                                                    .required
                                                            "
                                                        >
                                                            Target
                                                            purchasers/buyers is
                                                            required.
                                                        </div>
                                                    </div>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .target_buyer_others
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                                business_info.target_buyer
                                                            "
                                                            :value="target.id"
                                                            :id="
                                                                'target' +
                                                                target.id
                                                            "
                                                            :disabled="
                                                                status !== 0
                                                            "
                                                        />
                                                        <div
                                                            v-if="
                                                                target.id === 6
                                                            "
                                                        >
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
                                                                            validation
                                                                                .target_buyer_others
                                                                                .$error,
                                                                    }"
                                                                    type="text"
                                                                    placeholder="please specify"
                                                                    v-limit="{
                                                                        max: 95,
                                                                    }"
                                                                    v-model="
                                                                        business_info.target_buyer_others
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
                                                                'target' +
                                                                target.id
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
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Target Countries for Export (Top
                                        3)*</label
                                    >
                                    <div
                                        v-if="
                                            validation.target_country_1.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.target_country_1
                                                    .isUnique
                                            "
                                        >
                                            Target country for export duplicate
                                            entry.
                                        </div>
                                    </div>
                                    <select
                                        class="form-select form-select-sm mb-2"
                                        v-model="business_info.target_country_1"
                                        :class="{
                                            'is-invalid':
                                                validation.target_country_1
                                                    .$error,
                                        }"
                                        :disabled="status !== 0"
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
                                    <div
                                        v-if="
                                            validation.target_country_1.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.target_country_1
                                                    .required
                                            "
                                        >
                                            Target country for export (Top 1) is
                                            required.
                                        </div>
                                    </div>
                                    <select
                                        class="form-select form-select-sm mb-2"
                                        v-model="business_info.target_country_2"
                                        :class="{
                                            'is-invalid':
                                                validation.target_country_2
                                                    .$error,
                                        }"
                                        :disabled="status !== 0"
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
                                    <div
                                        v-if="
                                            validation.target_country_2.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.target_country_2
                                                    .required
                                            "
                                        >
                                            Target country for export (Top 2) is
                                            required.
                                        </div>
                                    </div>
                                    <select
                                        class="form-select form-select-sm"
                                        v-model="business_info.target_country_3"
                                        :class="{
                                            'is-invalid':
                                                validation.target_country_3
                                                    .$error,
                                        }"
                                        :disabled="status !== 0"
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
                                    <div
                                        v-if="
                                            validation.target_country_3.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.target_country_3
                                                    .required
                                            "
                                        >
                                            Target country for export (Top 3) is
                                            required.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card m-0 h-100 beige-bg">
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
                                                            validation
                                                                .certification
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                            validation
                                                                .certification_others
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                                business_info.certification
                                                            "
                                                            :value="cert.id"
                                                            :id="
                                                                'certification_' +
                                                                cert.id
                                                            "
                                                            :disabled="
                                                                status !== 0
                                                            "
                                                        />
                                                        <div
                                                            v-if="
                                                                cert.id === 14
                                                            "
                                                        >
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
                                                                            validation
                                                                                .certification_others
                                                                                .$error,
                                                                    }"
                                                                    :disabled="
                                                                        status !==
                                                                        0
                                                                    "
                                                                    type="text"
                                                                    placeholder="please specify"
                                                                    v-limit="{
                                                                        max: 95,
                                                                    }"
                                                                    v-model="
                                                                        business_info.certification_others
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
                                                            >{{
                                                                cert.name
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
                                                    <h4>
                                                        Industry Representation*
                                                    </h4>
                                                    <div
                                                        v-if="
                                                            validation
                                                                .industry_representation
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .industry_representation
                                                                    .required
                                                            "
                                                        >
                                                            Industry
                                                            representation is
                                                            required.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <input
                                                            type="radio"
                                                            class="form-check-input"
                                                            v-model="
                                                                business_info.industry_representation
                                                            "
                                                            :value="1"
                                                            :disabled="
                                                                status !== 0
                                                            "
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
                                                                business_info.industry_representation
                                                            "
                                                            :value="2"
                                                            :disabled="
                                                                status !== 0
                                                            "
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
                                                        business_info.industry_representation ===
                                                        1
                                                    "
                                                >
                                                    <label
                                                        class="form-label text-uppercase fw-bold"
                                                        >Countries Exporting To
                                                        (Top 3)*</label
                                                    >
                                                    <div
                                                        v-if="
                                                            validation
                                                                .exporting_country_1
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
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
                                                            business_info.exporting_country_1
                                                        "
                                                        :class="{
                                                            'is-invalid':
                                                                validation
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
                                                            validation
                                                                .exporting_country_1
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .exporting_country_1
                                                                    .required
                                                            "
                                                        >
                                                            Country exporting
                                                            (Top 1) is required.
                                                        </div>
                                                    </div>
                                                    <select
                                                        class="form-select form-select-sm mb-2 border border-secondary"
                                                        v-model="
                                                            business_info.exporting_country_2
                                                        "
                                                        :class="{
                                                            'is-invalid':
                                                                validation
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
                                                            validation
                                                                .exporting_country_2
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .exporting_country_2
                                                                    .required
                                                            "
                                                        >
                                                            Country exporting
                                                            (Top 2) is required.
                                                        </div>
                                                    </div>
                                                    <select
                                                        class="form-select form-select-sm border border-secondary"
                                                        v-model="
                                                            business_info.exporting_country_3
                                                        "
                                                        :class="{
                                                            'is-invalid':
                                                                validation
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
                                                            validation
                                                                .exporting_country_3
                                                                .$error
                                                        "
                                                    >
                                                        <div
                                                            class="fw-light invalid-feedback d-block"
                                                            v-if="
                                                                !validation
                                                                    .exporting_country_3
                                                                    .required
                                                            "
                                                        >
                                                            Country exporting
                                                            (Top 3) is required.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label
                                        class="form-label text-uppercase fw-bold"
                                        >Specific Products and/or Services
                                        Offered:*</label
                                    >
                                    <textarea
                                        class="form-control beige-bg"
                                        rows="3"
                                        v-model="business_info.product_promoted"
                                        :class="{
                                            'is-invalid':
                                                validation.product_promoted
                                                    .$error,
                                        }"
                                        v-limit="{ max: 400 }"
                                        :disabled="status !== 0"
                                    ></textarea>
                                    <div
                                        v-if="
                                            validation.product_promoted.$error
                                        "
                                    >
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="
                                                !validation.product_promoted
                                                    .required
                                            "
                                        >
                                            Please specify products to be
                                            promoted.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 pt-3">
                                    <h4>Supplier/Exhibitor Profile*</h4>
                                    <p>
                                        Please indicate if your company is
                                        offering the following (check all that
                                        applies):
                                    </p>
                                </div>
                                <div class="row">
                                    <div v-if="validation.category.$error">
                                        <div
                                            class="fw-light invalid-feedback d-block"
                                            v-if="!validation.category.required"
                                        >
                                            Exhibitor profile is required.
                                        </div>
                                    </div>
                                    <div
                                        class="col-md-6 mt-3 mt-md-0"
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
                                                        v-model="
                                                            business_info.category
                                                        "
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
                                        <div class="card m-0 h-100 beige-bg">
                                            <div class="card-body">
                                                <p
                                                    class="bg-light text-wrap mb-1"
                                                >
                                                    Please indicate if your
                                                    company has the following
                                                    characteristics (check all
                                                    that applies):
                                                </p>
                                                <h4>ON INPUT / OUTPUT:*</h4>
                                                <div
                                                    v-if="
                                                        validation.input_ouput
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !validation
                                                                .input_ouput
                                                                .required
                                                        "
                                                    >
                                                        On input/output is
                                                        required.
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
                                                        v-model="
                                                            business_info.input_ouput
                                                        "
                                                        :value="inout.id"
                                                        :id="
                                                            'input_ouput_' +
                                                            inout.id
                                                        "
                                                        :disabled="status !== 0"
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
                                        <div class="card m-0 h-100 beige-bg">
                                            <div class="card-body">
                                                <h4>ON PRODUCTION PROCESS:*</h4>
                                                <div
                                                    v-if="
                                                        validation
                                                            .production_process
                                                            .$error
                                                    "
                                                >
                                                    <div
                                                        class="fw-light invalid-feedback d-block"
                                                        v-if="
                                                            !validation
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
                                                            business_info.production_process
                                                        "
                                                        :value="prod_process.id"
                                                        :id="
                                                            'on_production_process_' +
                                                            prod_process.id
                                                        "
                                                        :disabled="status !== 0"
                                                    />
                                                    <div
                                                        v-if="
                                                            prod_process.id ===
                                                            3
                                                        "
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
                                                                        validation
                                                                            .production_process_others
                                                                            .$error,
                                                                }"
                                                                type="text"
                                                                placeholder="Please specify certification/s"
                                                                v-limit="{
                                                                    max: 95,
                                                                }"
                                                                v-model="
                                                                    business_info.production_process_others
                                                                "
                                                                :readonly="
                                                                    check_production_process_others
                                                                "
                                                                :disabled="
                                                                    status !== 0
                                                                "
                                                            />
                                                            <div
                                                                v-if="
                                                                    validation
                                                                        .production_process_others
                                                                        .$error
                                                                "
                                                            >
                                                                <div
                                                                    class="fw-light invalid-feedback d-block"
                                                                    v-if="
                                                                        !validation
                                                                            .production_process_others
                                                                            .required
                                                                    "
                                                                >
                                                                    Please
                                                                    specify
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
                                    <!-- SUSTAINABILITY IS MULTIFACETED -->
                                    <div
                                        class="col-12 mt-3"
                                        v-if="topics.length > 0"
                                    >
                                        <div class="card m-0 h-100 beige-bg">
                                            <div class="card-body">
                                                <p
                                                    class="bg-light text-wrap mb-1"
                                                >
                                                    Please indicate which
                                                    sustainability topics the
                                                    show should focus on (check
                                                    all that apply):
                                                </p>
                                                <h4>
                                                    SUSTAINABILITY IS
                                                    MULTIFACETED, WHICH OF THE
                                                    TOPICS BELOW DO YOU THINK
                                                    THE SHOW SHOULD FOCUS ON?*
                                                </h4>

                                                <!-- Validation -->

                                                <!-- Checkboxes -->
                                                <div
                                                    class="form-check"
                                                    v-for="topic in topics"
                                                    :key="topic.id"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="form-check-input"
                                                        v-model="
                                                            business_info.sustainability_topics
                                                        "
                                                        :value="topic.id"
                                                        :id="
                                                            'sustainability_topic_' +
                                                            topic.id
                                                        "
                                                        :disabled="status !== 0"
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
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "BusinessInfoCard",
    props: {
        business_info: { type: Object, required: true },
        business_types: Array,
        company_sizes: Array,
        annual_sales_volumes: Array,
        organization_types: Array,
        nature_businesses: Array,
        target_buyers: Array,
        countries: Array,
        certifications: Array,
        categories: Array,
        inputs_outputs: Array,
        production_processes: Array,
        topics: Array,
        checkTargetOthers: { type: Boolean, default: false },
        checkNatureBusinessOthers: { type: Boolean, default: false },
        checkCertificationOthers: { type: Boolean, default: false },
        onChangeIndustryRep: { type: Function, required: true },
        checkProductionProcessOthers: { type: Boolean, default: false },
        validation: { type: Object, required: true },
        canAction: {
            type: Boolean,
            default: false,
        },
        status: {
            type: Number,
            default: 0,
        },
    },
    computed: {
        check_certification_others() {
            return this.checkCertificationOthers;
        },

        check_nature_business_others() {
            return this.checkNatureBusinessOthers;
        },

        check_production_process_others() {
            return this.checkProductionProcessOthers;
        },

        check_target_others() {
            return this.checkTargetOthers;
        },
    },
};
</script>
