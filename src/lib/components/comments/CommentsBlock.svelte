<script lang="ts">
	import CommentBlock from './CommentBlock.svelte';
	import type { Comment } from '$lib/interfaces/Comment';

	export let comments: Comment[];
</script>

<div>
	<h3 class="sr-only">Comments</h3>
	{#each comments as comment}
		<CommentBlock {comment} />
	{/each}
</div>
