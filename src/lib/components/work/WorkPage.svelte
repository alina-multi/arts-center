<script lang="ts">
	import type { WorkPage } from '../../interfaces/Work';

	export let work: WorkPage;
</script>

Work id: {work.id}
Work title: {work.titles[0].title}
