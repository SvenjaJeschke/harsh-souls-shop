<template>
    <v-col md="4" sm="6" cols="12">
        <v-card>
            <v-carousel v-model="activeImage" hide-delimiters>
                <v-carousel-item v-for="image in images" :key="image.id">
                    <v-img :src="image.storage_url" />
                </v-carousel-item>
            </v-carousel>
        </v-card>
        <v-row>
            <v-col cols="4" v-for="(image, index) in images" :key="index">
                <v-card
                    @click="activeImage = index"
                    :color="activeImageClass(index)"
                >
                    <v-img :src="image.storage_url" />
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</template>

<script>
export default {
    name: 'ProductImages',
    props: {
        product: {
            type: Object,
            required: true,
            default: () => ({
                images: [],
                coverImage: null
            })
        },
        selectedVersion: {
            type: Object,
            required: false,
            default: () => ({})
        }
    },
    data() {
        return {
            activeImage: null
        };
    },
    computed: {
        images() {
            if (this.product.coverImage) {
                return [this.product.coverImage, ...this.product.images];
            }
            return [...this.product.images];
        }
    },
    watch: {
        activeImage(imageIndex) {
            this.$emit('active-image-changed', imageIndex);
        },
        selectedVersion: {
            handler(version) {
                if (
                    version.image &&
                    this.product.images[this.activeImage].id !==
                        version.image.id
                ) {
                    this.product.images.forEach((image, index) => {
                        if (image.id === version.image.id) {
                            this.activeImage = index;
                        }
                    });
                }
            },
            deep: true
        }
    },
    mounted() {
        this.activeImage = this.images[0];
    },
    methods: {
        activeImageClass(index) {
            if (this.activeImage !== index) {
                return;
            }
            return 'highlight';
        }
    }
};
</script>

<style scoped></style>
