<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import { MapPin, ArrowUpRight } from '@lucide/vue';
import WaitlistForm from '../components/WaitlistForm.vue';
const postcode = ref('');
const loading = ref(false);
const error = ref('');
const result = ref<{ message: string; planned: boolean; suburb: string | null } | null>(null);
async function check() {
    loading.value = true;
    error.value = '';
    result.value = null;
    try {
        result.value = (await axios.post('/delivery/check', { postcode: postcode.value })).data;
    } catch (e) {
        error.value =
            axios.isAxiosError(e) && e.response?.status === 422
                ? 'Enter a four-digit Australian postcode.'
                : 'We couldn’t check that just now. Please try again shortly.';
    } finally {
        loading.value = false;
    }
}
</script>
<template>
    <div class="container section">
        <div class="delivery-grid">
            <div>
                <p class="eyebrow">LET’S SEE WHERE YOU’RE AT.</p>
                <h1>Good times,<br /><span class="brand-underline">closer to home.</span></h1>
                <p class="page-intro">
                    Sydney, you’re first on our list. We’re planning our chilled delivery routes and want to
                    know where you’d like us to land.
                </p>
                <form @submit.prevent="check" class="postcode-check">
                    <label for="delivery-postcode">Your postcode</label>
                    <div>
                        <input
                            id="delivery-postcode"
                            v-model="postcode"
                            inputmode="numeric"
                            autocomplete="postal-code"
                            maxlength="4"
                            pattern="[0-9]{4}"
                            placeholder="2000"
                            required
                        /><button class="button primary" :disabled="loading">
                            {{ loading ? 'Checking…' : 'Check postcode' }}<ArrowUpRight :size="20" />
                        </button>
                    </div>
                </form>
                <p v-if="error" class="field-error" role="alert">{{ error }}</p>
                <div v-if="result" class="delivery-result" role="status">
                    <MapPin :size="24" />
                    <div>
                        <strong>{{
                            result.planned
                                ? `${result.suburb}: on our proposed route.`
                                : 'Help us get your area on the map.'
                        }}</strong>
                        <p>{{ result.message }}</p>
                    </div>
                </div>
                <p class="small-note">
                    Delivery isn’t open yet. A postcode result is a planning indication, not a delivery
                    guarantee.
                </p>
            </div>
            <aside class="delivery-signup">
                <p class="eyebrow">SAVE YOUR SPOT.</p>
                <h2>Put your hand up.</h2>
                <p>Leave your details for news about our launch.</p>
                <WaitlistForm :key="result ? postcode : 'initial'" :postcode="result ? postcode : ''" />
            </aside>
        </div>
    </div>
</template>
