@extends('layouts.metadata')
@section('content')
@include('layouts.navbar')
<div class="container">
    @if(Session::has('mensaje'))
    <p class="bg-success" style="padding:5px;color:white;">{{ Session::get('mensaje') }}</p>
    @endif
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <h4>Alta de servicio</h4>
    </div>
    <div class="row shadow p-3 mb-5 bg-white rounded">
        <div class="container">
            <form action="{{ route('store_service') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="service_type_id" class="font-weight-bold">Tipo de servicio</label>
                            <select onchange="cargarUsuarios(this.value);" name="service_type_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                                @foreach($servicesTypes as $serviceType)
                                <option value="{{ $serviceType->id }}">{{ $serviceType->service_type }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('service_type_id')) <small style="color:red">{{ $errors->first('service_type_id') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" id="ruta_cargar_empleados" value="{{ route('cargar_empleados') }}">
                            <label for="technical_id" class="font-weight-bold">Técnico asignado</label>
                            <select id="cbo_empleado_servicio" name="technical_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                            </select>
                            @if($errors->has('technical_id')) <small style="color:red">{{ $errors->first('technical_id') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer_id" class="font-weight-bold">Cliente</label>
                            <select onchange="cargarUsuariosFinales(this.value)" name="customer_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('customer_id')) <small style="color:red">{{ $errors->first('customer_id') }}</small>@endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" id="ruta_cargar_usuario_final" value="{{ route('cargar_usuario_final') }}">
                            <label for="usuario_final" class="font-weight-bold">Usuario final</label>
                            <select  id="cbo_usuario_final" name="final_user_id" class="form-control">
                                <option value>--Seleccione una opción--</option>
                            </select>
                            @if($errors->has('final_user_id')) <small style="color:red">{{ $errors->first('final_user_id') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="schedule_fecha" class="font-weight-bold">Asignar fecha</label>
                            <input type='date' value="{{ old('schedule_fecha') }}" name="schedule_fecha" class="form-control" id="datepicker"/>
                        </div>
                        @if($errors->has('schedule_fecha')) <small style="color:red">{{ $errors->first('schedule_fecha') }}</small>@endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="schedule_hora" class="font-weight-bold">Asignar fecha</label>
                            <input type='time' name="schedule_hora" value="{{ old('schedule_hora') }}"  class="form-control" id="datepicker"/>
                        </div>
                        @if($errors->has('schedule_hora')) <small style="color:red">{{ $errors->first('schedule_hora') }}</small>@endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Descripción</label>
                            <textarea name="description" class="form-control"></textarea>
                            @if($errors->has('description')) <small style="color:red">{{ $errors->first('description') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="observations" class="font-weight-bold">Observaciones</label>
                            <textarea name="observations" class="form-control"></textarea>
                            @if($errors->has('descriptobservationsion')) <small style="color:red">{{ $errors->first('observations') }}</small>@endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a  href="{{ route('index_service') }}" class="btn float-right"  style="background-color: #EAECEE">Cancelar</a>
                            <button  type="submit" class="btn btn-primary float-right">Iniciar servicio</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</div>
@endsection