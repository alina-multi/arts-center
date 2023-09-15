<script lang="ts">
	export let title:string;
</script>

<div class="flex justify-between px-6 py-3 rounded-md border dark:border-zinc-800 dark:bg-zinc-900">
	<div class="flex gap-3 items-center">
		<h1 class="text-2xl font-semibold">{title}</h1>
		<slot name="details" />
	</div>
	<slot name="buttons" />
</div>
