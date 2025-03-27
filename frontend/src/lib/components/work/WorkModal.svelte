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
			class=" lg:px-16  xs:my-9 xs:rounded-2xl  pb-12  "
			on:close={gotoGallery}
			open={true}
			closeButtonAddStyle=" xs:text-white max-xs:bg-zinc-50/30  max-xs:rounded-full max-xs:mt-3 text-zinc-500"
		>
			<div slot="otherEl" class="hidden sm:block">
				<NavigationArrows {currentWorkIndex} {gallery} />
			</div>

			<WorkPage {...$page.state.workModal} />
		</ModalWindow>
	{/if}
</BeforeNavigateLayout>
