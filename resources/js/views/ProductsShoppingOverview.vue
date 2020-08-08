<template>
    <v-card flat class="mx-6 my-2" color="#121212">
        <v-card-title class="pa-0">
            <category-breadcrumbs :category="category" />
        </v-card-title>
        <v-divider />
        <v-card-text>
            <v-row>
                <v-col md="3">
                    <filters-card v-model="params" />
                </v-col>
                <v-col md="9">
                    <v-row>
                        <v-col sm="3" md="8" lg="9" />
                        <v-col sm="9" md="4" lg="3">
                            <sort-select v-model="params.sort" />
                        </v-col>
                    </v-row>
                    <v-divider />
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import CategoryBreadcrumbs from '../components/productsShoppingOverview/CategoryBreadcrumbs';
import FiltersCard from '../components/productsShoppingOverview/FiltersCard';
import SortSelect from '../components/productsShoppingOverview/SortSelect';

export default {
    name: 'ProductsShoppingOverview',
    components: {
        'category-breadcrumbs': CategoryBreadcrumbs,
        'filters-card': FiltersCard,
        'sort-select': SortSelect
    },
    data() {
        return {
            params: {
                categoryId: null,
                sort: null,
                color: null,
                minPrice: null,
                maxPrice: null,
                search: null
            },
            category: null
        };
    },
    mounted() {
        this.getQueryParams();
        this.getCategory();
    },
    watch: {
        '$route.query': {
            handler() {
                this.getQueryParams();
            },
            deep: true
        },
        params: {
            handler() {
                this.setQueryParams();
            },
            deep: true
        },
        'params.categoryId'() {
            if (this.params.categoryId) {
                this.getCategory();
            } else {
                this.category = null;
            }
        }
    },
    methods: {
        getQueryParams() {
            this.params.categoryId =
                parseInt(this.$route.query.category || '0') || null;
            this.params.sort = this.$route.query.sort || null;
            this.params.color = this.$route.query.color || null;
            this.params.minPrice = this.$route.query.minPrice || null;
            this.params.maxPrice = this.$route.query.maxPrice || null;
            this.params.search = this.$route.query.search || null;
        },
        setQueryParams() {
            this.setQuery({
                category: this.params.categoryId,
                sort: this.params.sort,
                color: this.params.color,
                minPrice: this.params.minPrice,
                maxPrice: this.params.maxPrice,
                search: this.params.search
            });
        },
        getCategory() {
            this.$http
                .get(`/api/categories/${this.params.categoryId}`)
                .then((response) => {
                    this.category = response.data;
                });
        }
    }
};
</script>
