<script lang="ts">

	import { user as currentUser, isUserLoading } from '$lib/stores/auth';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { ChatBubbleOvalLeftEllipsis } from '@steeze-ui/heroicons';
	import { localePath } from '$lib/translations';
	import { getContext } from 'svelte';
	const locale = getContext('locale');
</script>

{#if !$isUserLoading}

	<a href={localePath($locale, `/my/thread`)}>
		<Icon src={ChatBubbleOvalLeftEllipsis} class="h-8 w-8 stroke-1" /></a>
{/if}


