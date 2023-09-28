<div>

    <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>

    <div class="py-4 space-y-2">

        <div class="flex justify-between">

            <div class="w-1/4 flex space-x-4">

                <x-input.text wire:model.live.debounce="filters.search" placeholder="Search..."/>

                <x-button.link wire:click="$toggle('showFilters')">

                    @if ($showFilters)

                        <span>Hide</span>

                    @else

                        <span>Advanced search...</span>

                    @endif

                </x-button.link>

            </div>

            <div>

                <x-button.primary wire:click="$toggle('showDeleteModal')" class="bg-red-500"><x-icon.plus />Delete</x-button.primary>
                <x-button.primary wire:click="create"><x-icon.plus />New</x-button.primary>

            </div>

        </div>

        <div>

            @if($showFilters)

                <div class="bg-white p-4 rounded shadow-inner flex relative">

                    <div class="w-1/2 pr-2 space-y-4">

                        <x-input.group inline for="filter-status" label="Status">

                            <x-input.select id="filter-status" wire:model.live="filters.status">

                                <option value="" selected>Select an aoption</option>

                                @foreach (App\Models\Transaction::STATUSES as $key => $status)

                                    <option value="{{ $key }}">{{  $status }}</option>

                                @endforeach

                            </x-input.select>

                        </x-input.group>

                        <x-input.group inline for="filter-amount-min" label="Minimum Amount">

                            <x-input.money id="filter-amount-min" wire:model.live="filters.amount-min" />

                        </x-input.group>

                        <x-input.group inline for="filter-amount-max" label="Maximum Amount">

                            <x-input.money id="filter-amount-max" wire:model.live="filters.amount-max" />

                        </x-input.group>

                    </div>

                    <div class="w-1/2 pr-2 space-y-4">

                        <x-input.group inline for="filter-date-min" label="Minimum Date">

                            <x-input.date id="filter-date-min" wire:model.live="filters.date-min" placeholder="DD/MM/YYYY"/>

                        </x-input.group>

                        <x-input.group inline for="filter-date-max" label="Maximum Date">

                            <x-input.date id="filter-date-max" wire:model.live="filters.date-max" placeholder="DD/MM/YYYY"/>

                        </x-input.group>

                    </div>

                    <x-button.link class="absolute right-0 bottom-0 p-4" wire:click="resetFilters">Reset Filters</x-button.link>

                </div>

            @endif

        </div>

        <div class="flex-col space-y-2">

            <x-table>

                <x-slot name="head">
                    <x-table.heading class="p-0 w-1"><x-input.checkbox wire:model.live="selectPage" /></x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">Title </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('amount')" :direction="$sortField === 'amount' ? $sortDirection : null">Amount </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('status')" :direction="$sortField === 'status' ? $sortDirection : null">Status </x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('date')" :direction="$sortField === 'date' ? $sortDirection : null" >Date </x-table.heading>
                    <x-table.heading></x-table.heading>

                </x-slot>

                <x-slot name="body">

                    @if ($selectPage)

                        <x-table.row wire:key="row-selection"  class="bg-gray-200">

                            <x-table.cell colspan="7">

                                @unless ($selectAll)

                                    <div>

                                        <span>You have selected <strong>{{ $transactions->count() }}</strong> transactions, do you want to select all <strong>{{ $transactions->total() }}?</strong></span>

                                        <x-button.link class="ml-2 text-blue-500" wire:click="selectAllItems">Select all</x-button.link>

                                    </div>

                                @else

                                    <div>

                                        <span>You are selecting all <strong>{{ $transactions->total() }} transactions.</strong></span>

                                    </div>

                                @endunless

                            </x-table.cell>

                        </x-table.row>

                    @endif

                    @forelse ($transactions as $transaction)

                        <x-table.row wire:key="row-{{ $transaction->id }}">

                            <x-table.cell class="p-0">

                                <x-input.checkbox wire:model.live="selected" value="{{ $transaction->id }}" />

                            </x-table.cell>

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
                            <x-table.cell>

                                <x-button.link wire:click="edit({{ $transaction->id }})">Edit</x-button.link>

                            </x-table.cell>

                        </x-table.row>

                    @empty

                        <x-table.row>

                            <x-table.cell colspan="7">
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

    <x-modal.dialog wire:model="showEditModal">

        <x-slot name="title">Edit Transaction</x-slot>

        <x-slot name="content">

            <x-input.group for="title" label="Title" :error="$errors->first('editing.title')" >

                <x-input.text id="title" wire:model="editing.title" />

            </x-input.group>

            <x-input.group for="amount" label="Amount" :error="$errors->first('editing.amount')" >

                <x-input.money id="amount" wire:model="editing.amount" />

            </x-input.group>

            <x-input.group for="status" label="Status" :error="$errors->first('editing.status')" >

                <x-input.select id="status" wire:model="editing.status" >

                    <option value="">Select an option</option>

                    @foreach (App\Models\Transaction::STATUSES as $key => $status)

                        <option value="{{ $key }}">{{ $status }}</option>

                    @endforeach

                </x-input.select>

            </x-input.group>

            <x-input.group for="date" label="Date" :error="$errors->first('date')" >

                <x-input.date id="date" wire:model="date" />

            </x-input.group>

        </x-slot>

        <x-slot name="footer">

            <x-button.secondary>Cancel</x-button.secondary>

            <x-button.primary wire:click="save">Save</x-button.primary>

        </x-slot>

    </x-modal>

    <x-modal.confirmation wire:model="showDeleteModal">

        <x-slot name="title">Delete transaction</x-slot>

        <x-slot name="content">Are you sure you want to delete the informaction?</x-slot>

        <x-slot name="footer">

            <x-button.secondary wire:click="$toggle('showDeleteModal')">Cancel</x-button.secondary>

            <x-button.primary wire:click="delete">Delete</x-button.primary>

        </x-slot>

    </x-modal.confirmation>

</div>
