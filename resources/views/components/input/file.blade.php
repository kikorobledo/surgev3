<div class="mt-2 flex items-center gap-x-3">

    {{ $slot }}

    <div
        x-data="{ focused: false }"
    >

        <input @focus="focused = true" @blur="focused = false" type="file" {{ $attributes }}  class="sr-only">

        <label for="{{ $attributes['id'] }}" :class="{ 'outline-none ring-blue-300 ring-2 shadow-outline-blue' : focused }" class="cursor-pointer rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</label>


    </div>

</div>
