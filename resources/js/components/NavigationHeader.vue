<template>
    <v-app-bar
        extended
        app
        shrink-on-scroll
    >
        <v-toolbar-title>Harsh Souls Shop</v-toolbar-title>
        <template v-slot:extension>
            <v-tabs align-with-title>
                <v-tab
                    v-for="category in categories"
                    :key="category.id"
                    :to="{name: category.route, params: category.params}"
                >
                    {{category.display_name}}
                </v-tab>
            </v-tabs>
        </template>
    </v-app-bar>
</template>

<script>
export default {
    name: "NavigationHeader",
    data: () => ({
        categories: [
            {id: 0, display_name: 'Home', route: 'home'},
            {id: 1, display_name: 'Toys', route: 'products-list', params: {category: 0}},
            {id: 2, display_name: 'Accessories', route: 'products-list', params: {category: 1}},
            {id: 3, display_name: 'Clothes', route: 'products-list', params: {category: 2}}
        ]
    })
}
</script>
