<script lang='ts'>
	export let title: string, description: string | null, author: string | null = null, image: string | null;
</script>

<svelte:head>
	<title>{title ?? 'ARTS CENTER'}</title>
	{#if title}
		<meta property='og:title' content={title} />
		<meta itemprop='name' content={title} />
		<meta name='twitter:title' content={title} />
	{/if}

	{#if description}
		<meta name='description' property='og:description' content={description} />
		<meta name='twitter:description' content={description} />
	{/if}

	{#if image}
		<meta property='og:image' content={image} />
		<meta itemprop='image' content={image} />
		<meta name='twitter:image' content={image} />
	{/if}

	{#if author}
		<meta name='author' content={author} />
	{/if}
</svelte:head>