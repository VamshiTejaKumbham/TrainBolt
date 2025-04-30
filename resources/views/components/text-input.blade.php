@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-black dark:border-white bg-white dark:bg-black text-black dark:text-white focus:border-black dark:focus:border-white focus:ring-black dark:focus:ring-white rounded-md shadow-sm']) }}>
