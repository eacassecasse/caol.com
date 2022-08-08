@extends('layouts.app')

@section('navtabs')
    <div class="row">
        <div class="col-12 py-1">
            <div class="btn-group" role="group" aria-label="Outlined Radio Options">
                <input type="radio" name="btnOptions" class="btn-check" id="btnConsultores" autocomplete="off">
                <label class="btn btn-outline-secondary" for="btnConsultores">Consultores</label>

                <input type="radio" name="btnOptions" class="btn-check" id="btnClientes" autocomplete="off" checked>
                <label class="btn btn-outline-secondary" for="btnClientes">Clientes</label>
            </div>
        </div>

        <div class="col-12 py-4">
            <div class="row">
                <div class="col-auto">
                    <label class="form-label" for="selectorUsuarios">
                        <strong class="strong">Clientes</strong>
                    </label>
                </div>
                <div class="col-auto float-end">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="selectorUsuarios"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Selecione o(s) Cliente (es)
                        </button>
                        <div class="dropdown-menu px-3" aria-labelledby="selectorUsuarios">
                            @if (count($clientes) > 0)
                                @foreach ($clientes as $cliente)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ $cliente->no_cliente }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-auto">
                    <strong class="strong col-3 d-inline me-2">Data de In&iacute;cio</strong>

                    @php($meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'])
                    @php($anos = [2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022])

                    <div class="dropdown col-4 d-inline mx-1">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="mesInicio"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            M&ecirc;s
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="mesInicio">
                            @foreach ($meses as $mes)
                                <li class="dropdown-item">{{ $mes }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown col-4 d-inline">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="anoInicio"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ano
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="anoInicio">
                            @foreach ($anos as $ano)
                                <li class="dropdown-item">{{ $ano }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-auto">
                    <strong class="strong col-3 d-inline me-3">Data de Fim</strong>

                    <div class="dropdown col-4 d-inline">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="mesFim"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            M&ecirc;s
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="mesFim">
                            @foreach ($meses as $mes)
                                <li class="dropdown-item">{{ $mes }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="dropdown col-4 d-inline mx-1">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="anoFim"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ano
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="anoFim">
                            @foreach ($anos as $ano)
                                <li class="dropdown-item">{{ $ano }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col pt-3">
            <div class="btn-group btn-group-toggle">
                <button class="btn btn-outline-primary" type="button">Relat&oacute;rio</button>
                <button class="btn btn-outline-primary" type="button">Gr&aacute;fico</button>
                <button class="btn btn-outline-primary" type="button">Pizza</button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('inc.report_cliente')
            </div>
        </div>
    </div>
@endsection
