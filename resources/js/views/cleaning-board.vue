<template>
  <div>
  	<div>No of rows: {{ rowCount }}</div>
  	<div class="box">
  		<div v-for="d in data" class="columns box p-0 m-0">
  			<div class="column is-three-quarters p-0">{{ d }}</div>
  			<div class="p-1 my-1 has-background-black column is-flex-direction-row is-align-content-flex-end">
	  			<button class="button is-success"><i class="fa fa-check"></i></button>
	  			<button class="button is-info"><i class="fa fa-pencil"></i></button>
	  			<button class="button is-danger"><i class="fa fa-trash-o"></i></button>
	  			<button class="button is-primary"><i class="fa fa-arrow-up"></i></button>
	  			<button class="button is-primary"><i class="fa fa-arrow-down"></i></button>
  			</div>
  		</div>
  	</div>
  </div>
</template>

<script>
export default {
  props: ["data"],
  data() {
  	return{
  		rows:0
  	}
  },
  computed: {
  	rowCount: function (){
  		return this.data.length;
  	}
  }
  
};
</script>
