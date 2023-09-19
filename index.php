<?php

require __DIR__ . '/vendor/autoload.php';

use App\Entity\Vaga;
use App\Database\Pagination;

//Busca
$buscar = filter_input(INPUT_GET, 'buscar', FILTER_SANITIZE_STRING);
//Filtro status
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
$filtroStatus = in_array($filtroStatus ,['s', 'n']) ? $filtroStatus : '';

//Condições SQL
$condicoes = [
    strlen($buscar) ? 'titulo LIKE "%' . str_replace(' ', '%',$buscar) . '%"' : null,
    strlen($filtroStatus) ? 'ativo = "'. $filtroStatus . '"' : null
];
//Remove posições vazias no array
$condicoes = array_filter($condicoes);

$where = implode(' AND ', $condicoes);

//Quantidade total de vagas
$quantidadeVagas = Vaga::getQuantidadeVagas($where);

//Paginação
$obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 3);

//Obtêm as vagas
$vagas = Vaga::getVagas($where, null, $obPagination->getLimit());

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/listagem.php';
include __DIR__ . '/includes/footer.php';