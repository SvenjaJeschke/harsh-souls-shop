<template>
    <v-dialog v-model="showDialog" persistent max-width="600">
        <template #activator="{ on: dialog }">
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn icon v-on="{ ...dialog, ...tooltip }">
                        <v-icon>fa-pen</v-icon>
                    </v-btn>
                </template>
                Edit
            </v-tooltip>
        </template>
        <v-card v-if="editVersion">
            <v-card-title>
                Edit: {{ version.display_name }}
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    label="Display name"
                    v-model="editVersion.display_name"
                    :error="!!errorMessages.display_name"
                    :error-messages="errorMessages.display_name"
                />
                <v-text-field
                    label="Color name"
                    v-model="editVersion.color"
                    :error="!!errorMessages.color"
                    :error-messages="errorMessages.color"
                />
                Select display color:
                <color-picker-swatches
                    v-model="editVersion.color_code"
                    :error="!!errorMessages.color_code"
                    :error-message="errorMessages.color_code"
                />
                <v-row>
                    <v-col md="8">
                        <!--<v-text-field
                            label="Price"
                            v-model="editVersion.price"
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
                            v-model="editVersion.is_active"
                            :error="!!errorMessages.is_active"
                            :error-messages="errorMessages.is_active"
                        />
                    </v-col>
                </v-row>
                <v-select
                    v-model="image_id"
                    :items="product.images"
                    :error="!!errorMessages.image_id"
                    :error-messages="errorMessages.image_id"
                    clearable
                    item-value="id"
                    label="Image"
                    @click:clear="
                        $nextTick(function () {
                            this.image_id = null;
                        })
                    "
                >
                    <template #selection="{ item }">
                        <v-img
                            height="50"
                            width="100"
                            contain
                            position="start"
                            :src="item.storage_url"
                        />
                        {{ item.original_name }}
                    </template>
                    <template #item="{ item }">
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
                <v-tooltip top>
                    <template #activator="{ on }">
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
                    @click="update"
                >
                    <v-icon left>fa-check</v-icon>
                    Save changes
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import ColorPickerSwatches from '../../ColorPickerSwatches';
import { cloneDeep } from 'lodash';

export default {
    name: 'EditVersionDialog',
    components: {
        'color-picker-swatches': ColorPickerSwatches
    },
    props: {
        version: {
            type: Object,
            required: true,
            default: () => ({
                id: null,
                product_id: null,
                display_name: '',
                color: null,
                color_code: null,
                is_active: true,
                image: {
                    id: null
                },
                price_adjustment: null,
                operator: null
            })
        },
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
            editVersion: null,
            isLoading: false,
            image_id: null,
            errorMessages: {},
            showDialog: false,
            priceInput: null
        };
    },
    computed: {
        hasChanges() {
            return (
                !this.version.image ||
                this.version.image.id !== this.image_id ||
                this.version.display_name !== this.editVersion.display_name ||
                this.version.color !== this.editVersion.color ||
                this.version.color_code !== this.editVersion.color_code ||
                this.version.price_adjustment !==
                    this.editVersion.price_adjustment ||
                this.version.operator !== this.editVersion.operator ||
                this.version.is_active !== this.editVersion.is_active
            );
        }
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
            this.editVersion.operator = value.charAt(0);
            if (value.length > 1) {
                this.editVersion.price_adjustment = value.substring(
                    1,
                    value.length
                );
            }
        }
    },
    created() {
        this.editVersion = cloneDeep(this.version);
        this.image_id = this.version.image ? this.version.image.id : null;
        this.priceInput =
            this.editVersion.operator + this.editVersion.price_adjustment;
    },
    methods: {
        close() {
            this.editVersion = cloneDeep(this.version);
            this.image_id = this.version.image ? this.version.image.id : null;
            this.errorMessages = {};
            this.showDialog = false;
        },
        update() {
            this.isLoading = true;
            this.editVersion.image_id = this.image_id;
            this.errorMessages = {};
            this.$http
                .put(`/api/admin/version/${this.version.id}`, this.editVersion)
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
        revertChanges() {
            this.errorMessages = {};
            this.editVersion = cloneDeep(this.version);
            this.image_id = this.version.image ? this.version.image.id : null;
        },
        resetPriceFields() {
            this.editVersion.operator = this.version.operator;
            this.editVersion.price_adjustment = this.version.price_adjustment;
        }
    }
};
</script>

<style scoped></style>
