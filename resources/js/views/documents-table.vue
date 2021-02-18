<template>
	<table class="table is-fullwidth">
		<thead>
			<tr>
				<th class="is-info" v-for="f in fields">{{ f[1] }}</th>
			</tr>
		</thead>
		<tbody class="">
			<tr v-for="d in data">
				<td>{{ d.id }}</td>
				<td>{{ d.filename }}</td>
				<td>{{ d.description }}</td>
				<td v-if="!d.parsed"><a class="button is-small is-success" @click="parseDoc(d.id)">Parse document</a></td>
			</tr>
		</tbody>
	</table>
</template>

<script>
export default {
	props: ["fields", "data"],
	methods: {
		parseDoc(file){
			window.location.href="documents/"+file;
		}
	}

};
</script>
