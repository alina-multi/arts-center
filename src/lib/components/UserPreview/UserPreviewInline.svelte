<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { UserCircle } from '@steeze-ui/heroicons';

	export let id: number, name: string, src: string, srcset: string;
</script>

<a
	href="#"
	class="group inline text-base pr-3 text-zinc-600 hover:text-zinc-500 dark:hover:text-zinc-400 dark:text-zinc-300"
>
	<div class="inline-flex items-center gap-2">
		{#if src}
			<img {src} {srcset} alt={name} class="flex-none h-10 w-10 rounded-full object-cover" />
		{:else}
			<Icon src={UserCircle} class="h-10 w-10 rounded-full stroke-zinc-600 dark:stroke-zinc-400" />
		{/if}
		<p>{name}</p>
	</div>
</a>
