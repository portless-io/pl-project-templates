<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request;
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

    public function createProduct(Request $request) {
        $res = $this->client->service('products')->create($request);

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

    public function updateProduct(Request $request, $id) {
        $res = $this->client->service('products')->updateById($id, $request);

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
