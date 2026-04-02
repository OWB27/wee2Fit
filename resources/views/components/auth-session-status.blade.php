@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success rounded-2xl border border-green-200 bg-green-50 text-sm text-green-800']) }}>
        <span>{{ $status }}</span>
    </div>
@endif
