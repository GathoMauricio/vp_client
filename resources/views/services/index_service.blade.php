@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Lista de servicios como {{ $rol }}</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <table class="table table-dark">
            <tr>
                <th>Folio</th>
                <th>Tipo</th>
                <th>Asignado por</th>
                <th>Asignado a</th>
                <th>Asignado para</th>
                <th>Descripción</th>
                <th>Comentarios</th>
                <th>Solución</th>
                <th><!--Options--></th>
            </tr>
        @if(count($services) <= 0)
            <tr><td colspan="8"><center>--No se encontraron registros--</center></td></tr>
        @endif
        @foreach($services as $service)
            <tr>
                <td>{{ $service->service_report }}</td>
                <td>{{ $service->service_type['service_type'] }}</td>
                <td>{{ $service->manager['name'] }} {{ $service->manager['last_name1'] }}</td>
                <td>{{ $service->technical['name'] }} {{ $service->technical['last_name1'] }}</td>
                <td>{{ $service->customer['name'] }}</td>
                <td>{{ $service->description }} </td>
                <td>{{ count(App\Comment::where('service_id',$service->id)->get()) }}</td>
                <td>
                    @if(empty($service->solution))
                    Pendiente
                    @else
                    {{ $service->solution }}
                    @endif
                </td>
                <td>
                    <a href="{{ route('show_service',$service->id) }}" class="btn btn-primary"><span class="icon icon-eye"></span></a>
                </td>
            </tr>
        @endforeach
        </table>
    </div>
</div>
@endsection