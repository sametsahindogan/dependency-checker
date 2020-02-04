@extends('layouts.app')
@section('pageTitle', 'E-Mail List')
@section('content')
    <section class="box-typical">
        <div id="toolbar-emails">
            <div class="bootstrap-table-header"><i class="fa fa-list-ul color-blue"></i> E-Mail List</div>
            <a href="{{route('emails.createPage')}}" data-toggle="modal" data-target="#modalsm"
               class="btn btn-sm btn-success"><i class="fa fa-plus"></i> <span
                    class="hidden-xs-down">Add E-Mail Address</span></a>
        </div>
        <table class="vtbl" id="emails"
               data-toolbar="#toolbar-emails"
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
               data-url="{{route('emails.get')}}">
            <thead>
            <tr>
                <th data-field="order" data-class="text-center wd-50 hidden-xs-down">#</th>
                <th data-field="title">E-Mail Address</th>
                <th data-field="created_at" data-class="wd-200" data-sortable="true">Created At</th>
                <th data-field="options" data-class="text-center wd-100">Process</th>
            </tr>
            </thead>
        </table>
    </section>
@endsection

