<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CurrencyIsoController extends Controller
{

    use ValidatesRequests;

    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }
    
    public function fetchCurrency(Request $request)
    {
        $validatedData = $this->validate($request, [
            'code' => 'nullable|string',
            'code_list' => 'nullable|array',
            'number' => 'nullable|integer',
            'number_list' => 'nullable|array'
        ]);

        $data = $this->currencyService->fetchCurrencyData($validatedData);

        return response()->json($data);
    }

}