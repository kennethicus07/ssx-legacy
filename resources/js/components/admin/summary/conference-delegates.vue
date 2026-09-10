<template>
    <div class="col-md-12">
        <div class="mc-card mc-card--outer">
            <!-- ===================================================== -->
            <!-- HEADER -->
            <!-- ===================================================== -->

            <div class="mc-header">
                <div>
                    <h4 class="mc-title">Conference Delegates</h4>

                    <p class="mc-subtitle">
                        Conference registration and participant overview
                    </p>
                </div>

                <div v-if="conference_summary.fair_code" class="mc-fair-badge">
                    <span class="mc-fair-badge__label"> Fair </span>

                    <span class="mc-fair-badge__value">
                        {{ conference_summary.fair_code }}
                    </span>
                </div>
            </div>

            <div class="mc-body">
                <!-- ================================================= -->
                <!-- CONFERENCE REGISTRATION -->
                <!-- ================================================= -->

                <section class="mc-section">
                    <div class="mc-chart-grid">
                        <!-- ========================================= -->
                        <!-- REGISTRATION PARTICIPANT -->
                        <!-- ========================================= -->

                        <div class="mc-chart-card">
                            <div class="mc-chart-header">
                                <div>
                                    <div class="mc-chart-title">
                                        Registration Participant
                                    </div>

                                    <div class="mc-chart-subtitle">
                                        Participant registration overview
                                    </div>
                                </div>
                            </div>

                            <div class="mc-registration-chart">
                                <canvas ref="registrationChart"></canvas>
                            </div>
                        </div>

                        <!-- ========================================= -->
                        <!-- PARTICIPANTS BY SEX -->
                        <!-- ========================================= -->

                        <div class="mc-chart-card">
                            <div class="mc-chart-header">
                                <div>
                                    <div class="mc-chart-title">
                                        Delegates by Sex
                                    </div>

                                    <div class="mc-chart-subtitle">
                                        Male and Female distribution
                                    </div>
                                </div>
                            </div>

                            <div class="mc-sex-chart">
                                <canvas ref="sexChart"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- ================================================= -->
                <!-- DELEGATE CATEGORIES -->
                <!-- ================================================= -->

                <section class="mc-section">
                    <div class="mc-category-chart-card">
                        <div class="mc-chart-header">
                            <div>
                                <div class="mc-chart-title">
                                    Delegate Categories
                                </div>

                                <div class="mc-chart-subtitle">
                                    Distribution of registered conference
                                    delegates
                                </div>
                            </div>
                        </div>

                        <div class="mc-category-chart">
                            <canvas ref="categoryChart"></canvas>
                        </div>
                    </div>
                </section>
                <!-- ================================================= -->
                <!-- COUNTRIES + REGISTRATION SOURCE -->
                <!-- ================================================= -->

                <section class="mc-section mc-section--last">
                    <div class="mc-two-column">
                        <!-- ========================================= -->
                        <!-- TOP COUNTRIES -->
                        <!-- ========================================= -->

                        <div class="mc-card mc-info-card">
                            <div class="mc-info-card__head">
                                <div>
                                    <h6>Top 5 Countries (Delegates)</h6>

                                    <span>
                                        Countries with the highest number of
                                        registrants
                                    </span>
                                </div>
                            </div>

                            <div
                                v-if="conference_summary.top_countries.length"
                                class="mc-ranking"
                            >
                                <div
                                    v-for="(
                                        country, index
                                    ) in conference_summary.top_countries"
                                    :key="country.country"
                                    class="mc-ranking__item"
                                >
                                    <div class="mc-ranking__rank">
                                        {{ index + 1 }}
                                    </div>

                                    <div class="mc-ranking__country">
                                        {{ country.country }}
                                    </div>

                                    <div class="mc-ranking__count">
                                        {{ country.count }}
                                    </div>
                                </div>
                            </div>

                            <div v-else class="mc-empty">
                                No country data available.
                            </div>
                        </div>

                        <!-- ========================================= -->
                        <!-- REGISTRATION SOURCE -->
                        <!-- ========================================= -->

                        <div class="mc-card mc-info-card">
                            <div class="mc-info-card__head">
                                <div>
                                    <h6>Registration Source (Delegates)</h6>

                                    <span>
                                        How participants learned about the
                                        conference
                                    </span>
                                </div>
                            </div>

                            <div
                                v-if="
                                    conference_summary.registration_sources
                                        .length
                                "
                                class="mc-source-list"
                            >
                                <div
                                    v-for="source in conference_summary.registration_sources"
                                    :key="source.source"
                                    class="mc-source-item"
                                >
                                    <div class="mc-source-item__top">
                                        <span class="mc-source-item__name">
                                            {{ source.source }}
                                        </span>

                                        <strong>
                                            {{ source.count }}
                                        </strong>
                                    </div>

                                    <div class="mc-source-bar">
                                        <div
                                            class="mc-source-bar__fill"
                                            :style="{
                                                width:
                                                    sourcePct(source.count) +
                                                    '%',
                                            }"
                                        ></div>
                                    </div>
                                </div>
                            </div>

                            <div v-else class="mc-empty">
                                No registration source data available.
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
    name: "ConferenceDelegates",

    data() {
        return {
            conference_summary: {
                fair_code: null,

                total_registrations: 0,

                total_speakers: 0,

                total_visitor_buyers: 0,

                total_all: 0,

                sex: {
                    male: 0,
                    female: 0,
                },

                categories: {
                    decision_maker: 0,
                    recommending_officer: 0,
                    technical_representative: 0,
                },

                top_countries: [],

                registration_sources: [],
            },

            registrationChart: null,

            sexChart: null,

            categoryChart: null,
        };
    },

    created() {
        this.conferenceSummary();
    },

    methods: {
        /* =========================================================
         * GET CONFERENCE SUMMARY
         * ========================================================= */

        conferenceSummary() {
            axios
                .get("/api/dashboard/conference/summary/fair")
                .then((response) => {
                    if (response.status === 200) {
                        this.conference_summary = response.data;

                        /*
                         * Wait until Vue updates the DOM
                         * before rendering Chart.js.
                         */

                        this.$nextTick(() => {
                            this.renderRegistrationChart();

                            this.renderSexChart();

                            this.renderCategoryChart();
                        });
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        /* =========================================================
         * REGISTRATION PARTICIPANT PIE CHART
         * ========================================================= */

        renderRegistrationChart() {
            const canvas = this.$refs.registrationChart;

            if (!canvas || typeof Chart === "undefined") {
                return;
            }

            if (this.registrationChart) {
                this.registrationChart.destroy();
                this.registrationChart = null;
            }

            const delegates =
                Number(this.conference_summary.total_registrations) || 0;

            const speakers =
                Number(this.conference_summary.total_speakers) || 0;

            const visitorBuyers =
                Number(this.conference_summary.total_visitor_buyers) || 0;

            const total = Number(this.conference_summary.total_all) || 0;

            const centerTextPlugin = {
                id: "registrationCenterText",

                afterDraw(chart) {
                    const { ctx, chartArea } = chart;

                    if (!chartArea) {
                        return;
                    }

                    const centerX = (chartArea.left + chartArea.right) / 2;

                    const centerY = (chartArea.top + chartArea.bottom) / 2;

                    ctx.save();

                    ctx.textAlign = "center";

                    ctx.textBaseline = "middle";

                    ctx.font = "800 30px Arial";

                    ctx.fillStyle = "#241c15";

                    ctx.fillText(total, centerX, centerY - 8);

                    ctx.font = "600 11px Arial";

                    ctx.fillStyle = "#6b655c";

                    ctx.fillText("Overall Total", centerX, centerY + 18);

                    ctx.restore();
                },
            };

            this.registrationChart = new Chart(canvas, {
                type: "doughnut",

                plugins: [centerTextPlugin],

                data: {
                    labels: [
                        "Registered Delegates",
                        "Speakers",
                        "Visitor / Buyers",
                    ],

                    datasets: [
                        {
                            data: [delegates, speakers, visitorBuyers],

                            backgroundColor: ["#9daa39", "#7460ee", "#2255a4"],

                            borderWidth: 0,

                            hoverOffset: 6,
                        },
                    ],
                },

                options: {
                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: "60%",

                    plugins: {
                        legend: {
                            position: "bottom",

                            labels: {
                                padding: 14,

                                usePointStyle: true,

                                pointStyle: "circle",

                                font: {
                                    size: 12,
                                },

                                generateLabels(chart) {
                                    const dataset = chart.data.datasets[0];

                                    const labels = chart.data.labels;

                                    return labels.map((label, index) => {
                                        return {
                                            text:
                                                label +
                                                "  " +
                                                dataset.data[index],

                                            fillStyle:
                                                dataset.backgroundColor[index],

                                            strokeStyle:
                                                dataset.backgroundColor[index],

                                            lineWidth: 0,

                                            hidden: false,

                                            index: index,
                                        };
                                    });
                                },
                            },
                        },

                        tooltip: {
                            callbacks: {
                                label(context) {
                                    return context.label + ": " + context.raw;
                                },
                            },
                        },
                    },
                },
            });
        },

        /* =========================================================
         * SEX DOUGHNUT CHART
         * ========================================================= */

        renderSexChart() {
            const canvas = this.$refs.sexChart;

            if (!canvas || typeof Chart === "undefined") {
                return;
            }

            if (this.sexChart) {
                this.sexChart.destroy();
                this.sexChart = null;
            }

            const male = Number(this.conference_summary.sex.male) || 0;

            const female = Number(this.conference_summary.sex.female) || 0;

            this.sexChart = new Chart(canvas, {
                type: "doughnut",

                data: {
                    labels: ["Male", "Female"],

                    datasets: [
                        {
                            data: [male, female],

                            backgroundColor: ["#2255a4", "#D1264F"],

                            borderWidth: 0,
                            hoverOffset: 6,
                        },
                    ],
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    cutout: "65%",

                    plugins: {
                        legend: {
                            position: "bottom",

                            labels: {
                                padding: 14,
                                usePointStyle: true,
                                pointStyle: "circle",

                                font: {
                                    size: 12,
                                },

                                generateLabels(chart) {
                                    const dataset = chart.data.datasets[0];

                                    const labels = chart.data.labels;

                                    return labels.map((label, index) => {
                                        return {
                                            text:
                                                label +
                                                "  " +
                                                dataset.data[index],

                                            fillStyle:
                                                dataset.backgroundColor[index],

                                            strokeStyle:
                                                dataset.backgroundColor[index],

                                            lineWidth: 0,
                                            hidden: false,
                                            index: index,
                                        };
                                    });
                                },
                            },
                        },

                        tooltip: {
                            callbacks: {
                                label(context) {
                                    return context.label + ": " + context.raw;
                                },
                            },
                        },
                    },
                },
            });
        },

        /* =========================================================
         * DELEGATE CATEGORY BAR CHART
         * ========================================================= */

        renderCategoryChart() {
            const canvas = this.$refs.categoryChart;

            /*
             * Make sure Chart.js CDN is loaded.
             */

            if (!canvas || typeof Chart === "undefined") {
                return;
            }

            /*
             * Destroy existing chart.
             */

            if (this.categoryChart) {
                this.categoryChart.destroy();

                this.categoryChart = null;
            }

            const categories = this.conference_summary.categories;

            this.categoryChart = new Chart(canvas, {
                type: "bar",

                data: {
                    labels: [
                        "Decision-Maker",
                        "Recommending Officer",
                        "Technical Representative",
                    ],

                    datasets: [
                        {
                            label: "Delegates",

                            data: [
                                Number(categories.decision_maker) || 0,

                                Number(categories.recommending_officer) || 0,

                                Number(categories.technical_representative) ||
                                    0,
                            ],

                            backgroundColor: ["#9daa39", "#7460ee", "#2255a4"],

                            borderWidth: 0,

                            borderRadius: 6,

                            barThickness: 32,
                        },
                    ],
                },

                options: {
                    indexAxis: "y",

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {
                        legend: {
                            display: false,
                        },

                        tooltip: {
                            callbacks: {
                                label(context) {
                                    return " Delegates: " + context.raw;
                                },
                            },
                        },
                    },

                    scales: {
                        x: {
                            beginAtZero: true,

                            ticks: {
                                precision: 0,
                            },

                            grid: {
                                color: "#e5e2dc",
                            },
                        },

                        y: {
                            grid: {
                                display: false,
                            },

                            ticks: {
                                font: {
                                    size: 12,
                                },

                                color: "#241c15",
                            },
                        },
                    },
                },
            });
        },

        /* =========================================================
         * REGISTRATION SOURCE PERCENTAGE
         * ========================================================= */

        sourcePct(value) {
            if (!this.conference_summary.registration_sources.length) {
                return 0;
            }

            const max = Math.max(
                ...this.conference_summary.registration_sources.map(
                    (source) => Number(source.count) || 0
                )
            );

            if (!max) {
                return 0;
            }

            return Math.round((Number(value) / max) * 100);
        },
    },

    /* =========================================================
     * CLEANUP CHARTS
     * ========================================================= */

    beforeDestroy() {
        if (this.registrationChart) {
            this.registrationChart.destroy();

            this.registrationChart = null;
        }

        if (this.sexChart) {
            this.sexChart.destroy();

            this.sexChart = null;
        }

        if (this.categoryChart) {
            this.categoryChart.destroy();

            this.categoryChart = null;
        }
    },
};
</script>

<style scoped>
/* =========================================================
   BASE CARD
   ========================================================= */

.mc-card {
    background: #ffffff;

    border: 1px solid #e5e2dc;

    border-radius: 14px;
}

.mc-card--outer {
    overflow: hidden;
}

/* =========================================================
   HEADER
   ========================================================= */

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

/* =========================================================
   BODY / SECTIONS
   ========================================================= */

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

/* =========================================================
   SUMMARY GRID
   ========================================================= */

.mc-summary-grid {
    display: grid;

    grid-template-columns: repeat(4, minmax(0, 1fr));

    gap: 16px;

    margin-bottom: 20px;
}

/* =========================================================
   SUMMARY CARD
   ========================================================= */

.mc-summary-card {
    display: flex;

    align-items: center;

    gap: 14px;

    min-height: 100px;

    padding: 18px;

    border-radius: 14px;

    border: 1px solid #e5e2dc;

    background: #faf8f4;
}

/* =========================================================
   SUMMARY ICON
   ========================================================= */

.mc-summary-card__icon {
    width: 46px;

    height: 46px;

    min-width: 46px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 12px;

    color: #ffffff;

    font-size: 17px;
}

/* =========================================================
   SUMMARY CONTENT
   ========================================================= */

.mc-summary-card__content {
    min-width: 0;
}

.mc-summary-card__number {
    font-size: 28px;

    line-height: 1;

    font-weight: 800;

    color: #241c15;
}

.mc-summary-card__label {
    margin-top: 6px;

    font-size: 12px;

    font-weight: 600;

    color: #6b655c;
}

/* =========================================================
   SUMMARY COLORS
   ========================================================= */

.mc-summary-card--total .mc-summary-card__icon {
    background: #241c15;
}

.mc-summary-card--delegates .mc-summary-card__icon {
    background: #9daa39;
}

.mc-summary-card--speakers .mc-summary-card__icon {
    background: #7460ee;
}

.mc-summary-card--buyers .mc-summary-card__icon {
    background: #2255a4;
}

/* =========================================================
   CHART GRID
   ========================================================= */

.mc-chart-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 20px;
}

/* =========================================================
   CHART CARD
   ========================================================= */

.mc-chart-card {
    background: #faf8f4;

    border: 1px solid #e5e2dc;

    border-radius: 14px;

    padding: 20px;
}

/* =========================================================
   CHART HEADER
   ========================================================= */

.mc-chart-header {
    margin-bottom: 8px;
}

.mc-chart-title {
    font-size: 14px;

    font-weight: 700;

    color: #241c15;
}

.mc-chart-subtitle {
    margin-top: 3px;

    font-size: 12px;

    color: #6b655c;
}

/* =========================================================
   REGISTRATION PIE CHART
   ========================================================= */

.mc-registration-chart {
    position: relative;

    width: 100%;

    height: 300px;
}

/* =========================================================
   SEX CHART
   ========================================================= */

.mc-sex-chart {
    position: relative;

    width: 100%;

    height: 300px;
}

/* =========================================================
   CATEGORY BAR CHART
   ========================================================= */

.mc-category-chart-card {
    background: #faf8f4;

    border: 1px solid #e5e2dc;

    border-radius: 14px;

    padding: 20px;
}

.mc-category-chart {
    position: relative;

    width: 100%;

    height: 280px;
}

/* =========================================================
   TWO COLUMN
   ========================================================= */

.mc-two-column {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;
}

.mc-info-card {
    padding: 20px;
}

.mc-info-card__head {
    margin-bottom: 18px;
}

.mc-info-card__head h6 {
    margin: 0 0 4px;

    font-size: 14px;

    font-weight: 700;

    color: #241c15;
}

.mc-info-card__head span {
    font-size: 12px;

    color: #6b655c;
}

/* =========================================================
   TOP COUNTRIES
   ========================================================= */

.mc-ranking {
    display: flex;

    flex-direction: column;

    gap: 10px;
}

.mc-ranking__item {
    display: flex;

    align-items: center;

    gap: 12px;

    padding: 10px 12px;

    background: #faf8f4;

    border: 1px solid #e5e2dc;

    border-radius: 9px;
}

.mc-ranking__rank {
    width: 26px;

    height: 26px;

    min-width: 26px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #9daa39;

    color: #ffffff;

    border-radius: 50%;

    font-size: 12px;

    font-weight: 700;
}

.mc-ranking__country {
    flex: 1;

    font-size: 13px;

    font-weight: 600;

    color: #241c15;
}

.mc-ranking__count {
    font-size: 14px;

    font-weight: 800;

    color: #241c15;
}

/* =========================================================
   REGISTRATION SOURCE
   ========================================================= */

.mc-source-list {
    display: flex;

    flex-direction: column;

    gap: 14px;
}

.mc-source-item__top {
    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 6px;
}

.mc-source-item__name {
    font-size: 13px;

    color: #6b655c;
}

.mc-source-item__top strong {
    font-size: 13px;

    color: #241c15;
}

.mc-source-bar {
    width: 100%;

    height: 8px;

    overflow: hidden;

    background: #f1efea;

    border-radius: 999px;
}

.mc-source-bar__fill {
    height: 100%;

    background: #7460ee;

    border-radius: 999px;
}

/* =========================================================
   EMPTY
   ========================================================= */

.mc-empty {
    padding: 20px 0;

    text-align: center;

    font-size: 13px;

    color: #9c958b;
}

/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 1100px) {
    .mc-summary-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 991px) {
    .mc-chart-grid {
        grid-template-columns: 1fr;
    }

    .mc-two-column {
        grid-template-columns: 1fr;
    }
}

/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767px) {
    .mc-header {
        padding: 20px;

        gap: 16px;

        flex-direction: column;
    }

    .mc-body {
        padding: 20px;
    }

    .mc-fair-badge {
        align-items: flex-start;
    }

    .mc-summary-grid {
        grid-template-columns: 1fr;

        gap: 12px;
    }

    .mc-summary-card {
        min-height: 90px;
    }

    .mc-summary-card__number {
        font-size: 26px;
    }

    .mc-chart-grid {
        grid-template-columns: 1fr;

        gap: 16px;
    }

    .mc-chart-card {
        padding: 16px;
    }

    .mc-registration-chart {
        height: 280px;
    }

    .mc-sex-chart {
        height: 280px;
    }

    .mc-category-chart-card {
        padding: 16px;
    }

    .mc-category-chart {
        height: 300px;
    }

    .mc-two-column {
        grid-template-columns: 1fr;
    }

    .mc-info-card {
        padding: 18px;
    }
}
</style>
