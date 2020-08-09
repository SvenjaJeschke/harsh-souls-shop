<template>
    <v-app-bar app shrink-on-scroll src="./assets/logo.png" color="black">
        <v-spacer />
        <v-text-field
            v-if="$route.name !== 'products'"
            label="Search all products"
            v-model="search"
            append-icon="mdi-magnify"
            single-line
            hide-details
            class="shrink pa-2"
            style="width: 400px;"
            @keyup.enter="goToProductsSearch"
        />
        <v-btn v-if="checkAuth" icon @click="toggleAdminNavigationDrawer">
            <v-icon>mdi-menu</v-icon>
        </v-btn>
        <div v-else>
            <v-tooltip left>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" :to="{ name: 'login' }">
                        <v-icon>mdi-login</v-icon>
                    </v-btn>
                </template>
                Admin Login
            </v-tooltip>
        </div>
        <template v-slot:img="{ props }">
            <v-img v-bind="props" contain />
        </template>
        <template v-slot:extension>
            <navigation-category-tabs />
        </template>
    </v-app-bar>
</template>

<script>
import { mapGetters } from 'vuex';
import NavigationCategoryTabs from './NavigationCategoryTabs';

export default {
    name: 'NavigationHeader',
    components: {
        'navigation-category-tabs': NavigationCategoryTabs
    },
    data() {
        return {
            search: null
        };
    },
    computed: {
        ...mapGetters(['checkAuth', 'user'])
    },
    methods: {
        toggleAdminNavigationDrawer() {
            this.$root.$emit('toggle-admin-navigation-drawer');
        },
        goToProductsSearch() {
            this.$router.replace({
                name: 'products',
                query: { search: this.search }
            });
        }
    }
};
</script>
