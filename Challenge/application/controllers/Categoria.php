<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Categoria extends CI_Controller
{
    public function listCategorias()
    {
        $this->load->model('CategoriaModel');
        $categorias = $this->CategoriaModel->getCategorias();
        return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($categorias));

    }

    public function saveCategoria(){
        $materia = json_decode(file_get_contents('php://input'));
        $this->load->model('CategoriaModel');
        $this->CategoriaModel->saveCategoria($materia);
    }

    public function updateCategoria(){
        $categoria = json_decode(file_get_contents('php://input'));
        $this->load->model('CategoriaModel');
        $this->CategoriaModel->updateCategoria($categoria);
    }

    public function deleteCategoria(){
        $categoria = json_decode(file_get_contents('php://input'));
        $this->load->model('CategoriaModel');
        /*$valida = $this->MateriaModel->validaMateria($materia);
        if($valida[0]->no_regs > 0){
            return $this->output
            ->set_status_header(409)
            ->set_content_type('application/json')
            ->set_output(json_encode(array('msj'=> 'No se puede eliminar la materia, ya se encuentra asignada al menos a un alumno')));
        }*/
        $this->CategoriaModel->deleteCategoria($categoria);
    }

}