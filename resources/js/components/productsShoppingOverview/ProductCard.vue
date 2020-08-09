<template>
    <v-card>
        <v-img :src="image" lazy-src="./assets/placeholder.png" />
        <v-card-title>
            {{ product.display_name }}
            <v-spacer />
            {{ displayPrice }} $
        </v-card-title>
    </v-card>
</template>

<script>
export default {
    name: 'ProductCard',
    props: {
        product: {
            type: Object,
            required: true,
            default: () => ({
                id: null,
                display_name: null,
                description: null,
                price: null,
                is_active: null,
                images: [],
                versions: [],
                discount: null,
                sizes: [],
                discount_price: null,
                coverImage: null
            })
        }
    },
    computed: {
        image() {
            if (this.product.coverImage) {
                return this.product.coverImage.storage_url;
            } else if (this.product.images.length) {
                return this.product.images[0].storage_url;
            } else {
                return null;
            }
        },
        displayPrice() {
            if (this.product.price) {
                return this.product.price;
            }
            if (this.product.versions[0]) {
                return this.product.versions[0].price;
            }
            if (this.product.sizes[0]) {
                return this.product.sizes[0].price;
            }
            return 0;
        }
    }
};
</script>

<style scoped></style>
