<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Jobs\ProductsImportJob;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    // the seller will be able to upload products by csv
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file')->store('files');

        if ($file) {
            ProductsImportJob::dispatch($file, $request->user()->id);
            return back()->with('status', 'Import is in progress, refresh after a while');
        }

        return abort(Response::HTTP_INTERNAL_SERVER_ERROR, 'Something went wrong, please try again.');
    }

}
