@extends('site.layouts.default')

{{-- Content --}}
@section('content')

<div class="page-header">
	<div class="row">
		<div class="col-md-9">
			<h4>{{{ Lang::get('site.webserivce_status') }}}</h4>
		</div>
	</div>
</div>

<?php
print_r($response);
?>
<div>
</div>

@stop
