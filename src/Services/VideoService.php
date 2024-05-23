<?php

namespace App\Services;

use App\Kernel\Database\DatabaseInterface;
use App\Kernel\Upload\UploadedFileInterface;
use App\Models\Video;

class VideoService
{
    public function __construct(
        private DatabaseInterface $db
    )
    {
        
    }

    public function all(): array
    {
        $movies = $this->db->get('movies');

        return array_map(function($movie){
            return new Video(
                $movie['id'],
                $movie['name'],
                $movie['description'],
                $movie['preview'],
                $movie['category_id'],
            );
        }, $movies);
    }
    
    public function store(string $name, string $description, UploadedFileInterface $image, int $category): false|int
    {
        $filePath = $image->move('video');
        
        $id = $this->db->insert('movies', [
            'name' => $name,
            'description' => $description,
            'preview' => $filePath,
            'category_id' => $category,
        ]);

        return $id;
    }

    public function find(int $id): ?Video
    {
        $video = $this->db->first('movies', [
            'id' => $id,
        ]);

        if(!$video)
            return null;

        return new Video(
            $video['id'],
            $video['name'],
            $video['description'],
            $video['preview'],
            $video['category_id'],
        );
    }

    public function update(int $id, string $name, string $description, ?UploadedFileInterface $image, int $category): void
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'category_id' => $category,
        ];

        if($image && !$image->hasError())
        {
            $filePath = $image->move('video');
            $data['preview'] = $filePath;
        }
            
        $this->db->update('movies', $data, [
            'id' => $id,
        ]);
        
    }

    public function destroy(int $id)
    {
        $this->db->delete('movies', [
            'id' => $id
        ]);
    }
}