@if ($user->is_coach)
    <section>
        <header>
            <h2 class="text-lg font-medium text-orange-600">
                {{ __('Coach Bio') }}
            </h2>

            <p class="mt-1 text-sm text-gray-100">
                {{ __("Update your coach bio to let others know about your experience and specialties.") }}
            </p>
        </header>

        <form method="POST" action="{{ route('profile.updateBio') }}" class="mt-6 space-y-6">
        @csrf
            @method('patch')

            <div>
                <x-input-label for="bio" :value="__('Your Bio')" />
                <textarea id="bio" name="bio" rows="4"
                          class="block w-full mt-1 border px-2 py-1 border-white/20 rounded-md shadow-sm text-sm focus:outline-none focus:ring-1 focus:ring-orange-600"
                          placeholder="Write a short description of your coaching experience...">{{ old('bio', $coach->bio ?? '') }}</textarea>
                <x-input-error :messages="$errors->get('bio')" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save Bio') }}</x-primary-button>

                @if (session('status') === 'bio-updated')
                    <p class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </section>
@endif
