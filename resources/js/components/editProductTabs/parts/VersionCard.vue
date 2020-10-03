<template>
    <v-card>
        <v-card-title>
            {{ version.display_name }}
            <v-spacer />
            <edit-version-dialog
                :product="product"
                :version="version"
                @versions-changed="$emit('versions-changed')"
            />
            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-btn
                        icon
                        :disabled="isLoading"
                        :loading="isLoading"
                        v-on="on"
                        @click="confirmDelete"
                    >
                        <v-icon>fa-times</v-icon>
                    </v-btn>
                </template>
                Delete
            </v-tooltip>
        </v-card-title>
        <v-card-text>
            <v-row>
                <v-col md="6">
                    <p v-if="version.color">
                        <v-icon :color="version.color_code">fa-circle</v-icon>
                        Color: {{ version.color }}
                    </p>
                    <p v-if="version.price">Price: {{ version.price }}</p>
                    <p>
                        Active:
                        <v-icon v-if="version.is_active" color="green">
                            mdi-check
                        </v-icon>
                        <v-icon v-else color="red">
                            mdi-clear
                        </v-icon>
                    </p>
                </v-col>
                <v-col md="6">
                    <v-img
                        v-if="version.image"
                        class="white"
                        :src="version.image.storage_url"
                    />
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
import EditVersionDialog from './EditVersionDialog';

export default {
    name: 'VersionCard',
    components: {
        'edit-version-dialog': EditVersionDialog
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
                price: 0,
                is_active: true,
                image: {
                    id: null
                }
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
            isLoading: false
        };
    },
    methods: {
        confirmDelete() {
            this.$root
                .$confirm(
                    'Delete Version',
                    "Do you really want to delete this product version? If it has an image, the image won't be deleted."
                )
                .then((confirm) => {
                    if (confirm) {
                        this.delete();
                    }
                });
        },
        delete() {
            this.isLoading = true;
            this.$http
                .delete(`/api/admin/version/${this.version.id}`)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('versions-changed');
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped></style>
