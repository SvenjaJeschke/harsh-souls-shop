<template>
    <v-main>
        <admin-navigation-drawer />
        <navigation-header></navigation-header>
        <router-view></router-view>
        <alert-snackbar></alert-snackbar>
        <confirm-modal ref="confirm"></confirm-modal>
    </v-main>
</template>

<script>
import NavigationHeader from './components/NavigationHeader';
import AlertSnackbar from "./components/AlertSnackbar";
import AdminNavigationDrawer from "./components/AdminNavigationDrawer";
import ConfirmModal from "./components/ConfirmModal";

export default {
    name: 'App',
    components: {
        'navigation-header': NavigationHeader,
        'alert-snackbar': AlertSnackbar,
        'admin-navigation-drawer': AdminNavigationDrawer,
        'confirm-modal': ConfirmModal
    },
    mounted() {
        this.$root.$confirm = this.$refs.confirm.open;
    }
}
</script>
