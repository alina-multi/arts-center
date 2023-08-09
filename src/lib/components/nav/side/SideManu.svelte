<div class="container mx-auto px-3 flex flex-col xl:flex-row max-xl:gap-3 mt-3 dark:text-white">
  <div class="xl:w-3/12 border dark:bg-zinc-900 dark:border-zinc-800 rounded-md">
    <slot name="nav" />
  </div>
  <main class="flex flex-col gap-3 xl:pl-3 xl:w-9/12">
    <slot />
  </main>
</div>