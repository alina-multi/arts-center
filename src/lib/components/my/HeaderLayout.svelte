<script lang="ts">
	export let title:string;
</script>

<div class="flex justify-between py-3 px-3 sm:p-6 border-b border-zinc-300 dark:border  dark:rounded-sm dark:bg-zinc-900 dark:border-zinc-800 mb-3 ">
	<div class="flex gap-3 items-center">
		<h1 class=" text-lg sm:text-2xl font-semibold leading-6">{title}</h1>
		<div class="flex gap-3 items-center leading-3 max-xs:text-sm  font-semibold">
			<div class="h-6 border-r border-zinc-300  dark:bg-zinc-300" />
		<slot name="details" />
		</div>
	</div>
	<slot name="buttons" />
</div>
