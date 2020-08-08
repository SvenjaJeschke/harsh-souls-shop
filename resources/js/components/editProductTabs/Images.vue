<template>
    <v-card flat>
        <v-card-title>
            Product Cover Image
        </v-card-title>
        <v-card-subtitle>
            This image will always be shown as the first image of the product.
        </v-card-subtitle>
        <v-divider />
        <v-card-text>
            <image-card
                v-if="coverImage"
                :image="coverImage"
                is-cover-image
                @files-changed="imagesChanged"
            />
            <span v-else>
                This product doesn't have a cover image yet.
            </span>
        </v-card-text>
        <v-card-title>
            Product images
            <v-spacer />
            <v-btn text color="secondary" @click="showUploadModal = true">
                Upload Images
            </v-btn>
        </v-card-title>
        <v-divider />
        <v-card-text>
            <v-row>
                <v-col v-for="image in product.images" :key="image.id" md="4">
                    <image-card
                        :image="image"
                        :has-cover-image="!!coverImage"
                        @files-changed="imagesChanged"
                    />
                </v-col>
            </v-row>
        </v-card-text>
        <upload-dialog
            v-model="showUploadModal"
            :product="product"
            @files-changed="$emit('files-changed')"
        />
    </v-card>
</template>

<script>
import UploadDialog from './parts/UploadDialog';
import ImageCard from './parts/ImageCard';

export default {
    name: 'Images',
    components: {
        'upload-dialog': UploadDialog,
        'image-card': ImageCard
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
        }
    },
    data() {
        return {
            showUploadModal: false,
            coverImage: null
        };
    },
    created() {
        this.getCoverImage();
    },
    methods: {
        getCoverImage() {
            this.$http
                .get(`/api/product/${this.product.id}/cover-image`)
                .then((response) => {
                    this.coverImage = response.data;
                });
        },
        imagesChanged() {
            this.$emit('files-changed');
            this.getCoverImage();
        }
    }
};
</script>

<style scoped></style>
