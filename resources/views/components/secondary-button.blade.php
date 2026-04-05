<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-ui btn-ui-md btn-ui-secondary']) }}>
    {{ $slot }}
</button>
