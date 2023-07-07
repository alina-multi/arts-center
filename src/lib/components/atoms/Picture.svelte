<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { User } from '@steeze-ui/heroicons';
	export let photo;
</script>

{#if photo}
	<picture>
		{#each photo.sources as { srcset, type}}
			<source {srcset} {type} />
		{/each}
		<img src={photo.src} alt=" username" class="w-12 h-12 object-cover" />
	</picture>
{:else}
	<Icon
		theme="solid"
		src={User}
		class="h-12 w-12 rounded-full fill-gray-300  p-[5px] border border-gray-300 dark:border-gray-700"
	/>
{/if}
