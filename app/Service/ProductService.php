<?php

namespace App\Service;

use App\Models\Product;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    private $model;

    public function __construct(Product $ProductModel)
    {
        $this->model = $ProductModel;
    }

    public function collections($data)
    {
        $productCollection = '';
        $products = $this->model;
        if (isset($data->search) || $data->search != null) {
            $search = $data->search;
            $productCollection = $products->where('name', 'LIKE', '%' . $search . '%');
        }
        if ($data->page = -1) {
            $productCollection = $products->get();
        } else {
            $productCollection = $products->paginate(10);
        }

        return $productCollection;
    }

    public function store($data)
    {

        $product = $this->model->create([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price
        ]);

        if ($data->hasFile('image')) {
            $file = $data->file('image');
            $filename = Str::random(4) . '-' . $file->getClientOriginalName();
            $file->storeAs('public/product/image', $filename);
            $product->image = $filename;
            $product->save();
        }
        return $product;
    }

    public function resource($id)
    {
        $product = $this->model->findOrFail($id);
        return $product;
    }

    public function update($data, $id)
    {
        $GetProduct = $this->resource($id);
        $product = $this->model->where('id', $id)->update([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price
        ]);
        if ($data->hasFile('image')) {
            if ($GetProduct->image != null) {
                Storage::disk('public')->delete(public_path('storage/public/product/image/' . $GetProduct->getRawOriginal('image')));
            }
            $file = $data->file('image');
            $filename = Str::random(4) . '-' . $file->getClientOriginalName();
            $file->storeAs('public/product/image', $filename);
            $GetProduct->image = $filename;
            $GetProduct->save();
        }

        return $GetProduct;
    }

    public function delete($id)
    {
        $data = [];
        $product = $this->resource($id);
        if ($product->image != null) {
            Storage::disk('public')->delete(public_path('storage/public/product/image/' . $product->getRawOriginal('image')));
        }
        if ($product->delete() == true) {
            $data['message'] = __('validation.deletedSucessfully');
        }

        return $data;
    }
}
