<template>
    <v-dialog :value="value" persistent max-width="900">
        <v-card>
            <v-card-title>
                Create Category
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="category.display_name"
                    label="Name"
                    :error="!!errorMessages.display_name"
                    :error-messages="errorMessages.display_name"
                />
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <v-checkbox
                            v-model="category.is_active"
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
                <v-btn
                    text
                    color="secondary"
                    :loading="isLoading"
                    :disabled="isLoading"
                    @click="create"
                >
                    Create
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'CreateCategoryDialog',
    props: {
        value: {
            type: Boolean,
            default: false
        },
        parentId: {
            type: Number,
            default: null
        }
    },
    data() {
        return {
            isLoading: false,
            category: {
                display_name: null,
                is_active: true,
                parent_id: this.parentId
            },
            errorMessages: {}
        };
    },
    methods: {
        create() {
            this.isLoading = true;
            this.errorMessages = {};
            this.$http
                .post('/api/admin/category', this.category)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('category-created');
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
            this.category = {
                display_name: null,
                is_active: true
            };
            this.errorMessages = {};
            this.$emit('input', false);
        }
    }
};
</script>

<style scoped></style>
