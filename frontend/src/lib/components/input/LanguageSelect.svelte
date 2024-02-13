<script lang="ts">
	export let value;
</script>

<select
	bind:value
	name="language"
	class="block w-full rounded-sm pl-3 border sm:text-sm pr-10 mt-1 dark:bg-zinc-900"
>
	<option>en</option>
	<option>uk</option>
</select>
