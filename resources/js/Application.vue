<template>
    <v-main>
        <navigation-header></navigation-header>
        <router-view></router-view>
        <alert-snackbar></alert-snackbar>
    </v-main>
</template>

<script>
import NavigationHeader from './components/NavigationHeader';
import AlertSnackbar from "./components/AlertSnackbar";

export default {
    name: 'App',
    components: {
        'navigation-header': NavigationHeader,
        'alert-snackbar': AlertSnackbar
    }
}
</script>
