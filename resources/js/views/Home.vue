<template>
    <v-card flat class="mx-6 my-2" color="transparent">
        <v-card-text class="pa-0">
            <v-row class="py-2 px-5">
                Home
            </v-row>
        </v-card-text>
        <v-divider />
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            Check out our newest products!
                        </v-card-title>
                    </v-card>
                    <products-list
                        :pagination="pagination"
                        :params="params"
                        full-width
                    />
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import ProductsList from '../components/productsShoppingOverview/ProductsList';

export default {
    name: 'Home',
    components: {
        'products-list': ProductsList
    },
    data() {
        return {
            newestProducts: [],
            pagination: {
                page: 1,
                length: 1,
                limit: 8
            },
            params: {
                categoryId: null,
                sort: 'newest products',
                color: null,
                minPrice: null,
                maxPrice: null,
                search: null
            }
        };
    }
};
</script>

<style scoped></style>
