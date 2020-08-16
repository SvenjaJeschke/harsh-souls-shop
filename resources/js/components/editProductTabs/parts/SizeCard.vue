<template>
    <v-card>
        <v-card-text>
            <v-row>
                <v-col cols="12" md="8">
                    Size: {{ size.display_name }}<br />
                    Price: {{ size.price }} $
                </v-col>
                <v-col cols="12" md="4">
                    <!-- edit modal -->
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
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'SizeCard',
    props: {
        size: {
            type: Object,
            required: true,
            default: () => ({
                display_name: null,
                price: 0.0,
                product_id: null
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
                    'Delete Size',
                    'Do you really want to delete this size?'
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
                .delete(`/api/admin/sizes/${this.size.id}`)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.$emit('sizes-changed');
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped></style>
