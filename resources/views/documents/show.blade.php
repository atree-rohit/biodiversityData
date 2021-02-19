@extends('layouts.app')

@section('style')
<style type="text/css">
	body{
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@endsection

@section('content')
	<div class="bg-dark">
		<div class="container bg-light p-2">
			<div id="app">
				<cleaning-board :data='@json($contents)'></cleaning-board>
			</div>
		</div>
	</div>
@endsection

@section('js')
<script type="text/javascript">
</script>
@endsection
