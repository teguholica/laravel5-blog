@extends('admin.layout')

@section('webTitle')
    Dashboard
@stop

@section('main')
	<div class="row">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Visitor By IP</div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitorByIP as $visitor)
                        <tr>
                            <th scope="row">{{ $visitor->ip }}</th>
                            <td>{{ $visitor->total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">No visitor(s)</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
    	<div class="panel panel-success">
            <div class="panel-heading">Visitor By Time</div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitorByTime as $visitor)
                        <tr>
                            <th scope="row">{{ $visitor->ip }}</th>
                            <td>{{ $visitor->created_at }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">No visitor(s)</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
    	<div class="panel panel-info">
            <div class="panel-heading">Visitor By URL</div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitorByURL as $visitor)
                        <tr>
                            <th scope="row"><a href="{{ $visitor->url }}">{{ $visitor->url }}</a></th>
                            <td>{{ $visitor->total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">No visitor(s)</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop