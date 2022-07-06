<?php


namespace core\interfaces;

interface AutomaticDataGrid{
    /**
     * busca dados para o componente DataGrid.
     *
     * @param string|array $headers
     * @param array $limit [inicio,fim]
     * @param array $search
     * @return array objects
     */
     public function getDataGrid($headers="*",$limit=null,$search=null);

     /**
      * Retorna o total de registros da grid (usado para fazer o paginator);
      *
      * @return void
      */
     public function countDataGrid($seach=null);
}