@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-outline-variant bg-surface text-on-surface focus:border-primary focus:ring-primary rounded-md shadow-sm']) }}>
