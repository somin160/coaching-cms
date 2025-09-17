<div
    wire:ignore
    x-data
    x-init="
        ClassicEditor
            .create($refs.editor, {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'blockQuote', 'insertTable', 'undo', 'redo', '|',
                    'bulletedList', 'numberedList', 'outdent', 'indent'
                ]
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    $wire.set('{{ $getStatePath() }}', editor.getData());
                });
            })
            .catch(error => console.error(error));
    "
>
    <textarea x-ref="editor">{!! $getState() !!}</textarea>
</div>

@once
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    @endpush
@endonce
