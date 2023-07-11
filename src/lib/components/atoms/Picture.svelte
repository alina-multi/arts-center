<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { User } from '@steeze-ui/heroicons';
	export let photo;
	export let size = 'h-6 w-6';
</script>

{#if photo}
	<picture>
		{#each photo.sources as { srcset, type }}
			<source {srcset} {type} />
		{/each}
		<img src={photo.src} alt=" username" class="{size} object-cover" />
	</picture>
{:else}
	<Icon
		theme="solid"
		src={User}
		class="{size} rounded-full fill-gray-300  p-[5px] border border-gray-300 dark:border-gray-700"
	/>
{/if}
