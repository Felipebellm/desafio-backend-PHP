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
        $conversion = $request->all();

        if (!isset($conversion['code_list']) &&
            is_string($conversion['code']) && 
            strpos($conversion['code'], ',')) {
                $conversion['code_list'] = array_map(
                    'trim', 
                    explode(',', $conversion['code'])
                );
        }
        
        if (!isset($conversion['number']) &&
            count($conversion['number_list']) == 1) {
            $conversion['number'] = $conversion['number_list'][0];
            $conversion['number_list'] = null;
        }

        $request->merge($conversion);

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