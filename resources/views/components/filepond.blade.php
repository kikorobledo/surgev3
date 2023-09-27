@push('styles')

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet"
    />

@endpush

    <div
        x-data
        x-init="

            FilePond.registerPlugin(FilePondPluginImagePreview);

            FilePond.setOptions({

                allowMultiple: {{ isset( $attributes['multiple'] )  ? 'true' : 'false' }},

                server: {

                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {

                        @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)

                    },

                    revert: (fileName, load, error) => {

                        @this.removeUpload('{{ $attributes['wire:model'] }}', fileName, load)

                    }

                },

            });

            FilePond.create($refs.input);

        "
        class="sm:col-span-4"
        wire:ignore
        >

        <input type="file" x-ref="input">

    </div>

@push('scripts')

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

@endpush
