<template>
    <div>
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="section form-header solution-header intelligence">
            <div class="content">
                <div class="header-desc">
                    <center>
                        <h1>Solutions Intelligence</h1>
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
                            @click-button="getArticles(1)" 
                            @selected="onSelect"  
                            @enter="getArticles(1)" 
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
                                <h4>TYPE</h4>
                                <ul class="type-options">
                                    <li v-for="type in article_types" :key="type.id">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :value="type.id" v-model="article_type_selected" :id="'article_type_'+type.id">
                                            <label class="form-check-label align-middle" :for="'article_type_'+type.id">{{ type.name }}</label>
                                        </div>
                                    </li>
                                </ul>
                                <div class="btn-holder link-border flex">
                                    <button class="btn btn-sm black_btn" @click="getArticles(1)">APPLY</button>
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
                            <div class="solution product" v-for="article in articles" :key="article.id">
                                <div class="image">
                                    <img :src="article.thumb" class="d-block w-100" alt="...">
                                </div>
                                <div class="desc">
                                    <h3><a :href="article.url">{{ article.title }}</a></h3>
                                    <p v-html="article.sub_title"></p>
                                    <p class="tags" v-if="article.tags.length >= 1">
                                        <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1" v-for="tag in article.tags" :key="tag.id">{{ tag.sub_category_remarks }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center w-100" v-if="total_rec <= 0">
                                <h4>No solutions intelligence found.</h4>
                            </div>    
                            <div class="d-flex justify-content-end w-100 black pt-3" v-if="total_rec > Number(per_page)">
                                <div class="row">
                                    <pagination :records="total_rec" v-model="page" :per-page="Number(per_page)" @paginate="getArticles(page)" :options="pagination_options"></pagination>
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
            per_page: 8,
            total_rec: 0,
            articles: [],
            suggestionAttribute: 'title',
            suggestions: [],
            categories: [],
            categories_selected: [],
            article_types: [],
            article_type_selected: [],
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
        this.getArticles(this.page)
        this.getCategories()
        this.getArticleTypes()
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
        getArticleTypes() {
            axios.get('/api/article_types')
            .then(response => {
                //console.log(response.data)
                if (response.status === 200) {
                    this.article_types = response.data
                }
            })
            .catch(error => {
                console.log(error);
            });
        },
        getArticles(page) {
            this.isLoading = true
            let formData = new FormData()
            formData.append('sort', this.sort)
            formData.append('page', Number(page))
            formData.append('per_page', Number(this.per_page))
            formData.append('qry', this.query)
            formData.append('categories', JSON.stringify(this.categories_selected))
            formData.append('article_types', JSON.stringify(this.article_type_selected))
            axios.post('/solutions/intelligence/list', formData)
            .then(response => {
                //console.log(response.data);
                if (response.status === 200) {
                    this.articles = response.data.results
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
            axios.get('/solutions/intelligence/search/'+text)
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
            this.getArticles(1)
        },
        doReset() {
            this.msg = 'Resetting...'
            this.categories_selected = []
            this.article_type_selected = []
            this.getArticles(1)
        },
        doSort() {
            this.msg = 'Sorting...'
            this.isLoading = true
            this.articles = []
            this.page = 1
            this.getArticles(1)
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