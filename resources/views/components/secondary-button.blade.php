<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-outline min-h-11 rounded-full border-slate-200 bg-white px-5 text-sm font-semibold normal-case text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50']) }}>
    {{ $slot }}
</button>
