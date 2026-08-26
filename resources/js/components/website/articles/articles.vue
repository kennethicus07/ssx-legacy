<template>
    <div class="section ssx-info resource-holder">
        <BlockUI :message="msg" v-show="isLoading">
            <div class="fa-3x">
                <i class="fas fa-spinner fa-spin lightgreen"></i>
            </div>
        </BlockUI>
        <div class="content">
            <h2>More news & articles</h2>
            <div class="row row-cols-1 row-cols-md-4 g-3 mt-3">
                <div class="col" v-for="article in articles" :key="article.id">
                    <div class="card h-100">
                        <img
                            :src="'/storage/articles/thumbs/' + article.thumb"
                            class="card-img-top"
                            alt="..."
                        />
                        <div class="card-body">
                            <a :href="article.url" class="lightgreen-link">
                                <p class="fw-bold lh-base fs-6">
                                    {{ article.title }}
                                </p>
                            </a>
                            <p class="card-text" v-html="article.sub_title"></p>
                            <p class="tags" v-if="article.tags.length >= 1">
                                <span
                                    class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1"
                                    v-for="tag in article.tags"
                                    :key="tag.id"
                                    >{{
                                        truncateTag(tag.sub_category_remarks)
                                    }}</span
                                >
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="d-flex justify-content-center w-100"
                    v-if="total_rec <= 0"
                >
                    <h4>No news & article found.</h4>
                </div>
                <div
                    class="d-flex justify-content-end w-100 black pt-3"
                    v-show="total_rec > Number(per_page)"
                >
                    <div class="row">
                        <pagination
                            :records="total_rec"
                            v-model="page"
                            :per-page="Number(per_page)"
                            @paginate="getArticles(page)"
                            :options="pagination_options"
                        ></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Pagination from "vue-pagination-2";
import BlockUI from "vue-blockui";

Vue.use(BlockUI);

export default {
    data() {
        return {
            isLoading: false,
            msg: "Loading...",
            page: 1,
            per_page: 12,
            total_rec: 0,
            articles: [],
            pagination_options: {
                edgeNavigation: true,
                texts: {
                    first: "First",
                },
            },
        };
    },
    components: {
        Pagination,
    },
    created() {
        this.getArticles(this.page);
    },
    methods: {
        getArticles(page) {
            this.isLoading = true;
            let formData = new FormData();
            formData.append("page", page);
            formData.append("per_page", Number(this.per_page));
            axios
                .post("/news-articles/more", formData)
                .then((response) => {
                    //console.log(response.data);
                    if (response.status === 200) {
                        this.isLoading = false;
                        this.articles = response.data.results;
                        this.total_rec = response.data.total_rec;
                    }
                    this.scrollToTop();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        scrollToTop() {
            window.scroll({ top: 150, behavior: "smooth" });
        },
        truncateTag(text, limit = 30) {
            if (!text) return "";
            return text.length > limit
                ? text.substring(0, limit) + "..."
                : text;
        },
    },
};
</script>
