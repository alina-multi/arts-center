<script lang="ts">
	import { TabList } from '@rgossiaux/svelte-headlessui';
</script>

<TabList>
	<div class="border-b border-gray-200">
		<nav class="-mb-px flex space-x-8" aria-label="Tabs">
			<slot />
		</nav>
	</div>
</TabList>
