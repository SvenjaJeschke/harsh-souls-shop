<template>
    <v-dialog :value="value" persistent max-width="600">
        <v-card v-if="editVersion">
            <v-card-title>
                Edit: {{ version.display_name }}
                <v-spacer/>
                <v-btn
                    icon
                    @click="close"
                >
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    label="Display name"
                    v-model="editVersion.display_name"
                ></v-text-field>
                <v-text-field
                    label="Color name"
                    v-model="editVersion.color"
                ></v-text-field>
                Select display color:
                <v-color-picker
                    v-model="editVersion.color_code"
                    hide-mode-switch
                    hide-inputs
                    mode="hexa"
                ></v-color-picker>
                <v-row>
                    <v-col md="8">
                        <v-text-field
                            label="Price"
                            v-model="editVersion.price"
                        ></v-text-field>
                    </v-col>
                    <v-col md="4">
                        <v-checkbox
                            label="Active"
                            v-model="editVersion.is_active"
                        ></v-checkbox>
                    </v-col>
                </v-row>
                <v-select
                    v-model="image_id"
                    :items="product.images"
                    clearable
                    item-value="id"
                    label="Image"
                    @click:clear="$nextTick(() => image_id = null)"
                >
                    <template v-slot:selection="{ item }">
                        <v-img
                            height="50"
                            width="100"
                            contain
                            position="start"
                            :src="item.storage_url"
                        ></v-img>
                        {{ item.original_name }}
                    </template>
                    <template v-slot:item="{ item }">
                        <v-img
                            height="50"
                            width="100"
                            contain
                            position="start"
                            :src="item.storage_url"
                        ></v-img>
                        {{ item.original_name }}
                    </template>
                </v-select>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-tooltip top>
                    <template v-slot:activator="{on}">
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
import Vue from 'vue';

export default {
    name: "EditVersionDialog",
    props: {
        version: {
            type: Object,
            required: true,
            default: {
                id: null,
                product_id: null,
                display_name: '',
                color: null,
                color_code: null,
                price: 0,
                is_active: true
            }
        },
        product: {
            type: Object,
            required: true,
            default: {
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
            }
        },
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            editVersion: null,
            isLoading: false,
            image_id: null
        };
    },
    computed: {
        hasChanges() {
            return this.version.image.id !== this.image_id ||
                this.version.display_name !== this.editVersion.display_name ||
                this.version.color !== this.editVersion.color ||
                this.version.color_code !== this.editVersion.color_code ||
                this.version.price !== this.editVersion.price ||
                this.version.is_active !== this.editVersion.is_active;
        }
    },
    created() {
        this.editVersion = this.copy(this.version);
        this.image_id = this.version.image.id;
    },
    methods: {
        close() {
            this.editVersion = this.copy(this.version);
            this.image_id = this.version.image.id;
            this.$emit('input', false);
        },
        update() {
            this.isLoading = true;
            this.editVersion.image_id = this.image_id;
            this.$http.put(`/api/version/${this.version.id}`, this.editVersion)
                .then(response => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.close();
                    this.$emit('versions-changed');
                })
                .finally(() => {
                    this.isLoading = false;
                })
        },
        revertChanges() {
            this.errorMessages = [];
            this.editVersion = this.copy(this.version);
            this.image_id = this.version.image.id;
        }
    }
}
</script>

<style scoped>

</style>