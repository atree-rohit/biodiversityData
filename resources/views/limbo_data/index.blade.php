@extends('layouts.app')

@section('style')
<style type="text/css">
</style>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="p-5 text-center" style="background-color: #ccc;">
			<p class="display-1">
				Limbo Data
			</p>
			<button class="btn btn-lg btn-outline-success" data-bs-toggle="modal" data-bs-target="#addModal">Add Biodiversity Document</button>

		</div>
		@include("layouts.message")



		<div id="app">
			<limbo-table :fields='@json($fields)' :data='@json($data)'></documents-table>
		</div>

	</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection
