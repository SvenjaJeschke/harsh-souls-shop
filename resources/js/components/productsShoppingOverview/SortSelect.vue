<template>
    <v-select
        outlined
        hide-details
        dense
        label="Sort products by"
        :items="sortTypes"
        :value="value"
        @input="$emit('input', $event)"
    />
</template>

<script>
export default {
    name: 'SortSelect',
    props: {
        value: {
            type: String,
            required: false,
            default: null
        }
    },
    data() {
        return {
            sortTypes: [
                'newest products',
                'price descending',
                'price ascending'
            ]
        };
    },
    mounted() {
        if (!this.value) {
            this.$emit('input', this.sortTypes[0]);
        }
    }
};
</script>

<style scoped></style>
