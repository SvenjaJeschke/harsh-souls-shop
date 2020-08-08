<template>
    <v-card flat tile>
        <v-card-title class="headline">
            FILTERS
        </v-card-title>
        <v-divider />
        <v-card-text>
            <price-range v-model="priceRange" />
            <color-select class="mt-10" v-model="filters.color" />
        </v-card-text>
    </v-card>
</template>

<script>
import PriceRange from './PriceRange';
import ColorSelect from './ColorSelect';

export default {
    name: 'FiltersCard',
    components: {
        'price-range': PriceRange,
        'color-select': ColorSelect
    },
    props: {
        value: {
            type: Object,
            required: false,
            default: () => ({
                categoryId: null,
                sort: null,
                color: null,
                minPrice: null,
                maxPrice: null,
                search: null
            })
        }
    },
    data() {
        return {
            filters: this.value,
            priceRange: []
        };
    },
    watch: {
        value: {
            handler(value) {
                this.filters = value;
            },
            deep: true
        },
        filters: {
            handler(value) {
                this.priceRange = [value.minPrice, value.maxPrice];
                this.$emit('input', value);
            },
            deep: true
        },
        priceRange(value) {
            this.filters.minPrice = value[0];
            this.filters.maxPrice = value[1];
        }
    }
};
</script>

<style scoped></style>
