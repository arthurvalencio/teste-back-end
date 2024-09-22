<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os produtos de uma API externa e os salva no banco de dados da aplicação.';

    public function __construct() {
        parent::__construct();
    }

    public function handle(): void
    {
        $id = $this->option('id');

        $url = 'https://fakestoreapi.com/products';

        if ($id) {
            $url .= '/' . $id;
        }

        $response = Http::withOptions([
            'verify' => storage_path('cacert.pem')
        ])->get($url);

        if ($response->successful()) {
            $products = $id ? [$response->json()] : $response->json();

            foreach ($products as $product) {
                $categoryName = $product['category'];
                $category = Category::firstOrCreate(['name' => $categoryName]);

                $productCheck = Product::where('name', $product['title'])->first();

                if ($productCheck) {
                    $productCheck->update([
                        'name' => trim($product['title']),
                        'price' => $product['price'],
                        'description' => trim($product['description']),
                        'category' => $category->id,
                        'image_url' => trim($product['image'])
                    ]);

                    $this->info("Produto '{$product['title']}' atualizado.");
                } else {
                    Product::create([
                        'name' => trim($product['title']),
                        'price' => $product['price'],
                        'description' => trim($product['description']),
                        'category' => $category->id,
                        'image_url' => trim($product['image'])
                    ]);

                    $this->info("Produto '{$product['title']}' importado.");
                }
            }
        } else {
            $this->error('Erro ao importar os produtos.');
        }
    }
}
