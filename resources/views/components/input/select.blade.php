@props([
    'placeholder' => null,
    'trailingAddOn' => null,
])

<div class="flex">

  <select {{ $attributes->merge(['class' => 'mt-1 p-1.5 flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md' . ($trailingAddOn ? ' rounded-r-none' : '')]) }}>

    @if ($placeholder)

        <option disabled value="">{{ $placeholder }}</option>

    @endif

    {{ $slot }}

  </select>

  @if ($trailingAddOn)

    {{ $trailingAddOn }}

  @endif

</div>
