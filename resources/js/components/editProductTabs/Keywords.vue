<template>
    <v-card flat>
        <v-card-title>
            Keywords
        </v-card-title>
        <v-card-subtitle>
            Set keywords so users can find products easier by using the search
            functionality.
        </v-card-subtitle>
        <v-divider />
        <v-card-text>
            <v-card flat class="mx-auto" max-width="800">
                <v-row>
                    <v-col md="10">
                        <v-text-field
                            v-model="newKeyword"
                            label="Type new keyword"
                            hide-details
                        />
                    </v-col>
                    <v-col md="2">
                        <v-btn
                            color="primary"
                            :disabled="!valid || isLoading"
                            :loading="isLoading"
                            @click="addKeyword"
                        >
                            Add
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card>
            <v-card flat>
                <v-card-text>
                    <v-chip
                        v-for="keyword in keywords"
                        :key="keyword.id"
                        close
                        class="ma-1"
                        @click:close="removeKeyword(keyword)"
                    >
                        {{ keyword.name }}
                    </v-chip>
                </v-card-text>
            </v-card>
        </v-card-text>
    </v-card>
</template>

<script>
export default {
    name: 'Keywords',
    props: {
        product: {
            type: Object,
            required: true,
            default: () => ({
                id: null,
                display_name: '',
                description: '',
                price: '',
                is_active: false,
                created_at: '',
                updated_at: '',
                deleted_at: '',
                discount: null,
                categories: [],
                versions: [],
                images: []
            })
        }
    },
    data() {
        return {
            newKeyword: '',
            keywords: [],
            isLoading: false
        };
    },
    computed: {
        valid() {
            return !!this.newKeyword.length && !/\s/.test(this.newKeyword);
        }
    },
    created() {
        this.getKeywords();
    },
    methods: {
        getKeywords() {
            this.$http
                .get(`/api/keywords/product/${this.product.id}`)
                .then((response) => {
                    this.keywords = response.data;
                });
        },
        addKeyword() {
            this.isLoading = true;
            this.$http
                .post(`/api/keywords/product/${this.product.id}`, {
                    name: this.newKeyword
                })
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.getKeywords();
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        removeKeyword(keyword) {
            this.$http
                .delete(
                    `/api/keywords/${keyword.id}/product/${this.product.id}`
                )
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.getKeywords();
                });
        }
    }
};
</script>

<style scoped></style>
