<?php

namespace services;

use BaseRepository;

class MovieService {

    public  function find_all_movies($limit,$offset,$orderby,$order){

        $result =  BaseRepository::get_base_repository()
            ->get_movie_repository()
            ->get_movie_data_for_list_table($limit,$offset,$orderby,$order);

        return $result;
    }

    public function find_movie_by_id($id) {

        $result = BaseRepository::get_base_repository()->get_movie_repository()->get_movie_by_id($id);

        return $result;
    }

    public function find_movie_by_name($name, $limit, $offset, $orderby, $order) {

        $result = BaseRepository::get_base_repository()
            ->get_movie_repository()
            ->get_movie_by_name($name, $limit,$offset,$orderby,$order);

        return $result;
    }

    public function delete_movie($id) {

        $result = BaseRepository::get_base_repository()->get_movie_repository()->delete_movie($id);
        return $result;
    }

    public function update_movie($id, $movie) {


        $movie = $this->check_recommended_age_for_movie($movie);

        if(!$movie || !$this->check_movie_category($movie['movie_category_id'])){
            return false;
        }

        $result = BaseRepository::get_base_repository()->get_movie_repository()->update_movie($id, $movie);

        return $result;
    }

    public function save_movie($movie) {

        $movie = $this->check_recommended_age_for_movie($movie);

        if(!$movie || !$this->check_movie_category($movie['movie_category_id'])){
            return false;
        }

        $result = BaseRepository::get_base_repository()->get_movie_repository()->save_new_movie($movie);

        return $result;
    }

    private function check_recommended_age_for_movie($movie) {


        $recommended_age = get_option('horror_movie_min_age_option');

        $category = BaseRepository::get_base_repository()->get_movie_category_repository()->get_movie_category_by_id($movie['movie_category_id']);

        if (!$category) {

            return false;
        }

        if ($category['movie_category_slug'] === 'horor' && $movie['movie_age'] < $recommended_age) {
            $movie['movie_age'] = $recommended_age;
        }

        return $movie;


    }
    private function check_movie_category($id){

        return BaseRepository::get_base_repository()
            ->get_movie_category_repository()->get_movie_category_by_id($id);

    }


}