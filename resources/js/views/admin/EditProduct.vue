<template>
    <v-card v-if="product" class="ma-6">
        <v-card-title>
            <v-btn light class="mr-3" :to="{name: 'product-management'}">
                <v-icon left>fa-arrow-left</v-icon>
                Back to products
            </v-btn>
            #{{ product.id }} {{ product.display_name }}
            <v-spacer />
            <v-tabs v-model="activeTab" right>
                <v-tab
                    v-for="tab in tabs"
                    :key="tab.key"
                    :to="`#${tab.key}`"
                >
                    <v-icon left>{{tab.icon}}</v-icon>
                    {{tab.title}}
                </v-tab>
            </v-tabs>
        </v-card-title>
        <v-card-text>
            <v-tabs-items v-model="activeTab">
                <v-tab-item value="product-details">
                    <product-details :product="product" @product-changed="getProduct" />
                </v-tab-item>
                <v-tab-item value="images">
                    <images :product="product" @files-changed="getProduct" />
                </v-tab-item>
                <v-tab-item value="keywords">
                    <keywords :product="product" />
                </v-tab-item>
                <v-tab-item value="versions">
                    <versions :product="product" @versions-changed="getProduct" />
                </v-tab-item>
                <v-tab-item value="categories">
                    <categories />
                </v-tab-item>
                <v-tab-item value="sizes">
                    <sizes />
                </v-tab-item>
                <v-tab-item value="discount">
                    <discount />
                </v-tab-item>
            </v-tabs-items>
        </v-card-text>
    </v-card>
</template>

<script>
import ProductDetails from "../../components/editProductTabs/ProductDetails";
import Images from "../../components/editProductTabs/Images";
import Keywords from "../../components/editProductTabs/Keywords";
import Versions from "../../components/editProductTabs/Versions";
import Categories from "../../components/editProductTabs/Categories";
import Discount from "../../components/editProductTabs/Discount";
import Sizes from "../../components/editProductTabs/Sizes";

export default {
    name: "EditProduct",
    components: {
        'product-details': ProductDetails,
        'images': Images,
        'keywords': Keywords,
        'versions': Versions,
        'categories': Categories,
        'sizes': Sizes,
        'discount': Discount
    },
    props: {
        id: {
            type: [String, Number],
            required: true
        }
    },
    data() {
        return {
            product: null,
            tabs: [
                {title: 'Product Details', icon: 'fa-box-open', key: 'product-details'},
                {title: 'Images', icon: 'fa-images', key: 'images'},
                {title: 'Keywords', icon: 'fa-search', key: 'keywords'},
                {title: 'Versions', icon: 'fa-palette', key: 'versions'},
                {title: 'Categories', icon: 'fa-sitemap', key: 'categories'},
                {title: 'Sizes', icon: 'fa-ruler', key: 'sizes'},
                {title: 'Discount', icon: 'fa-percentage', key: 'discount'}
            ],
            activeTab: this.$route.query
        };
    },
    created() {
        this.getProduct();
    },
    methods: {
        getProduct() {
            this.$http.get(`/api/product/${this.id}`)
                .then(response => {
                    this.product = response.data;
                })
        }
    }
}
</script>

<style scoped>

</style>
