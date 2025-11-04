@props(["exercises", "selectedBodypart", "selectedEquipment", "page"])

<div class="mt-6 flex justify-between">
    @if($exercises['metadata']['previousPage'])
        <a href="?page={{ $page - 1 }}&bodypart={{ $selectedBodypart }}&equipment={{ $selectedEquipment }}"
           class="bg-transparent border border-orange-600 px-4 py-2 rounded-xl text-orange-600 hover:bg-orange-600 hover:text-black hover:scale-105 transition ease-in-out duration-100">
            <i class="fas fa-left-long"></i>
        </a>
    @endif

    @if($exercises['metadata']['nextPage'])
        <a href="?page={{ $page + 1 }}&bodypart={{ $selectedBodypart }}&equipment={{ $selectedEquipment }}"
           class="bg-transparent border border-orange-600 px-4 py-2 rounded-xl text-orange-600 hover:bg-orange-600 hover:text-black hover:scale-105 transition ease-in-out duration-100">
            <i class="fas fa-right-long"></i>
        </a>
    @endif
</div>
