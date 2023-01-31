<script lang="ts">
	import { Icon } from '@steeze-ui/svelte-icon';
	import { HandThumbDown, HandThumbUp } from '@steeze-ui/heroicons';
	export let allowDown: boolean, rating: number, dislikes: number, showVotedPreview: boolean, isLiked: boolean, isDisliked: boolean, usersList: any;

	let isModalOpen = false;

	const onLike = () => {
		if (showVotedPreview && isLiked) {
			return;
		}

		if (showVotedPreview) {
			rating++;
			isLiked = true;
			return;
		}

		if (isLiked) {
			rating--;
			isLiked = false;
			return;
		}
		if (isDisliked) {
			dislikes--;
			isDisliked = false;
		}

		rating++;
		isLiked = true;
	};

	const onDislike = () => {
		if (isDisliked) {
			dislikes--;
			isDisliked = false;
			return;
		}
		if (isLiked) {
			rating--;
			isLiked = false;
		}
		dislikes++;
		isDisliked = true;
	};
</script>

<div
	class="inline-flex items-center gap-3 dark:text-zinc-100 cursor-pointer 
    {showVotedPreview
		? ''
		: 'dark:border dark:border-zinc-500 dark:bg-zinc-900 px-3 py-1 rounded-full'}"
>
	{#if showVotedPreview}
		
			{#if !isLiked}
				<span on:click={onLike}>
					<Icon src={HandThumbUp} class="w-6 h-6 hover:text-green-600 active:animate-ping" />
				</span>
			{/if}

			{#if rating > 0}
				<span
					on:click={() => (isModalOpen = true)}
					class="hover:underline {isLiked ? 'text-green-600' : ''}">
					{rating.toLocaleString('ru-RU')}
				</span>

        <div class="inline-flex -space-x-2 ">
            {#each usersList as user}
			<a href={user.userPage}
				><img
					class="inline-block h-10 w-10 rounded-full border border-zinc-100"
					src={user.avatar}
					alt='Avatar {user.name}'
				/>
            </a>
            {/each}
          
		</div> 
        {/if}
	{:else}

<div class="flex items-center gap-2"> 
		<span on:click={onLike}>
			<Icon
				src={HandThumbUp}
				class=" w-6 h-6 active:text-green-600 hover:scale-125 {isLiked ? 'text-green-600' : ''}"
			/></span
		>
		{#if rating > 0}
			<span>{rating.toLocaleString('ru-RU')}</span>
		{/if}
	</div>

	{#if allowDown}
    <div class="flex items-center gap-2"> 
		<span on:click={onDislike}>
			<Icon
				src={HandThumbDown}
				class="w-6 h-6  hover:scale-105 active:text-red-600 {isDisliked ? 'text-red-600' : ''}"
			/></span
		>
		{#if dislikes > 0}
			<span>{dislikes.toLocaleString('ru-RU')}</span>
		{/if}
    </div>
	{/if}
    {/if}

</div>

{#if isModalOpen}
	<h1 class="dark:text-white">Modal</h1>
{/if}
