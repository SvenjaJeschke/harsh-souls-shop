<template>
    <v-card flat class="mx-6 my-2">
        <v-card-title>

        </v-card-title>
        <v-divider />
        <v-card-text>

        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'ProductsShoppingOverview',
    data() {
        return {
            sortTypes: [
                'newest products',
                'price descending',
                'price ascending'
            ],
            params: {
                categoryId: null,
                sort: null,
                color: null,
                minPrice: null,
                maxPrice: null,
                search: null
            },
            category: {}
        };
    },
    mounted() {
        this.params.sort = this.sortTypes[0];
        this.getQueryParams();
    },
    watch: {
        '$route.query': {
            handler: this.getQueryParams,
            deep: true
        },
        params: {
            handler: this.setQueryParams,
            deep: true
        },
        'params.categoryId'() {}
    },
    computed: {
        categoryIdIsValid() {
            return (
                !!this.params.categoryId &&
                typeof this.params.categoryId === 'number' &&
                this.params.categoryId > 0
            );
        },
        sortIsValid() {
            return (
                !!this.params.sort &&
                typeof this.params.sort === 'string' &&
                this.sortTypes.includes(this.sortTypes)
            );
        },
        colorIsValid() {
            return (
                !!this.params.color &&
                typeof this.params.color === 'string' &&
                this.isColor(this.params.color)
            );
        },
        minPriceIsValid() {
            return (
                !!this.params.minPrice &&
                typeof this.params.minPrice === 'number' &&
                this.params.minPrice >= 0 &&
                this.params.minPrice <= this.params.maxPrice
            );
        },
        maxPriceIsValid() {
            return (
                !!this.params.maxPrice &&
                typeof this.params.maxPrice === 'number' &&
                this.params.maxPrice >= 0 &&
                this.params.minPrice <= this.params.maxPrice
            );
        },
        searchIsValid() {
            return (
                !!this.params.search &&
                typeof this.params.search === 'string' &&
                this.params.search.length >= 3
            );
        }
    },
    methods: {
        getQueryParams() {
            this.params.categoryId =
                parseInt(this.$route.query.category || '0') || null;
            this.params.color = this.$route.query.color || null;
            this.params.minPrice = this.$route.query.minPrice || null;
            this.params.maxPrice = this.$route.query.maxPrice || null;
            this.params.search = this.$route.query.search || null;
        },
        setQueryParams() {
            this.$route.query.category = this.params.categoryId;
            this.$route.query.color = this.params.color;
            this.$route.query.minPrice = this.params.minPrice;
            this.$route.query.maxPrice = this.params.maxPrice;
            this.$route.query.search = this.params.search;
        },
        getCategory() {}
    }
};
</script>
