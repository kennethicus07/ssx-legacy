<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section form-header">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h3>{{ totalResults }} search result/s for keyword <span class="darkgreen">'{{ qry }}'</span></h3>
                    </center>
                    <div class="d-flex justify-content-center">
                        <vue-instant 
                            :suggestOnAllWords="false" 
                            :suggestion-attribute="suggestionAttribute" 
                            :show-autocomplete="false"
                            :autofocus="false"
                            :suggestions="suggestions"
                            v-model="query" 
                            @click-input="clickInput" 
                            @click-button="getSearch" 
                            @enter="getSearch" 
                            @clear="onClear"  
                            placeholder="Search..." 
                            type="amazon"
                        >
                        </vue-instant>
                    </div>
                </div>
            </div>
        </div>
        <div class="section white-bg ssx-info solution-listing company-info">
            <div class="content">
                <div class="flex">
                    <div class="flex1">
                        <div class="list-header">
                            <h4 class="ico-holder filter">Filter</h4>
                        </div>
                        <div class="select-holder">
                            <div class="select-options">
                                <h4>ZONE</h4>
                                <div v-for="category in categories" :key="category.id">
                                    <h5 class="lightgreen">{{ category.name }}</h5>
                                    <ul class="sub-options">
                                        <li v-for="subcategory in category.sub_categories" :key="subcategory.id">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="'prod_sub_categories_'+subcategory.id" :value="subcategory.id" v-model="categories_selected">
                                                <label class="form-check-label align-middle" :for="'prod_sub_categories_'+subcategory.id">{{ subcategory.name }}</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>    
                                <div class="btn-holder link-border flex">
                                    <button class="btn btn-sm black_btn" @click="doSort">APPLY</button>
                                    <button class="btn btn-sm clear_btn" @click="doReset">RESET</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        </div>
                        <div class="solutions-holder">
                            <div class="content">
                                <ul class="nav nav-pills nav-fill">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="true" @click="getSearchProductsResults">Products and Solutions</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="suppliers-tab" data-bs-toggle="tab" data-bs-target="#suppliers" type="button" role="tab" aria-controls="suppliers" aria-selected="false" @click="getSearchSuppliersResults">Suppliers</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-controls="articles" aria-selected="false" @click="getSearchArticlesResults">Articles</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="events" aria-selected="false" @click="getSearchEventsResults">Events & Activities</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
                                        <div class="solutions-holder mt-3">
                                            <div class="solution product" v-for="product in products.results" :key="product.id">
                                                <div class="image">
                                                    <a :href="product.url" class="d-block w-100"><img :src="product.thumb" class="d-block w-100" alt="..."></a>
                                                </div>
                                                <div class="desc">
                                                    <h3><a :href="product.url">{{ product.title }}</a></h3>
                                                    <p>
                                                        {{ product.details | str_limit(60) }} <a :href="product.url">Learn more</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center w-100" v-if="products.total_rec <= 0">
                                            <h4>No product & solution found.</h4>
                                        </div>    
                                        <div class="d-flex justify-content-end w-100 black pt-3" v-if="products.total_rec > Number(per_page)">
                                            <div class="row">
                                                <pagination :records="products.total_rec" v-model="products.page" :per-page="Number(per_page)" @paginate="getSearchProductsResults(products.page)" :options="pagination_options"></pagination>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="suppliers" role="tabpanel" aria-labelledby="suppliers-tab">
                                        <div class="solutions-holder mt-3">
                                            <div class="h-100 border-0" v-for="supplier in suppliers.results" :key="supplier.id">
                                                <div class="row g-0">
                                                    <div class="col-md-4">
                                                        <a :href="'/solutions/marketplace/'+supplier.id+'/'+supplier.slug">
                                                            <img :src="supplier.thumb" class="img-fluid w-100 h-100" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body">
                                                            <div class="event-info main">
                                                                <div class="image">
                                                                    <img :src="supplier.logo" class="img-fluid" alt="...">
                                                                </div>
                                                                <div class="desc border-0">
                                                                    <a :href="'/solutions/marketplace/'+supplier.id+'/'+supplier.slug" class="fw-bold text-decoration-none text-dark">{{ supplier.title }}</a>
                                                                </div>
                                                            </div>
                                                            <p>{{ supplier.details | str_limit(90) }} <a :href="'/solutions/marketplace/'+supplier.id+'/'+supplier.slug">Learn more</a></p>
                                                            <p class="tags" v-if="supplier.tags.length >= 1">
                                                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1" v-for="tag in supplier.tags" :key="tag.id" :title="tag.sub_category_remarks">{{ tag.sub_category_remarks | str_limit(30) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center w-100" v-if="suppliers.total_rec <= 0">
                                                <h4>No supplier found.</h4>
                                            </div>    
                                            <div class="d-flex justify-content-end w-100 black pt-3" v-if="suppliers.total_rec > Number(per_page)">
                                                <div class="row">
                                                    <pagination :records="suppliers.total_rec" v-model="suppliers.page" :per-page="Number(per_page)" @paginate="getSearchSuppliersResults(suppliers.page)" :options="pagination_options"></pagination>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                                        <div class="solutions-holder row mt-3 p-3">
                                            <div class="col-6 pb-3" v-for="article in articles.results" :key="article.id">
                                                <div class="solution product w-100 h-100">
                                                    <div class="image">
                                                        <a :href="article.url" class="d-block w-100"><img :src="article.thumb" class="d-block w-100" alt="..."></a>
                                                    </div>
                                                    <div class="desc">
                                                        <h3><a :href="article.url">{{ article.title }}</a></h3>
                                                        <p v-html="article.details"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center w-100" v-if="articles.total_rec <= 0">
                                            <h4>No news article found.</h4>
                                        </div>    
                                        <div class="d-flex justify-content-end w-100 black pt-3" v-if="articles.total_rec > Number(per_page)">
                                            <div class="row">
                                                <pagination :records="articles.total_rec" v-model="articles.page" :per-page="Number(per_page)" @paginate="getSearchArticlesResults(articles.page)" :options="pagination_options"></pagination>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab">
                                        <div class="content">
                                            <div class="row pt-3">
                                                <div class="col-6 pb-3" v-for="event in events.results" :key="event.id">
                                                    <div class="card h-100 maroon-bg">
                                                        <img :src="event.thumb" class="owl-lazy card-img-top" alt="...">
                                                        <div class="card-body">
                                                            <a :href="event.link" target="_blank" class="lightgreen-link2">
                                                                <p class="fw-bold lh-base fs-6">{{ event.title }}</p>
                                                            </a>
                                                            <p class="loc" v-if="event.type == 'digital'"><i class="fas fa-map-marker-alt"></i> {{ event.platform }}</p>
                                                            <p class="loc" v-else><i class="fas fa-map-marker-alt"></i> {{ event.location }}</p>
                                                            <div class="d-flex align-items-center mt-2">
                                                                <div class="event-org-logo flex-shrink-0">
                                                                    <img :src="event.logo" alt="...">
                                                                </div>
                                                                <div class="flex-grow-1 ms-2 white fs-12">
                                                                    Organized By<br/><strong>{{ event.organizer }}</strong>
                                                                </div>
                                                            </div>
                                                            <a :href="event.link" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center w-100" v-if="events.total_rec <= 0">
                                            <h4>No event & activities found.</h4>
                                        </div>    
                                        <div class="d-flex justify-content-end w-100 black pt-3" v-if="events.total_rec > Number(per_page)">
                                            <div class="row">
                                                <pagination :records="events.total_rec" v-model="events.page" :per-page="Number(per_page)" @paginate="getSearchEventsResults(events.page)" :options="pagination_options"></pagination>
                                            </div>
                                        </div>
                                    </div>
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
    props: ['qry'],
    data() {
        return {
            isLoading: false,
            msg: 'Loading...',
            query: '',
            sort: 1,
            per_page: 12,
            categories: [],
            suggestionAttribute: '',
            suggestions: [],
            categories: [],
            categories_selected: [],
            products: {
                results: [],
                page: 1,
                total_rec: 0,
            },
            suppliers: {
                results: [],
                page: 1,
                total_rec: 0,
            },
            articles: {
                results: [],
                page: 1,
                total_rec: 0,
            },
            events: {
                results: [],
                page: 1,
                total_rec: 0,
            },
            pagination_options: {
                edgeNavigation: true,
                texts: {
                    first: 'First'
                }
            }
        }
    },
    components: {
        Pagination,
    },
    created() {
        this.query = this.qry
        this.getCategories()
        this.getSearchProductsResults()
        this.getSearchSuppliersResults()
        this.getSearchArticlesResults()
        this.getSearchEventsResults()
    },
    computed: {
        totalResults() {
            let total = parseInt(this.products.total_rec) + parseInt(this.suppliers.total_rec) + parseInt(this.articles.total_rec) + parseInt(this.events.total_rec)
            return total
        }
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
        getCategories() {
            axios.get('/api/categories')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.categories = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getSearch() {
            let txt = this.query
            let s = txt.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&#34;')
            let uri = "/search/"+s;
            window.location.href = uri;
        },
        getSearchProductsResults() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(this.products.page))
            formData.append('per_page', Number(this.per_page))
            formData.append('module', 'products')
            formData.append('qry', this.query)
            formData.append('categories', JSON.stringify(this.categories_selected))
            axios.post('/api/sitewide/search', formData)
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.products.results = response.data.results
                    this.products.total_rec = response.data.total_rec
                    this.isLoading = false
                    this.scrollToTop()
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getSearchSuppliersResults() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(this.suppliers.page))
            formData.append('per_page', Number(this.per_page))
            formData.append('module', 'suppliers')
            formData.append('qry', this.query)
            formData.append('categories', JSON.stringify(this.categories_selected))
            axios.post('/api/sitewide/search', formData)
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.suppliers.results = response.data.results
                    this.suppliers.total_rec = response.data.total_rec
                    this.isLoading = false
                    this.scrollToTop()
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getSearchArticlesResults() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(this.articles.page))
            formData.append('per_page', Number(this.per_page))
            formData.append('module', 'articles')
            formData.append('qry', this.query)
            formData.append('categories', JSON.stringify(this.categories_selected))
            axios.post('/api/sitewide/search', formData)
            .then(response => {
                console.log(response.data)
                if (response.status === 200) {
                    this.articles.results = response.data.results
                    this.articles.total_rec = response.data.total_rec
                    this.isLoading = false
                    this.scrollToTop()
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getSearchEventsResults() {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(this.events.page))
            formData.append('per_page', Number(this.per_page))
            formData.append('module', 'events')
            formData.append('qry', this.query)
            formData.append('categories', JSON.stringify(this.categories_selected))
            axios.post('/api/sitewide/search', formData)
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.events.results = response.data.results
                    this.events.total_rec = response.data.total_rec
                    this.isLoading = false
                    this.scrollToTop()
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        onInputChange(text) {
           
        },
        clickInput() {
            console.log('click input')
        },
        onClear() {
            this.isLoading = true
            this.query = ''
        },
        doReset() {
            this.isLoading = true
            this.categories_selected = []
            this.getSearchProductsResults()
            this.getSearchSuppliersResults()
            this.getSearchArticlesResults()
            this.getSearchEventsResults()
            this.scrollToTop()
        },
        doSort() {
            this.isLoading = true
            this.products.page = 1
            this.suppliers.page = 1
            this.articles.page = 1
            this.events.page = 1
            this.getSearchProductsResults()
            this.getSearchSuppliersResults()
            this.getSearchArticlesResults()
            this.getSearchEventsResults()
            this.scrollToTop()
        },
        scrollToTop() {
            window.scroll({ top: 0, behavior: 'smooth' });
        },
    }
}
</script>