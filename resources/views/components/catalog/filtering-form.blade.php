@props(["action", "bodyparts", "equipments", "selectedBodypart", "selectedEquipment"])

<form method="GET" action="{{ $action }}" class="mb-8 flex gap-4 items-center">
    <div>
        <label for="bodypart" class="block text-sm font medium text-gray-700 mb-1">Filter by Body Part:</label>
        <select
            name="bodypart"
            id="bodypart"
            class="border border-gray-300 rounded-lg px-3 py-2"
            onChange="this.form.submit()"
        >
            <option value="">All</option>
            @foreach($bodyparts as $bodypart)
                <option
                    value="{{ $bodypart["name"] }}"
                    {{ $selectedBodypart === $bodypart["name"] ? "selected" : "" }}>
                    {{ ucfirst($bodypart["name"]) }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="equipment" class="block text-sm font medium text-gray-700 mb-1">Filter by Equipment:</label>
        <select
            name="equipment"
            id="equipment"
            class="border border-gray-300 rounded-lg px-3 py-2"
            onChange="this.form.submit()"
        >
            <option value="">All</option>
            @foreach($equipments as $equipment)
                <option
                    value="{{ $equipment["name"] }}"
                    {{ $selectedEquipment=== $equipment["name"] ? "selected" : "" }}>
                    {{ ucfirst($equipment["name"]) }}
                </option>
            @endforeach
        </select>
    </div>
</form>
