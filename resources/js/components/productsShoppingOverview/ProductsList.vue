<template>
    <div>
        <v-row v-if="isLoading">
            <v-progress-circular class="mx-auto" indeterminate />
        </v-row>
        <v-row>
            <v-col
                v-for="product in products"
                :key="product.id"
                :lg="fullWidth ? 3 : 4"
                :md="fullWidth ? 4 : 6"
                :sm="fullWidth ? 6 : 12"
                cols="12"
            >
                <product-card :product="product" />
            </v-col>
        </v-row>
    </div>
</template>

<script>
import ProductCard from './ProductCard';
import { debounce } from 'lodash';

export default {
    name: 'ProductsList',
    components: {
        'product-card': ProductCard
    },
    props: {
        pagination: {
            type: Object,
            required: true,
            default: () => ({
                page: 1,
                length: 1,
                limit: null
            })
        },
        params: {
            type: Object,
            required: false,
            default: () => ({
                categoryId: null,
                sort: null,
                color: null,
                minPrice: null,
                maxPrice: null,
                search: null
            })
        },
        fullWidth: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    data() {
        return {
            products: [],
            isLoading: false
        };
    },
    watch: {
        pagination: {
            handler() {
                this.getProducts();
            },
            deep: true
        },
        'params.categoryId'() {
            this.getProducts();
        },
        'params.sort'() {
            this.getProducts();
        },
        'params.color'() {
            this.getProducts();
        },
        'params.search'() {
            this.isLoading = true;
            this.debounceGetProducts();
        },
        'params.maxPrice'() {
            this.isLoading = true;
            this.debounceGetProducts();
        },
        'params.minPrice'(value, oldValue) {
            if (!!value && !!oldValue) {
                this.isLoading = true;
                this.debounceGetProducts();
            }
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        debounceGetProducts: debounce(function () {
            this.getProducts();
        }, 2000),
        getProducts() {
            this.isLoading = true;
            this.$http
                .get('/api/products', {
                    params: { ...this.pagination, ...this.params }
                })
                .then((response) => {
                    this.products = response.data.data;
                    this.$emit('loaded-total-pages', response.data.last_page);
                })
                .catch(this.handleServerError)
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped></style>
