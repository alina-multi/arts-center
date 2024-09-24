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
		currentWorkIndex = gallery.findIndex((work) => work.id === $page.state.workModal.work.id);
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
			class="container py-10 xs:px-6 xs:py-3 md:py-6 md:px-9 lg:px-0 lg:pb-12 xl:px-16  xs:my-12 xs:rounded-md dark:lg:rounded-none lg:dark:px-0 dark:lg:pt-0   lg:dark:border-x-0 lg:dark:border-b-0 "
			on:close={gotoGallery}
			open={true}
			closeButtonAddStyle=" xs:text-white "
		>
			<div slot="otherEl" class="hidden xs:block">
				<NavigationArrows {currentWorkIndex} {gallery} />
			</div>

			<WorkPage {...$page.state.workModal} />
		</ModalWindow>
	{/if}
</BeforeNavigateLayout>
