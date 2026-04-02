@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'input input-bordered min-h-11 w-full rounded-2xl border-slate-200 bg-white text-sm text-slate-900 shadow-sm transition focus:border-green-600 focus:outline-none focus:ring-4 focus:ring-green-100']) }}>
