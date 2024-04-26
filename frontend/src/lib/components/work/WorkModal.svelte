<script lang="ts">
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import WorkPage from '$lib/components/work/WorkPage.svelte';
	import { page } from '$app/stores';
	import globalLoading from '$lib/stores/loading';
	import { beforeNavigate, goto, preloadData, pushState } from '$app/navigation';
	import NavigationArrows from './NavigationArrows.svelte';

	export let gallery;

	let initialHref = $page.url.href;
	$: currentWorkIndex = -1;

	$: if ($page?.state?.workModal) {
		currentWorkIndex = gallery.findIndex((work) => work.id === $page.state.workModal.work.id);
	}

	beforeNavigate(async (navigation: import('@sveltejs/kit').BeforeNavigate) => {
		if (navigation.to?.route.id === '/[[lang=lang]]/(with-nav)/(single-column)/work/[id=int]') {
			navigation.cancel();
			globalLoading.set(true);
			const preloaded = await preloadData(navigation.to?.url.href);
			globalLoading.set(false);
			if (preloaded.type === 'loaded') {
				pushState(navigation.to?.url.href, {
					workModal: {
						work: preloaded.data.work,
						comments: preloaded.data.comments
					}
				});

				// Fallback if for any reason preload fails
			} else {
				goto(preloaded.data.work);
			}
		}
	});

	function gotoGallery() {
		pushState(initialHref);
	}
</script>

{#if $page?.state?.workModal}
	<ModalWindow
		class="container px-4 py-10 xs:px-6 xs:py-3 md:py-6 md:px-9 lg:px-0 lg:pb-12 xl:px-16  xs:my-12 xs:rounded-md dark:lg:rounded-none lg:dark:px-0 dark:lg:pt-0   lg:dark:border-x-0 lg:dark:border-b-0 "
		on:close={gotoGallery}
		open={true}
		closeButtonAddStyle="max-xs:bg-white xs:text-white max-xs:dark:bg-black"
	>
		<div slot="otherEl" class="hidden xs:block">
			<NavigationArrows {currentWorkIndex} {gallery} />
		</div>

		<WorkPage {...$page.state.workModal} />
	</ModalWindow>
{/if}
