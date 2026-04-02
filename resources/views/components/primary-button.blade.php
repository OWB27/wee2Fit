<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary min-h-11 rounded-full border-0 px-5 text-sm font-semibold normal-case shadow-sm transition hover:shadow']) }}>
    {{ $slot }}
</button>
