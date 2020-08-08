<template>
    <v-dialog :value="value" persistent max-width="900">
        <v-card>
            <v-card-title>
                Edit Category {{ category.display_name }}
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="editCategory.display_name"
                    label="Name"
                    :error="!!errorMessages.display_name"
                    :error-messages="errorMessages.display_name"
                />
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <v-checkbox
                            v-model="editCategory.is_active"
                            label="Active"
                            v-on="on"
                            :error="!!errorMessages.is_active"
                            :error-messages="errorMessages.is_active"
                        />
                    </template>
                    If a category is deactivated, the customers won't be able to
                    see it in the shop.
                </v-tooltip>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
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
                    Save changes
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'EditCategoryDialog',
    props: {
        value: {
            type: Boolean,
            default: false
        },
        category: {
            type: Object,
            default: () => ({
                display_name: null,
                is_active: true
            })
        }
    },
    data() {
        return {
            isLoading: false,
            editCategory: this.copy(this.category),
            errorMessages: {}
        };
    },
    computed: {
        hasChanges() {
            return (
                this.category.display_name !== this.editCategory.display_name ||
                this.category.is_active !== this.editCategory.is_active
            );
        }
    },
    methods: {
        update() {
            this.isLoading = true;
            this.errorMessages = {};
            this.$http
                .put(
                    `/api/admin/category/${this.category.id}`,
                    this.editCategory
                )
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('category-updated');
                    this.close();
                })
                .catch((error) => {
                    this.errorMessages = error.response.data.errors;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        close() {
            this.editCategory = this.copy(this.category);
            this.errorMessages = {};
            this.$emit('input', false);
        },
        revertChanges() {
            this.errorMessages = {};
            this.editCategory = this.copy(this.category);
        }
    }
};
</script>

<style scoped></style>
