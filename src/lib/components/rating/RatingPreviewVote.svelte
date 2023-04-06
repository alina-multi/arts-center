<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbDown, HandThumbUp, Heart } from '@steeze-ui/heroicons';

	export let allowDownVote: boolean,
		rating: number,
		showVotedPreview: boolean,
		typeOfVote: boolean | null,
		usersList: any;

	let isModalOpen = false;
	let type = typeOfVote;

	const onVote = (value) => {
		if (value === 'like' && type === 'like') {
			return;
		}
		if (value === 'dislike' && type === 'dislike') {
			return;
		}
		if ((value === 'like' && !type) || (value === 'like' && type === 'dislike')) {
			rating++;
			type = 'like';
			return;
		}

		if ((value === 'dislike' && !type) || (value === 'dislike' && type === 'like')) {
			rating--;
			type = 'dislike';
			return;
		}
	};

	const onSwitch = () => {
		if (!type) {
			onVote('like');
			return;
		}
		if (type === 'like') {
			onVote('dislike');
			return;
		}

		if (type === 'dislike') {
			onVote('like');
			return;
		}
	};
</script>

<div
	class="inline-flex items-center gap-2 dark:text-zinc-100 cursor-pointer 
    {showVotedPreview
		? ''
		: 'dark:border dark:border-zinc-500 dark:bg-zinc-900 rounded-full dark:px-2  dark:py-1'}"
>
	{#if allowDownVote}
		<div class="flex items-center gap-2">
			<span on:click={() => onVote('like')}>
				<Icon
					src={HandThumbUp}
					theme={type === 'like' ? 'solid' : 'outline'}
					class=" w-5 h-5 active:text-sky-700 hover:scale-125 hover:text-sky-700 {type === 'like'
						? 'fill-sky-600'
						: ''}"
				/></span
			>
			{#if rating}
				<span>{rating.toLocaleString('ru-RU')}</span>
			{/if}
		</div>
		<div class="flex items-center gap-2">
			<span on:click={() => onVote('dislike')}>
				<Icon
					src={HandThumbDown}
					class="w-5 h-5  hover:scale-105 {type === 'dislike' ? 'text-red-600' : ''}  "
				/></span
			>
		</div>
	{:else}
		<span on:click={() => onSwitch()}>
			<Icon
				src={Heart}
				class="w-7 h-7 hover:text-red-600 {type === 'like'
					? 'fill-red-600 stroke-red-600'
					: 'active:animate-ping '}"
			/>
		</span>
		{#if rating}
			<span on:click={() => (isModalOpen = true)} class="hover:underline ">
				{rating.toLocaleString('ru-RU')}
			</span>
		{/if}

		{#if showVotedPreview && rating}
			<div class="flex -space-x-2 ">
				{#each usersList as user}
					<a href={user.userPage}
						><img
							class="inline-block rounded-full border border-zinc-100 h-8 w-8"
							src={user.avatar}
							alt="Avatar {user.name}"
						/>
					</a>
				{/each}
			</div>
		{/if}
	{/if}
</div>

{#if isModalOpen}
	<h1 class="dark:text-white">Modal</h1>
{/if}
