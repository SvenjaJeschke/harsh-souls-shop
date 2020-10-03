<template>
    <v-select
        label="Versions"
        :value="value"
        :items="versions"
        return-object
        item-text="display_name"
        @input="$emit('input', $event)"
    >
        <template v-slot:selection="{ item }">
            <v-icon left :color="item.color_code">
                fa-circle
            </v-icon>
            {{ item.display_name }}
        </template>
        <template v-slot:item="{ item }">
            <v-icon left :color="item.color_code">
                fa-circle
            </v-icon>
            {{ item.display_name }}
        </template>
    </v-select>
</template>

<script>
export default {
    name: 'ProductVersionSelect',
    props: {
        value: {
            type: Object,
            required: false,
            default: () => ({
                id: null,
                display_name: null
            })
        },
        versions: {
            type: Array,
            required: false,
            default: () => []
        }
    }
};
</script>

<style scoped></style>
