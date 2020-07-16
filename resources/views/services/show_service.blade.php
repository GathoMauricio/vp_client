@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Detalles del servicio {{ $service->service_report }}</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12 py-4">

                    @if($service->status_id == 1)
                    <span class="bg-primary" style="padding:5px;border-radius:10px;color:white;font-weight:bold">
                    Pendiente
                    </span>
                    @endif
                        
                    
                    <a href="{{ route('formato_pdf_servicio',$service->id) }}" style="color:red;float:right;"><span class="icon icon-file-pdf"></span> Imprimir formato</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Cliente(Razón social</label>
                    <br>
                    {{ $service->customer['name'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Usuario final</label>
                    <br>
                    {{ $service->usuario_Final['name'] }} {{ $service->usuario_Final['last_name1'] }} {{ $service->usuario_Final['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Tipo de servicio</label>
                    <br>
                    {{ $service->service_type['service_type'] }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">E-Mail de contacto</label>
                    <br>
                    {{ $service->usuario_Final['email'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Teléfono de contacto</label>
                    <br>
                    {{ $service->usuario_Final['phone'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Dirección de contacto</label>
                    <br>
                    {{ $service->usuario_Final['calle_numero'] }} 
                    {{ $service->usuario_Final['asentamiento'] }}, 
                    {{ $service->usuario_Final['cp'] }} 
                    {{ $service->usuario_Final['ciudad'] }} 
                    {{ $service->usuario_Final['municipio'] }} 
                    {{ $service->usuario_Final['estado'] }} 
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Mesa de ayuda</label>
                    <br>
                    {{ $service->manager['name'] }} {{ $service->manager['last_name1'] }} {{ $service->manager['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Empleado asignado</label>
                    <br>
                    {{ $service->technical['name'] }} {{ $service->technical['last_name1'] }} {{ $service->technical['last_name2'] }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Fecha de asignación</label>
                    <br>
                    {{ date_format(new \DateTime($service->schedule), 'd-m-Y g:i A') }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Descripción</label>
                    <br>
                    {{ $service->description }}
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Solución</label>
                    <br>
                    @if(@empty($service->solution))
                    Pendiente
                    @else
                    {{ $service->solution }}
                    @endif
                </div>
                <div class="col-md-4">
                    <label for="" class="font-weight-bold">Observación</label>
                    <br>
                    {{ $service['observations'] }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small style="color:#154360;">
                        <b>
                            Este sercivio fue creado el {{ date_format(new \DateTime($service->created_at), 'd-m-Y g:i A') }} 
                            y actualizado por última vez el {{ date_format(new \DateTime($service->updated_at), 'd-m-Y g:i A') }}
                        </b>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('store_comment') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="comment_type_id" value="1">
                        <table style="width:100%;">
                            <tr>
                                <td width="95%"><input type="text" name="comment" class="form-control" placeholder="Escriba aquí..." required></td>
                                <td width="5%"><input type="image" src="{{ asset('img/send.png') }}" width="80" height="60"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(count($comments) <= 0)
                    <center>No se han agregado comentarios a este servicio</center>
                    @endif
                    @foreach($comments as $comment)
                    <div class="comment-item">
                        <span class="float-right bg-primary" style="padding:5px;">
                            {{ $comment->type['comment_type'] }}
                        </span>
                        <label class="font-weight-bold" style="color:#154360;">
                            {{ $comment->user['name'] }} {{ $comment->user['last_name1'] }} {{ $comment->user['last_name2'] }}
                        </label>
                        <br>
                        {{ $comment->comment }}
                        <br>
                        <span class="float-right">{{ date_format(new \DateTime($comment->created_at), 'd-m-Y g:i A') }}</span>
                        <br>
                    </div>
                    <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection