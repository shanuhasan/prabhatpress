@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'h-11 rounded-xl border-slate-300 bg-white px-3.5 text-sm text-ink shadow-sm placeholder:text-slate-400 transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/15 disabled:bg-slate-50']) !!}>
