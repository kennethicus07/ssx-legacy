<template>
    <div class="section ssx-info resource-holder" id="on-demand-resources" v-show="articles.length > 0 ">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="content">
            <center>
                <h2>Browse On-Demand Resources</h2>
            </center>
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
            <div class="row row-cols-1 row-cols-md-4 g-4 mt-1">
                <div class="col" v-for="article in articles" :key="article.id">
                    <div class="card h-100">
                        <img :src="article.thumb" class="card-img-top" alt="..."> 
                        <div class="card-body">
                            <a role="button" class="lightgreen-link" @click="doRedirect(article.url)">
                                <p class="fw-bold lh-base fs-6">{{ article.title }}</p>
                            </a>
                            <p class="card-text" v-html="article.sub_title"></p>
                            <p class="tags" v-if="article.tags.length >= 1">
                                <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1" v-for="tag in article.tags" :key="tag.id">{{ tag.sub_category_remarks }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center flex-column mt-4 black" v-if="!isFinished">
                <div>
                    <a role="button" class="text-decoration-none text-uppercase fs-5 lightgreen-link" @click="doLoadMore">
                        {{ buttonText }}<br/><div class="text-center"><i class="fas fa-angle-down fs-2"></i></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import BlockUI from 'vue-blockui'

    Vue.use(BlockUI)

    export default {
        data() {
            return {
                isLoading: false,
                isAuth: false,
                msg: 'Loading...',
                isFinished: false,
                buttonText: 'Load more',
                sort: 1,
                page: 1,
                per_page: 8,
                articles: [],
            }
        },
        created() {
            this.getOnDemandResources()
        },
        methods: {
            getOnDemandResources() {
                this.isLoading = true
                let formData = new FormData()
                formData.append('sort', this.sort)
                formData.append('page', Number(this.page))
                formData.append('per_page', Number(this.per_page))
                axios.post('/on-demand-resources/list', formData)
                .then(response => {
                    //console.log(response.data);
                    if (response.data.results != '') {
                        this.isAuth = response.data.auth
                        var len = this.articles.length;
                        if (len > 0) {
                            for (var i = 0; i < response.data.results.length; i++){
                                this.articles.push(response.data.results[i])
                            } 
                            this.buttonText = "Load More"
                        } else {
                            this.articles = response.data.results
                        }
                        this.isLoading = false
                    } else {
                        this.isFinished = true
                        this.isLoading = false
                    }
                }).catch(err => {
                    console.log(err)
                })
            },
            doLoadMore() {
                this.page++
                this.buttonText = "Loading..."
                this.getOnDemandResources()
            },
            doSort() {
                this.isLoading = true
                this.articles = []
                this.page = 1
                this.getOnDemandResources()
            },
            doRedirect(url) {
                var loginModal = new bootstrap.Modal(document.getElementById('popup-login'), {
                    backdrop: 'static'
                });
                if (!this.isAuth) {
                    loginModal.show()
                } else {
                    window.location.href = url
                }
            }
        }
    }
</script>