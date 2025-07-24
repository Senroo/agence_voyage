<?php
namespace Utilities;

class JsonResponse{
    public static function send(array $data, int $httpCode = 200 ): void{
        http_response_code($httpCode);
        echo json_encode($data);
        exit; 
    }

    public static function success(string $message, int $httpCode = 200): void{
        self::send(['message' => $message], $httpCode);
    }

    public static function error(string $errorMessage, int $httpCode = 400, ?string $detail = null): void{
        $reponse = ['errorMessage' => $errorMessage];
        if($detail){
            $reponse['detail'] = $detail;
        }
        self::send($reponse, $httpCode);
    }
}