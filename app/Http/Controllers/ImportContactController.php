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
        $rows = $request->getCsvRows();

        foreach ($rows as $row) {
            $request->user()->contacts()->create([
                'first_name' => $row[0],
                'last_name' => $row[1],
                'email' => $row[2],
                'phone' => $row[3],
                'address' => $row[4],
                'company_id' => $request->company_id
            ]);
        }

        return redirect()->route('contacts.index')->with('message', 'Contacts has been imported successfully');
    }
}
