<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-brand-600 px-5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:-translate-y-px hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-500/25 active:translate-y-0']) }}>
    {{ $slot }}
</button>
