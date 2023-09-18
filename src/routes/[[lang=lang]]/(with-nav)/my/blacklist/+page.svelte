<script lang="ts">
	import BlockButton from '$lib/components/atoms/buttons/BlockButton.svelte';
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';

	export let data;
	let blacklist = data.blacklist;
</script>


	<div>
		<HeaderLayout title="Blocked users">
			<div slot="details" class="flex gap-3 items-center leading-3">
				<div class="h-1 w-1 bg-gray-500 dark:bg-zinc-300 rounded-full" />
				<span class=""> {blacklist.length} people </span>
			</div>
		</HeaderLayout>
	
		<div
			class="flex flex-col border-x -mt-1 border-b py-3 dark:border-t rounded-b-sm dark:border-zinc-800 dark:bg-zinc-900"
		>
		{#if blacklist?.length > 0}
			<ul class="lg:divide-y dark:lg:divide-zinc-800">
				{#each blacklist as user (user.id)}
					<li class="flex justify-between items-center gap-x-6 py-3 px-3 sm:px-9">
						<div>
							<UserPreview
								{user}
								avatar_size={'w-12 h-12'}
								crown_size={'w-3 h-3'}
								followButton={false}
							/>
						</div>

						<BlockButton type="unblock" user_id={user.id} bind:entity={blacklist} />
					</li>
				{/each}
			</ul>
			{:else}
			<p class="px-6 py-3 ">There are no users in your blacklist</p>
		{/if}
		</div>

	</div>

