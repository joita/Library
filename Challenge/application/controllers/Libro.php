<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Libro extends CI_Controller
{
    public function listaLibros()
    {
        $this->load->model('LibroModel');
        $libros = $this->LibroModel->getLibros();
        return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($libros));

    }

    public function saveLibros(){
        $libros = json_decode(file_get_contents('php://input'));
        $this->load->model('LibroModel');
        $this->LibroModel->saveLibro($libros);
    }

    public function deleteLibros(){
        $libros = json_decode(file_get_contents('php://input'));
        $this->load->model('LibroModel');
        $this->LibroModel->deleteLibro($libros);
    }


}