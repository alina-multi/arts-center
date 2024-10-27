<script lang="ts">
	import { getContext, onMount } from 'svelte';
	import AvatarLink from '$lib/components/atoms/AvatarLink.svelte';
	import { user } from '$lib/stores/auth';

	const t = getContext('t');

	export let isEditing: boolean | undefined = false,
		isReplying: boolean | undefined = false,
		onSubmit: (comment_id: string) => Promise<void>,
		commentID: string | undefined = undefined,
		value: string;
	commentID = commentID?.toString();
	let textarea: HTMLTextAreaElement;
	$: enabled = value.length > 3;

	onMount(() => {
		if (isReplying || isEditing) {
			textarea.focus();
		}
	});
</script>

<div class="flex flex-col gap-3 dark:border-zinc-800 mt-6">
	<div class="flex gap-3 w-full items-start">
		{#if !isEditing}
			<AvatarLink user={$user} size={'h-12 w-12'} />
		{/if}
		<form class="mx-auto w-full" method="POST" on:submit|preventDefault={() => onSubmit(commentID)}>
			<textarea
				bind:this={textarea}
				bind:value
				placeholder="{$t('global.comment.placeholder')}..."
				rows="2"
				class="block w-full text-black rounded-sm placeholder:text-sm font-medium placeholder:text-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-300 focus:ring-0 focus:border-zinc-400 dark:focus:border-zinc-500 border-zinc-300"
			/>

			<div class="flex flex-row-reverse mt-3 gap-3">
				<button
					class="border rounded-full {enabled
						? ' border-emerald-600  text-white bg-emerald-600 dark:text-zinc-200 border  hover:bg-emerald-500 hover:text-white hover:border-emerald-500 '
						: 'text-zinc-500 dark:text-zinc-200  dark:bg-zinc-800  border-zinc-300 bg-white '}  px-3 py-2 dark:border-0 text-sm font-semibold"
				>
					{isReplying
						? $t('global.comment.reply')
						: $t('global.comment.post') && !isEditing
							? $t('global.comment.post')
							: $t('global.buttons.save')}
				</button>

				<slot />
			</div>
		</form>
	</div>
</div>
