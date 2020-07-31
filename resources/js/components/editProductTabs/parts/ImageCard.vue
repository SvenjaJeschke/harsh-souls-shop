<template>
    <v-card :max-width="isCoverImage ? 800 : null" class="mx-auto">
        <v-img
            :src="image.storage_url"
            lazy-src="./assets/placeholder.png"
        >
            <v-card-title>
                {{ image.original_name }}
                <v-spacer />
                <v-tooltip top>
                    <template v-slot:activator="{on}">
                        <v-btn
                            v-if="!isCoverImage"
                            icon
                            :disabled="hasCoverImage || loading.makeCoverImage"
                            :loading="loading.makeCoverImage"
                            v-on="on"
                            @click="makeCoverImage"
                        >
                            <v-icon>fa-book</v-icon>
                        </v-btn>
                    </template>
                    Make cover image
                </v-tooltip>
                <v-tooltip top>
                    <template v-slot:activator="{on}">
                        <v-btn
                            v-if="isCoverImage"
                            icon
                            :disabled="loading.unsetCoverImage"
                            :loading="loading.unsetCoverImage"
                            v-on="on"
                            @click="unsetCoverImage"
                        >
                            <v-icon>fa-unlink</v-icon>
                        </v-btn>
                    </template>
                    Unset cover image. Image won't be deleted.
                </v-tooltip>
                <v-tooltip top>
                    <template v-slot:activator="{on}">
                        <v-btn
                            icon
                            :disabled="loading.download"
                            :loading="loading.download"
                            v-on="on"
                            @click="download"
                        >
                            <v-icon>fa-download</v-icon>
                        </v-btn>
                    </template>
                    Download
                </v-tooltip>
                <v-tooltip top>
                    <template v-slot:activator="{on}">
                        <v-btn
                            icon
                            :disabled="loading.delete"
                            :loading="loading.delete"
                            v-on="on"
                            @click="confirmDelete"
                        >
                            <v-icon>fa-times</v-icon>
                        </v-btn>
                    </template>
                    Delete
                </v-tooltip>
            </v-card-title>
            <template v-slot:placeholder>
                <v-row
                    class="fill-height ma-0"
                    align="center"
                    justify="center"
                >
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-row>
            </template>
        </v-img>
    </v-card>
</template>

<script>
import {saveAs} from 'file-saver';

export default {
    name: "ImageCard",
    props: {
        image: {
            type: Object,
            required: true,
            default: {
                id: null,
                product_id: null,
                version_id: null,
                name: '',
                storage_url: '',
                original_name: '',
                path: '',
                file_size: 0,
                file_extension: '',
                is_cover: false,
                is_visible: false,
                created_at: '',
                updated_at: ''
            }
        },
        hasCoverImage: {
            type: Boolean,
            default: false
        },
        isCoverImage: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            loading: {
                delete: false,
                download: false,
                makeCoverImage: false,
                unsetCoverImage: false
            }
        }
    },
    methods: {
        confirmDelete() {
            this.$root.$confirm(
                'Remove Image',
                'Do you really want to remove this image? You won\'t be able to view or download it anymore.'
            ).then(confirm => {
                if (confirm) {
                    this.deleteImage();
                }
            })
        },
        deleteImage() {
            this.loading.delete = true;
            this.$http.delete(`/api/images/${this.image.id}`)
                .then(response => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('files-changed');
                })
                .finally(() => {
                    this.loading.delete = false;
                })
        },
        download() {
            this.loading.download = true;
            this.$http.get(`/api/images/${this.image.id}/download`, {
                responseType: 'blob'
            }).then(response => {
                saveAs(response.data, this.image.original_name);
            })
            .finally(() => {
                this.loading.download = false;
            })
        },
        makeCoverImage() {
            this.loading.makeCoverImage = true;
            this.$http.put(`/api/product/cover-image/${this.image.id}`)
                .then(response => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('files-changed');
                })
                .finally(() => {
                    this.loading.makeCoverImage = false;
                })
        },
        unsetCoverImage() {
            this.loading.unsetCoverImage = true;
            this.$http.put(`/api/product/cover-image/${this.image.id}/unset`)
                .then(response => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('files-changed');
                })
                .finally(() => {
                    this.loading.unsetCoverImage = false;
                })
        }
    }
}
</script>

<style scoped>

</style>
