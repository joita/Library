<?php
class LibroModel extends CI_Model
{
    public $name;
    public $author;
    public $category_id;
    public $publish_date;
    public $user_id;
    public function getLibros()
    {
        $this->load->database();
        $query = $this->db->query("
        SELECT b.id, b.name, b.author, b.category_id, b.publish_date, b.user_id, c.name as categoria, u.name as usuario, case when user_id is not null then 'NO DISPONIBLE'  when user_id is null then 'DISPONIBLE' end as estatus_text
        FROM book b
        inner join category c on c.id = b.category_id 
        left join usuario u on u.id = b.user_id ;");
        return $query->result();
    }

    public function saveLibro($libro)
    {
        $this->load->database();
        $this->name = $libro->nombreLibro;
        $this->author = $libro->autor;
        $this->category_id = $libro->idCategoria;
        $this->publish_date = $libro->date;
        $this->user_id = $libro->idUsuario;
        $this->db->insert('book', $this);
    }

    public function deleteLibro($libro)
    {
        $id = $libro->id;
        $this->load->database();
        $this->db->where('id', $id);
        $this->db->delete('book');

    }
}