@extends('layouts.guest')

@section('title', 'Register')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                          name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                          name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Coach Checkbox -->
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_coach" id="is_coach" value="1"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ms-2 text-gray-700">Are you a coach?</span>
            </label>
        </div>

        <!-- Coach Bio -->
        <div id="coach_bio" class="mt-4 hidden">
            <x-input-label for="bio" :value="__('Coach Bio')" />
            <textarea name="bio" id="bio" rows="4"
                      class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
        </div>

        <!-- Subscription -->
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="subscription" id="subscription" value="1"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ms-2 text-gray-700">Subscribe to premium membership</span>
            </label>
        </div>

        <!-- Payment Section -->
        <div id="payment-section" class="mt-4 hidden">
            <h3 class="font-semibold text-lg text-gray-800 mb-2">Payment Information</h3>

            <!-- Card Number -->
            <div class="mb-3">
                <x-input-label for="card_number" :value="__('Card Number')" />
                <x-text-input id="card_number" name="card_number" type="text"
                              inputmode="numeric" maxlength="19"
                              placeholder="1234 5678 9012 3456"
                              class="block mt-1 w-full" />
            </div>

            <!-- Expiration -->
            <div class="mb-3">
                <x-input-label for="expiry_date" :value="__('Expiration (MM/YY)')" />
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
            </div>

            <!-- CVV -->
            <div class="mb-3 w-1/2">
                <x-input-label for="cvv" :value="__('CVV')" />
                <x-text-input id="cvv" name="cvv" type="text"
                              inputmode="numeric"
                              maxlength="4" placeholder="123"
                              class="block mt-1 w-full" />
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        // Show/hide Coach Bio
        const coachCheckbox = document.getElementById('is_coach');
        const bioDiv = document.getElementById('coach_bio');
        coachCheckbox.addEventListener('change', () => {
            bioDiv.classList.toggle('hidden', !coachCheckbox.checked);
        });

        // Show/hide Payment Section
        const subCheckbox = document.getElementById('subscription');
        const paymentSection = document.getElementById('payment-section');
        subCheckbox.addEventListener('change', () => {
            paymentSection.classList.toggle('hidden', !subCheckbox.checked);
        });

        // Format Card Number
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
@endsection
