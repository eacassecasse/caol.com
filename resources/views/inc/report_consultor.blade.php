@foreach($consultores as $cons)

    @php
        $somaReceita = 0;
        $somaCustoFixo = 0;
        $somaComissao = 0;
        $somaLucro = 0;
    @endphp

<table class="table table-striped my-5">
    <thead>
        <tr>
            <th>{{ $cons->no_usuario}}</th>
        </tr>
        <tr>
            <th scope="col">Per&iacute;odo</th>
            <th scope="col">Receita L&iacute;quida</th>
            <th scope="col">Custo Fixo</th>
            <th scope="col">Comiss&atilde;o</th>
            <th scope="col">Lucro</th>
        </tr>
    </thead>
    <tbody>
 
    @foreach($receita_comissao as $rc)
        @if ($rc->consultor === $cons->no_usuario)
            @php
                $somaReceita += $rc->receita_liquida;
                $somaCustoFixo += $custo_fixo[0]->brut_salario;
                $somaComissao += $rc->comissao;
                $somaLucro += $rc->receita_liquida - ($custo_fixo[0]->brut_salario + $rc->comissao);
            @endphp

            <tr>
                <td>{{ $meses[$rc->mes_emissao - 1 ] }}</td>
                <td>{{ number_format($rc->receita_liquida, 2) }}</td>
                <td>{{ number_format($custo_fixo[0]->brut_salario, 2) }}</td>
                <td>{{ number_format($rc->comissao, 2) }}</td>
                <td>{{ number_format($rc->receita_liquida - ($custo_fixo[0]->brut_salario + $rc->comissao), 2)}}</td>
            </tr>
        @endif
    @endforeach

    <tr>
        <td><strong class="strong">SALDO</strong></td>
        <td>{{ number_format($somaReceita, 2) }}</td>
        <td>{{ number_format($somaCustoFixo, 2) }}</td>
        <td>{{ number_format($somaComissao, 2) }}</td>
        <td>{{ number_format($somaLucro, 2) }}</td>
    </tr>
    </tbody>
</table>
@endforeach