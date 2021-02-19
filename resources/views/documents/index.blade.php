@extends('layouts.app')

@section('style')
<style type="text/css">
	body{

	}
</style>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="p-5 text-center" style="background-color: #ccc;">
			<p class="display-1">
				Biodiversity Documents
			</p>
			<button class="btn btn-lg btn-outline-success" data-bs-toggle="modal" data-bs-target="#addModal">Add Biodiversity Document</button>

		</div>
		@include("layouts.message")




		<div id="addModal" class="modal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add a PDF file</h5>
						<button type="button" class="btn-close cancelModal" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form method="POST" action="./documents" enctype="multipart/form-data">
						@csrf
						<div class="modal-body">
							<div class="mb-3">
								<label for="formFile" class="form-label">Default file input example</label>
								<input class="form-control" type="file" name="file" enctype="multipart/form-data">
							</div>
							<div class="mb-3">
								<label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
								<textarea class="form-control" name="description" placeholder="Enter file description" rows="3"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		<div id="app">
			<documents-table :fields='@json($fields)' :data='@json($documents)'></documents-table>
		</div>

	</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection
