<template>
    <v-snackbar
        v-model="show"
        :timeout="timeout"
        bottom
    >
        {{ text }}
        <template v-slot:action="{ attrs }">
            <v-btn
                color="secondary"
                text
                v-bind="attrs"
                @click="show = false"
            >
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script>
export default {
    name: "AlertSnackbar",
    data: () => ({
        show: false,
        text: null,
        timeout: 5000
    }),
    mounted() {
        this.$root.$on('open-alert-snackbar', (text) => {
            this.open(text);
        })
    },
    methods: {
        open(text) {
            this.text = text;
            this.show = true;
        }
    }
}
</script>

