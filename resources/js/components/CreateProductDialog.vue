<template>
    <v-dialog :value="value" persistent max-width="900">
        <v-card>
            <v-card-title>
                Create new product
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col md="7">
                        <v-text-field
                            v-model="product.display_name"
                            label="Name"
                            :error="!!errorMessages.display_name"
                            :error-messages="errorMessages.display_name"
                        />
                    </v-col>
                    <v-col md="3">
                        <v-text-field
                            v-model="product.price"
                            label="Price"
                            append-icon="fa-dollar-sign"
                            :error="!!errorMessages.price"
                            :error-messages="errorMessages.price"
                        />
                    </v-col>
                    <v-col md="2">
                        <v-tooltip top>
                            <template v-slot:activator="{ on }">
                                <v-checkbox
                                    v-model="product.is_active"
                                    label="Active"
                                    v-on="on"
                                    :error="!!errorMessages.is_active"
                                    :error-messages="errorMessages.is_active"
                                />
                            </template>
                            If a product is deactivated, the customers won't be
                            able to see or order it in the shop.
                        </v-tooltip>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col md="12">
                        <v-textarea
                            v-model="product.description"
                            label="Description"
                            :error="!!errorMessages.description"
                            :error-messages="errorMessages.description"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    color="secondary"
                    :loading="isLoading"
                    :disabled="isLoading"
                    @click="create"
                >
                    Create
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'CreateProductDialog',
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isLoading: false,
            product: {
                display_name: null,
                price: null,
                is_active: true,
                description: null
            },
            errorMessages: {}
        };
    },
    methods: {
        create() {
            this.isLoading = true;
            this.errorMessages = {};
            this.$http
                .post('/api/admin/product', this.product)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.close();
                })
                .catch((error) => {
                    this.errorMessages = error.response.data.errors;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        close() {
            this.product = {
                display_name: null,
                price: null,
                is_active: true,
                description: null
            };
            this.errorMessages = {};
            this.$emit('input', false);
        }
    }
};
</script>

<style scoped></style>
