<?php 
class UsuarioModel extends CI_Model
{
    public $name;
    public $email;
    public function getUsuarios()
    {
        $this->load->database();
        $query =  $this->db->get('usuario');
        return $query->result();
    }

    public function saveUsuario($usuario)
    {
        $this->load->database();
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->db->insert('usuario', $this);

    }

    public function updateUsuario($usuario)
    {
        $this->load->database();
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $id = $usuario->id;
        $this->db->update('usuario', $this, array('id' => $id));

    }

    public function deleteUsuario($usuario)
    {
        $id = $usuario->id;
        $this->load->database();
        $this->db->where('id', $id);
        $this->db->delete('usuario');

    }

    /*public function validaUsuario($alumno)
    {
        $this->load->database();
        $id = $alumno->id;
        $query = $this->db->query('SELECT COUNT(id) as no_regs FROM asignaciones where asignaciones.id_alumno = '.$id);
        return $query->result();
    }*/

}