<script lang='ts'>
	import { onMount } from 'svelte';
	import { MultiSelect } from 'svelte-multiselect';

	export let options, maxSelect, required, name, value, placeholder;
	
	let multiselectProps, hiddenValue;

	// Default from value prop to format that component understands
	let selected = options.filter((option) => value?.map((value) => value.toString()).includes(option?.value));
		multiselectProps = {
			outerDivClass: 'rounded-sm border sm:text-sm h-10',
			ulSelectedClass: 'h-8',
			liSelectedClass: 'bg-amber-500',
			options: options,
			placeholder,
			maxSelect,
			required
		};
	
	// Back to array of id's for the backend
	$: hiddenValue = selected.map(({ value }) => value).join(',');


	let isDark = false;
	onMount(() => {
		if (typeof window !== 'undefined') {
			isDark = document.documentElement.classList.contains('dark');
		}
	});
</script>

<div class='border border-gray-300 rounded-sm dark:bg-zinc-900 dark:border-zinc-700'>
	<MultiSelect
		bind:selected
		{...multiselectProps}
		--sms-options-bg={isDark ? 'gray' : 'white'}
		--sms-border={'transparent'}
		--sms-bg={isDark ? ' ' : ''}
		--sms-options-padding={'18px'}
	/>
</div>

<input type='hidden' {name} value={hiddenValue} />
