<script lang="ts">
	import type { PageData } from './$types';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { locale, localePath } from '$lib/translations';
	import toast from 'svelte-french-toast';
	import { redirect } from '@sveltejs/kit';

	export let data: PageData;
	let uploadedUrls = [],
		error = '';

	async function send(main = null) {
		if (!main) {
			main = uploadedUrls.pop().url;
		}
		const more = uploadedUrls.filter(({ url }) => url !== main).map(({ url }) => urlToPath(url));
		main = urlToPath(main);
		await fetch('/api/draft', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				main,
				more,
				locale: locale.get()
			})
		})
			.then(async (response) => {
				const json = await response.json();
				if (response.ok) {
					redirect(301, localePath(`/my/work/draft/${json.id}`));
				} else {
					toast.error(json?.message);
				}
			})
			.catch((e) => toast.error('Something is wrong with API server'));
	}

	function urlToPath(url) {
		return url.replace('https://i.arts.center/', '');
	}

	async function uploadComplete({ detail }) {
		uploadedUrls = [...uploadedUrls, ...detail];
		if (detail.length == 1) {
			send();
		}
	}

	function deleteImage(deleteUrl) {
		uploadedUrls = uploadedUrls.filter(({ url }) => url != deleteUrl);
	}
</script>

<WorkAddProgressSteps />
{#if uploadedUrls?.length > 0}
	<FormGroup h1="Select the main image">
		<ul
			role="list"
			class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
		>
			{#each uploadedUrls as url, index (url.url)}
				<li class="relative">
					<div
						on:click={send(url.url)}
						class="cursor-pointer group aspect-h-7 aspect-w-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100"
					>
						<img
							src={url.preview}
							class="pointer-events-none object-cover group-hover:opacity-75"
						/>
					</div>
					<div
						class="text-red-500 underline cursor-pointer text-right"
						on:click={deleteImage(url.url)}
					>
						delete
					</div>
				</li>
			{/each}
		</ul>
	</FormGroup>
{:else}
	<FormGroup h1="What have you been working on?">
		<FileUploader {...data.transloadit} on:complete={uploadComplete} />
	</FormGroup>
{/if}
