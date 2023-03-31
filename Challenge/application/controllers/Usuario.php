<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Usuario extends CI_Controller
{
    public function listaUsuarios()
    {
        $this->load->model('UsuarioModel');
        $usuarios = $this->UsuarioModel->getUsuarios();
        return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($usuarios));

    }
    public function saveUsuario(){
        $usuario = json_decode(file_get_contents('php://input'));
        $this->load->model('UsuarioModel');
        $this->UsuarioModel->saveUsuario($usuario);
    }

    public function updateUsuario(){
        $usuario = json_decode(file_get_contents('php://input'));
        $this->load->model('UsuarioModel');
        $this->UsuarioModel->updateUsuario($usuario);
    }

    public function deleteUsuario(){
        $usuario = json_decode(file_get_contents('php://input'));
        $this->load->model('UsuarioModel');
        /*$valida = $this->UsuarioModel->validaAlumno($usuario);
        if($valida[0]->no_regs > 0){
            return $this->output
            ->set_status_header(409)
            ->set_content_type('application/json')
            ->set_output(json_encode(array('msj'=> 'No se puede eliminar el alumno, ya tiene materias asignadas')));
        }*/
        $this->UsuarioModel->deleteUsuario($usuario);
    }
    
}