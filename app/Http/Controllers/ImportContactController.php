<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportContactRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class ImportContactController extends Controller
{
    public function create()
    {
        $companies = Company::forUser(auth()->user())
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('contacts.import', compact('companies'));
    }

    public function store(ImportContactRequest $request)
    {
        dd("import");
    }
}
