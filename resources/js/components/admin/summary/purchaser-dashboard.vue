<template>
    <div class="col-md-12">
        <div class="bc-card bc-card--outer">
            <!-- HEADER -->
            <div class="bc-header">
                <div>
                    <h4 class="bc-title">Purchasers / Buyers</h4>

                    <p class="bc-subtitle">
                        Registration and application status overview
                    </p>
                </div>

                <div v-if="purchaser_summary.fair_code" class="bc-fair-badge">
                    <span class="bc-fair-badge__label"> Fair </span>

                    <span class="bc-fair-badge__value">
                        {{ purchaser_summary.fair_code }}
                    </span>
                </div>
            </div>

            <!-- BODY -->
            <div class="bc-body">
                <section class="bc-section bc-section--last">
                    <div class="bc-section-head">
                        <h5 class="bc-section-title">Registration</h5>

                        <p class="bc-section-desc">
                            Current purchaser and buyer registration status
                        </p>
                    </div>

                    <!-- REGISTRATION SUMMARY -->
                    <div class="bc-registration">
                        <!-- TOTAL -->
                        <div class="bc-hero">
                            <div class="bc-hero__number">
                                {{ purchaser_summary.total_registered }}
                            </div>

                            <div class="bc-hero__label">Registered so far</div>
                        </div>

                        <!-- STATUS -->
                        <div class="bc-pill-grid">
                            <div
                                v-for="stat in registrationStats"
                                :key="stat.key"
                                class="bc-pill"
                            >
                                <span
                                    class="bc-pill__dot"
                                    :style="{
                                        backgroundColor: stat.color,
                                    }"
                                ></span>

                                <span class="bc-pill__count">
                                    {{ purchaser_summary[stat.key] }}
                                </span>

                                <span class="bc-pill__label">
                                    {{ stat.label }}
                                </span>
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
    name: "PurchaserDashboard",

    data() {
        return {
            purchaser_summary: {
                fair_code: null,

                total_registered: 0,

                approved: 0,
                denied: 0,
                incomplete: 0,
                pending: 0,
                reviewed: 0,
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
                    key: "denied",
                    label: "Denied",
                    color: "#D1264F",
                },
            ],
        };
    },

    computed: {
        statusTotal() {
            return (
                this.purchaser_summary.approved +
                this.purchaser_summary.pending +
                this.purchaser_summary.reviewed +
                this.purchaser_summary.incomplete +
                this.purchaser_summary.denied
            );
        },

        approvedPct() {
            return this.pct(this.purchaser_summary.approved, this.statusTotal);
        },

        pendingPct() {
            return this.pct(this.purchaser_summary.pending, this.statusTotal);
        },

        reviewedPct() {
            return this.pct(this.purchaser_summary.reviewed, this.statusTotal);
        },

        incompletePct() {
            return this.pct(
                this.purchaser_summary.incomplete,
                this.statusTotal
            );
        },

        deniedPct() {
            return this.pct(this.purchaser_summary.denied, this.statusTotal);
        },
    },

    created() {
        this.purchaserSummary();
    },

    methods: {
        pct(value, total) {
            if (!total) {
                return 0;
            }

            return Math.round((value / total) * 100);
        },

        purchaserSummary() {
            axios
                .get("/api/dashboard/purchasers/summary/fair")
                .then((response) => {
                    if (response.status === 200) {
                        this.purchaser_summary = response.data;
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
.bc-card {
    background: #ffffff;
    border: 1px solid #e5e2dc;
    border-radius: 14px;
}

.bc-card--outer {
    overflow: hidden;
}

/* HEADER */

.bc-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 24px 28px;
    border-bottom: 1px solid #e5e2dc;
}

.bc-title {
    margin: 0 0 4px;
    font-size: 20px;
    font-weight: 800;
    color: #241c15;
}

.bc-subtitle {
    margin: 0;
    font-size: 13px;
    color: #6b655c;
}

/* FAIR */

.bc-fair-badge {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    background: #e6f4f5;
    border-radius: 10px;
    padding: 8px 14px;
}

.bc-fair-badge__label {
    font-size: 11px;
    color: #007c89;
}

.bc-fair-badge__value {
    font-size: 15px;
    font-weight: 700;
    color: #007c89;
}

/* BODY */

.bc-body {
    padding: 28px;
}

.bc-section {
    margin-bottom: 36px;
}

.bc-section--last {
    margin-bottom: 0;
}

.bc-section-head {
    margin-bottom: 16px;
}

.bc-section-title {
    margin: 0 0 2px;
    font-size: 16px;
    font-weight: 700;
    color: #241c15;
}

.bc-section-desc {
    margin: 0;
    font-size: 13px;
    color: #6b655c;
}

/* REGISTRATION */

.bc-registration {
    display: flex;
    gap: 20px;
    align-items: stretch;
    flex-wrap: wrap;
}

/* TOTAL */

.bc-hero {
    background: #9daa39;
    border-radius: 14px;
    padding: 24px 32px;
    min-width: 180px;

    display: flex;
    flex-direction: column;
    justify-content: center;
}

.bc-hero__number {
    font-size: 40px;
    font-weight: 800;
    color: white;
    line-height: 1;
}

.bc-hero__label {
    margin-top: 8px;
    font-size: 13px;
    color: white;
}

/* PILLS */

.bc-pill-grid {
    flex: 1;

    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-content: center;
}

.bc-pill {
    display: flex;
    align-items: center;
    gap: 8px;

    background: #faf8f4;
    border: 1px solid #e5e2dc;
    border-radius: 999px;

    padding: 8px 16px;
}

.bc-pill__dot {
    width: 8px;
    height: 8px;

    min-width: 8px;

    border-radius: 50%;
}

.bc-pill__count {
    font-weight: 700;
    color: #241c15;
    font-size: 14px;
}

.bc-pill__label {
    font-size: 13px;
    color: #6b655c;
}

/* STATUS CARD */

.bc-status-card {
    margin-top: 20px;

    background: #faf8f4;
    border: 1px solid #e5e2dc;
    border-radius: 14px;

    padding: 20px;
}

.bc-status-card__head {
    margin-bottom: 14px;
}

.bc-status-card__head h6 {
    margin: 0;

    font-size: 14px;
    font-weight: 700;

    color: #241c15;
}

.bc-status-card__head span {
    font-size: 12px;
    color: #6b655c;
}

/* BAR */

.bc-bar {
    display: flex;

    width: 100%;
    height: 10px;

    border-radius: 999px;
    overflow: hidden;

    background: #f1efea;

    margin-bottom: 14px;
}

.bc-bar__segment {
    height: 100%;
}

/* LEGEND */

.bc-legend {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.bc-legend__item {
    display: flex;
    align-items: center;
    gap: 6px;

    font-size: 13px;
    color: #6b655c;
}

.bc-legend__item strong {
    color: #241c15;
    margin-left: 2px;
}

.bc-legend__dot {
    width: 8px;
    height: 8px;

    border-radius: 50%;
}

/* RESPONSIVE */

@media (max-width: 991px) {
    .bc-registration {
        flex-direction: column;
    }

    .bc-hero {
        min-width: 100%;
    }

    .bc-pill-grid {
        width: 100%;
    }
}

@media (max-width: 767px) {
    .bc-header {
        padding: 20px;
        gap: 16px;

        flex-direction: column;
    }

    .bc-body {
        padding: 20px;
    }

    .bc-fair-badge {
        align-items: flex-start;
    }

    .bc-registration {
        flex-direction: column;
        gap: 16px;
    }

    .bc-hero {
        width: 100%;
        min-width: 0;
    }

    .bc-pill-grid {
        width: 100%;
        gap: 8px;
    }

    .bc-pill {
        padding: 8px 12px;
    }

    .bc-status-card {
        padding: 18px;
    }

    .bc-legend {
        gap: 10px 14px;
    }
}
</style>
