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
        $contacts = Contact::forUser($request->user())
            ->with('company')
            ->latest()
            ->get();

        return response()->streamDownload(function () use ($contacts, $columns) {
            $resource = fopen('php://output', 'w');
            fputcsv($resource, $columns);

            $contacts->each(function ($row) use ($columns, $resource) {
                $rowData = [];

                foreach ($columns as $column) {
                    if ($column === 'company') {
                        $rowData[] = $row->company->name;
                    } else {
                        $rowData[] = $row->{$column};
                    }
                }

                fputcsv($resource, $rowData);
            });

            fclose($resource);
        }, "contacts" . time() . ".csv", [
            'Content-Type' => 'text/csv'
        ]);
    }
}
