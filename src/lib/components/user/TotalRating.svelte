<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { Star } from '@steeze-ui/heroicons';
	export let user, full;
</script>

{#if user?.rating}
	<div class="flex items-center {full ? 'gap-1 font-semibold' : ''} ">
		<Icon src={Star} theme="solid" class="  w-[16px] fill-amber-600 stroke-amber-600 " />
		{#if full} <span>Total rating: </span> {/if}
		<span> {user.rating}</span>
	</div>
{/if}
