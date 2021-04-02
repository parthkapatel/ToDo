@extends("welcome")
@section("title","To DO Notes")


@section("content")

    <div class="container" id="mainDiv" xmlns="http://www.w3.org/1999/html">
        <div class="container border-bottom bg-dark row" id="heading">
            <div class="col-lg-6 col-sm-6 text-left w-auto form-inline">
                <h4 class="text-light p-2">To Do</h4>
                <input type="text" class="form-control w-auto" placeholder="Type here to search..." id="search" name="search">
            </div>
            <div class="col-lg-6 col-sm-6 text-right w-auto">
                <i class="bi bi-trash text-white p-2 h-25 w-25" id="trash"></i>
                <button type="button" class="btn btn-primary" name="add" id="btnAdd">Add Task</button>
            </div>
        </div>
        <div class="row p-0">
            <div class="container m-0 p-0 col-lg-6 col-md-12 border-right" id="listDiv">
                <div class="container m-0 p-0" id="subDiv" style="cursor: default;">




                </div>
            </div>
            <div class="container col-lg-6 col-md-12" id="addDiv">
                <p class="lead text-center" id="selectTitle">Select Task</p>
                <div class="container my-5" id="formDiv">
                    <form method="post" id="" class="form">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                   name="title" placeholder="Title" value="" autocomplete="title" autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="startDate">Start Date</label>
                                <input type="date" class="form-control"  id="startDate" min="" name="startDate"
                                       placeholder="First name">
                            </div>
                            <div class="col">
                                <label for="dueDate">Due Date</label>
                                <input type="date" class="form-control" min=""  id="dueDate" name="dueDate"
                                       placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <input type="button" name="add" id="addData" class="btn btn-success" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
