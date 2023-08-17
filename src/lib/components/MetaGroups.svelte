<script lang='ts'>
	export let title, description, author, image;
</script>

<svelte:head>


{#if title}
	<meta property="og:title" content={title} />
    <meta itemprop="name" content={title} />
    <meta name="twitter:title" content={title} />
    {/if}

    {#if description}
	<meta property="description" content={description} />
    <meta itemprop="description" content={description} />
	<meta property="og:description" content={description} />
    <meta name="twitter:description" content={description} />
    {/if}

    {#if image}
	<meta property="og:image" content={image} />
    <meta itemprop="image" content={image} />
    <meta name="twitter:image" content={image} />
    {/if}

    {#if author}
    <meta name="author" content={author} />
    {/if}

	
	
</svelte:head>

	<!--pinterest-->
	<!-- <meta name="p:domain_verify" content="key" /> -->
	<!-- <meta name="pinterest-rich-pin" content="true" />
    <meta name="pinterest:description" content={description} />
    <meta name="pinterest:title" content={title} />
    <meta name="pinterest:image" content={image} />
    <meta name="pinterest:media" content={image} />
    <meta name="pinterest:site" content="ARTS.CENTER" /> -->