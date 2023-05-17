@extends('layouts.master_backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Budget Estimation Table</div>
                <div class="card-body">
                    <br/>
                    <form method="post" action="{{route('save-budget')}}">
                    @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" class="form-control" name="idall">
                                <label>Budget Amount</label>
                                <input type="number" class="form-control" name="estimation">
                            </div>
                        </div>
                        <br/>
                        <button class="btn btn-info">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection
