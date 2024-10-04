<?php
include_once "DAL/table.php";
include_once "DAL/models/type.php";

class Genres extends Table {

    public function get($id) {
        $genre = $this->db->selectWhere("genresarmes", [["id", "=", $id]]);

        if (count($genre) > 0) $genre = $genre[0];
        else return null;

        return $this->parseData($genre);
    }

    public function toList() {
        $list = [];
        $genres = $this->db->selectAll("genresarmes");
        
        foreach($genres as $genre) {
            $list[] = $this->parseData($genre);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $genres = $this->db->selectWhere("genresarmes", $conditions);
        
        foreach($genres as $genre) {
            $list[] = $this->parseData($genre);
        }

        return $list;
    }

    private function parseData($data) {
        return new Type (
            $data["id"],
            $data["genre"]
        );
    }
}