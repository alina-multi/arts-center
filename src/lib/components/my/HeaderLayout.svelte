<script lang="ts">
	export let title:string;
</script>

<div class="flex justify-between px-6 py-3 rounded-sm dark:border-zinc-700 dark:bg-zinc-800 bg-zinc-600 dark:border dark:border dark:rounded-b-none text-white">
	<div class="flex gap-3 items-center">
		<h1 class="text-xl font-semibold leading-6">{title}</h1>
		<div class="flex gap-3 items-center leading-3">
			<div class="h-6 border bg-zinc-100  dark:bg-zinc-300" />
		<slot name="details" />
		</div>
	</div>
	<slot name="buttons" />
</div>
