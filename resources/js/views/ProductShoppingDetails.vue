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
                            <v-card
                                v-if="product.keywords.length"
                                flat
                                class="mb-4"
                            >
                                <span class="ma-2">
                                    Keywords:
                                </span>
                                <v-chip
                                    outlined
                                    class="mx-1"
                                    v-for="keyword in product.keywords"
                                    :key="keyword.id"
                                    :to="{
                                        name: 'products',
                                        query: { search: keyword.name }
                                    }"
                                >
                                    {{ keyword.name }}
                                </v-chip>
                            </v-card>
                            {{ product.description }}
                            <v-row>
                                <v-col lg="5" md="6" cols="12">
                                    <v-select
                                        v-if="product.versions.length"
                                        label="Versions"
                                        v-model="selection.version"
                                        :items="product.versions"
                                        return-object
                                        item-text="display_name"
                                    >
                                        <template v-slot:selection="{ item }">
                                            <v-icon
                                                left
                                                :color="item.color_code"
                                            >
                                                fa-circle
                                            </v-icon>
                                            {{ item.display_name }}
                                        </template>
                                        <template v-slot:item="{ item }">
                                            <v-icon
                                                left
                                                :color="item.color_code"
                                            >
                                                fa-circle
                                            </v-icon>
                                            {{ item.display_name }}
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col lg="5" md="6" cols="12">
                                    <v-select
                                        v-if="product.sizes.length"
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

export default {
    name: 'ProductShoppingDetails',
    components: {
        'category-breadcrumbs': CategoryBreadcrumbs,
        'confirm-add-product-to-cart-modal': ConfirmAddProductToCartModal
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
                keywords: [],
                coverImage: null
            },
            isLoading: false,
            activeImage: null,
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
        images() {
            if (this.product.coverImage) {
                return [this.product.coverImage, ...this.product.images];
            }
            return [...this.product.images];
        },
        discountPrice() {
            if (!this.product.discount) return;
            return (this.price / this.product.discount.discount_percent) * 100;
        },
        price() {
            if (!this.selection.version && !this.selection.size) return;
            let price = parseFloat(this.product.price);
            if (
                this.selection.version &&
                this.selection.version.operator &&
                this.selection.version.price_adjustment
            ) {
                const versionPriceAdjustment = parseFloat(
                    this.selection.version.price_adjustment
                );
                if (this.selection.version.operator === '+') {
                    price += versionPriceAdjustment;
                }
                if (this.selection.version.operator === '-') {
                    price -= versionPriceAdjustment;
                }
            }
            if (
                this.selection.size &&
                this.selection.size.operator &&
                this.selection.size.price_adjustment
            ) {
                const sizePriceAdjustment = parseFloat(
                    this.selection.size.price_adjustment
                );
                if (this.selection.size.operator === '+') {
                    price += sizePriceAdjustment;
                }
                if (this.selection.size.operator === '-') {
                    price -= sizePriceAdjustment;
                }
            }
            return (price * this.selection.amount).toFixed(2);
        }
    },
    watch: {
        id() {
            this.getProduct();
        },
        'selection.version': {
            handler(version) {
                if (
                    version.image &&
                    this.product.images[this.activeImage].id !==
                        version.image.id
                ) {
                    this.product.images.forEach((image, index) => {
                        if (image.id === version.image.id) {
                            this.activeImage = index;
                        }
                    });
                }
            },
            deep: true
        },
        activeImage(imageIndex) {
            this.product.versions.forEach((version) => {
                if (version.image.id === this.product.images[imageIndex].id) {
                    this.selection.version = version;
                }
            });
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
        this.activeImage = this.images[0];
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
        activeImageClass(index) {
            if (this.activeImage !== index) {
                return;
            }
            return 'highlight';
        },
        confirmAddToCard() {
            this.selection.price = this.price;
            this.selection.discountPrice = this.discountPrice;
            this.showConfirmModal = true;
        }
    }
};
</script>

<style scoped></style>
