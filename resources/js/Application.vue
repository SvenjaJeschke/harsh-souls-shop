<template>
    <v-main>
        <navigation-header></navigation-header>
        <router-view></router-view>
    </v-main>
</template>

<script>
import NavigationHeader from './components/NavigationHeader';

export default {
    name: 'App',
    components: {
        'navigation-header': NavigationHeader
    }
}
</script>
