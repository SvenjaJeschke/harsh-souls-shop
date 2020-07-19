<template>
    <div>
        <navigation-header></navigation-header>
        <router-view></router-view>
    </div>
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
