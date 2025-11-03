<tr>
    <td class="border-1 px-4">
        {{ $i + 1 }}
    </td>
    <td class="border-1 px-4">
        <input type="number" name="weight[{{$id}}][]" min="0" required value="{{ old('weight.' . $id . '.0') }}"/>
    </td>
    <td class="border-1 px-4">
        <input type="number" name="reps[{{$id}}][]" min="0" required value="{{ old('reps.' . $id . '.0') }}"/>
    </td>
</tr>
