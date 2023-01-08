<template>
  <nuxt-link :args="props" class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium"
             :class="getClass">
    <slot/>
  </nuxt-link>
</template>

<script setup lang="ts">
import NuxtLink from "#app/components/nuxt-link";

const props = defineProps({
  ...NuxtLink.props, // pass all the nuxt-link props
  exact: Boolean
})

const link = useLink({to: props.to})

const getClass = computed(() => {
  const linkProp = props.exact ? 'isExactActive' : 'isActive'
  return link[linkProp].value === true ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
})
</script>