@extends('layouts.header')
@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <p class="page-title"><a class="text-reset" href="javascript: void(0);"><b>General</b></a> <span class="uri-seg">></span> Perfil</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="profile-bg-picture" style="background-image:url('assets/images/bg-profile.jpg')">
                <span class="picture-bg-overlay"></span>
            </div>
            
            <div class="profile-user-box">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                            $logo = 'logo.png';
                            if (!empty($cli->logo)) {
                                $logo = $cli->logo;
                            }
                        ?>
                        <span class="float-left mr-3  border border-secondary rounded-circle"><img src="{{ asset('image/'.$logo) }}" alt="" class="avatar-xl rounded-circle"></span>
                        <div class="media-body">
                            <h4 class="mt-1 mb-1 font-18 ellipsis">{{ $cli->dsc_cliente }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-uppercase font-weight-medium card-box"><b>{{ $servicio }}</b></p>
        </div>
        @if(count($ser_k) > 0)
            @foreach($ser_k as $s)
            <?php
                ($s->flg_activo) ?  $check = 'mdi mdi-check-circle-outline check' : $check = 'mdi mdi-close-circle-outline no-check';
                if($s->id == 4) {
                    $icono = '<img src="'.asset($s->icono).'" class="avatar-title font-30 text-white">';
                } else {
                    $icono = '<i class="'.$s->icono.' avatar-title font-30 text-white"></i>';
                }
            ?>
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <div class="media">
                        <div class="avatar-lg rounded-circle bg-servicio widget-two-icon align-self-center">
                            <?php echo  $icono ?>
                        </div>

                        <div class="wigdet-two-content media-body">
                            <p class="m-0 text-uppercase font-weight-medium text-truncate" title="{{ $s->dsc_servicio }}">{{ $s->dsc_servicio }}</p>
                            <p class="mr-4"><i class="{{ $check }} size"></i></p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            @foreach($cli_serv as $s)
            <?php
                ($s->flg_activo) ?  $check = 'mdi mdi-check-circle-outline check' : $check = 'mdi mdi-close-circle-outline no-check';
                if($s->id == 4) {
                    $icono = '<img src="'.asset($s->icono).'" class="avatar-title font-30 text-white">';
                } else {
                    $icono = '<i class="'.$s->icono.' avatar-title font-30 text-white"></i>';
                }
            ?>
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <div class="media">
                        <div class="avatar-lg rounded-circle bg-servicio widget-two-icon align-self-center">
                            <?php echo  $icono ?>
                        </div>

                        <div class="wigdet-two-content media-body">
                            <p class="m-0 text-uppercase font-weight-medium text-truncate" title="{{ $s->dsc_servicio }}">{{ $s->dsc_servicio }}</p>
                            <p class="mr-4"><i class="{{ $check }} size"></i></p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <h4 class="header-title mt-0 mb-4">Información</h4>
                <div class="panel-body">
                    <p class="text-muted font-13">
                        {{ $cli->observaciones }}
                    </p>
                    <hr/>
                    <div class="row">
                        <div class="col-md-1"><b>RUC</b></div>
                        <div class="col-md-11">{{$cli->dsc_ruc}}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-1"><b>TELÉFONO</b></div>
                        <div class="col-md-11">{{$cli->telefono}}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-1"><b>EMAIL</b></div>
                        <div class="col-md-11">{{$cli->email}}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-1"><b>DIRECCIÓN</b></div>
                        <div class="col-md-11">{{$cli->direccion}}</div>
                    </div>
                    <!-- <ul class="social-links list-inline mt-4 mb-0">
                        <li class="list-inline-item">
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fab fa-skype"></i></a>
                        </li>
                    </ul> -->
                </div>
            </div>

            <div class="card-box ribbon-box">
                <div class="ribbon ribbon-primary">Miembros</div>
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="table-list" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th class="text-center">SUCURSAL</th>
                                <th class="text-center">NOMBRES</th>
                                <th class="text-center">CARGO</th>
                                <th class="text-center">AREA</th>
                                <th class="text-center">TELÉFONO</th>
                                <th class="text-center">EMAIL</th>
                                <th class="text-center">DIRECCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($usu as $u)
                            <?php ($u->dsc_sucursal) ? $suc = $u->dsc_sucursal : $suc = ''; ?>
                            <tr>
                                <td class="text-center">{{ $suc }}</td>
                                <td>{{ $u->nombres.' '.$u->apellidos }}</td>
                                <td>{{ $u->cargo }}</td>
                                <td class="text-center">{{ $u->area }}</td>
                                <td class="text-center">{{ $u->telefono }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->direccion }}</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <style>
        .bg-servicio {
            background-color: #AA0000;
        }
        .size {
            font-size: 50px;
        }
        .check {
            color: #2ECC71;
        }
        .no-check {
            color: #FF0000;
        }
    </style>
@endsection
@push('scripts')
    <script>
        $(function() {
            // var a = sha1('hola');
            // console.log(a);
            // alert(a);
        });
    </script>
@endpush