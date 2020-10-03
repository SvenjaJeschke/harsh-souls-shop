<template>
    <v-card v-if="keywords.length" flat class="mb-4">
        <span class="ma-2">
            Keywords:
        </span>
        <v-chip
            outlined
            class="mx-1"
            v-for="keyword in keywords"
            :key="keyword.id"
            :to="{
                name: 'products',
                query: { search: keyword.name }
            }"
        >
            {{ keyword.name }}
        </v-chip>
    </v-card>
</template>

<script>
export default {
    name: 'ProductKeywords',
    props: {
        keywords: {
            type: Array,
            required: true,
            default: () => []
        }
    }
};
</script>

<style scoped></style>
