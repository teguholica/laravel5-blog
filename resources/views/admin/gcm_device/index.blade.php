@extends('admin.layout')

@section('webTitle')
    GCM Device List
@stop

@section('breadcrumb')
<li class="active">GCM Device(s)</li>
@stop

@section('main')
<div style="margin-top: 10px">
	<div class="row">
		@include('admin.alert')
		<div class="col-md-6">
			<table class="table table-striped">
				<tbody>
					@forelse($GCMDevices as $GCMDevice)
					<tr>
						<td style='width: 10px;'>{{ $GCMDevice->active == 1?'<span class="glyphicon glyphicon-check"></span>':'' }}</td>
						<td>{{ $GCMDevice->device_id }}</td>
						<td style="text-align: right;">
							<a href="{{ route('admin.gcm_device.destroy', $GCMDevice->id) }}" onclick="return confirm('Delete?')" class="btn btn-danger btn-xs">Delete</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="3" style="text-align: center;">No Device(s)</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
	<div style="text-align: center">
		{{ $GCMDevices->render() }}
	</div>
</div>
@stop