<style>
	.badge:hover{
		cursor: pointer;
		box-shadow: 1px 1px 5px #000;
	}
</style>
<template>
	<table class="table pt-2 border border-primary">
		<thead>
			<tr>
				<th class="bg-primary text-light" v-for="f in fields">{{ f[1] }}</th>
			</tr>
		</thead>
		<tbody class="text-center">
			<tr v-for="d in data">
				<td>{{ d.id }}</td>
				<td class="text-start">{{ d.filename }}</td>
				<td class="text-start">{{ d.description }}</td>
				<td v-if="!d.parsed"><span class="badge rounded-pill bg-success" @click="parseDoc(d.id)">Parse document</span></td>
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
