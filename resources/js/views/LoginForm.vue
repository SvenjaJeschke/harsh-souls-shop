<template>
    <v-card class="mx-auto mt-5" max-width="700">
        <v-card-title>Admin Login</v-card-title>
        <v-card-text>
            <v-form>
                <v-text-field
                    v-model="input.email"
                    label="E-Mail"
                    :error="!!errors.email"
                    :error-messages="errors.email"
                />
                <v-text-field
                    v-model="input.password"
                    label="Password"
                    counter
                    :type="showPassword ? 'text' : 'password'"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :error="!!errors.password"
                    :error-messages="errors.password"
                    @click:append="showPassword = !showPassword"
                />
            </v-form>
        </v-card-text>
        <v-card-actions>
            <v-spacer />
            <v-btn
                color="primary"
                @click="login"
                :loading="isLoading"
                :disabled="isLoading"
            >
                Login
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import {debounce} from "lodash";

export default {
    name: 'LoginForm',
    data() {
        return {
            input: {
                email: null,
                password: null
            },
            showPassword: false,
            isLoading: false,
            errors: []
        };
    },
    methods: {
        login() {
            this.isLoading = true;
            this.errors = [];
            this.$http
                .post('/login', this.input, {
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(() => {
                    //todo
                    location.reload();
                })
                .catch((error) => {
                    this.$root.$emit('snackbar', error.response.data.message);
                    this.errors = error.response.data.errors;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
};
</script>
