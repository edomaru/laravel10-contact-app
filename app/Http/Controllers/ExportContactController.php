<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ExportContactController extends Controller
{
    public function create()
    {
        $columns = ['first_name', 'last_name', 'email', 'phone', 'address', 'company'];

        return view('contacts.export', compact('columns'));
    }

    public function store(ExportContactRequest $request)
    {
        $columns = $request->columns;
        dd($columns);
    }
}
