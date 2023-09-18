<script lang="ts">
	import UserPreview from '$lib/components/user/UserPreview.svelte';
	import HeaderLayout from '$lib/components/my/HeaderLayout.svelte';
	import FollowButton from '$lib/components/atoms/buttons/FollowButton.svelte';

	export let data;
	let followers = data.followers;
</script>

{#if followers?.length > 0}
	<div>
		<HeaderLayout title="Followers">
			<div slot="details" class="flex gap-3 items-center leading-3">
				<div class="h-1 w-1 bg-gray-500 dark:bg-zinc-300 rounded-full" />
				<span class=""> {followers.length} people </span>
			</div>
		</HeaderLayout>

		<div
			class="flex flex-col border-x -mt-1 border-b py-3 dark:border-t rounded-b-sm dark:border-zinc-800 dark:bg-zinc-900"
		>
			<ul class="lg:divide-y dark:lg:divide-zinc-800">
				{#each followers as user (user.id)}
					<li class="flex justify-between items-center gap-x-6 py-3 px-3 sm:px-9">
						<div>
							<UserPreview
								{user}
								avatar_size={'w-12 h-12'}
								crown_size={'w-3 h-3'}
								followButton={false}
							/>
						</div>

						<div><FollowButton {user} size="base" /></div>
					</li>
				{/each}
			</ul>
		</div>
	</div>
{:else}
	<h1>Your followers</h1>
	<p>You'll see all of the people who follow you here</p>
{/if}
