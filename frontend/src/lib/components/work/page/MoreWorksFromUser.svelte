<script lang="ts">
	import Picture from '$lib/components/atoms/Picture.svelte';
	export let user, works;
</script>

<div class=" space-y-6 bg-zinc-60 mt-6 px-6 lg:px-9">
	<p class="font-bold">More from <span class="underline">{user.name}</span></p>

	<div class="grid grid-cols-3 lg:grid-cols-6 gap-3">
		{#each works as photo}
			<div class=" aspect-1 overflow-hidden">
				<Picture
					{photo}
					alt="Thumbnail"
					class="w-full h-full object-cover cursor-pointer hover:opacity-80"
				/>
			</div>
		{/each}
	</div>
</div>
