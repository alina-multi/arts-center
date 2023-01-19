<script lang="ts">
	import newUniqueId from 'locally-unique-id-generator';
	import { Icon } from '@steeze-ui/svelte-icon';
	import { XMark } from '@steeze-ui/heroicons';

	// export let tags, errorDescription, placeholder, label, description, name;
	export let label: string,
		name: string,
		tags: Array<string>,
		placeholder: string,
		errorDescription: string;

	let options = [
		'JavaScript',
		'TypeScript',
		'Svelte',
		'React',
		'Vue',
		'Angular',
		'Node',
		'Express',
		'MongoDB',
		'MySQL',
		'PostgreSQL',
		'GraphQL',
		'HTML',
		'CSS',
		'Sass',
		'Tailwind',
		'Bootstrap',
		'Material UI',
		'Ant Design',
		'Jest',
		'Mocha',
		'Chai',
		'Jasmine',
		'Cypress',
		'Puppeteer',
		'Selenium',
		'Docker',
		'Kubernetes'
	];

	// Generate a unique ID for the fields
	const id = newUniqueId();

	let openList = false;
	let visibleOptions = [];
	let value = '';
	let error = false;

	const searchOptions = (search: string): Promise<string[]> => {
		return new Promise((resolve, reject) => {
			setTimeout(() => {
				resolve(options.filter((option) => option.toLowerCase().includes(search.toLowerCase())));
			}, 1000);
		});
	};

	const addTags = (newTag) => {
		if (newTag === '' || newTag.length <= 2) {
			openList = false;
			error = true;
			return;
		} else {
			error = false;
		}

		tags = [...tags, newTag];
		value = '';
		openList = false;
		console.log(error);
	};

	const onInput = (e) => {
		error = false;
		if (value.length > 1) {
			openList = true;
		}

		value = e.target.value.trim();

		searchOptions(value).then((options) => {
			visibleOptions = options;
		});
	};

	const removeTag = (i) => {
		tags.splice(i, 1);
		tags = [...tags];
	};

	const onEsc = (e) => {
		if (e.key === 'Escape') {
			addTags(value);
		}
	};

	const onEnter = (e) => {
		if (e.key === 'Enter') {
			addTags(value);
		}
	};

	const onBackspace = (e) => {
		if (e.key === 'Backspace' && value === '') {
			tags.pop();
			tags = [...tags];
		}
	};
</script>

<div class="relative">
	{#if label}
		<label for="tag" class="block text-sm font-medium text-zinc-900 mb-1"> {label} </label>
	{/if}
	<div
		on:keydown={(e) => onBackspace(e)}
		class="flex flex-wrap gap-1 rounded-md border p-1 border-gray-300 shadow-sm focus-within:border-indigo-600 focus-within:ring-1 focus-within:ring-indigo-600 overflow-hidden"
	>
		{#each tags as tag, i}
			<div class="bg-indigo-100 inline-flex items-center text-sm rounded">
				<span class="ml-2 mr-1 leading-relaxed truncate max-w-xs">{tag}</span>
				<button
					on:click={() => removeTag(i)}
					class="w-6 h-8 inline-block align-middle text-zinc-500 hover:text-zinc-900 focus:outline-none "
				>
					<Icon src={XMark} class="w-4 h-4 fill-current mx-auto" />
				</button>
			</div>
		{/each}

		<div class="inline-flex">
			<input
				type="text"
				{name}
				{id}
				{placeholder}
				bind:value
				on:input={onInput}
				on:keydown={(e) => onEsc(e)}
				on:keypress={(e) => onEnter(e)}
				class="inline py-2 px-3 appearance-none border-none ring-transparent w-full text-zinc-700 leading-tight sm:text-sm focus:ring-transparent  focus:outline-none focus:shadow-outline"
			/>
		</div>
	</div>
	{#if error}
		<p class="text-sm text-red-500 mt-1">{errorDescription}</p>
	{/if}

	{#if openList}
		<div class="absolute z-40 left-0 mt-2 w-full">
			<div class="py-1 text-sm bg-white rounded shadow-lg border border-zinc-300">
				<a
					on:click={() => addTags(value)}
					class="block py-1 px-5 cursor-pointer hover:bg-indigo-600 hover:text-white"
					><span class="font-semibold" />Add tag "{value}"</a
				>
				{#if visibleOptions.length === 0}
					<p class="block py-1 px-5">
						There are no tags available for selection. Please add a new tag.
					</p>
				{/if}
				<ul>
					{#each visibleOptions as option}
						<li
							on:click={() => addTags(option)}
							class="block py-1 px-5 cursor-pointer hover:bg-indigo-600 hover:text-white"
						>
							{option}
						</li>
					{/each}
				</ul>
			</div>
		</div>
	{/if}
</div>
