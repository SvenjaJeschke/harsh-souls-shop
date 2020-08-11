<template>
    <v-dialog
        :value="showDialog"
        persistent
        max-width="600"
        overlay-opacity="1"
        overlay-color="black"
    >
        <div
            class="secondary--text"
            style="font-size: 60pt; text-align: center;"
        >
            18+
        </div>
        <v-card>
            <v-card-text class="pt-4 subtitle-1">
                Disclaimer: This page contains documents with adult language and
                content. It is not suitable for anyone under the age of 18 and
                may not be suitable for all adult readers. View at your
                discretion. By clicking OK you confirm that you are over the age
                of 18.
            </v-card-text>
            <v-card-actions class="pt-0 mt-0">
                <v-spacer />
                <v-btn text color="secondary" @click="confirm">Ok</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'ConfirmAgeAlert',
    data() {
        return {
            showDialog: false
        };
    },
    created() {
        this.checkConfirmOrOpen();
    },
    methods: {
        checkConfirmOrOpen() {
            let hasConfirmed = localStorage.getItem('hasConfirmed');
            if (hasConfirmed) {
                return;
            }
            this.showDialog = true;
        },
        confirm() {
            this.showDialog = false;
            localStorage.setItem('hasConfirmed', 'true');
        }
    }
};
</script>

<style scoped></style>
