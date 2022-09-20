@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="{{ url('configuracion') }}"><b>Resumen de Soporte Técnico</b></a> <span class="uri-seg"> > </span>Tipo de Atención</p>
            </div>
        </div>
    </div>

    <div class="row card-box">
        @foreach($res as $r)
            <div class="col-md-6">
                <?= $r ?>
            </div>
        @endforeach
    </div>
@endsection