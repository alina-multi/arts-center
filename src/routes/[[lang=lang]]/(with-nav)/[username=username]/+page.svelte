<script lang="ts">
	import type { PageData } from './$types';
	import ImageWork from '$lib/components/atoms/ImageWork.svelte';
	import MetaGroups from '$lib/components/MetaGroups.svelte';

	export let data: PageData;

	let user= data.user;
	let description = user.bio;
	let title = user.name;
	let image = user.photo.src;
	
</script>

<MetaGroups {title} {description} {image} />


<ul class=" grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
	{#each data.gallery as work}
		<li>
			<ImageWork {work} withDesription />
		</li>
	{/each}
</ul>

