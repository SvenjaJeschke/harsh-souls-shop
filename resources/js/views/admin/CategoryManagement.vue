<template>
    <v-card class="ma-6">
        <v-card-title>
            Categories
            <v-spacer></v-spacer>
            <v-btn
                text
                color="secondary"
                @click="create()"
            >
                <v-icon left>fa-plus</v-icon>
                Create main category
            </v-btn>
        </v-card-title>
        <v-card-text>
            <v-treeview
                :items="categories"
                item-children="children_recursive"
                hoverable
            >
                <template v-slot:label="{item}">
                    <v-icon left>fa-folder</v-icon>
                    {{item.display_name}}
                    <v-tooltip top>
                        <template v-slot:activator="{on}">
                            <v-btn
                                v-on="on"
                                icon
                                color="primary"
                                @click="edit(item)"
                            >
                                <v-icon small>fa-pen</v-icon>
                            </v-btn>
                        </template>
                        Edit
                    </v-tooltip>
                    <v-tooltip top>
                        <template v-slot:activator="{on}">
                            <v-btn
                                v-on="on"
                                :disabled="!!item.children_recursive.length || isLoading"
                                :loading="isLoading"
                                icon
                                color="error"
                                @click="confirmDelete(item)"
                            >
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </template>
                        Delete
                    </v-tooltip>
                    <v-tooltip top>
                        <template v-slot:activator="{on}">
                            <v-btn
                                v-if="!item.parent_id"
                                v-on="on"
                                icon
                                color="secondary"
                                @click="create(item.id)"
                            >
                                <v-icon small>fa-plus</v-icon>
                            </v-btn>
                        </template>
                        Add Subcategory
                    </v-tooltip>
                </template>
            </v-treeview>
        </v-card-text>
        <create-category-dialog
            v-if="showCreateModal"
            v-model="showCreateModal"
            :parent-id="createCategoryParentId"
            @category-created="getCategories"
        />
        <edit-category-dialog
            v-if="showEditModal"
            v-model="showEditModal"
            :category="editCategory"
            @category-updated="getCategories"
        />
    </v-card>
</template>

<script>
import CreateCategoryDialog from '../../components/CreateCategoryDialog';
import EditCategoryDialog from '../../components/EditCategoryDialog';

export default {
    name: 'CategoryManagement',
    components: {
        'create-category-dialog': CreateCategoryDialog,
        'edit-category-dialog': EditCategoryDialog
    },
    data() {
        return {
            categories: [],
            isLoading: false,
            showCreateModal: false,
            createCategoryParentId: null,
            showEditModal: false,
            editCategory: null
        };
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            this.$http.get('/api/categories/all')
                .then(response => {
                    this.categories = response.data;
                })
        },
        create(parent_id = null) {
            this.createCategoryParentId = parent_id;
            this.showCreateModal = true;
        },
        confirmDelete(category) {
            this.$root.$confirm(
                'Delete Category',
                `Do you really want to delete the category ${category.display_name}?`
            ).then(confirm => {
                if (confirm) {
                    this.delete(category);
                }
            })
        },
        delete(category) {
            this.isLoading = true;
            this.$http.delete(`/api/category/${category.id}`)
                .then(response => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.getCategories();
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        edit(category) {
            this.showEditModal = true;
            this.editCategory = category;
        }
    }
}
</script>

<style scoped>

</style>
