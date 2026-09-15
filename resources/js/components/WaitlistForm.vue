<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ArrowUpRight, Check } from '@lucide/vue';
const props = withDefaults(defineProps<{ postcode?: string }>(), { postcode: '' });
const form = useForm({
    email: '',
    postcode: props.postcode,
    interest: 'subscription',
    consent: false,
    website: '',
});
function submit() {
    form.post('/waitlist', { preserveScroll: true, onSuccess: () => form.reset('email', 'consent') });
}
</script>
<template>
    <form class="waitlist-form" @submit.prevent="submit">
        <div v-if="form.wasSuccessful" class="success-panel" role="status">
            <Check :size="22" /> You’re on the list. Good things are cooking!
        </div>
        <div class="form-pair">
            <div class="field">
                <label for="launch-email">Email address</label
                ><input
                    id="launch-email"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    placeholder="you@example.com"
                    required
                    :aria-invalid="!!form.errors.email"
                /><span v-if="form.errors.email" class="field-error">{{ form.errors.email }}</span>
            </div>
            <div class="field postcode-field">
                <label for="launch-postcode">Postcode</label
                ><input
                    id="launch-postcode"
                    v-model="form.postcode"
                    inputmode="numeric"
                    pattern="[0-9]{4}"
                    maxlength="4"
                    autocomplete="postal-code"
                    placeholder="2000"
                    required
                /><span v-if="form.errors.postcode" class="field-error">{{ form.errors.postcode }}</span>
            </div>
        </div>
        <div class="field">
            <label for="launch-interest">What tickles your tastebuds?</label
            ><select id="launch-interest" v-model="form.interest">
                <option value="subscription">A regular sausage subscription</option>
                <option value="gift">Giving the gift of sausage</option>
                <option value="shop">Picking my own packs</option>
            </select>
        </div>
        <div class="honeypot" aria-hidden="true">
            <label for="website">Website</label
            ><input id="website" v-model="form.website" tabindex="-1" autocomplete="off" />
        </div>
        <label class="checkbox-label"
            ><input v-model="form.consent" type="checkbox" required /><span
                >Email me Wiener Box launch news. I can unsubscribe from any launch email.
                <a href="/privacy">Privacy notice</a>.</span
            ></label
        ><span v-if="form.errors.consent" class="field-error">{{ form.errors.consent }}</span>
        <button class="button primary" :disabled="form.processing">
            {{ form.processing ? 'Joining…' : 'Count me in' }}<ArrowUpRight :size="20" />
        </button>
    </form>
</template>
