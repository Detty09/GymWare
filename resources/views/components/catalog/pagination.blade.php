@props(["exercises", "selectedBodypart", "selectedEquipment", "page"])

<div class="mt-6 flex justify-between">
    @if($exercises['metadata']['previousPage'])
        <a href="?page={{ $page - 1 }}&bodypart={{ $selectedBodypart }}&equipment={{ $selectedEquipment }}"
           class="bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Previous</a>
    @endif

    @if($exercises['metadata']['nextPage'])
        <a href="?page={{ $page + 1 }}&bodypart={{ $selectedBodypart }}&equipment={{ $selectedEquipment }}"
           class="bg-gray-100 px-4 py-2 rounded-lg hover:bg-gray-200">Next</a>
    @endif
</div>
