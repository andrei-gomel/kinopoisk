<?php

namespace App\Services;

use App\Kernel\Database\DatabaseInterface;
use App\Models\Category;

class CategoryService
{    
    public function __construct(
        private DatabaseInterface $db
    )
    {
        
    }

    /**
     * @return array<Category>
     */
    
    public function all(): array
    {
        $categories = $this->db->get('categories');

        $categories = array_map(function($category){
            return new Category(
                $category['id'],
                $category['name'],
                $category['created_at'],
                $category['updated_at']
            );
        }, $categories);

        return $categories;
    }

    public function find(int $id): ?Category
    {
        $category = $this->db->first('categories', [
            'id' => $id
        ]);

        if(!$category)
            return null;

        return new Category(
            $category['id'],
            $category['name'],
            $category['created_at'],
            $category['updated_at'],
        );
    }

    public function update(int $id, string $name): void
    {
        $this->db->update('categories',            
            ['name' => $name],
            ['id'   => $id],
        );
    }

    public function delete(int $id): void
    {
        $this->db->delete('categories', [
            'id' => $id,
        ]);
    }

    public function store(string $name): int
    {
        return $this->db->insert('categories', [
            'name' => $name,
        ]);
    }    
}