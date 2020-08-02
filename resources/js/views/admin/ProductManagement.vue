<template>
    <v-card class="ma-6">
        <v-card-title>
            Product management
            <v-spacer />
            <v-text-field
                v-model="pagination.search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            <v-btn
                text
                color="secondary"
                @click="showCreateProductDialog = true"
            >
                Create product
            </v-btn>
        </v-card-title>
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="products"
                :options.sync="pagination"
                :loading="isLoading"
                :server-items-length="totalProducts"
                :footer-props="{
                    itemsPerPageOptions: [10, 20, 50, 100, 200]
                }"
            >
                <template v-slot:item.coverImage="{item}">
                    <v-img
                        :src="getImage(item)"
                        lazy-src="./assets/placeholder.png"
                        height="50"
                        width="100"
                    ></v-img>
                </template>
                <template v-slot:item.price="{item}">
                    <span v-if="item.price">{{item.price}} $</span>
                    <span v-else>-</span>
                </template>
                <template v-slot:item.is_active="{item}">
                    <v-icon v-if="item.is_active" color="green">
                        mdi-check
                    </v-icon>
                    <v-icon v-else color="red">
                        mdi-clear
                    </v-icon>
                </template>
                <template v-slot:item.updated_at="{item}">
                    {{formatDate(item.updated_at)}}
                </template>
                <template v-slot:item.created_at="{item}">
                    {{formatDate(item.created_at)}}
                </template>
                <template v-slot:item.actions="{item}">
                    <edit-product-button :product-id="item.id" />
                    <delete-product-button :product-id="item.id" />
                </template>
            </v-data-table>
        </v-card-text>
        <create-product-dialog
            v-model="showCreateProductDialog"
        ></create-product-dialog>
    </v-card>
</template>

<script>
import dayjs from 'dayjs';
import EditProductButton from "../../components/productActionButtons/EditProductButton";
import DeleteProductButton from "../../components/productActionButtons/DeleteProductButton";
import CreateProductDialog from "../../components/CreateProductDialog";

export default {
    name: 'ProductManagement',
    components: {
        'edit-product-button': EditProductButton,
        'delete-product-button': DeleteProductButton,
        'create-product-dialog': CreateProductDialog
    },
    data() {
        return {
            headers: [
                {text: 'Image', value: 'coverImage', sortable: false},
                {text: 'Name', value: 'display_name'},
                {text: 'Price', value: 'price'},
                {text: 'Active', value: 'is_active'},
                {text: 'Updated', value: 'updated_at'},
                {text: 'Created', value: 'created_at'},
                {text: 'Actions', value: 'actions', sortable: false}
            ],
            products: [],
            pagination: {
                search: null
            },
            isLoading: false,
            totalProducts: 0,
            showCreateProductDialog: false
        };
    },
    watch: {
        pagination: {
            handler() {
                this.getProducts();
            },
            deep: true
        }
    },
    methods: {
        getProducts() {
            this.isLoading = true;
            this.$http.get('/api/products', {params: this.pagination})
                .then(response => {
                    this.products = response.data.data;
                    this.totalProducts = response.data.total;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        formatDate(date) {
            return dayjs(date).format('MMMM D, YYYY hh:mm');
        },
        getImage(item) {
            if(!!item.coverImage) {
                return item.coverImage.storage_url;
            } else if (!!item.images.length) {
                return item.images[0].storage_url;
            } else {
                return null;
            }
        }
    }
}
</script>

<style scoped>

</style>
