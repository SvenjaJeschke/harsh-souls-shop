<template>
    <div>
        <v-row v-if="isLoading">
            <v-progress-circular class="mx-auto" indeterminate />
        </v-row>
        <v-row>
            <v-col
                v-for="product in products"
                :key="product.id"
                lg="4"
                md="6"
                sm="12"
                cols="6"
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
                length: 1
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
