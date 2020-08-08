<template>
    <v-tooltip bottom>
        <template v-slot:activator="{ on }">
            <v-btn icon color="error" v-on="on" @click.stop="confirmDelete">
                <v-icon>mdi-delete</v-icon>
            </v-btn>
        </template>
        Delete
    </v-tooltip>
</template>

<script>
export default {
    name: 'DeleteProductButton',
    props: {
        productId: {
            type: Number,
            required: true
        }
    },
    methods: {
        confirmDelete() {
            this.$root
                .$confirm(
                    'Delete Product',
                    'Do you really want to delete this product?'
                )
                .then((confirm) => {
                    if (confirm) {
                        this.deleteProduct();
                    }
                });
        },
        deleteProduct() {}
    }
};
</script>

<style scoped></style>
