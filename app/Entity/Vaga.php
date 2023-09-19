<?php 

namespace App\Entity;

use App\database\DataBase;
use \PDO;

class Vaga
{
    public $id;

    public $titulo;

    public $descricao;

    public $ativo;

    //Data de publicação da vaga
    public $data;

    //Metódo responsável por cadastrar uma nova vaga no BD
    public function cadastrar()
    {
        //Define a data do cadastro
        $this->data = date('Y-m-d H:i:s');
        //Insere as informações no BD
        $database = new Database('vagas');
        $this->id = $database->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        //Retornar sucesso
        return true;
    }


    /**
     * Método responsável por atualizar a vaga no banco
     * @return bool
     */
    public function atualizar()
    {
        return (new Database('vagas'))->update('id = ' . $this->id, [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);
    }

    /**
     * Método responsável por excluir a vaga no banco
     * @return bool
     */
    public function excluir()
    {
        return (new Database('vagas'))->delete('id =' . $this->id);
    }

    /**
     * Método responsável por obter as vagas do banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */

    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new DataBase('vagas'))->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter a quantidade de vagas do banco
     * @param string $where
     * @return integer
     */

     public static function getQuantidadeVagas($where = null)
     {
         return (new DataBase('vagas'))->select($where, null, null, 'COUNT(*) AS qtd')->fetchObject()->qtd;
     }


    /**
     * Método responsável por buscar uma vaga no banco com base no seu id
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id)
    {
        return (new DataBase('vagas'))->select('id = ' . $id)->fetchObject(self::class);
    }
}