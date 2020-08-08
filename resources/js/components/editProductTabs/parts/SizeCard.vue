<template>
    <v-card>
        <v-card-text>
            Size: {{ size.display_name }}<br>
            Price: {{ size.price }} $
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
            default: {
                display_name: null,
                price: 0.00,
                product_id: null
            }
        }
    }
}
</script>

<style scoped>

</style>
