<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-orange-600">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-100">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>
    </header>

    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <!-- Normal delete button -->
        <button
            id="delete-button"
            type="button"
            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:ring-2 focus:ring-red-500 transition"
        >
            {{ __('Delete Account') }}
        </button>

        <!-- Hidden confirm section -->
        <div id="confirm-delete" class="hidden mt-3 space-x-2">
            <span class="text-gray-100 text-sm">Are you sure?</span>

            <button
                type="submit"
                class="px-4 py-2 bg-red-700 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-red-800 focus:ring-2 focus:ring-red-500 transition"
            >
                {{ __('Confirm Delete') }}
            </button>

            <button
                type="button"
                id="cancel-delete"
                class="px-4 py-2 bg-gray-600 text-white rounded-md text-xs font-semibold uppercase tracking-widest hover:bg-gray-700 focus:ring-2 focus:ring-gray-400 transition"
            >
                {{ __('Cancel') }}
            </button>
        </div>
    </form>

    <script>
        const deleteBtn = document.getElementById('delete-button');
        const confirmSection = document.getElementById('confirm-delete');
        const cancelBtn = document.getElementById('cancel-delete');

        deleteBtn.addEventListener('click', () => {
            deleteBtn.classList.add('hidden');
            confirmSection.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            confirmSection.classList.add('hidden');
            deleteBtn.classList.remove('hidden');
        });
    </script>
</section>
