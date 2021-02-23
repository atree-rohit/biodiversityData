<style type="text/css">
	.c_row{
		margin: 4px 2px;
	}
	.c_row>div{
		padding: 4px 7px;
	}
</style>
<template>
	<div class="d-flex flex-row c_row badge" :class="border_color">
		<div>{{ changelog.id }}</div>
		<div class="border-light border-start border-end">{{ changelog.type }}</div>
		<div>{{ changelog.data }}</div>
	</div>
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
		border_color: function (){
			var border = "";
			if(this.changelog.type == "delete"){
				border = "danger bg-danger";
			} else if(this.changelog.type.includes("merge")){
				border = "success bg-success";
			} else if(this.changelog.type.includes("edit")){
				border = "success bg-primary";
			} else {
				border = "warning bg-dark";				
			}
			return "border-" + border;
		}
	},
	methods:{
	}

};
</script>
