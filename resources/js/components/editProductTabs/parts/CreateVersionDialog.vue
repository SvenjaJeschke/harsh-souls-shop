<template>
    <v-dialog :value="value" persistent max-width="600">
        <v-card>
            <v-card-title>
                Create new product version
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    label="Display name"
                    v-model="version.display_name"
                    :error="!!errorMessages.display_name"
                    :error-messages="errorMessages.display_name"
                />
                <v-text-field
                    label="Color name"
                    v-model="version.color"
                    :error="!!errorMessages.color"
                    :error-messages="errorMessages.color"
                />
                Select display color:
                <color-picker-swatches
                    v-model="version.color_code"
                    :error="!!errorMessages.color_code"
                    :error-messages="errorMessages.color_code"
                />
                <v-row>
                    <v-col md="8">
                        <!--<v-text-field
                            label="Price"
                            v-model="version.price"
                            :error="!!errorMessages.price"
                            :error-messages="errorMessages.price"
                        />-->
                        <v-text-field
                            label="Price"
                            v-model="priceInput"
                            :error="
                                !!errorMessages.price_adjustment ||
                                !!errorMessages.operator
                            "
                            :error-messages="
                                errorMessages.price_adjustment ||
                                errorMessages.operator
                            "
                            hint="write + or - and the price to change from the products base price"
                        />
                    </v-col>
                    <v-col md="4">
                        <v-checkbox
                            label="Active"
                            v-model="version.is_active"
                            :error="!!errorMessages.is_active"
                            :error-messages="errorMessages.is_active"
                        />
                    </v-col>
                </v-row>
                <v-select
                    v-model="version.image_id"
                    :items="product.images"
                    :error="!!errorMessages.image_id"
                    :error-messages="errorMessages.image_id"
                    clearable
                    item-value="id"
                    label="Image"
                >
                    <template v-slot:selection="{ item }">
                        <v-img
                            height="50"
                            width="100"
                            contain
                            position="start"
                            :src="item.storage_url"
                        />
                        {{ item.original_name }}
                    </template>
                    <template v-slot:item="{ item }">
                        <v-img
                            height="50"
                            width="100"
                            contain
                            position="start"
                            :src="item.storage_url"
                        />
                        {{ item.original_name }}
                    </template>
                </v-select>
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
                    <v-icon left>fa-plus</v-icon>
                    Create
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import ColorPickerSwatches from '../../ColorPickerSwatches';

export default {
    name: 'CreateVersionDialog',
    components: {
        'color-picker-swatches': ColorPickerSwatches
    },
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
        },
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            version: {
                product_id: this.product.id,
                display_name: '',
                color: null,
                color_code: '#ffffff',
                is_active: true,
                image_id: null,
                price_adjustment: null,
                operator: null
            },
            isLoading: false,
            errorMessages: {},
            priceInput: null
        };
    },
    watch: {
        priceInput(value) {
            this.errorMessages.price_adjustment = null;
            if (!value || !value.length) {
                this.resetPriceFields();
                return;
            }
            if (this.hasWhiteSpace(value)) {
                this.errorMessages.price_adjustment = 'contains spaces';
                this.resetPriceFields();
                return;
            }
            if (!['+', '-'].includes(value.charAt(0))) {
                this.errorMessages.price_adjustment = 'must begin with + or -';
                this.resetPriceFields();
                return;
            }
            this.version.operator = value.charAt(0);
            if (value.length > 1) {
                this.version.price_adjustment = value.substring(
                    1,
                    value.length
                );
            }
        }
    },
    methods: {
        close() {
            this.version = {
                product_id: this.product.id,
                display_name: '',
                color: null,
                color_code: '#ffffff',
                price: 0,
                is_active: true,
                price_adjustment: null,
                operator: null
            };
            this.priceInput = null;
            this.errorMessages = {};
            this.$emit('input', false);
        },
        create() {
            this.isLoading = true;
            this.errorMessages = {};
            this.$http
                .post(
                    `/api/admin/version/product/${this.product.id}`,
                    this.version
                )
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.close();
                    this.$emit('versions-changed');
                })
                .catch((error) => {
                    this.errorMessages = error.response.data.errors;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        resetPriceFields() {
            this.version.operator = null;
            this.version.price_adjustment = null;
        }
    }
};
</script>

<style scoped></style>
