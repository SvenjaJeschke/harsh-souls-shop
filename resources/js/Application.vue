<template>
    <v-main>
        <admin-navigation-drawer />
        <navigation-header />
        <router-view />
        <alert-snackbar />
        <confirm-modal ref="confirm" />
        <confirm-age-alert />
    </v-main>
</template>

<script>
import NavigationHeader from './components/NavigationHeader';
import AlertSnackbar from './components/AlertSnackbar';
import AdminNavigationDrawer from './components/AdminNavigationDrawer';
import ConfirmModal from './components/ConfirmModal';
import ConfirmAgeAlert from './components/ConfirmAgeAlert';

export default {
    name: 'App',
    components: {
        'navigation-header': NavigationHeader,
        'alert-snackbar': AlertSnackbar,
        'admin-navigation-drawer': AdminNavigationDrawer,
        'confirm-modal': ConfirmModal,
        'confirm-age-alert': ConfirmAgeAlert
    },
    mounted() {
        this.$root.$confirm = this.$refs.confirm.open;
    }
};
</script>
