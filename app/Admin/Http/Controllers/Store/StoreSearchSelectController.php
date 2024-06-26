<?php

namespace App\Admin\Http\Controllers\Store;

use App\Admin\Http\Controllers\BaseSearchSelectController;
use App\Admin\Http\Resources\Store\StoreSearchSelectResource;
use App\Admin\Repositories\Store\StoreRepositoryInterface;

class StoreSearchSelectController extends BaseSearchSelectController
{
    public function __construct(
        StoreRepositoryInterface $repository
    ){
        $this->repository = $repository;
    }

    protected function selectResponse(){
        $this->instance = [
            'results' => StoreSearchSelectResource::collection($this->instance)
        ];
    }
}
