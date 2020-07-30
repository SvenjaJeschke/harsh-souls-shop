<template>
    <v-app-bar
        app
        shrink-on-scroll
        src="./assets/logo.png"
        color="black"
    >
        <v-spacer></v-spacer>
        <v-btn
            v-if="checkAuth"
            icon
            @click="toggleAdminNavigationDrawer"
        >
            <v-icon>mdi-menu</v-icon>
        </v-btn>
        <div v-else>
            <v-tooltip left>
                <template v-slot:activator="{on}">
                    <v-btn
                        icon
                        v-on="on"
                        :to="{name: 'login'}"
                    >
                        <v-icon small>mdi-login</v-icon>
                    </v-btn>
                </template>
                Admin Login
            </v-tooltip>
        </div>
        <template v-slot:img="{ props }">
            <v-img
                v-bind="props"
                contain
            />
        </template>
        <template v-slot:extension>
            <navigation-category-tabs />
        </template>

    </v-app-bar>
</template>

<script>
import {mapGetters} from 'vuex';
import NavigationCategoryTabs from "./NavigationCategoryTabs";

export default {
    name: "NavigationHeader",
    components: {
        'navigation-category-tabs': NavigationCategoryTabs
    },
    computed: {
        ...mapGetters(['checkAuth', 'user'])
    },
    methods: {
        toggleAdminNavigationDrawer() {
            this.$root.$emit('toggle-admin-navigation-drawer');
        }
    }
}
</script>
