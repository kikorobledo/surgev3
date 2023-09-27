@props([
    'leadingAddOn' => false
])

<div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

    @if($leadingAddOn)

        <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm pr-2">
            {{ $leadingAddOn }}
        </span>

    @endif

    <input
        {{ $attributes }}
        class="{{ 'leadingAddOn' ? 'rounded-r-md' : '' }} block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 outline-indigo-600">

</div>
