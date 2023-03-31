<script lang="ts">
	import UserFooter from '$lib/components/work/page/footer/UserFooter.svelte';

	import MobileButton from '$lib/components/work/page/MobileButtons.svelte';
	export let work;
</script>

<div class="flex flex-col  ">
	<div>
		<div
			class="flex justify-between  mt-1 text-xs sm:text-sm text-gray-700 items-center border rounded-sm lg:hidden  dark:border-transparent bg-gray-100 dark:bg-transparent p-3  dark:text-gray-300 "
		>
			<MobileButton type="like" />
			<MobileButton type="bookmark" />
			<MobileButton type="comment" />
			<MobileButton type="cart" />
		</div>
	</div>

	<div
		class="flex items-center gap-3  justify-between text-base py-3 lg:border border-x-transparent border-t-transparent  dark:border-b-gray-700 dark:text-gray-500"
	>
		<UserFooter {work} />
	</div>
</div>
