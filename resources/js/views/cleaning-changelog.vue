<style type="text/css">
</style>
<template>
	<tr>
		<td>{{ changelog.row_id }}</td>
		<td>{{ changelog.change_type }}</td>
	</tr>	
</template>

<script>
export default {
	name:"cleaning-changelog",
	props: ["changelog"],
	data() {
		return{}
	},
	created(){
	},
	computed: {
	},
	methods:{
	}

};
</script>
