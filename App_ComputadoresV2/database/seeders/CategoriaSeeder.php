<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Gamer',
                'descripcion' => 'Computadores de alto rendimiento para videojuegos.',
                'proveedor' => 'TechZone Colombia',
                'estado' => true,
            ],
            [
                'nombre' => 'Ofimática',
                'descripcion' => 'Equipos para tareas de oficina y uso académico.',
                'proveedor' => 'Computronix',
                'estado' => true,
            ],
            [
                'nombre' => 'Diseño Gráfico',
                'descripcion' => 'Equipos con GPU dedicada para programas de diseño.',
                'proveedor' => 'Creativa Store',
                'estado' => true,
            ],
            [
                'nombre' => 'Servidor',
                'descripcion' => 'Equipos para gestión de bases de datos y almacenamiento.',
                'proveedor' => 'DataCorp',
                'estado' => true,
            ],
            [
                'nombre' => 'Portátiles Livianos',
                'descripcion' => 'Ultrabooks y laptops para movilidad y uso diario.',
                'proveedor' => 'GlobalTech',
                'estado' => true,
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
