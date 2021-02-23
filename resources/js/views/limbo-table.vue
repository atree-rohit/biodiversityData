<style>
</style>
<template>
	<div>
		<div class="row">
			<div class="col">
				<table class="table pt-2 border border-primary">
					<thead>
						<tr>
							<th class="bg-primary text-light" v-for="f in fields">{{ f[1] }}</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<tr v-for="d in data.limbo_data">
							<td>{{ d.id }}</td>
							<td class="text-start">{{ d.range }}</td>
							<td class="text-start" v-text="count_json_rows(d.text)"></td>
							<td class="p-0"><button class="btn btn-sm btn-success" v-if="!d.parsed" @click="parseLimbo(d.id)">View Data</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: ["fields", "data"],
	data() {
		return {
			url:"",
			limbo_data:[]
		}
	},
	created(){
		var x = window.location.href;
		if(x.slice(-1) == "/")
			x = x.substring(0, x.length-1);
		var y = x.split("/");
		y.pop();
		y.pop();
		var z = y.join("/")
		this.url = z;
		this.limbo_data = this.data.limbo_data;

	},
	methods: {
		noOfRows(id){
			console.log(id)
		},
		count_json_rows(data){
			var json = JSON.parse(data);
			return json.length;
		},
		parseLimbo(id){
			window.location.href = this.url + "/" + id;
		}
	}

};
</script>
