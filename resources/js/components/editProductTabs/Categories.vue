<template>
    <v-card flat>
        <v-card-title>
            Categories
        </v-card-title>
        <v-card-subtitle>
            Select the categories you want the product to belong to.
        </v-card-subtitle>
        <v-divider />
        <v-card-text>
            <v-treeview
                v-if="categories.length"
                v-model="selected"
                :items="categories"
                item-children="children_recursive"
                item-text="display_name"
                item-key="id"
                selectable
                selection-type="independent"
                hoverable
            />
        </v-card-text>
        <v-card-actions>
            <v-spacer />
            <v-btn
                text
                color="secondary"
                :loading="isLoading"
                :disabled="isLoading"
                @click="update"
            >
                Save changes
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: 'Categories',
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
            categories: [],
            selected: [],
            isLoading: false
        };
    },
    created() {
        this.getCategories();
        this.selected = this.product.categories.map((item) => item.id);
    },
    methods: {
        getCategories() {
            this.$http.get('/api/admin/categories/all').then((response) => {
                this.categories = response.data;
            });
        },
        update() {
            this.isLoading = true;
            this.$http
                .put(`/api/admin/product/${this.product.id}/categories`, {
                    categories: this.selected
                })
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped></style>
