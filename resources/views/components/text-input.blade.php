@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'placeholder' => '',
    'type' => 'text',
    'disabled' => false,
])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}"
        placeholder="{{ $placeholder }}" name="{{ $name }}" value="{{ $value }}"
        {{ $disabled ? 'disabled' : '' }}>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
