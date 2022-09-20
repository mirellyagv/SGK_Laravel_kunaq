@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript:void(0)"><b>Resumen de Soporte Técnico</b></a></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2 p-12 card-box">
            <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">CLIENTE</th>
                        <th class="text-center">REPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach($cli as $c)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td class="text-center">{{ $c->dsc_cliente }}</td>
                        <td class="text-center"><a href="{{ url('soporte/reporte/'.$c->id) }}" target="_blank" class="uri-seg s-editar" title="DESCARGAR"><i class="mdi mdi-download"></i></a></td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(function() {
        });
    </script>
@endpush