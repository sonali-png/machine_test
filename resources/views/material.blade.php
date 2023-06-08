@extends('layout')
 
@section('content')
<div class="content">
    <div class="container">
    <div class="row">
        <div class="col">
            <h1> Save material </h1>
            <form action="{{ route('material.store') }}" method="POST" id="form">
                @csrf
                <div class="form-group">
                    <label>Material name </label>
                    <input type="text" class="form-control" name="name" value = "{{ $material_data->name ?? '' }}" required>
                    <input type="hidden" class="form-control" name="id" value = "{{ $material_data->id ?? 0 }}">
                </div>
                
                <div class="form-group">
                    <label for="sel1">Select category </label>
                    <select class="form-control" name="category_id" required> 
                        <option value=""> Select category</option>    
                        @forelse($categories as $category) 
                        <option value="{{$category->id}}" {{ ($category->id  ==  $material_data->category_id) ? 'selected' : '' }}> {{$category->name}} </option>
                        @empty 
                            {{""}}
                        @endforelse
                    </select>
                </div>

                <div class="form-group">
                    <label>Opening balance </label>
                    <input type="text" id="opening_balance" class="form-control" name="opening_balance" value = "{{ $material_data->opening_balance ?? '' }}" required>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <input type="submit" name="submit" value="Submit" class="btn btn-primary"> 
            </form>
        </div>
        <div class="col">
        <h1> List </h1>
        @if(isset($data) && $data->count() > 0)
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $datas)
                        <tr>
                            <td>{{ $datas->name }}</td>
                            <td>
                                <form action = "{{ route('material.destroy',$datas->id) }}" method="POST"> 
                                    @csrf @method('DELETE')
                                    <a class="btn btn-primary" href="{{ route('material.edit',$datas->id) }}"> Edit </a>
                                    <button class="btn btn-danger deleteRecord" data-id="{{ $datas->id }}" > Delete </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="{{$data->previousPageUrl()}}">Previous</a></li>
                    @for($i=1;$i<=$data->lastPage();$i++)
                        <li class="page-item">
                            <a class="page-link" href="{{$data->url($i)}}">{{$i}}</a>
                        </li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="{{$data->nextPageUrl()}}">Next</a></li>
                </ul>
                </nav>
            </div>  
        @else
            <p> No records found ! </p>
        @endif

        </div>
    </div>
    <p></p>
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    </div>

</div>
 
@endsection