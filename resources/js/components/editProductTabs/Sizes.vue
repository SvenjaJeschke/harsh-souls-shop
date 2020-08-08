<template>
    <v-card flat>
        <v-card-title>
            Sizes
            <v-spacer />
            <v-btn text color="secondary" @click="showCreateDialog = true">
                Create size
            </v-btn>
        </v-card-title>
        <v-divider />
        <v-card-text>
            <v-row>
                <v-col v-for="size in product.sizes" :key="size.id" md="4">
                    <size-card :size="size" />
                </v-col>
            </v-row>
        </v-card-text>
        <create-size-dialog
            v-if="showCreateDialog"
            v-model="showCreateDialog"
            :product="product"
            @size-created="$emit('sizes-changed')"
        />
    </v-card>
</template>

<script>
import SizeCard from './parts/SizeCard';
import CreateSizeDialog from './parts/CreateSizeDialog';

export default {
    name: 'Sizes',
    components: {
        'size-card': SizeCard,
        'create-size-dialog': CreateSizeDialog
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
                images: [],
                sizes: []
            })
        }
    },
    data() {
        return {
            showCreateDialog: false
        };
    }
};
</script>

<style scoped></style>
