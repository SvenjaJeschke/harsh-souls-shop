<template>
    <v-dialog v-model="showModal" persistent max-width="400">
        <v-card>
            <v-card-title>
                {{ title }}
            </v-card-title>
            <v-card-text>
                {{ text }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    color="primary"
                    @click="cancel"
                >
                    Cancel
                </v-btn>
                <v-btn
                    text
                    color="primary"
                    @click="confirm"
                >
                    Confirm
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "ConfirmModal",
    data() {
        return {
            showModal: false,
            title: null,
            text: null,
            resolve: null,
            reject: null
        }
    },
    methods: {
        open(title, text) {
            this.title = title;
            this.text = text;
            this.showModal = true;

            return new Promise((resolve, reject) => {
                this.resolve = resolve
                this.reject = reject
            })
        },
        cancel() {
            this.showModal = false;
            this.resolve(false);
        },
        confirm() {
            this.showModal = false;
            this.resolve(true);
        }
    }
}
</script>

<style scoped>

</style>
