<template>
    <v-card v-if="editProduct" flat>
        <v-card-title>
            Edit Product Details
        </v-card-title>
        <v-divider />
        <v-card-text>
            <v-row>
                <v-col md="8">
                    <v-text-field
                        v-model="editProduct.display_name"
                        label="Name"
                        :error="!!errorMessages.display_name"
                        :error-messages="errorMessages.display_name"
                    />
                </v-col>
                <v-col md="3">
                    <v-text-field
                        v-model="editProduct.price"
                        label="Price"
                        append-icon="fa-dollar-sign"
                        :error="!!errorMessages.price"
                        :error-messages="errorMessages.price"
                    />
                </v-col>
                <v-col md="1">
                    <v-tooltip top>
                        <template v-slot:activator="{ on }">
                            <v-checkbox
                                v-model="editProduct.is_active"
                                label="Active"
                                v-on="on"
                                :error="!!errorMessages.is_active"
                                :error-messages="errorMessages.is_active"
                            />
                        </template>
                        If a product is deactivated, the customers won't be able
                        to see or order it in the shop.
                    </v-tooltip>
                </v-col>
            </v-row>
            <v-row>
                <v-col md="12">
                    <v-textarea
                        v-model="editProduct.description"
                        label="Description"
                        :error="!!errorMessages.description"
                        :error-messages="errorMessages.description"
                    />
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-spacer />
            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-btn
                        text
                        :disabled="!hasChanges"
                        v-on="on"
                        @click="revertChanges"
                    >
                        Revert changes
                    </v-btn>
                </template>
                You can only revert changes that are not saved yet.
            </v-tooltip>
            <v-btn
                text
                color="secondary"
                :loading="isLoading"
                :disabled="isLoading"
                @click="updateProduct"
            >
                Save changes
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: 'ProductDetails',
    props: {
        product: {
            type: Object,
            required: true,
            default: () => ({
                id: null,
                display_name: '',
                description: '',
                price: '',
                is_active: false,
                created_at: '',
                updated_at: '',
                deleted_at: '',
                discount: null,
                categories: [],
                versions: [],
                images: []
            })
        }
    },
    data() {
        return {
            editProduct: null,
            isLoading: false,
            errorMessages: []
        };
    },
    computed: {
        hasChanges() {
            return (
                this.product.display_name !== this.editProduct.display_name ||
                this.product.price !== this.editProduct.price ||
                this.product.is_active !== this.editProduct.is_active ||
                this.product.description !== this.editProduct.description
            );
        }
    },
    watch: {
        product: {
            handler(value) {
                if (this.hasChanges) {
                    this.editProduct = this.copy(value);
                }
            },
            deep: true
        }
    },
    created() {
        this.editProduct = this.copy(this.product);
    },
    methods: {
        updateProduct() {
            const input = {
                display_name: this.editProduct.display_name,
                price: this.editProduct.price,
                is_active: this.editProduct.is_active,
                description: this.editProduct.description
            };
            this.isLoading = true;
            this.$http
                .put(`/api/admin/product/${this.product.id}`, input)
                .then((response) => {
                    this.errorMessages = [];
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('product-changed');
                })
                .catch((error) => {
                    this.$root.$emit('snackbar', error.response.data.message);
                    this.errorMessages = error.response.data.errors;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        revertChanges() {
            this.errorMessages = [];
            this.editProduct = this.copy(this.product);
        }
    }
};
</script>

<style scoped></style>
