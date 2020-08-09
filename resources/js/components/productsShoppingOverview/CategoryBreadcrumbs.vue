<template>
    <div>
        <v-breadcrumbs :items="items" class="py-1 px-3">
            <template v-slot:divider>
                <v-icon>mdi-chevron-right</v-icon>
            </template>
        </v-breadcrumbs>
    </div>
</template>

<script>
export default {
    name: 'CategoryBreadcrumbs',
    props: {
        category: {
            type: Object,
            required: false,
            default: () => ({
                id: null,
                display_name: null,
                is_active: true,
                parent_id: null,
                parent: {
                    id: null,
                    display_name: null,
                    is_active: true,
                    parent_id: null
                }
            })
        },
        product: {
            type: Object,
            required: false,
            default: null
        }
    },
    computed: {
        items() {
            let breadcrumb = [
                {
                    text: 'Products',
                    href: '#/products'
                }
            ];
            if (!this.category) {
                return breadcrumb;
            }
            if (this.category.parent) {
                breadcrumb.push({
                    text: this.category.parent.display_name,
                    href: `#/products?category=${this.category.parent_id}`
                });
            }
            if (this.product) {
                breadcrumb.push({
                    text: this.category.display_name,
                    href: `#/products?category=${this.category.id}`
                });
                breadcrumb.push({ text: this.product.display_name });
            } else {
                breadcrumb.push({ text: this.category.display_name });
            }
            return breadcrumb;
        }
    }
};
</script>

<style scoped></style>
