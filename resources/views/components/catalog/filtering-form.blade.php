@props(["action", "bodyparts", "equipments", "selectedBodypart", "selectedEquipment"])

<form method="GET" action="{{ $action }}" class="mb-8 flex gap-4 items-center">
    <div>
        <label for="bodypart" class="block text-sm font medium text-gray-100 mb-1">Filter by Body Part:</label>
        <select
            name="bodypart"
            id="bodypart"
            class="border border-white/20 rounded-lg px-3 py-2 text-white bg-white/10 hover:border-orange-600 transition ease-in-out duration-100"
            onChange="this.form.submit()"
        >
            <option
                class="text-black"
                value="">All
            </option>
            @foreach($bodyparts as $bodypart)
                <option
                    class="text-black"
                    value="{{ $bodypart["name"] }}"
                    {{ $selectedBodypart === $bodypart["name"] ? "selected" : "" }}>
                    {{ ucfirst($bodypart["name"]) }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="equipment" class="block text-sm font medium text-gray-100 mb-1">Filter by Equipment:</label>
        <select
            name="equipment"
            id="equipment"
            class="border border-white/20 rounded-lg px-3 py-2 text-white bg-white/10 hover:border-orange-600 transition ease-in-out duration-100"
            onChange="this.form.submit()"
        >
            <option
                class="text-black"
                value="">All</option>
            @foreach($equipments as $equipment)
                <option
                    class="text-black"
                    value="{{ $equipment["name"] }}"
                    {{ $selectedEquipment=== $equipment["name"] ? "selected" : "" }}>
                    {{ ucfirst($equipment["name"]) }}
                </option>
            @endforeach
        </select>
    </div>
</form>
