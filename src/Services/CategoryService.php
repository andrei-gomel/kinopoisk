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
}