<script lang='ts'>
	import type { PageData } from './$types';
	import FormGroup from '$lib/components/input/FormGroup.svelte';
	import WorkAddProgressSteps from '$lib/components/work/add/WorkAddProgressSteps.svelte';
	import FileUploader from '$lib/components/input/FileUploader.svelte';
	import { localePath, t, locale } from '$lib/translations';
	import { goto } from '$app/navigation';
	import { magicFetch } from '$lib/helpers/fetchData';

	export let data: PageData;
	let uploadedUrls = [];
	let key = 1;

	async function send(main = null) {
		if (!main) {
			main = uploadedUrls.pop().url;
		}
		const more = uploadedUrls.filter(({ url }) => url !== main).map(({ url }) => urlToPath(url));
		main = urlToPath(main);

		try {
			const json = await magicFetch('POST', '/api/draft', {
				main,
				more,
				language: locale.get()
			});
			await goto(localePath(`/my/work/draft/${json.id}`));
		} catch (e) {
			key++; // Reset form
		}
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
{#key key}
	{#if uploadedUrls?.length > 0}
		<FormGroup h1={$t('my.add_work_page.select_main_image')}>
			<ul
				class='grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8'
			>
				{#each uploadedUrls as url(url.url)}
					<li class='relative'>
						<!-- svelte-ignore a11y-click-events-have-key-events a11y-no-static-element-interactions -->
						<div
							on:click={send(url.url)}
							class='cursor-pointer group aspect-h-7 aspect-w-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100'
						>
							<img
								src={url.preview}
								class='pointer-events-none object-cover group-hover:opacity-75'
								alt='main'
							/>
						</div>
						<!-- svelte-ignore a11y-click-events-have-key-events a11y-no-static-element-interactions -->
						<div
							class='text-red-500 underline cursor-pointer text-right'
							on:click={deleteImage(url.url)}
						>
							{$t('global.buttons.delete')}
						</div>
					</li>
				{/each}
			</ul>
		</FormGroup>
	{:else}
		<FormGroup h1={$t('my.add_work_page.label_step_1')}>
			<FileUploader {...data.transloadit} on:complete={uploadComplete} />
		</FormGroup>
	{/if}
{/key}

