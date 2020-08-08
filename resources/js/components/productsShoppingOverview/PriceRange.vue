<template>
    <div>
        <span class="subtitle-1">Price range</span>
        <v-range-slider
            v-if="show"
            :value="value"
            :max="maxPrice"
            :min="0"
            thumb-label="always"
            :thumb-size="40"
            hide-details
            class="align-center mt-12"
            @input="$emit('input', $event)"
        >
            <template v-slot:thumb-label="{ value }">
                {{ value }} $
            </template>
        </v-range-slider>
        <v-row class="px-3">
            0 $
            <v-spacer />
            {{ maxPrice }} $
        </v-row>
    </div>
</template>

<script>
export default {
    name: 'PriceRange',
    props: {
        value: {
            type: Array,
            required: false,
            default: () => [0, 0]
        }
    },
    data() {
        return {
            maxPrice: null,
            show: false
        };
    },
    created() {
        this.getMaxPrice();
    },
    methods: {
        getMaxPrice() {
            this.$http
                .get('/api/products/max-price')
                .then((response) => {
                    this.maxPrice = response.data.price;
                    this.$emit('input', [
                        parseInt(this.value[0]) || 0,
                        parseInt(this.value[1]) || this.maxPrice
                    ]);
                })
                .finally(() => (this.show = true));
        }
    }
};
</script>

<style scoped></style>
