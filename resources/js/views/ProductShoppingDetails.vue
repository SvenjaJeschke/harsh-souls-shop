<template>
    <v-card v-if="!isLoading" flat class="mx-6 my-2" color="transparent">
        <v-card-text class="pa-0">
            <v-row
                v-for="category in subCategories.length
                    ? subCategories
                    : mainCategories"
                :key="category.id"
            >
                <category-breadcrumbs :category="category" :product="product" />
            </v-row>
        </v-card-text>
        <v-divider />
        <v-card-text class="px-16">
            <v-row>
                <v-col md="4" sm="6" cols="12">
                    <v-card>
                        <v-carousel v-model="activeImage" hide-delimiters>
                            <v-carousel-item
                                v-for="image in images"
                                :key="image.id"
                            >
                                <v-img :src="image.storage_url" />
                            </v-carousel-item>
                        </v-carousel>
                    </v-card>
                    <v-row>
                        <v-col
                            cols="4"
                            v-for="(image, index) in images"
                            :key="index"
                        >
                            <v-card
                                @click="activeImage = index"
                                :color="activeImageClass(index)"
                            >
                                <v-img :src="image.storage_url" />
                            </v-card>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col md="8" sm="6" cols="12">
                    <v-card>
                        <v-card-title>
                            {{ product.display_name }}
                            <v-spacer />
                            {{ product.price }} $
                        </v-card-title>
                        <v-divider />
                        <v-card-text>
                            {{ product.description }}
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import CategoryBreadcrumbs from '../components/productsShoppingOverview/CategoryBreadcrumbs';

export default {
    name: 'ProductShoppingDetails',
    components: {
        'category-breadcrumbs': CategoryBreadcrumbs
    },
    props: {
        id: {
            type: [String, Number],
            required: true,
            default: null
        }
    },
    data() {
        return {
            product: {
                id: null,
                display_name: null,
                description: null,
                price: null,
                is_active: null,
                images: [],
                versions: [],
                discount: null,
                sizes: [],
                categories: [],
                discount_price: null,
                coverImage: null
            },
            isLoading: false,
            activeImage: null
        };
    },
    computed: {
        subCategories() {
            return this.product.categories.filter((item) => item.parent_id);
        },
        mainCategories() {
            return this.product.categories.filter((item) => !item.parent_id);
        },
        images() {
            if (this.product.coverImage) {
                return [this.product.coverImage, ...this.product.images];
            }
            return [...this.product.images];
        }
    },
    watch: {
        id() {
            this.getProduct();
        }
    },
    created() {
        this.getProduct();
        this.activeImage = this.images[0];
    },
    methods: {
        getProduct() {
            this.isLoading = true;
            this.$http
                .get(`/api/products/${this.id}`)
                .then((response) => {
                    this.product = response.data;
                    this.getCoverImage();
                })
                .catch(this.handleServerError);
        },
        getCoverImage() {
            this.$http
                .get(`/api/products/${this.id}/cover-image`)
                .then((response) => {
                    this.product.coverImage = response.data;
                })
                .catch(this.handleServerError)
                .finally(() => (this.isLoading = false));
        },
        activeImageClass(index) {
            if (this.activeImage !== index) {
                return;
            }
            return '#4e4e4e';
        }
    }
};
</script>

<style scoped></style>
