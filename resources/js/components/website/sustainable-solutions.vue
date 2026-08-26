<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section form-header solution-header">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h1>Sustainable Solutions</h1>
                    </center>
                    <p>&nbsp;</p>
                    <div class="d-flex justify-content-center">
                        <vue-instant 
                            :suggestOnAllWords="true" 
                            :suggestion-attribute="suggestionAttribute" 
                            :show-autocomplete="true"
                            :autofocus="false"
                            :suggestions="suggestions"
                            v-model="query" 
                            @input="onInputChange" 
                            @click-input="clickInput" 
                            @click-button="getSuppliers(1)" 
                            @selected="onSelect"  
                            @enter="getSuppliers(1)" 
                            @clear="onClear"  
                            placeholder="Search..." 
                            type="amazon"
                        >
                        </vue-instant>
                    </div>
                </div>
            </div>
        </div>
        <div class="section white-bg ssx-info solution-listing">
            <div class="content">
                <div class="flex">
                    <div class="flex4">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="p-1 fw-bold fs-6">Sort by</div>
                            <div class="p-1">
                                <select class="form-select form-select-sm lightgreen border-0" v-model="sort" @change="doSort">
                                    <option :value="1">A-Z</option>
                                    <option :value="2">Z-A</option>
                                    <option :value="3">Latest</option>
                                    <option :value="4">Oldest</option>
                                </select>
                            </div>
                            <div class="p-1 fw-bold fs-6">Result Per Page:</div>
                            <div class="p-1">
                                <select class="form-select form-select-sm lightgreen border-0" v-model="per_page" @change="getSuppliers(1)">
                                    <option :value="10">10</option>
                                    <option :value="20">20</option>
                                    <option :value="50">50</option>
                                    <option :value="100">100</option>
                                </select>
                            </div>
                        </div>
                        <div class="solutions-holder mt-3">
                            <div class="solution company" v-for="supplier in suppliers" :key="supplier.id">
                                <div class="image">
                                    <a :href="'/solutions/sustainable/'+supplier.id+'/'+supplier.slug">
                                        <img :src="supplier.co_thumb" class="d-block w-100 img-fluid" alt="...">
                                    </a>
                                </div>
                                <div class="desc">
                                    <div class="event-info main">
                                        <div class="image">
                                            <img :src="supplier.co_logo" alt="...">
                                        </div>
                                        <div class="desc">
                                            <a :href="'/solutions/sustainable/'+supplier.id+'/'+supplier.slug">{{ supplier.co_name }}</a>
                                        </div>
                                    </div>
                                    <p>{{ supplier.co_details }} <a :href="'/solutions/sustainable/'+supplier.id+'/'+supplier.slug">Learn more</a></p>
                                    <p class="tags" v-if="supplier.tags.length >= 1">
                                        <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in supplier.tags" :key="tag.id" :title="tag.sub_category_remarks">{{ tag.sub_category_remarks | str_limit(30) }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center w-100" v-if="total_rec <= 0">
                                <h4>No supplier found.</h4>
                            </div>    
                            <div class="d-flex justify-content-end w-100 black pt-3" v-if="total_rec > Number(per_page)">
                                <div class="row">
                                    <pagination :records="total_rec" v-model="page" :per-page="Number(per_page)" @paginate="getSuppliers(page)" :options="pagination_options"></pagination>
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
import BlockUI from 'vue-blockui'
import Pagination from 'vue-pagination-2'
import 'vue-instant/dist/vue-instant.css'
import VueInstant from 'vue-instant/dist/vue-instant.common'

Vue.use(VueInstant)
Vue.use(BlockUI)

export default {
    data() {
        return {
            isLoading: false,
            msg: 'Loading...',
            query: '',
            sort: 1,
            page: 1,
            per_page: 10,
            total_rec: 0,
            suppliers: [],
            suggestionAttribute: 'name',
            suggestions: [],
            pagination_options: {
                edgeNavigation: true,
                texts: {
                    first: 'First'
                }
            }
        }
    },
    components: {
        Pagination
    },
    created() {
        this.getSuppliers(this.page)
    },
    filters: {
        str_limit: function (value, size) {
            if (!value) return ''
            value = value.toString()

            if (value.length <= size) {
                return value;
            }
            return value.substr(0, size) + '...';
        }
    },
    methods: {
        getSuppliers(page) {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(page))
            formData.append('per_page', Number(this.per_page))
            formData.append('qry', this.query)
            axios.post('/solutions/sustainable/list', formData)
            .then(response => {
                //console.log(response.data);
                if (response.status === 200) {
                    this.suppliers = response.data.results
                    this.total_rec = response.data.total_rec
                    this.isLoading = false
                    this.msg = 'Loading...'
                    this.scrollToTop()
                }
            }).catch(err => {
                console.log(err)
            })
        },
        onInputChange(text) {
            this.suggestions = []
            axios.get('/solutions/sustainable/search/'+text)
            .then(response => {
                //console.log(response.data);
                if (response.status === 200) {
                    for (var i = 0; i < response.data.length; i++){
                        this.suggestions.push(response.data[i])
                    } 
                }
            }).catch(err => {
                console.log(err)
            })
        },
        onSelect(val) {
            console.log(val.id)
        },
        clickInput() {
            console.log('click input')
        },
        clickButton() {
            console.log('click button')
        },
        enter() {
            console.log('ENTER')
        },
        onClear() {
            this.msg = 'Resetting...'
            this.query = ''
            this.getSuppliers(1)
        },
        doReset() {
            this.msg = 'Resetting...'
            this.categories_selected = []
            this.query = ''
            this.getSuppliers(1)
        },
        doSort() {
            this.msg = 'Sorting...'
            this.isLoading = true
            this.suppliers = []
            this.page = 1
            this.getSuppliers(1)
        },
        scrollToTop() {
            window.scroll({ top: 150, behavior: 'smooth' });
        },
    }
}
</script>
<style>
.vue-instant__suggestions li.highlighted__amazon {
    background-color: #9daa39;
}
.vue-instant__suggestions {
    top: 100%;
    text-align: left;
}
@media only screen and (min-width : 320px) {
    .sbx-amazon {
        width: 300px;
    }
}
@media only screen and (min-width : 768px) {
    .sbx-amazon {
        width: 500px;
    }
}
</style>