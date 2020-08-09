<template>
    <v-tabs
        v-if="tabs.length"
        align-with-title
        hide-slider
        mobile-breakpoint="md"
    >
        <v-menu
            tile
            v-for="(tab, index) in tabs"
            :key="index"
            open-on-hover
            offset-y
            :close-on-content-click="false"
        >
            <template v-slot:activator="{ on }">
                <v-tab
                    :to="{ name: tab.route, query: tab.query }"
                    v-on="on"
                    exact
                    :class="activeClass(tab.category)"
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
                    <v-list-item-title :class="activeClass(child)">
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
            categories: [],
            getCategoryAttempts: 0
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
        }
    },
    created() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            this.getCategoryAttempts += 1;
            this.$http
                .get('/api/categories')
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    if (this.getCategoryAttempts < 3) {
                        this.getCategories();
                    } else {
                        this.handleServerError(error);
                    }
                });
        },
        activeClass(category) {
            if (category.id === this.$route.query.category) {
                return 'primary--text';
            }
        }
    }
};
</script>

<style scoped></style>
