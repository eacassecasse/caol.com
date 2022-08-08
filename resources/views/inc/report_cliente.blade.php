
@php
    $receitas = [];
@endphp

@foreach ($clientes as $cliente)
    @php
        $somaReceita = 0;
    @endphp

    @foreach ($receita_liquida as $receita)
        @if ($receita->cliente === $cliente->no_cliente)
            @php
                $somaReceita += $receita->receita_liquida;
            @endphp
        @endif
    @endforeach

    @php
        array_push($receitas, [
            'cliente' => $cliente->no_cliente,
            'receitaTotal' => $somaReceita]);
    @endphp
@endforeach

<table class="table table-striped my-5">
    <thead>
        <tr>
            <th scope="col">Per&iacute;odo</th>
            @foreach ($clientes as $cliente)
                <th scope="col">{{ $cliente->no_cliente }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($receita_liquida as $receita)
            <tr>
                <td>{{ $meses[$receita->mes_emissao - 1] }}</td>

                @foreach ($clientes as $cliente)
                    @if ($receita->cliente === $cliente->no_cliente)
                        <td>{{ number_format($receita->receita_liquida, 2) }}</td>
                    @else
                        <td>0.00</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td><strong class="strong">TOTAL</strong></td>
            @foreach($clientes as $cliente)
                @foreach($receitas as $receita)
                    @if($cliente->no_cliente === $receita['cliente'])
                        <td>{{ number_format($receita['receitaTotal'], 2) }}</td>
                    @endif
                @endforeach
            @endforeach
        </tr>

    </tbody>
</table>
