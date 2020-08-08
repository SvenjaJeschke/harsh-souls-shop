<template>
    <v-navigation-drawer
        v-if="checkAuth"
        v-model="show"
        app
        temporary
        right
        hide-overlay
    >
        <v-list dense>
            <v-list-item>
                <v-list-item-avatar>
                    <v-img src="./assets/harshsouls.png" />
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>
                        {{ user.username }}
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
            <v-divider />

            <v-list-item
                v-for="(item, index) in items"
                :key="index"
                :to="{ name: item.route }"
            >
                <v-list-item-icon>
                    <v-icon small>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'AdminNavigationDrawer',
    data() {
        return {
            show: false
        };
    },
    computed: {
        ...mapGetters(['checkAuth', 'user']),
        items() {
            return [
                {
                    title: 'Products',
                    icon: 'fa-boxes',
                    route: 'product-management'
                },
                {
                    title: 'Categories',
                    icon: 'fa-sitemap',
                    route: 'category-management'
                },
                {
                    title: 'Orders',
                    icon: 'fa-tasks',
                    route: 'orders'
                }
            ];
        }
    },
    mounted() {
        this.$root.$on('toggle-admin-navigation-drawer', () => {
            this.show = !this.show;
        });
    }
};
</script>

<style scoped></style>
