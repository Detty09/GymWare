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

        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
            onclick="confirmDelete()"
        >
            {{ __('Delete Account') }}
        </button>
    </form>

    <script>
        function confirmDelete() {
            const confirmed = confirm("⚠️ Are you sure you want to permanently delete your account? This cannot be undone.");
            if (confirmed) {
                document.getElementById('delete-account-form').submit();
            }
        }
    </script>
</section>
