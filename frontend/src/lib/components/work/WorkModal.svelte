<script lang="ts">
	import ModalWindow from '$lib/components/atoms/ModalWindow.svelte';
	import WorkPage from '$lib/components/work/WorkPage.svelte';
	import { page } from '$app/stores';
	import { pushState } from '$app/navigation';
	import NavigationArrows from './NavigationArrows.svelte';
	import BeforeNavigateLayout from '../atoms/BeforeNavigateLayout.svelte';

	export let gallery;

	let initialHref = $page.url.href;
	$: currentWorkIndex = -1;

	$: if ($page?.state?.workModal) {
		currentWorkIndex = gallery.findIndex(
			(work) => Number(work.id) === Number($page.state?.workModal.work.id)
		);
	}

	function gotoGallery() {
		pushState(initialHref);
	}
</script>

<BeforeNavigateLayout
	route={'/[[lang=lang]]/(with-nav)/(single-column)/work/[id=int]'}
	stateName={'workModal'}
	keysToInclude={['work', 'comments']}
>
	{#if $page?.state?.workModal}
		<ModalWindow
			class=" md:px-9 xl:px-16 lg:max-xl:py-3  lg:my-9 rounded-t-[36px] dark:border-2 max-xs:dark:border-t-2  dark:border-zinc-700 shadow-sm  max-lg:mt-16 xs:rounded-2xl  pb-12  "
			on:close={gotoGallery}
			open={true}
			closeButtonAddStyle=" text-white  mt-3 lg:mt-6 max-md:bg-zinc-500/20 max-lg:rounded-full   "
		>
			<div slot="otherEl" class="hidden lg:block">
				<NavigationArrows {currentWorkIndex} {gallery} />
			</div>

			<WorkPage {...$page.state.workModal} />
		</ModalWindow>
	{/if}
</BeforeNavigateLayout>
