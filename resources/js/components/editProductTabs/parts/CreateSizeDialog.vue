<template>
    <v-dialog :value="value" persistent max-width="600">
        <v-card>
            <v-card-title>
                Create product size
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    label="Size display name"
                    v-model="size.display_name"
                />
                <!--<v-text-field
                    label="Price"
                    append-icon="fa-dollar-sign"
                    v-model="size.price"
                />-->
                <v-text-field
                    label="Price"
                    append-icon="fa-dollar-sign"
                    v-model="priceInput"
                    :error="
                        !!errorMessages.price_adjustment ||
                        !!errorMessages.operator
                    "
                    :error-messages="
                        errorMessages.price_adjustment || errorMessages.operator
                    "
                    hint="write + or - and the price to change from the products base price"
                />
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
export default {
    name: 'CreateSizeDialog',
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
            size: {
                display_name: null,
                product_id: this.product.id,
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
            this.size.operator = value.charAt(0);
            if (value.length > 1) {
                this.size.price_adjustment = value.substring(1, value.length);
            }
        }
    },
    methods: {
        create() {
            this.isLoading = true;
            this.$http
                .post(`/api/admin/size/${this.product.id}`, this.size)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('size-created');
                    this.close();
                })
                .catch((error) => {
                    this.$root.$emit('snackbar', error.response.data.message);
                    this.errorMessages = error.response.data.errors;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        close() {
            this.size = {
                display_name: null,
                product_id: this.product.id,
                price_adjustment: null,
                operator: null
            };
            this.errorMessages = {};
            this.$emit('input', false);
        },
        resetPriceFields() {
            this.version.operator = null;
            this.version.price_adjustment = null;
        }
    }
};
</script>

<style scoped></style>
