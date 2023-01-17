<script lang="ts">
	import "$lib/css/app.css";
</script>

<div class="app">
	<div class="flex gap-1 border border-2">
		<a href="/" class="bg-amber-200 shadow p-3">index</a>
		<a href="/en/about" class="bg-amber-200 shadow p-3">test</a>
	</div>
	<main class="mt-3 p-3">
		<slot />
	</main>
</div>
