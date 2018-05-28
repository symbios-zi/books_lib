<?php

namespace App\Http\Requests;

use App\Services\LoggerService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ScannerRequest extends FormRequest
{
    /**
     * @var LoggerService
     */
    private $loggerService;

    /**
     * ScannerRequest constructor.
     * @param LoggerService $loggerService
     */
    public function __construct(LoggerService $loggerService)
    {
        $this->loggerService = $loggerService;
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cover' => 'url',
            'title' => 'required|string',
            'year' => 'date_format:Y',
            'author_name' => 'required|string'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $this->loggerService->logError($errors);


        throw new HttpResponseException(
            response()->json(
                [
                    'success' => false,
                    'errors' => $errors
                ],JsonResponse::HTTP_BAD_REQUEST)
        );

    }
}
