<template>
    <v-dialog :value="value" persistent max-width="600">
        <v-card>
            <v-card-title>
                Select the files you want to upload.
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-file-input
                    v-model="images"
                    chips
                    multiple
                    label="Select Images"
                    accept="image/*"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    color="secondary"
                    :loading="isLoading"
                    :disabled="isLoading"
                    @click="upload"
                >
                    <v-icon>mdi-cloud_upload</v-icon>
                    Upload
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'UploadDialog',
    props: {
        value: {
            type: Boolean,
            required: true,
            default: false
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
            images: [],
            isLoading: false
        };
    },
    methods: {
        upload() {
            this.isLoading = true;
            let formData = new FormData();
            this.images.forEach((image) => {
                formData.append('images[]', image, image.name);
            });
            this.$http
                .post(`/api/admin/images/${this.product.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/formdata'
                    }
                })
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('files-changed');
                })
                .finally(() => {
                    this.isLoading = false;
                    this.close();
                });
        },
        close() {
            this.images = [];
            this.$emit('input', false);
        }
    }
};
</script>

<style scoped></style>
