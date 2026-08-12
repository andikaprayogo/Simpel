@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <a href="{{ route('forms.index') }}" class="me-3">
                <i class="fas fa-arrow-left text-dark" style="font-size: 24px;"></i>
            </a>
            <h2 class="mb-0">Form List</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('forms.list') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by title or site ID..." name="search" value="{{ $query ?? '' }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <select name="type" class="form-select" onchange="this.form.submit()">
                            <option value="">All Form Types</option>
                            <option value="ba-survey-mini-olt" {{ $type == 'ba-survey-mini-olt' ? 'selected' : '' }}>BA SURVEY MINI OLT</option>
                            <option value="ba-survey-big-olt" {{ $type == 'ba-survey-big-olt' ? 'selected' : '' }}>BA SURVEY BIG OLT</option>
                            <option value="caf" {{ $type == 'caf' ? 'selected' : '' }}>CAF</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($forms) && $forms->isEmpty())
        <div class="alert alert-info">
            No forms found {{ $query ? 'matching your search' : '' }} {{ $type ? 'for this type' : '' }}.
        </div>
    @elseif(isset($forms))
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Site ID</th>
                            <th>Type</th>
                            <th>Uploaded By</th>
                            <th>Uploaded On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forms as $form)
                            <tr>
                                <td>{{ $form->title }}</td>
                                <td>{{ $form->site_id }}</td>
                                <td>
                                    <span class="badge 
                                        @if($form->type == 'ba-survey-mini-olt') bg-primary
                                        @elseif($form->type == 'ba-survey-big-olt') bg-success
                                        @elseif($form->type == 'caf') bg-warning
                                        @else bg-secondary
                                        @endif">
                                        {{ $form->formatted_type }}
                                    </span>
                                </td>
                                <td>
                                    @if($form->user)
                                        @if(isset($form->user->full_name))
                                            {{ $form->user->full_name }}
                                        @elseif(isset($form->user->name))
                                            {{ $form->user->name }}
                                        @else
                                            {{ $form->user->email ?? 'Unknown' }}
                                        @endif
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                <td>{{ $form->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('forms.download', $form->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-4">
            {{ $forms->appends(['search' => $query ?? '', 'type' => $type ?? ''])->links() }}
        </div>
    @endif
</div>
@endsection