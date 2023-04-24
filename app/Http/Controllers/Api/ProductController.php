<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Create;
use Illuminate\Http\Request;
use App\Service\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductController extends Controller
{
    private $service;

    public function __construct(ProductService $Productservice)
    {
        $this->service = $Productservice;
    }

    public function index(Request $request)
    {
        $data = $this->service->collections($request);
        return new ProductCollection($data);

    }

    public function store(Create $request)
    {
        $data = $this->service->store($request);
        return new ProductResource($data);
    }

    public function show($id)
    {
        $data = $this->service->resource($id);
        return new ProductResource($data);
    }

    public function update(Request $request, $id)
    {
        $data = $this->service->update($request, $id);
        return new ProductResource($data);
    }

    public function destroy($id)
    {
        $data = $this->service->delete($id);
        return $data;
    }
}
