<script lang="ts">
	import type { WorkPage } from '../../interfaces/Work';
	BigInt.prototype.toJSON = function () {
		return this.toString();
	};
	export let work: WorkPage;
</script>

<h1>Work data for test:</h1>
{JSON.stringify(work)}
