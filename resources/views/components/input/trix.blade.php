@push('styles')

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

@endpush

@props([
    'initialValue' => '',
    'rows' => 3,
])


<div
    {{ $attributes }}
    x-data
    @trix-blur="$dispatch('input', event.target.value)"
    class="mt-2">

    <input id="x" type="hidden" value="{{ $initialValue }}">

    <trix-editor input="x" rows="{{ $rows }}" id="{{ $attributes['id'] }}" class="p-3 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset outline-transparent focus:ring-indigo-600 sm:text-sm sm:leading-6"></trix-editor>

</div>

@push('scripts')

    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

@endpush
