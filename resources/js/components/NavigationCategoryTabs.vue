<template>
    <v-tabs
        v-if="tabs.length"
        align-with-title
        :hide-slider="isNotOnMainCategoryPage"
    >
        <v-menu
            v-for="(tab, index) in tabs"
            :key="index"
            open-on-hover
            offset-y
            :close-on-content-click="false"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-tab
                    :to="{ name: tab.route, query: tab.query }"
                    exact
                    v-on="on"
                    v-bind="attrs"
                >
                    {{ tab.display_name }}
                </v-tab>
            </template>
            <v-list
                v-if="
                    tab.category.children_recursive &&
                    tab.category.children_recursive.length
                "
            >
                <v-list-item
                    v-for="child in tab.category.children_recursive"
                    :key="child.id"
                    :to="{ name: 'products', query: { category: child.id } }"
                    exact
                >
                    <v-list-item-title>
                        {{ child.display_name }}
                    </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-tabs>
</template>

<script>
export default {
    name: 'NavigationCategoryTabs',
    data() {
        return {
            categories: []
        };
    },
    computed: {
        tabs() {
            let tabs = [{ display_name: 'Home', route: 'home', category: {} }];

            this.categories.forEach((category) => {
                tabs.push({
                    display_name: category.display_name,
                    route: 'products',
                    query: { category: category.id },
                    category
                });
            });

            return tabs;
        },
        isNotOnMainCategoryPage() {
            let mainRoutes = ['/home'];
            this.categories.forEach((category) => {
                mainRoutes.push('/products/' + category.id);
            });

            return !mainRoutes.includes(this.$route.fullPath);
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            this.$http
                .get('/api/categories')
                .then((response) => {
                    this.categories = response.data;
                })
                .catch(() => {
                    this.getCategories();
                });
        }
    }
};
</script>

<style scoped></style>
