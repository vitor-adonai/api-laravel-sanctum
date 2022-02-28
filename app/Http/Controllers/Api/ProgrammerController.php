<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Programmer;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProgrammerController extends Controller
{

    use ApiResponder;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request) :JsonResponse
    {
        $programmers = Programmer::paginate(10);
        return $this->success(
            "Programmers",
            $programmers->toArray(),
        );
    }
}
