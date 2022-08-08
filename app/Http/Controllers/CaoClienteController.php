<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaoClienteController extends Controller
{
    //
    public function index(Request $request) {

        /*$this->validate($request, [
            'consultor' => 'required',
            'mes_emissao' => 'required',
            'ano_emissao' => 'required'
        ]);*/

        return view('perfomance.clientes')
        ->with(
            [
                'clientes' => $this->getClientes(), 
                'receita_liquida' => $this->getReceitaLiquida(
                    'Toyota do Brasil', 
                    1, 
                    2007,
                    12, 
                    2022)
            ]
        );
    }

    public function getClientes()
    {
        $clientes = DB::select("
        SELECT 
            no_fantasia AS no_cliente
        FROM 
            cao_cliente
        WHERE
            tp_cliente = 'A'"
        );

        return $clientes;
    }

    public function getReceitaLiquida(string $cliente, int $mes_inicio, int $ano_inicio, int $mes_fim, int $ano_fim) {
        
        $receitaLiquida = DB::select(
            "SELECT 
                cao_cliente.no_fantasia AS cliente,
                SUM(cao_fatura.valor - (cao_fatura.valor * (cao_fatura.total_imp_inc/100))) AS receita_liquida,
                MONTH(cao_fatura.data_emissao) AS mes_emissao,
                YEAR(cao_fatura.data_emissao) AS ano_emissao
            FROM
                cao_cliente   
            INNER JOIN 
                (cao_fatura)
            INNER JOIN 
                (cao_os)
            ON 
                cao_fatura.co_cliente = cao_cliente.co_cliente
            AND 
                cao_os.co_os = cao_fatura.co_os
            AND 
                cao_cliente.no_fantasia = :nome_cliente
            AND 
                MONTH(cao_fatura.data_emissao) >= :mes_inicio
            AND
                MONTH(cao_fatura.data_emissao) <= :mes_fim
            AND 
                YEAR(cao_fatura.data_emissao) >= :ano_inicio
            AND
                YEAR(cao_fatura.data_emissao) <= :ano_fim
            GROUP BY cliente, mes_emissao, ano_emissao
            ORDER BY mes_emissao    
            ", [
                'nome_cliente' => $cliente, 
                'mes_inicio' => $mes_inicio, 
                'ano_inicio' => $ano_inicio,
                'mes_fim' => $mes_fim,
                'ano_fim' => $ano_fim
            ]);
        
        return $receitaLiquida;
    }

}

