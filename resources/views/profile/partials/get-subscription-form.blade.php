
@if(!Auth::user()->subscription)
    <!-- Show "Get Subscription" if not subscribed -->
    <section id="subscription-section">
        <h2>Get subscription!</h2>
            <button id="subscribe" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Subscribe
            </button>
    </section>
    <!-- Show Payment info if subscribed -->
    <section id="payment-section" class="hidden">
        <h2>Manage Payment</h2>
        <form method="POST" action="{{ route('profile.subscribe') }}">
            @csrf
            @method('PATCH')

            <x-input-label for="card_number" :value="__('Card Number')" required />
            <x-text-input id="card_number" name="card_number" type="text"
                          inputmode="numeric" maxlength="19"
                          placeholder="1234 5678 9012 3456"
                          class="block mt-1 w-full" />

            <x-input-label for="expiry_date" :value="__('Expiration (MM/YY)')" required />
            <x-text-input id="expiry_date" name="expiry_date" type="text"
                          inputmode="numeric" maxlength="5"
                          placeholder="MM/YY"
                          class="block mt-1 w-full" />
            <p id="expiry_warning" class="text-red-600 text-sm mt-2 hidden">
                ⚠️ Your card appears to be expired.
            </p>
            <p id="invalid_date" class="text-red-600 text-sm mt-2 hidden">
                ⚠️ Your card date is invalid. Please enter a valid date in MM/YY format.
            </p>
            <x-input-label for="cvv" :value="__('CVV')" required />
            <x-text-input id="cvv" name="cvv" type="text"
                          inputmode="numeric"
                          maxlength="4" placeholder="123"
                          class="block mt-1 w-full" />

            <div>
                <x-primary-button class="mt-4">Pay</x-primary-button>
            </div>
        </form>

        <x-danger-button id="cancel">
            Cancel
        </x-danger-button>
    </section>
@endif
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const subscribe = document.getElementById('subscribe');
        const paymentForm = document.getElementById('payment-section');
        const subscriptionSection = document.getElementById('subscription-section');
        const cancelButton = document.getElementById('cancel');

        if(subscribe) {
            subscribe.addEventListener('click', () => {
                subscriptionSection.classList.add('hidden');
                paymentForm.classList.remove('hidden');
            });
        }
        if(cancelButton) {
            cancelButton.addEventListener('click', () => {
                subscriptionSection.classList.remove('hidden');
                paymentForm.classList.add('hidden');
            });
        }
    });
    document.getElementById('card_number').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim();
    });

    // Format CVV
    document.getElementById('cvv').addEventListener('input', e => {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // Expiry Date Validation
    document.getElementById('expiry_date').addEventListener('input', e => {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length > 2) val = val.substring(0, 2) + '/' + val.substring(2, 4);
        e.target.value = val;

        const match = val.match(/^(0[1-9]|1[0-2])\/(\d{2})$/);
        const warning = document.getElementById('expiry_warning');
        const invalid = document.getElementById('invalid_date');

        if (!match && val !== '') {
            warning.classList.add('hidden');
            return invalid.classList.remove('hidden');
        }
        if(match) {
            invalid.classList.add('hidden');
        }
        if(val === '') {
            invalid.classList.add('hidden');
        }

        const month = parseInt(match[1]);
        const year = parseInt('20' + match[2]);
        const today = new Date();
        const expired = year < today.getFullYear() ||
            (year === today.getFullYear() && month < (today.getMonth() + 1));

        warning.classList.toggle('hidden', !expired);
    });
</script>
