<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GlobalCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentación', 'descripcion' => 'Compras de supermercado y restaurantes'],
            ['name' => 'Transporte', 'descripcion' => 'Gasolina, transporte público, mantenimiento'],
            ['name' => 'Vivienda', 'descripcion' => 'Alquiler, hipoteca, servicios básicos'],
            ['name' => 'Ocio', 'descripcion' => 'Entretenimiento, cine, hobbies'],
            ['name' => 'Salud', 'descripcion' => 'Medicamentos, consultas, seguros'],
            ['name' => 'Educación', 'descripcion' => 'Cursos, libros, formación online'],
            ['name' => 'Suscripciones', 'descripcion' => 'Netflix, Spotify, etc.'],
            ['name' => 'Ingresos', 'descripcion' => 'Salarios y entradas de dinero'],
            ['name' => 'Ahorro', 'descripcion' => 'Depósitos y ahorros personales'],
            ['name' => 'Deudas y Préstamos', 'descripcion' => 'Pagos a créditos o tarjetas'],
        ];

        foreach ($categories as $cat) {
            Categories::firstOrCreate([
                'name' => $cat['name'],
                'user_id' => null
            ], $cat);
        }
    }
}
