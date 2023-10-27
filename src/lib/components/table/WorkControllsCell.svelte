<script lang='ts'>
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Pencil, Eye } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';

	export let id: number;
	export let status: number;
</script>
<div class="flex items-center max-xs:gap-6 flex-col xs:flex-row gap-3">
	<a href={localePath(`/my/work/${id}/form`)}>
		<Icon src={Pencil} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />
	</a>
	{#if status>20}
		<a href={localePath(`/work/${id}`)}>
			<Icon src={Eye} theme="solid" class="h-5 w-5 inline" aria-hidden="true" />
		</a>
	{/if}
	
</div>