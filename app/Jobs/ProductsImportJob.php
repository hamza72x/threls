<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ProductsImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 5 * 60;

    public $filepath;
    public $seller_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stored_file, $seller_id)
    {
        $this->filepath = storage_path('app/' . $stored_file);
        $this->seller_id = $seller_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (($handle = fopen($this->filepath, "r")) !== FALSE) {

            $header = null;
            $slugify = function ($string) {
                return Str::slug($string, '_');
            };

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($header === null) {
                    $header = array_map($slugify, $data);
                } else {
                    $row = array_combine($header, $data);

                    $name = $row['product_name'];
                    $brand = $row['brand'];
                    // price has symbol, so keep only numbers (in float)
                    $price = floatval(preg_replace('/[^0-9.]/', '', $row['price']));

                    if ($name && $brand && $price && strlen($name) > 0 && strlen($brand) > 0 && $price > 0) {
                        Product::firstOrCreate([
                            'user_id' => $this->seller_id,
                            'name' => $name,
                            'brand' => $brand,
                            'price' => $price,
                        ]);
                    }
                }
            }

            // should've added some status of this job in DB
            // so that we can check if it's completed or not

            fclose($handle);
        }

        unlink($this->filepath);
    }
}
