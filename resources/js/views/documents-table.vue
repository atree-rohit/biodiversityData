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
				<td class="p-0"><button class="btn btn-sm btn-success" v-if="!d.parsed" @click="parseDoc(d.id)">Parse document</button></td>
				<td class="p-0"><button class="btn btn-sm btn-info" v-if="d.limbo_data.length" @click="limboData(d.id)">View Parsed Data</button></td>
			</tr>
		</tbody>
	</table>
</template>

<script>
export default {
	props: ["fields", "data"],
	data() {
		return {
			url:""
		}
	},
	created(){
		var x = window.location.href;
		if(x.slice(-1) == "/")
			x = x.substring(0, x.length-1);
		this.url = x;
	},
	methods: {
		parseDoc(file){
			window.location.href = this.url + "/" + file;
		},
		limboData(file){
			var base = this.url.replace("documents", "limbo_data")
			window.location.href = base + "/parsed/" + file;
		}
	}

};
</script>
