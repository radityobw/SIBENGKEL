@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-outline-variant dark:border-[#3E3E3A] bg-surface dark:bg-[#111111] text-on-surface dark:text-white placeholder:text-outline dark:placeholder:text-gray-600 focus:border-primary dark:focus:border-white focus:ring-primary rounded-md shadow-sm transition-colors']) }}>
