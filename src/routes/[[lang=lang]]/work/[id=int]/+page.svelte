<script lang="ts">
	import type { PageData } from './$types';
	import WorkPage from '$lib/components/work/WorkPage.svelte';
	import CommentsBlock from '$lib/components/comments/CommentsBlock.svelte';
	export let data: PageData;
</script>
{JSON.stringify(data.work.tags)}

<WorkPage work={data.work} comments={data.comments} />
