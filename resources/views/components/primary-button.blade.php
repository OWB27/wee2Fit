<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-ui btn-ui-md btn-ui-primary']) }}>
    {{ $slot }}
</button>
