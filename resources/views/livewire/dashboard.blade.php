<div>

    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

    <div class="py-4 space-y-2">

        <div class="">

            <div class="w-1/4">

                <x-input.text wire:model.live.debounce="search" placeholder="Search..."/>

            </div>

        </div>

        <div class="flex-col space-y-2">

            <x-table>

                <x-slot name="head">

                    <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">Title </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('amount')" :direction="$sortField === 'amount' ? $sortDirection : null">Amount </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">Status </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('date')" :direction="$sortField === 'date' ? $sortDirection : null">Date </x-table.heading>

                </x-slot>

                <x-slot name="body">

                    @forelse ($transactions as $transaction)

                        <x-table.row>

                            <x-table.cell>

                                <span class="inline-flex space-x-2 truncate text-sm leading-5">

                                    <x-icon.cash class="text-gray-400 mr-2" />

                                    {{ $transaction->title }}

                                </span>

                            </x-table.cell>
                            <x-table.cell>

                                <span class="text-gray-900 font-medium">
                                    {{ $transaction->amount }}
                                </span>USD

                                {{ $transaction->amout }}</x-table.cell>
                            <x-table.cell class="">

                                <span class="inline-flex items-center px-2.5 py-1 rounded-full font-medium leading-4 bg-{{ $transaction->status_color }}-100 text-{{ $transaction->status_color }}-800 capitalize">
                                    {{ $transaction->status }}
                                </span>

                            </x-table.cell>
                            <x-table.cell>{{ $transaction->date_for_humans }}</x-table.cell>

                        </x-table.row>

                    @empty

                        <x-table.row>

                            <x-table.cell colspan="4">
                                <div class="flex justify-center items-center">
                                    <span class="py-8 text-xl text-gray-400 font-medium">No results.</span>
                                </div>
                            </x-table.cell>

                        </x-table.row>

                    @endforelse

                </x-slot>

            </x-table>

            <div>

                {{ $transactions->links() }}

            </div>

        </div>

    </div>

</div>
