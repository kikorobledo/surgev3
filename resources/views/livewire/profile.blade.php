<form wire:submit.prevent="save">

    <div class="space-y-12">
        {{ $errors }}
        <h2 class="text-3xl font-semibold leading-7 text-gray-900">Profile</h2>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <x-input.group label="Name" for="name" :error="$errors->first('name')">

                <x-input.text leading-add-on="surge.com/" wire:model.live="name" id="name" />

            </x-input.group>

            <x-input.group label="Birthday" for="birthday">

                <x-input.date wire:model.live="birthday" id="birthday" placeholder="MM/DD/YYYY" />

            </x-input.group>

            <x-input.group label="About" for="about" :error="$errors->first('about')" help-text="Write a few sentences about yourself.">

                <x-input.trix wire:model="about" id="about" :initialValue="$about" />

            </x-input.group>

            <x-input.group  label="Photo" for="file">

                <x-input.file wire:model="newAvatar" id="file" >

                    @if($newAvatar)

                        <img class="inline-block h-16 w-16 rounded-full" src="{{ $newAvatar->temporaryUrl() }}" alt="Profile photo">

                    @else

                        <img class="inline-block h-16 w-16 rounded-full" src="{{ auth()->user()->avatarUrl() }}" alt="Profile photo">

                    @endif

                </x-input.file>

            </x-input.group>

            <x-filepond wire:model="newAvatar" multiple></x-filepond>

        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">

            <div class="text-gray-500">

                <span
                    x-data = "{ open: false }"
                    x-init = "
                        @this.on('notify-saved', () => {

                            open = true;

                            setTimeout( () => { open = false }, 2500)

                        })
                    "
                    x-show="open"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90"
                    style = "display: none;"
                    x-ref = "this"
                >Saved!</span>

            </div>

            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>

            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>

          </div>

    </div>

</form>
