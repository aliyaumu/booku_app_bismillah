@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500 transition-colors'
            : 'group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700/50 hover:text-gray-900 dark:hover:text-white transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <i class="ti {{ $icon }} {{ ($active ?? false) ? 'text-amber-600 dark:text-amber-500' : 'text-gray-400 dark:text-slate-500 group-hover:text-gray-500 dark:group-hover:text-slate-400' }} flex-shrink-0 -ml-1 mr-3 h-6 w-6 text-xl flex items-center justify-center transition-colors"></i>
    <span class="truncate">
        {{ $slot }}
    </span>
</a>
