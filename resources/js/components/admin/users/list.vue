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
                            <div class="col-4">
                                <label for="name" class="form-label">User Name</label>
                                <input type="text" class="form-control form-control-sm" id="name" v-model="serverParams.columnFilters.name">
                            </div>
                            <div class="col-4">
                                <label for="name" class="form-label">User E-mail Address</label>
                                <input type="email" class="form-control form-control-sm" id="email" v-model="serverParams.columnFilters.email">
                            </div>
                            <div class="col-4">
                                <label for="name" class="form-label">Status</label>
                                <select class="form-select form-select-sm" v-model="serverParams.columnFilters.status">
                                    <option value="">-- Select --</option>
                                    <option :value="'active'">Active</option>
                                    <option :value="'suspended'">Suspended</option>
                                </select>
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
                        <h5 class="card-title">List of user accounts</h5>
                        <div class="text-end pb-3">
                            <a href="/admin/user-accounts/create" class="btn btn-warning btn-sm text-white" role="button">Add new user</a>
                        </div>
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
                                    <span v-if="props.column.field == 'name'">
                                        {{ props.row.name }}
                                        <span v-if="props.row.user_group === 1" class="badge rounded-pill bg-danger">Super Admin</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'status'">
                                        <span v-if="props.row.status === 1" class="badge bg-success align-middle">Active</span>
                                        <span v-else class="badge bg-danger align-middle">Suspended</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'updated_at'">
                                        {{ props.row.updated_at | moment("llll") }}
                                    </span>
                                    <span v-else-if="props.column.field == 'actions'">
                                        <div class="btn-group dropstart" v-show="props.row.user_group != 1">
                                            <button type="button" class="btn btn-outline-warning dropdown-toggle btn-sm" data-bs-display="static" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                            <ul class="dropdown-menu dropdown-menu-dark">
                                                <li v-if="props.row.status === 1"><a class="dropdown-item" role="button" @click="doSuspend(props.row.id)"><i class="fas fa-user-times"></i> Suspend</a></li>
                                                <li v-else><a class="dropdown-item" role="button" @click="doActivate(props.row.id)"><i class="far fa-user-circle"></i> Activate</a></li>
                                                <li><a class="dropdown-item" role="button" @click="doRemove(props.row.id)"><i class="far fa-trash-alt"></i> Delete</a></li>
                                                <li v-if="props.row.status === 1"><a class="dropdown-item" :href="'/admin/user-accounts/'+props.row.id+'/edit'"><i class="fas fa-universal-access"></i> Permission</a></li>
                                            </ul>
                                        </div>
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
                    label: 'Name',
                    field: 'name',
                    tdClass: 'align-middle',
                },
                {
                    label: 'E-mail',
                    field: 'email',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Status',
                    field: 'status',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Date Last Update',
                    field: 'updated_at',
                    tdClass: 'align-middle',
                },
                {
                    label: '',
                    field: 'actions',
                    sortable: false,
                },
            ],
            rows: [],
            isLoading: false,
            totalRecords: 0,
            serverParams: {
                columnFilters: {
                    name: '',
                    email: '',
                    status: '',
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
                status: '',
                happening: '',
                type: '',
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
            axios.post('/admin/user-accounts/list', formData)
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.rows = response.data.data
                    this.totalRecords = response.data.total
                    this.isLoading = false
                    this.scrollToTop()
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },
        onPageChange(params) {
            console.log(params)
            this.updateParams({page: params.currentPage})
            this.getLists();
        },
        onPerPageChange(params) {
            console.log(params)
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
                title: 'Are you sure you want to delete this user account?',
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
                        axios.delete('/admin/user-accounts/'+id)
                        .then(response => {
                            if (response.status === 200) {
                                Vue.$toast.success('User account successfully deleted.', {
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
        doSuspend(id) {
            this.$swal({
                title: 'Are you sure you want to suspend this user account?',
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
                        axios.get('/admin/user-accounts/suspend/'+id)
                        .then(response => {
                            if (response.status === 200) {
                                Vue.$toast.success('User account successfully suspended.', {
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
        doActivate(id) {
            this.$swal({
                title: 'Are you sure you want to activate this user account?',
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
                        axios.get('/admin/user-accounts/activate/'+id)
                        .then(response => {
                            if (response.status === 200) {
                                Vue.$toast.success('User account successfully activated.', {
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