<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class AiHelper
{
    protected static $predictionServiceClient;

    public static function translate()
    {

    }

    public static function imageCaption($imageUrl)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ',
        ])->post('https://us-central1-aiplatform.googleapis.com/v1/projects/arts-2/locations/us-central1/publishers/google/models/imagetext:predict'
            , [
                "instances" => [
                    [
                        "image" => [
                            "bytesBase64Encoded" => "B64_IMAGE"
                        ]
                    ]
                ],
                "parameters" => [
                    "sampleCount" => 1,
                    "language" => "en"
                ]
            ]
        );

        print_r($response->body());
    }
}