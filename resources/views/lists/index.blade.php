@extends('app')

@section('content')
    <div class="row">
        <h1>@lang('all.heading')</h1>
    </div>
    <div class="row">
        <div class="btn-group">
            <button id="addButton" type="button" class="btn btn-success new-item" data-toggle="modal" data-target="#addModal">
                @lang('all.addBtn')
            </button>
        </div>
        <br>
        <div class="table-container">
            <h2>@lang('all.tableHeading')</h2>
            <table id="mytable" class="table">
                <thead>
                    <tr>
                        <th class="text-center col-xs-2">#</th>
                        <th class="text-center col-xs-2">Title</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td class="text-center col-xs-2">{{$task->id}}</td>
                            <td class="text-center col-xs-2">{{$task->title}}</td>
                            <td class="text-center col-xs-2 edit"><button id="{{'edit' . $task->id}}" value="{{$task->id}}" class="btn btn-primary" data-toggle="modal" data-target="#editModal">@lang('all.editItem')</button></td>
                            <td class="text-center col-xs-2 view"><button id="{{'view' . $task->id}}" value="{{$task->id}}" class="btn btn-danger" data-toggle="modal" data-target="#viewModal">@lang('all.viewItem')</button></td>
                            <td class="text-center col-xs-2 delete"><button id="{{'delete' .$task->id}}" value="{{$task->id}}" class="btn btn-success" data-toggle="modal" data-target="#deleteModal">@lang('all.deleteItem')</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title label label-default" id="exampleModalLabel">@lang('all.modalAdd')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="newName">@lang('all.modalTitle')</label>
                        <input  type="text" id="newName" class="form-control" autocomplete="off"><br>
                        <label for="newBody">@lang('all.modalBody')</label>
                        <textarea class="form-control" id="newBody" rows="6" autocomplete="off"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('all.modalClose')</button>
                        <button type="button" class="btn btn-primary" id="ajax-add">@lang('all.modalSave')</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title label label-default" id="exampleModalLabel">@lang('all.modalEdit')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="ediName">@lang('all.modalTitle')</label>
                        <input class="form-control" type="text" id="editName" value=""><br>
                        <label for="editBody">@lang('all.modalBody')</label>
                        <textarea class="form-control" id="editBody" rows="6"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('all.modalClose')</button>
                        <button type="button" class="btn btn-primary" id="ajax-edit">@lang('all.modalSave')</button>
                        <input type="hidden" value="" id="edit-identifier">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title label label-default" id="exampleModalLabel">@lang('all.modalShow')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>@lang('all.modalTitle')</strong>
                        <p id="taskName"></p>
                        <strong>@lang('all.modalBody')</strong>
                        <p id="taskBody"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('all.modalClose')</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
