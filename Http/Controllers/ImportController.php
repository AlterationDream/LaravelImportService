<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\ImportRequest;
use App\Services\Import\ImportFrom1CService;
use Exception;

class ImportController extends Controller
{
    /**
     * @throws Exception
     */
    public function innerPayments(ImportRequest $request, ImportFrom1CService $importService)
    {
        $validatedData = $request->validated()['data'];
        unset($request);
        $importService->importInnerPayments($validatedData);
    }

    /**
     * @throws Exception
     */
    public function contractPayments1C(ImportRequest $request, ImportFrom1CService $importService)
    {
        $validatedData = $request->validated()['data'];
        unset($request);
        $importService->importContractPayments1C($validatedData);
    }

    /**
     * @throws Exception
     */
    public function contractExecutions(ImportRequest $request, ImportFrom1CService $importService)
    {
        $validatedData = $request->validated()['data'];
        unset($request);
        $importService->importContractExecutions($validatedData);
    }

    /**
     * @throws Exception
     */
    public function subContractors(ImportRequest $request, ImportFrom1CService $importService)
    {
        $validatedData = $request->validated()['data'];
        unset($request);
        $importService->importSubContractors($validatedData);
    }
}