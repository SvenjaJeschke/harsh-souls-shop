<template>
    <v-text-field
        label="Search products"
        :value="value"
        append-icon="mdi-magnify"
        single-line
        hide-details
        @input="$emit('input', $event)"
        @keyup.enter="$emit('submit')"
    />
</template>

<script>
export default {
    name: 'SearchField',
    props: {
        value: {
            type: String,
            required: false,
            default: null
        }
    }
};
</script>

<style scoped></style>
