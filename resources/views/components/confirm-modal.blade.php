@props(['question' => 'Are you sure?', 'confirm' => 'Yes', 'cancel' => 'No'])

<div id="confirmModal"
     class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="text-gray-100 bg-[#141414] border border-white/20 py-5 rounded-xl w-80 text-center text-wrap">
        <p class="mb-4 text-lg">{{$question}}</p>
        <div class="flex justify-center gap-4">
            <button onclick="confirmDelete()"
                    class="bg-red-600 hover:bg-red-400 px-4 py-2 rounded-lg">
                {{$confirm}}
            </button>
            <x-button type="button"
                      onclick="closeConfirmModal()"
                      class="justify-center bg-transparent border border-orange-600 hover:border-orange-500 hover:bg-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                {{$cancel}}
            </x-button>
        </div>
    </div>
</div>

<script>
    let currentForm = null;

    function openConfirmModal(event) {
        event.preventDefault();
        currentForm = event.target.closest('form');
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function confirmDelete() {
        if (currentForm) {
            currentForm.submit();
        }
    }
</script>
