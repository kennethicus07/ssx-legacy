<template>
    <div class="col-md-12">
        <div class="mc-card mc-card--outer">
            <!-- ===================================================== -->
            <!-- HEADER -->
            <!-- ===================================================== -->

            <div class="mc-header">
                <div>
                    <h4 class="mc-title">Suppliers / Exhibitors</h4>
                    <p class="mc-subtitle">
                        Registration, compliance and payment overview
                    </p>
                </div>

                <div v-if="supplier_summary.fair_code" class="mc-fair-badge">
                    <span class="mc-fair-badge__label">Fair</span>
                    <span class="mc-fair-badge__value">
                        {{ supplier_summary.fair_code }}
                    </span>
                </div>
            </div>

            <div class="mc-body">
                <section class="mc-section">
                    <div class="mc-section-head">
                        <h5 class="mc-section-title">Registration</h5>

                        <p class="mc-section-desc">
                            Current supplier / exhibitor registration status
                        </p>
                    </div>

                    <div class="mc-registration">
                        <!-- Hero number -->
                        <div class="mc-hero">
                            <div class="mc-hero__number">
                                {{ supplier_summary.total_registered }}
                            </div>

                            <div class="mc-hero__label">Registered so far</div>
                        </div>

                        <!-- Status breakdown pills -->
                        <div class="mc-pill-grid">
                            <div
                                v-for="stat in registrationStats"
                                :key="stat.key"
                                class="mc-pill"
                            >
                                <span
                                    class="mc-pill__dot"
                                    :style="{ background: stat.color }"
                                ></span>

                                <span class="mc-pill__count">
                                    {{ supplier_summary[stat.key] }}
                                </span>

                                <span class="mc-pill__label">
                                    {{ stat.label }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ================================================= -->
                <!-- CONFORME / RTB -->
                <!-- ================================================= -->

                <section class="mc-section">
                    <div class="mc-section-head">
                        <h5 class="mc-section-title">Conforme &amp; RTB</h5>

                        <p class="mc-section-desc">
                            Where each supplier sits in the document and RTB
                            process
                        </p>
                    </div>

                    <!-- Arrow process -->
                    <div class="mc-process">
                        <div
                            v-for="(step, index) in conformeSteps"
                            :key="step.key"
                            class="mc-process__item"
                        >
                            <!-- Process stage -->
                            <div class="mc-process__stage">
                                <div class="mc-process__count">
                                    {{ supplier_summary[step.key] }}
                                </div>

                                <div class="mc-process__label">
                                    <span
                                        class="mc-process__dot"
                                        :style="{ backgroundColor: step.color }"
                                    ></span>

                                    <span>
                                        {{ step.label }}
                                    </span>
                                </div>
                            </div>
                            <div class="px-2 py-2"></div>

                            <!-- <div
                                v-if="index < conformeSteps.length - 1"
                                class="mc-process__arrow"
                            >
                                →
                            </div> -->
                        </div>
                    </div>
                </section>

                <!-- ================================================= -->
                <!-- FINANCIAL -->
                <!-- ================================================= -->

                <section class="mc-section mc-section--last">
                    <div class="mc-section-head">
                        <h5 class="mc-section-title">Financial overview</h5>

                        <p class="mc-section-desc">
                            Statement of Account and payment status
                        </p>
                    </div>

                    <div class="mc-finance-grid">
                        <!-- ================================================= -->
                        <!-- SOA -->
                        <!-- ================================================= -->

                        <div class="mc-card mc-finance-card">
                            <div class="mc-finance-card__head">
                                <h6>Statement of Account</h6>

                                <span class="mc-finance-card__total">
                                    {{ soaTotal }} total
                                </span>
                            </div>

                            <div class="mc-bar">
                                <div
                                    class="mc-bar__segment"
                                    :style="{
                                        background: '#2BA641',
                                        width: soaGeneratedPct + '%',
                                    }"
                                ></div>

                                <div
                                    class="mc-bar__segment"
                                    :style="{
                                        background: '#F0B429',
                                        width: soaNotGeneratedPct + '%',
                                    }"
                                ></div>
                            </div>

                            <div class="mc-legend">
                                <div class="mc-legend__item">
                                    <span
                                        class="mc-legend__dot"
                                        style="background: #2ba641"
                                    ></span>

                                    Generated

                                    <strong>
                                        {{ supplier_summary.soa_generated }}
                                    </strong>
                                </div>

                                <div class="mc-legend__item">
                                    <span
                                        class="mc-legend__dot"
                                        style="background: #f0b429"
                                    ></span>

                                    Not generated

                                    <strong>
                                        {{ supplier_summary.soa_not_generated }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <!-- ================================================= -->
                        <!-- PAYMENT -->
                        <!-- ================================================= -->

                        <div class="mc-card mc-finance-card">
                            <div class="mc-finance-card__head">
                                <h6>Payment</h6>

                                <span class="mc-finance-card__total">
                                    {{ paymentTotal }} total
                                </span>
                            </div>

                            <div class="mc-bar">
                                <div
                                    class="mc-bar__segment"
                                    :style="{
                                        background: '#2BA641',
                                        width: paidPct + '%',
                                    }"
                                ></div>

                                <div
                                    class="mc-bar__segment"
                                    :style="{
                                        background: '#F0B429',
                                        width: paymentPendingPct + '%',
                                    }"
                                ></div>

                                <div
                                    class="mc-bar__segment"
                                    :style="{
                                        background: '#D1264F',
                                        width: unpaidPct + '%',
                                    }"
                                ></div>
                            </div>

                            <div class="mc-legend">
                                <div class="mc-legend__item">
                                    <span
                                        class="mc-legend__dot"
                                        style="background: #2ba641"
                                    ></span>

                                    Paid

                                    <strong>
                                        {{ supplier_summary.paid }}
                                    </strong>
                                </div>

                                <div class="mc-legend__item">
                                    <span
                                        class="mc-legend__dot"
                                        style="background: #f0b429"
                                    ></span>

                                    Pending

                                    <strong>
                                        {{ supplier_summary.payment_pending }}
                                    </strong>
                                </div>

                                <div class="mc-legend__item">
                                    <span
                                        class="mc-legend__dot"
                                        style="background: #d1264f"
                                    ></span>

                                    Unpaid

                                    <strong>
                                        {{ supplier_summary.unpaid }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SupplierDashboard",

    data() {
        return {
            supplier_summary: {
                fair_code: null,

                // Registration
                total_registered: 0,
                approved: 0,
                incomplete: 0,
                pending: 0,
                reviewed: 0,
                onhold: 0,
                denied: 0,

                // Conforme / RTB
                pending_conforme_generation: 0,
                awaiting_conforme_response: 0,
                for_rtb: 0,
                generated_rtb: 0,

                // SOA
                soa_not_generated: 0,
                soa_generated: 0,

                // Payment
                unpaid: 0,
                payment_pending: 0,
                paid: 0,
            },

            registrationStats: [
                {
                    key: "approved",
                    label: "Approved",
                    color: "#9daa39",
                },
                {
                    key: "pending",
                    label: "Pending",
                    color: "#2255a4",
                },
                {
                    key: "reviewed",
                    label: "Reviewed",
                    color: "#7460ee",
                },
                {
                    key: "incomplete",
                    label: "Incomplete",
                    color: "#6c757d",
                },
                {
                    key: "onhold",
                    label: "On hold",
                    color: "#9C958B",
                },
                {
                    key: "denied",
                    label: "Denied",
                    color: "#D1264F",
                },
            ],

            conformeSteps: [
                {
                    key: "pending_conforme_generation",
                    label: "Pending Conforme Generation",
                    color: "#ffb848",
                },
                {
                    key: "awaiting_conforme_response",
                    label: "Awaiting Conforme Response",
                    color: "#7460ee",
                },
                {
                    key: "for_rtb",
                    label: "For RTB",
                    color: "#ffb848",
                },
                {
                    key: "generated_rtb",
                    label: "Generated RTB",
                    color: "#9daa39",
                },
            ],
        };
    },

    computed: {
        // =========================================================
        // SOA
        // =========================================================

        soaTotal() {
            return (
                this.supplier_summary.soa_generated +
                this.supplier_summary.soa_not_generated
            );
        },

        soaGeneratedPct() {
            return this.pct(this.supplier_summary.soa_generated, this.soaTotal);
        },

        soaNotGeneratedPct() {
            return this.pct(
                this.supplier_summary.soa_not_generated,
                this.soaTotal
            );
        },

        // =========================================================
        // PAYMENT
        // =========================================================

        paymentTotal() {
            return (
                this.supplier_summary.paid +
                this.supplier_summary.payment_pending +
                this.supplier_summary.unpaid
            );
        },

        paidPct() {
            return this.pct(this.supplier_summary.paid, this.paymentTotal);
        },

        paymentPendingPct() {
            return this.pct(
                this.supplier_summary.payment_pending,
                this.paymentTotal
            );
        },

        unpaidPct() {
            return this.pct(this.supplier_summary.unpaid, this.paymentTotal);
        },
    },

    created() {
        this.supplierSummary();
    },

    methods: {
        pct(value, total) {
            if (!total) {
                return 0;
            }

            return Math.round((value / total) * 100);
        },

        supplierSummary() {
            axios
                .get("/api/dashboard/suppliers/summary/fair")
                .then((response) => {
                    if (response.status === 200) {
                        this.supplier_summary = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
/* ========================================================= */
/* BASE CARD */
/* ========================================================= */

.mc-card {
    background: #ffffff;
    border: 1px solid #e5e2dc;
    border-radius: 14px;
}

.mc-card--outer {
    overflow: hidden;
}

/* ========================================================= */
/* HEADER */
/* ========================================================= */

.mc-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 24px 28px;
    border-bottom: 1px solid #e5e2dc;
}

.mc-title {
    margin: 0 0 4px;
    font-size: 20px;
    font-weight: 800;
    color: #241c15;
}

.mc-subtitle {
    margin: 0;
    font-size: 13px;
    color: #6b655c;
}

.mc-fair-badge {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    background: #e6f4f5;
    border-radius: 10px;
    padding: 8px 14px;
}

.mc-fair-badge__label {
    font-size: 11px;
    color: #007c89;
}

.mc-fair-badge__value {
    font-size: 15px;
    font-weight: 700;
    color: #007c89;
}

/* ========================================================= */
/* BODY / SECTIONS */
/* ========================================================= */

.mc-body {
    padding: 28px;
}

.mc-section {
    margin-bottom: 36px;
}

.mc-section--last {
    margin-bottom: 0;
}

.mc-section-head {
    margin-bottom: 16px;
}

.mc-section-title {
    margin: 0 0 2px;
    font-size: 16px;
    font-weight: 700;
    color: #241c15;
}

.mc-section-desc {
    margin: 0;
    font-size: 13px;
    color: #6b655c;
}

/* ========================================================= */
/* REGISTRATION */
/* ========================================================= */

.mc-registration {
    display: flex;
    gap: 20px;
    align-items: stretch;
    flex-wrap: wrap;
}

.mc-hero {
    background: #9daa39;
    border-radius: 14px;
    padding: 24px 32px;
    min-width: 180px;

    display: flex;
    flex-direction: column;
    justify-content: center;
}

.mc-hero__number {
    font-size: 40px;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.mc-hero__label {
    margin-top: 8px;
    font-size: 13px;
    color: white;
}

.mc-pill-grid {
    flex: 1;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-content: center;
}

.mc-pill {
    display: flex;
    align-items: center;
    gap: 8px;

    background: #faf8f4;
    border: 1px solid #e5e2dc;
    border-radius: 999px;

    padding: 8px 16px;
}

.mc-pill__dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.mc-pill__count {
    font-weight: 700;
    color: #241c15;
    font-size: 14px;
}

.mc-pill__label {
    font-size: 13px;
    color: #6b655c;
}

/* ========================================================= */
/* CONFORME / RTB PROCESS */
/* ========================================================= */

.mc-process {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 10px 0;
}

.mc-process__item {
    display: flex;
    align-items: center;
    flex: 1;
    min-width: 0;
}

.mc-process__stage {
    flex: 1;
    min-width: 0;

    text-align: center;

    padding: 18px 12px;

    background: #faf8f4;
    border: 1px solid #e5e2dc;
    border-radius: 12px;
}

.mc-process__count {
    font-size: 26px;
    font-weight: 800;
    line-height: 1;
    color: #241c15;
}

.mc-process__label {
    margin-top: 8px;

    font-size: 12.5px;
    line-height: 1.3;

    color: #6b655c;
}

.mc-process__arrow {
    flex: 0 0 auto;

    padding: 0 10px;

    font-size: 24px;
    font-weight: 600;

    color: #9c958b;
}

/* ========================================================= */
/* FINANCIAL */
/* ========================================================= */

.mc-finance-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.mc-finance-card {
    padding: 20px;
}

.mc-finance-card__head {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 14px;
}

.mc-finance-card__head h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #241c15;
}

.mc-finance-card__total {
    font-size: 12px;
    color: #6b655c;
}

/* ========================================================= */
/* PROGRESS BAR */
/* ========================================================= */

.mc-bar {
    display: flex;
    width: 100%;
    height: 10px;

    border-radius: 999px;
    overflow: hidden;

    background: #f1efea;

    margin-bottom: 14px;
}

.mc-bar__segment {
    height: 100%;
}

/* ========================================================= */
/* LEGEND */
/* ========================================================= */

.mc-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.mc-legend__item {
    display: flex;
    align-items: center;
    gap: 6px;

    font-size: 13px;
    color: #6b655c;
}

.mc-legend__item strong {
    color: #241c15;
    margin-left: 2px;
}

.mc-legend__dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
.mc-process__label {
    margin-top: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    font-size: 12.5px;
    line-height: 1.3;
    color: #6b655c;
}

.mc-process__dot {
    width: 8px;
    height: 8px;
    min-width: 8px;
    border-radius: 50%;
    display: inline-block;
}

/* ========================================================= */
/* TABLET */
/* ========================================================= */

@media (max-width: 991px) {
    .mc-registration {
        flex-direction: column;
    }

    .mc-hero {
        min-width: 100%;
    }

    .mc-pill-grid {
        width: 100%;
    }

    .mc-process__stage {
        padding: 16px 8px;
    }

    .mc-process__arrow {
        padding: 0 6px;
        font-size: 20px;
    }
}

/* ========================================================= */
/* MOBILE */
/* ========================================================= */

@media (max-width: 767px) {
    .mc-header {
        padding: 20px;
        gap: 16px;
    }

    .mc-body {
        padding: 20px;
    }

    .mc-header {
        flex-direction: column;
    }

    .mc-fair-badge {
        align-items: flex-start;
    }

    .mc-registration {
        flex-direction: column;
        gap: 16px;
    }

    .mc-hero {
        width: 100%;
        min-width: 0;
    }

    .mc-pill-grid {
        width: 100%;
        gap: 8px;
    }

    .mc-pill {
        padding: 8px 12px;
    }

    /* ========================================= */
    /* MOBILE CONFORME PROCESS */
    /* ========================================= */

    .mc-process {
        flex-direction: column;
        align-items: stretch;
        gap: 0;
    }

    .mc-process__item {
        flex-direction: column;
        width: 100%;
    }

    .mc-process__stage {
        width: 100%;
        padding: 16px 12px;
    }

    .mc-process__count {
        font-size: 24px;
    }

    .mc-process__label {
        font-size: 12px;
    }

    .mc-process__arrow {
        padding: 7px 0;

        font-size: 22px;

        line-height: 1;

        transform: rotate(90deg);
    }

    /* ========================================= */
    /* MOBILE FINANCIAL */
    /* ========================================= */

    .mc-finance-grid {
        grid-template-columns: 1fr;
    }

    .mc-finance-card {
        padding: 18px;
    }

    .mc-legend {
        gap: 10px 14px;
    }
}
</style>
