<script setup lang="ts">
import { computed } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowUpRight, LockKeyhole } from '@lucide/vue';
import ProductImage from '../components/ProductImage.vue';
const props = defineProps<{
    mode: 'login' | 'register' | 'forgot' | 'reset';
    token?: string;
    email?: string;
}>();
const titles = {
    login: 'Hello again, sausage.',
    register: 'Join the good crowd.',
    forgot: 'Lost the secret sauce?',
    reset: 'A fresh start.',
};
const title = computed(() => titles[props.mode]);
const form = useForm({
    name: '',
    email: props.email ?? '',
    password: '',
    password_confirmation: '',
    remember: false,
    token: props.token ?? '',
});
const button = computed(
    () =>
        ({
            login: 'Sign in',
            register: 'Create account',
            forgot: 'Send reset link',
            reset: 'Set new password',
        })[props.mode],
);
function submit() {
    form.post(
        { login: '/login', register: '/register', forgot: '/forgot-password', reset: '/reset-password' }[
            props.mode
        ],
        { onFinish: () => form.reset('password', 'password_confirmation') },
    );
}
</script>
<template>
    <div class="container auth-page">
        <div class="auth-intro">
            <p class="eyebrow">YOUR LITTLE CORNER OF THE WURST.</p>
            <h1>{{ title }}</h1>
            <p>
                {{
                    mode === 'forgot'
                        ? 'Enter your email and we’ll send a link to reset your password.'
                        : mode === 'reset'
                          ? 'Choose a password with at least 12 characters.'
                          : 'Your boxes, your details, your good times. All in one place.'
                }}
            </p>
            <ProductImage slug="the-regular" name="The Big Wiener Club" sizes="270px" decorative />
        </div>
        <div class="auth-card">
            <LockKeyhole :size="24" />
            <h2>{{ button }}</h2>
            <form @submit.prevent="submit">
                <div v-if="mode === 'register'" class="field">
                    <label for="name">Your name</label
                    ><input id="name" v-model="form.name" autocomplete="name" maxlength="120" required />
                </div>
                <div class="field">
                    <label for="email">Email address</label
                    ><input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        required
                        :readonly="mode === 'reset'"
                    />
                </div>
                <div v-if="mode !== 'forgot'" class="field">
                    <label for="password">Password</label
                    ><input
                        id="password"
                        v-model="form.password"
                        type="password"
                        :autocomplete="mode === 'login' ? 'current-password' : 'new-password'"
                        :minlength="mode === 'login' ? undefined : 12"
                        required
                    /><span v-if="mode !== 'login'" class="small-note">At least 12 characters.</span>
                </div>
                <div v-if="mode === 'register' || mode === 'reset'" class="field">
                    <label for="password_confirmation">Confirm password</label
                    ><input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                    />
                </div>
                <div v-if="Object.keys(form.errors).length" class="field-error" role="alert">
                    <p v-for="(message, field) in form.errors" :key="field">{{ message }}</p>
                </div>
                <div v-if="mode === 'login'" class="auth-options">
                    <label class="checkbox-label"
                        ><input v-model="form.remember" type="checkbox" />Remember me</label
                    ><Link href="/forgot-password">Forgot password?</Link>
                </div>
                <button class="button primary full-width" :disabled="form.processing">
                    {{ form.processing ? 'One moment…' : button }}<ArrowUpRight :size="20" />
                </button>
            </form>
            <p class="auth-switch" v-if="mode === 'login'">
                New around here? <Link href="/register">Create an account</Link>
            </p>
            <p class="auth-switch" v-else><Link href="/login">Back to sign in</Link></p>
            <div class="auth-guest"><Link href="/shop">Just browsing? Carry on as a guest →</Link></div>
        </div>
    </div>
</template>
