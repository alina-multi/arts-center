<template>
  <button @click="toggleDark()" class="flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
    <SunIcon v-if="isDark" class="h-6 w-6" aria-hidden="true" />
    <MoonIcon v-else class="h-6 w-6" aria-hidden="true" />
  </button>
</template>

<script setup>
import { SunIcon, MoonIcon } from '@heroicons/vue/20/solid'
import { useDark, useToggle } from "@vueuse/core";
const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>