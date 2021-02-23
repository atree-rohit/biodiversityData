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
		<div class="d-flex justify-content-around text-center my-2">
			<div class="border border-danger rounded">
				<div class="h4 bg-danger text-light rounded py-2">ID</div>
				<div class="h3 px-4">{{ $data->id }}</div>
			</div>
			<div class="border border-danger rounded px-4 py-1">
				<div class="h4">Filename</div>
				<div class="h3">{{ $data->filename }}</div>
			</div>
		</div>

		<div id="app">
			<limbo-table :fields='@json($fields)' :data='@json($data)'></documents-table>
		</div>

	</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection
