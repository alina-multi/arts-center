<script>
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';

	import WorkFilters from '$lib/components/filters/WorkFilters.svelte';
	import UserCard from '$lib/components/user/UserCard.svelte';

	export let user, gallery, params;

	let userTags = user.ratings.map((rating) => rating.tag);
</script>

<div class="flex gap-3">
	<div class=" w-1/4 rounded-md shadow-sm border">
		<UserCard {user} />
	</div>
	<div class="flex flex-col gap-3 w-3/4">
		<WorkFilters tags={userTags} {params} />

		<ul class=" grid grid-cols-3 gap-3">
			{#each gallery as work}
				<li>
					<ImageWork {work} withDesription />
				</li>
			{/each}
		</ul>
	</div>
</div>
