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
    public function __construct($token, $language) {
        $this->recastai = new Client($token, $language);
    }


    public function get() : Client  {
        return $this->recastai;
    }


}
