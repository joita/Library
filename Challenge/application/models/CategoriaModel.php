<?php 
class CategoriaModel extends CI_Model
{
    public $name;
    public $description;
    public function getCategorias()
    {
        $this->load->database();
        $query = $this->db->get('category');
        return $query->result();
    }
    
    public function saveCategoria($categoria)
    {
        $this->load->database();
        $this->name = $categoria->nombre;
        $this->description = $categoria->descripcion;
        $this->db->insert('category', $this);

    }

    public function updateCategoria($categoria)
    {
        $this->load->database();
        $this->name = $categoria->nombre;
        $this->description = $categoria->descripcion;
        $id = $categoria->id;
        $this->db->update('category', $this, array('id' => $id));

    }

    public function deleteCategoria($categoria)
    {
        $id = $categoria->id;
        $this->load->database();
        $this->db->where('id', $id);
        $this->db->delete('category');

    }

    public function validaCategoria($materia)
    {
        $this->load->database();
        $id = $materia->id;
        $query = $this->db->query('SELECT COUNT(id) as no_regs FROM asignaciones where asignaciones.id_materia = '.$id);
        return $query->result();
    }
}