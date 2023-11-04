@extends('layouts.main')

@section('content')
<main class="py-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-title">
              <strong>Import Contacts</strong>
            </div>           
            <div class="card-body">
                <form action="{{ route('contacts.import.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group row">
                            <label for="file" class="col-md-3 col-form-label">File (in .csv)</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" accept=".csv" class="custom-file-input @error('csv') is-invalid @enderror" name="csv" id="csv">
                                    <label class="custom-file-label" for="csv">Choose file</label>
                                    @error('csv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <a class="form-text" href="{{ route('sample-contacts') }}">Download sample CSV</a>
                                </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="company_id" class="col-md-3 col-form-label">Company</label>
                            <div class="col-md-9">
                              <select name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror">
                                <option value="">Select Company</option>
                                @foreach ($companies as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                              </select>
                              @error('company_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>
                          </div>
                          <hr>
                          <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">Import</button>
                                <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                          </div>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@section('title', 'Contact App | Import Contacts')

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
    $(document).ready(function () {
      bsCustomFileInput.init()
    })
</script>
@endpush