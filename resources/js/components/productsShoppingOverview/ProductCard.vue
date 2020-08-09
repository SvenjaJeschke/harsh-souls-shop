<template>
    <v-hover v-slot:default="{ hover }">
        <v-card>
            <v-img :src="image">
                <v-expand-transition>
                    <v-card
                        flat
                        tile
                        :to="{ name: 'product', params: { id: product.id } }"
                        v-if="hover"
                        class="d-flex transition-fast-in-fast-out primary darken-1 v-card--reveal display-3 subtitle-2"
                        style="height: 10%;"
                    >
                        SHOW PRODUCT
                    </v-card>
                </v-expand-transition>
            </v-img>
            <v-card-title style="position: relative;">
                <v-btn absolute color="primary" fab large right top>
                    <v-icon>mdi-cart</v-icon>
                </v-btn>
                {{ product.display_name }}
            </v-card-title>
            <v-card-subtitle> {{ displayPrice }} $ </v-card-subtitle>
        </v-card>
    </v-hover>
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
                return './assets/placeholder.png';
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
    },
    methods: {
        cardStyle(hover) {
            if (!hover) {
                return;
            }
            return {
                cursor: 'pointer'
            };
        }
    }
};
</script>

<style scoped>
.v-card--reveal {
    align-items: center;
    bottom: 0;
    justify-content: center;
    opacity: 0.5;
    position: absolute;
    width: 100%;
}
</style>
