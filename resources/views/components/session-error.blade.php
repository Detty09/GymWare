@if (session('error'))
    <div class="m-2">
        <p class="text-red-600 text-center font-bold text-2xl">
            {{session('error')}}
        </p>
    </div>
@endif
