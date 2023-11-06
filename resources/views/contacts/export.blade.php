@extends('layouts.main')

@section('content')
<main class="py-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-title">
              <strong>Export Contacts</strong>
            </div>           
            <div class="card-body">
                <form action="{{ route('contacts.export.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Select columns</label>
                            @error('columns')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @foreach ($columns as $index => $column)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="columns[{{ $index }}]" @checked(old("columns.{$index}")) value="{{ $column }}" id="{{ $column }}">
                                    <label class="form-check-label" for="{{ $column }}">
                                        {{ $column }}
                                    </label>
                                </div>                                
                            @endforeach
                          </div>
                
                          <hr>
                          <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">Export</button>
                            <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary">Cancel</a>
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