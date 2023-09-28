<div class="mt-1 relative flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">

        <span class="text-gray-500 sm:leading-5">
            $
        </span>

    </div>

    <input {{ $attributes }} class="block w-full flex-1 border-0 bg-transparent py-1.5 pr-5 pl-8 text-gray-900 placeholder:text-gray-400 focus:ring-0 ring-1 ring-inset ring-gray-300 sm:text-sm sm:leading-6 outline-indigo-600" placeholder="0.00" aria-describedby="price-currency">

    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">

        <span class="text-gray-500 sm:leading-5" id="price-currency">
            USD
        </span>

    </div>

</div>
