<tr>
    <td class="border-1 text-center border-gray-500">
        {{ $i + 1 }}
    </td>
    <td class="border-1 border-gray-500">
        <input
            type="number"
            name="weight[{{$id}}][]"
            min="0"
            required value="{{ old('weight.' . $id . '.0') }}"
            class="w-full bg-white/20 focus:outline-none focus:ring-1 focus:ring-orange-600"
        />
    </td>
    <td class="border-1 border-gray-500">
        <input
            type="number"
            name="reps[{{$id}}][]"
            min="0"
            step="1"
            required value="{{ old('reps.' . $id . '.0') }}"
            class="w-full bg-white/20 focus:outline-none focus:ring-1 focus:ring-orange-600"
        />
    </td>
</tr>
