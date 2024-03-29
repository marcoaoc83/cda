<?php

namespace App\Helpers;

use App\Helpers\RecastAI\Client;


class RecastAI {

    private $recastai;

    /**
     * Constructor
     * @param string $token
     * @param string $language
     */
    public function __construct() {
        $token= env('RECASTAI_TOKEN','32af5b8eacd51b2fbe0a9526eee4a9d5');
        $language =env('LANGUAGE','pt');
        $this->recastai = new Client($token, $language);
    }


    public function get():Client  {
        return $this->recastai;
    }


}
