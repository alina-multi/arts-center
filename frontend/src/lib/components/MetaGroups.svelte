<script lang="ts">
	import { page } from '$app/stores';

	export let title: string,
		description: string | null,
		author: string | null = null,
		image: string | null,
		rss: string | null,
		atom: string | null;
</script>

<svelte:head>
	<title>{title ?? 'ARTS CENTER'}</title>
	<meta property="og:url" content={`https://arts.center${$page.url.pathname}`} />
	<meta property="og:site_name" content="ARTS.CENTER" />
	{#if title}
		<meta property="og:title" content={title} />
		<meta itemprop="name" content={title} />
		<meta name="twitter:title" content={title} />
	{/if}

	{#if description}
		<meta name="description" property="og:description" content={description} />
		<meta name="twitter:description" content={description} />
	{/if}

	{#if image}
		<meta property="og:image" content={image} />
		<meta itemprop="image" content={image} />
		<meta name="twitter:image" content={image} />
	{/if}

	{#if author}
		<meta property="og:type" content="article" />
		<meta name="author" content={author} />
		<meta property="article:author" content={author} />
	{/if}

	{#if rss}
		<link rel="alternate" type="application/rss+xml" href={rss} />
	{/if}
	{#if atom}
		<link rel="alternate" type="application/atom+xml" href={atom} />
	{/if}
</svelte:head>
