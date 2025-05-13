@props(['type' => 'submit'])

<button type="{{ $type }}" class="btn btn-warning" name="submit">
    {{ $slot }}
</button>
