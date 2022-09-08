<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Microgen\MicrogenClient;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var MicrogenClient
     */
    private $client;

    public function __construct() {
        $this->client = app(MicrogenClient::class);
    }

    /**
     * Get all products.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProducts() {
        $res = $this->client->service('products')->find();

        if (!is_null($res['error'])) {
            if ($res['error']['message'] === "project not found") {
                return response()->json(
                    [
                    'message' => 'failed to connect to your project, please check if the api had been set properly.'
                    ],
                    $res['status']
                );
            };

            return response()->json($res['error'], $res['status']);
        };

        return response()->json($res['data']);
    }

    /**
     * Get product by id.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function getProductById($id) {
        $res = $this->client->service('products')->getById($id);

        if (!is_null($res['error'])) {
            if ($res['error']['message'] === "project not found") {
                return response()->json(
                    [
                    'message' => 'failed to connect to your project, please check if the api had been set properly.'
                    ],
                    $res['status']
                );
            };

            return response()->json($res['error'], $res['status']);
        };

        return response()->json($res['data']);
    }

    /**
     * Create product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createProduct(Request $request) {
        $body = $request->all();

        if (count($body) == 0) {
            return response()->json(['message' => 'request body cannot be empty'], 400);
        }

        $res = $this->client->service('products')->create($body);

        if (!is_null($res['error'])) {
            if ($res['error']['message'] === "project not found") {
                return response()->json(
                    [
                    'message' => 'failed to connect to your project, please check if the api had been set properly.'
                    ],
                    $res['status']
                );
            };

            return response()->json($res['error'], $res['status']);
        };

        return response()->json($res['data']);
    }

    /**
     * Update the given product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request, $id) {
        $body = $request->all();

        if (count($body) == 0) {
            return response()->json(['message' => 'request body cannot be empty'], 400);
        }

        $res = $this->client->service('products')->updateById($id, $body);

        if (!is_null($res['error'])) {
            if ($res['error']['message'] === "project not found") {
                return response()->json(
                    [
                    'message' => 'failed to connect to your project, please check if the api had been set properly.'
                    ],
                    $res['status']
                );
            };

            return response()->json($res['error'], $res['status']);
        };

        return response()->json($res['data']);
    }

    /**
     * Delete product by id.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct($id) {
        $res = $this->client->service('products')->deleteById($id);

        if (!is_null($res['error'])) {
            if ($res['error']['message'] === "project not found") {
                return response()->json(
                    [
                    'message' => 'failed to connect to your project, please check if the api had been set properly.'
                    ],
                    $res['status']
                );
            };

            return response()->json($res['error'], $res['status']);
        };

        return response()->json($res['data']);
    }
}
