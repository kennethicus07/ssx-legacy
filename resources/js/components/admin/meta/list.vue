<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Filters</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="title" class="form-label">Page Title</label>
                                <input type="text" class="form-control form-control-sm" id="title" v-model="serverParams.columnFilters.title">
                            </div>
                            <div class="col mt-3 text-end">
                                <a role="button" @click="onColumnFilter" class="btn btn-sm btn-success text-white">Search</a>
                                <a role="button" @click="onResetFilter" class="btn btn-sm btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List of pages meta tags</h5>
                        <div class="table-responsive">
                            <vue-good-table
                                mode="remote"
                                @on-page-change="onPageChange"
                                @on-sort-change="onSortChange"
                                @on-per-page-change="onPerPageChange"
                                :pagination-options="{
                                    enabled: true,
                                    perPageDropdown: [10, 20, 50, 100],
                                    dropdownAllowAll: false,
                                    mode: 'pages'
                                }"
                                :totalRows="totalRecords"
                                :isLoading.sync="isLoading"
                                :columns="columns"
                                :rows="rows"
                                styleClass="vgt-table striped">
                                <div slot="emptystate" class="col-12 text-center">
                                    <span class="fw-bold">No record found.</span>
                                </div>
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'created_at'">
                                        {{ props.row.created_at | moment("llll") }}
                                    </span>
                                    <span v-else-if="props.column.field == 'updated_at'">
                                        {{ props.row.updated_at | moment("llll") }}
                                    </span>
                                    <span v-else-if="props.column.field == 'actions'">
                                        <a v-if="permissions.can_edit" role="button" class="btn btn-warning btn-sm" :href="'/admin/pages-meta-tags/'+props.row.id+'/edit'"><i class="far fa-edit"></i> Edit</a>
                                    </span>
                                    <span v-else>
                                        {{props.formattedRow[props.column.field]}}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { VueGoodTable } from 'vue-good-table'
import VTooltipPlugin from 'v-tooltip'
import 'v-tooltip/dist/v-tooltip.css'
import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'

Vue.use(VTooltipPlugin)
Vue.use(require('vue-moment'))
Vue.use(VueToast)

export default {
    data() {
        return {
            columns: [
                {
                    label: 'Title',
                    field: 'title',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Created',
                    field: 'created_at',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Date Created',
                    field: 'created_at',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Date Updated',
                    field: 'updated_at',
                    tdClass: 'align-middle',
                },
                {
                    label: '',
                    field: 'actions',
                    sortable: false,
                    tdClass: 'align-middle',
                },
            ],
            rows: [],
            permissions: [],
            isLoading: false,
            totalRecords: 0,
            serverParams: {
                columnFilters: {
                    title: '',
                },
                sort: {
                    field: 'created_at',
                    type: 'desc'
                },
                page: 1, 
                perPage: 10
            },
            filter: {
                title: '',
            }
        }
    },
    components: {
        VueGoodTable,
    },
    mounted() {
        
    },
    created() {
        this.getLists()
    },
    methods: {
        getLists() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', JSON.stringify(this.serverParams.sort))
            formData.append('filter', JSON.stringify(this.serverParams.columnFilters))
            formData.append('page', this.serverParams.page)
            formData.append('per_page', this.serverParams.perPage)
            axios.post('/admin/pages-meta-tags/list', formData)
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.rows = response.data.data
                    this.totalRecords = response.data.total
                    this.permissions = response.data.permissions
                    this.isLoading = false
                    this.scrollToTop()
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        eventDateFormat(date1, date2) {
            let date1_day = moment(date1, "DD")
            let date1_month = moment(date1, "MM")
            let date1_month1 = moment(date1, "MMM")
            let date1_year = moment(date1, "YYYY")
            var event_date = ''
            if (date2) {
                let date2_day = moment(date2, "DD")
                let date2_month = moment(date2, "MM")
                let date2_year = moment(date2, "YYYY")
                if (date1_month == date2_month && date1_year == date2_year) {
                    event_date = date1_day+'-'+date2_day+' '+date1_month1+' '+date1_year
                }
            } else {
                event_date = date1_day+' '+date1_month1+' '+date1_year
            }
            return date1_day
        },
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },
        onPageChange(params) {
            this.updateParams({page: params.currentPage})
            this.getLists();
        },
        onPerPageChange(params) {
            this.updateParams({page: 1, perPage: params.currentPerPage})
            this.getLists()
        },
        onSortChange(params) {
            //console.log(params[0].type)
            this.updateParams({
                sort: params[0],
            })
            this.getLists()
        },
        onColumnFilter(params) {
            this.updateParams(params)
            this.getLists()
        },
        onResetFilter() {
            this.serverParams.columnFilters = {
                title : '',
                status: '',
            }
            this.getLists()
        },
        doRemove(id) {
            this.$swal({
                title: 'Are you sure you want to delete this banner?',
                icon: 'question',
                showCancelButton: true,
                customClass: {
                    title: 'fs-5',
                    confirmButton: 'btn btn-sm btn-success text-white m-1',
                    cancelButton: 'btn btn-sm btn-secondary m-1'
                },
                buttonsStyling: false,
                preConfirm: (value) => {
                    if (value) {
                        axios.delete('/admin/carousel-banners/'+id)
                        .then(response => {
                            if (response.status === 200) {
                                Vue.$toast.success('Banner successfully deleted.', {
                                    position: 'top-right',
                                    onDismiss: this.getLists()
                                });
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        });
                    }
                }
            })
        },
        scrollToTop() {
            window.scroll({ top: 300, behavior: 'smooth' })
        }
    }
}
</script>

<style>
table.vgt-table {
    font-size: 14px !important;
}
.vgt-table.bordered td, .vgt-table.bordered th {
    vertical-align: middle;
}
.vgt-wrap__footer .footer__row-count__label {
    font-size: 14px !important;
    font-weight: 600 !important;
}
.vgt-wrap__footer .footer__row-count__select {
    font-size: 14px !important;
    margin-top: -5px !important;
}
.vgt-wrap__footer .footer__row-count::after {
    margin-top: -5px !important;
}
.vgt-wrap__footer .footer__navigation {
    font-size: 14px !important;
}
.vgt-wrap__footer .footer__navigation__page-btn span {
    font-size: 14px !important;
}
</style>