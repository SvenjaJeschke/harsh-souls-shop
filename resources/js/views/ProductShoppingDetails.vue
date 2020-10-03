<template>
    <v-card v-if="!isLoading" flat class="mx-6 my-2" color="transparent">
        <v-card-title class="pa-0">
            <v-row
                v-for="category in subCategories.length
                    ? subCategories
                    : mainCategories"
                :key="category.id"
            >
                <category-breadcrumbs :category="category" :product="product" />
            </v-row>
        </v-card-title>
        <v-divider />
        <v-card-text class="px-16">
            <v-row>
                <product-images
                    :product="product"
                    @active-image-changed="onActiveImageChanged"
                    :selected-version="selection.version"
                />
                <v-col md="8" sm="6" cols="12">
                    <v-card>
                        <v-card-title>
                            {{ product.display_name }}
                            <v-spacer />
                            <span v-if="product.discount">
                                <span class="primary--text">
                                    <span
                                        style="text-decoration: line-through;"
                                    >
                                        {{ price }} $
                                    </span>
                                    <span class="mx-5">
                                        {{ discountPrice }}
                                    </span>
                                    {{ product.discount.discount_percent }}%
                                </span>
                            </span>
                            <span v-else> {{ price }} $ </span>
                        </v-card-title>
                        <v-divider />
                        <v-card-text style="min-height: 250px;">
                            <product-keywords :keywords="product.keywords" />
                            {{ product.description }}
                            <v-row>
                                <v-col
                                    v-if="product.versions.length"
                                    lg="5"
                                    md="6"
                                    cols="12"
                                >
                                    <product-version-select
                                        v-model="selection.version"
                                        :versions="product.versions"
                                    />
                                </v-col>
                                <v-col
                                    v-if="product.sizes.length"
                                    lg="5"
                                    md="6"
                                    cols="12"
                                >
                                    <v-select
                                        label="Sizes"
                                        v-model="selection.size"
                                        :items="product.sizes"
                                        return-object
                                        item-text="display_name"
                                    />
                                </v-col>
                                <v-col lg="2" cols="12" />
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
        <confirm-add-product-to-cart-modal
            v-model="showConfirmModal"
            :product="product"
            :params="selection"
        />
    </v-card>
</template>

<script>
import CategoryBreadcrumbs from '../components/productsShoppingOverview/CategoryBreadcrumbs';
import ConfirmAddProductToCartModal from '../components/ConfirmAddProductToCartModal';
import ProductImages from '../components/productShoppingDetails/ProductImages';
import ProductKeywords from '../components/productShoppingDetails/ProductKeywords';
import ProductVersionSelect from '../components/productShoppingDetails/ProductVersionSelect';
import CalculatePrice from '../mixins/CalculatePrice';

export default {
    name: 'ProductShoppingDetails',
    components: {
        'product-version-select': ProductVersionSelect,
        'product-keywords': ProductKeywords,
        'product-images': ProductImages,
        'category-breadcrumbs': CategoryBreadcrumbs,
        'confirm-add-product-to-cart-modal': ConfirmAddProductToCartModal
    },
    mixins: [CalculatePrice],
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
                keywords: [],
                coverImage: null
            },
            isLoading: false,
            selection: {
                product: null,
                version: null,
                size: null,
                amount: 1,
                price: null,
                discountPrice: null
            },
            showConfirmModal: false
        };
    },
    computed: {
        subCategories() {
            return this.product.categories.filter((item) => item.parent_id);
        },
        mainCategories() {
            return this.product.categories.filter((item) => !item.parent_id);
        },
        discountPrice() {
            if (!this.product.discount) return;
            return (this.price / this.product.discount.discount_percent) * 100;
        }
    },
    watch: {
        id() {
            this.getProduct();
        },
        'selection.amount'(value) {
            if (value <= 0) {
                this.selection.amount = '1';
                this.$refs.amountInput.lazyValue = '1';
            }
            if (value > 100) {
                this.selection.amount = '100';
                this.$refs.amountInput.lazyValue = '100';
            }
        }
    },
    created() {
        this.getProduct();
    },
    methods: {
        getProduct() {
            this.isLoading = true;
            this.$http
                .get(`/api/products/${this.id}`)
                .then((response) => {
                    this.product = response.data;
                    this.selection.product = this.product.id;
                    if (this.product.sizes.length) {
                        this.selection.size = this.product.sizes[0];
                    }
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
        onActiveImageChanged(imageIndex) {
            this.product.versions.forEach((version) => {
                if (version.image.id === this.product.images[imageIndex].id) {
                    this.selection.version = version;
                }
            });
        }
    }
};
</script>

<style scoped></style>
