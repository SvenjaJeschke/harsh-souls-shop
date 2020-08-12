<template>
    <v-dialog v-model="show" persistent max-width="900">
        <template v-slot:activator="{ on: dialog }">
            <v-tooltip bottom>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn
                        v-if="user.id === currentUser.id"
                        icon
                        color="secondary"
                        v-on="{ ...tooltip, ...dialog }"
                    >
                        <v-icon small>fa-key</v-icon>
                    </v-btn>
                </template>
                Change Password
            </v-tooltip>
        </template>
        <v-card>
            <v-card-title>
                Change password
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="input.password"
                    label="New password"
                    counter
                    :type="showPassword ? 'text' : 'password'"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showPassword = !showPassword"
                />
                <v-text-field
                    v-model="input.oldPassword"
                    label="Old password"
                    counter
                    :type="showOldPassword ? 'text' : 'password'"
                    :append-icon="showOldPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append="showOldPassword = !showOldPassword"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    color="secondary"
                    :loading="isLoading"
                    :disabled="isLoading"
                    @click="save"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    name: 'ChangeUserPasswordButton',
    props: {
        currentUser: {
            type: Object,
            required: true,
            default: () => ({
                id: null
            })
        }
    },
    data() {
        return {
            show: false,
            input: {
                password: null,
                oldPassword: null
            },
            isLoading: false,
            showPassword: false,
            showOldPassword: false
        };
    },
    computed: {
        ...mapGetters(['checkAuth', 'user'])
    },
    methods: {
        save() {
            this.isLoading = true;
            this.$http
                .put(`/api/admin/auth-user/password`, this.input)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.close();
                })
                .catch((error) => {
                    this.$root.$emit('snackbar', error.response.data.message);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        close() {
            this.input = {
                password: null,
                oldPassword: null
            };
            this.showPassword = false;
            this.show = false;
        }
    }
};
</script>

<style scoped></style>
