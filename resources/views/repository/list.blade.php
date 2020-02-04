@extends('layouts.app')
@section('pageTitle', 'Repository List')
@section('content')
    <section class="box-typical">
        <div id="toolbar-git-repositories">
            <div class="bootstrap-table-header"><i class="fa fa-list-ul color-blue"></i> Repository List</div>
            <a href="{{route('repositories.createPage')}}" data-toggle="modal" data-target="#modalsm"
               class="btn btn-sm btn-success"><i class="fa fa-plus"></i> <span
                    class="hidden-xs-down">Add Git Repository</span></a>
        </div>
        <table class="vtbl" id="git-repositories"
               data-toolbar="#toolbar-git-repositories"
               data-search="true"
               data-show-refresh="true"
               data-pagination="true"
               data-id-field="id"
               data-unique-id="id"
               data-page-list="[10, 25, 50, 100, 250]"
               data-side-pagination="server"
               data-icon-size="xs"
               data-sort-name="id"
               data-sort-order="asc"
               data-striped="true"
               data-url="{{route('repositories.get')}}">
            <thead>
            <tr>
                <th data-field="order" data-class="text-center wd-50 hidden-xs-down">#</th>
                <th data-field="status" data-class="wd-100">Status</th>
                <th data-field="provider" data-class="text-center wd-100">Provider</th>
                <th data-field="slug" data-class="wd-250">Name</th>
                <th data-field="checked_at" data-class="wd-200">Checked At</th>
                <th data-field="created_at" data-class="wd-200" data-sortable="true">Created At</th>
            </tr>
            </thead>
        </table>
    </section>
@endsection

