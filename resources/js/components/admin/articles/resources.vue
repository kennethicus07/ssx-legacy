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
                            <div class="col-md-8">
                                <label for="title" class="form-label">Article Title</label>
                                <input type="text" class="form-control form-control-sm" id="title" v-model="serverParams.columnFilters.title">
                            </div>
                            <div class="col-md-4">
                                <label for="title" class="form-label">Status</label>
                                <select class="form-select form-select-sm" v-model="serverParams.columnFilters.status">
                                    <option value="">-- Select --</option>
                                    <option :value="'published'">Published</option>
                                    <option :value="'draft'">Draft</option>
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
                        <h5 class="card-title">List of on-demand resources articles</h5>
                        <div class="text-end pb-3" v-if="permissions.can_add">
                            <a href="/admin/articles/on-demand-resources/create" class="btn btn-warning btn-sm text-white" role="button">Add new article</a>
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
                                }"
                                :totalRows="totalRecords"
                                :isLoading.sync="isLoading"
                                :columns="columns"
                                :rows="rows"
                                styleClass="vgt-table table table-hover striped">
                                <div slot="emptystate" class="col-12 text-center">
                                    <span class="fw-bold">No record found.</span>
                                </div>
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field === 'title'">
                                        <span v-tooltip="props.row.title">{{ props.row.title | str_limit(70) }}</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'status'">
                                        <span v-if="props.row.status === 1" class="badge bg-success">Published</span>
                                        <span v-else class="badge bg-secondary">Draft</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'created_at'">
                                        {{ props.row.created_at | moment("llll") }}
                                    </span>
                                    <span v-else-if="props.column.field == 'updated_at'">
                                        {{ props.row.updated_at | moment("llll") }}
                                    </span>
                                    <span v-else-if="props.column.field == 'actions'">
                                        <div class="btn-group dropstart">
                                            <button type="button" class="btn btn-outline-warning dropdown-toggle btn-sm" data-bs-display="static" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton1">
                                                <li v-if="permissions.can_view"><a class="dropdown-item" :href="'/admin/articles/on-demand-resources/'+props.row.id" target="_blank"><i class="far fa-eye"></i> Preview</a></li>
                                                <li v-if="permissions.can_edit"><a class="dropdown-item" :href="'/admin/articles/on-demand-resources/'+props.row.id+'/edit'"><i class="far fa-edit"></i> Edit</a></li>
                                                <li v-if="permissions.can_delete"><a class="dropdown-item" role="button" @click="doRemove(props.row.id)"><i class="far fa-trash-alt"></i> Delete</a></li>
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
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import VTooltipPlugin from 'v-tooltip'
import 'v-tooltip/dist/v-tooltip.css'
import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'

Vue.use(VTooltipPlugin)
Vue.use(require('vue-moment'))
Vue.use(VueSweetalert2)
Vue.use(VueToast)

export default {
    data() {
        return {
            columns: [
                {
                    label: 'Title',
                    field: 'title',
                    tooltip: 'A title of the article',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Status',
                    field: 'status',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Date Created',
                    field: 'created_at',
                    tooltip: 'Date created',
                    tdClass: 'align-middle',
                },
                {
                    label: 'Date Updated',
                    field: 'updated_at',
                    tooltip: 'Date last edited',
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
                    status: '',
                    featured: '',
                    carousel: '',
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
    filters: {
        str_limit(value, size) {
            if (!value) return '';
            value = value.toString();
            if (value.length <= size) {
                return value;
            }
            return value.substr(0, size) + '...';
        }
    },
    methods: {
        getLists() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', JSON.stringify(this.serverParams.sort))
            formData.append('filter', JSON.stringify(this.serverParams.columnFilters))
            formData.append('page', this.serverParams.page)
            formData.append('per_page', this.serverParams.perPage)
            axios.post('/admin/articles/on-demand-resources/list', formData)
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
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },
        onPageChange(params) {
            //console.log(params)
            this.updateParams({page: params.currentPage})
            this.getLists();
        },
        onPerPageChange(params) {
            //console.log(params)
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
                featured: '',
                carousel: '',
            }
            this.getLists()
        },
        doRemove(id) {
            this.$swal({
                title: 'Are you sure you want to delete this article/news?',
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
                        axios.delete('/admin/articles/on-demand-resources/'+id)
                        .then(response => {
                            if (response.status === 200) {
                                Vue.$toast.success('Article successfully deleted.', {
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