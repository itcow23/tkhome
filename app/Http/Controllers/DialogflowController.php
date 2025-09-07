<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DialogflowController extends Controller
{
    // public function handle(Request $request)
    // {
    //     $query = $request->input('queryResult.queryText'); // câu hỏi từ user
    //     $intent = $request->input('queryResult.intent.displayName'); // tên intent

    //     $responseText = "Xin chào! Tôi là trợ lý ảo của TK Home. Bạn cần giúp gì?";

    //     switch ($intent) {
    //         case 'hỏi giá bàn ăn':
    //             $responseText = $this->hoiGiaBanAn($request);
    //             break;
    //         // Thêm các case khác cho các intent khác nếu cần
    //         default:
    //             $responseText = "Xin lỗi, tôi không hiểu câu hỏi của bạn.";
    //             break;
    //     }

    //     return response()->json([
    //         'fulfillmentText' => $responseText
    //     ]);
    // }

    // private function hoiGiaBanAn(Request $request)
    // {
    //     $tableName = $request->input('queryResult.parameters.table_name');

    //     if (!$tableName) {
    //         return "Bạn vui lòng cung cấp tên bàn ăn để tôi có thể giúp bạn.";
    //     }

    //     $product = Product::where('name', 'LIKE', "%$tableName%")->first();
    //     if ($product) {
    //         $responseText = "Bàn ăn '{$product->name}' hiện có giá {$product->price} VND.";
    //     } else {
    //         $responseText = "Hiện tại tôi chưa tìm thấy sản phẩm bàn ăn trong kho.";
    //     }

    //     return $responseText;
    // }

public function handle(Request $request)
{
    $query = $request->input('queryResult.queryText'); // câu hỏi từ user
    $intent = $request->input('queryResult.intent.displayName'); // tên intent

    $responseMessages = [];

    switch ($intent) {
        case 'hỏi giá bàn ăn':
            $responseMessages = $this->hoiGiaBanAn($request);
            break;

        default:
            $responseMessages = [
                [
                    "text" => [
                        "text" => ["Xin lỗi, tôi không hiểu câu hỏi của bạn."]
                    ]
                ]
            ];
            break;
    }

    return response()->json([
        "fulfillmentMessages" => $responseMessages
    ]);
}

private function hoiGiaBanAn(Request $request)
{
    $tableName = $request->input('queryResult.parameters.table_name');

    if (!$tableName) {
        return [
            [
                "text" => [
                    "text" => ["Bạn vui lòng cung cấp tên bàn ăn để tôi có thể giúp bạn."]
                ]
            ]
        ];
    }

    $product = Product::where('name', 'LIKE', "%$tableName%")->first();

    if ($product) {
        $text = "Bàn ăn '{$product->name}' hiện có giá {$product->price} VND.";
        $imageUrl = ('http://127.0.0.1:8000/products') . '/' . ($product->img ?? "https://example.com/no-image.jpg"); // cột image trong DB

        return [
            [
                "text" => [
                    "text" => [$text]
                ]
            ],
            [
                "payload" => [
                    "richContent" => [
                        [
                            [
                                "type" => "image",
                                "rawUrl" => $imageUrl,
                                "accessibilityText" => $product->name
                            ]
                        ]
                    ]
                ]
            ]
        ];
    } else {
        return [
            [
                "text" => [
                    "text" => ["Hiện tại tôi chưa tìm thấy sản phẩm bàn ăn trong kho."]
                ]
            ]
        ];
    }
}

}
