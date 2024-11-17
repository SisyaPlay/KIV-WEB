<?php

class Model_Album extends Model {
    public function get_images() {
        $query = $this->mysql->prepare("SELECT picture FROM article_pictures");
        $query->execute();
        $result = $query->get_result();

        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row['picture'];
        }

        return $images;
    }
}
