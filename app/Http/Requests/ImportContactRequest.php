<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class ImportContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'csv' => 'required',
            'company_id' => 'required|exists:companies,id',
        ];
    }

    public function getCsvRows(): array
    {
        $rows = [];

        $path = Storage::putFile('csv-files', $this->file('csv'));
        $stream = Storage::readStream($path);

        $isHeader = true;
        while ($row = fgetcsv($stream)) {
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            $rows[] = $row;
        }

        Storage::delete($path);

        return $rows;
    }
}
