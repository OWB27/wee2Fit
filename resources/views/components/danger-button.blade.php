<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-error min-h-11 rounded-full border-0 px-5 text-sm font-semibold normal-case text-white shadow-sm transition hover:shadow']) }}>
    {{ $slot }}
</button>
