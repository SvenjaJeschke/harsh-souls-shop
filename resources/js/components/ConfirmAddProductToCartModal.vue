<template>
    <v-dialog :value="value" max-width="600" persistent>
        <v-card outlined>
            <v-card-title>
                Do you want to add this to your cart?
            </v-card-title>
            <v-divider />
            <v-card-text class="pb-0">
                <v-row>
                    <v-col cols="6">
                        <p>Product:</p>
                        <p v-if="params.version">Version:</p>
                        <p v-if="params.size">Size:</p>
                        <p>Amount:</p>
                        <p>Price:</p>
                    </v-col>
                    <v-col cols="6">
                        <p>{{ product.display_name }}</p>
                        <p v-if="params.version">
                            <v-icon
                                v-if="params.version.color_code"
                                left
                                :color="params.version.color_code"
                            >
                                fa-circle
                            </v-icon>
                            {{ params.version.display_name }}
                        </p>
                        <p v-if="params.size">{{ params.size.display_name }}</p>
                        <p>{{ params.amount }}</p>
                        <p>
                            <span v-if="params.discountPrice">
                                <span class="primary--text">
                                    <span
                                        style="text-decoration: line-through;"
                                    >
                                        {{ params.price }} $
                                    </span>
                                    <span class="mx-5">
                                        {{ params.discountPrice }}
                                    </span>
                                    {{ product.discount.discount_percent }}%
                                </span>
                            </span>
                            <span v-else> {{ params.price }} $ </span>
                        </p>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="pt-0">
                <v-spacer />
                <v-btn text @click="$emit('input', false)">
                    No
                </v-btn>
                <v-btn text color="secondary" @click="submit">
                    Yes
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'ConfirmAddProductToCartModal',
    props: {
        value: {
            type: Boolean,
            required: true,
            default: false
        },
        params: {
            type: Object,
            required: false,
            default: () => ({
                product: null,
                version: null,
                size: null,
                amount: 1,
                price: null,
                discountPrice: null
            })
        },
        product: {
            type: Object,
            required: false,
            default: () => ({
                id: null,
                display_name: null,
                description: null,
                price: null,
                is_active: null,
                images: [],
                versions: [],
                discount: null,
                sizes: [],
                categories: [],
                coverImage: null
            })
        }
    },
    methods: {
        submit() {

        }
    }
};
</script>

<style scoped></style>
