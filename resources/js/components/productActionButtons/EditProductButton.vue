<template>
    <v-tooltip bottom>
        <template v-slot:activator="{on}">
            <v-btn
                icon
                color="primary"
                v-on="on"
                :to="{name: 'edit-product', params: {id: productId}}"
            >
                <v-icon small>fa-pen</v-icon>
            </v-btn>
        </template>
        Edit
    </v-tooltip>
</template>

<script>
export default {
    name: "EditProductButton",
    props: {
        productId: {
            type: Number,
            required: true
        }
    }
}
</script>

<style scoped>

</style>
