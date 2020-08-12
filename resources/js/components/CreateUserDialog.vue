<template>
    <v-dialog :value="value" persistent max-width="900">
        <v-card>
            <v-card-title>
                Create user
                <v-spacer />
                <v-btn icon @click="close">
                    <v-icon>fa-times</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    label="Username"
                    v-model="user.username"
                    :error="!!errorMessages.username"
                    :error-messages="errorMessages.username"
                />
                <v-text-field
                    label="E-Mail"
                    v-model="user.email"
                    :error="!!errorMessages.email"
                    :error-messages="errorMessages.email"
                />
                <v-text-field
                    v-model="user.password"
                    label="Password"
                    counter
                    :type="showPassword ? 'text' : 'password'"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :error="!!errorMessages.password"
                    :error-messages="errorMessages.password"
                    @click:append="showPassword = !showPassword"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    color="secondary"
                    :loading="isLoading"
                    :disabled="isLoading"
                    @click="create"
                >
                    Create user
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: 'CreateUserDialog',
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            user: {
                username: null,
                email: null,
                password: null
            },
            errorMessages: {},
            isLoading: false,
            showPassword: false
        };
    },
    methods: {
        close() {
            this.user = {
                username: null,
                email: null,
                password: null
            };
            this.errorMessages = {};
            this.showPassword = false;
            this.$emit('input', false);
        },
        create() {
            this.isLoading = true;
            this.errorMessages = {};
            this.$http
                .post(`/api/admin/users`, this.user)
                .then((response) => {
                    this.$root.$emit('snackbar', response.data.message);
                    this.close();
                    this.$emit('created');
                })
                .catch((error) => {
                    this.errorMessages = error.response.data.errors;
                    this.$root.$emit('snackbar', error.response.data.message);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>

<style scoped></style>
