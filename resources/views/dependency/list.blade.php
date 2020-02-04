@extends('layouts.app')
@section('pageTitle', 'Dependency List')
@section('content')
    <section class="box-typical">
        <div id="toolbar-dependencies">
            <div class="bootstrap-table-header"><i class="fa fa-list-ul color-blue"></i> Dependency List for {{$repo}}/{{$project}}</div>
        </div>
        <table class="vtbl" id="dependencies"
               data-toolbar="#toolbar-dependencies"
               data-show-refresh="true"
               data-side-pagination="server"
               data-icon-size="xs"
               data-striped="true"
               data-url="{{route('dependencies.get', ['repo_slug' => $repo,'project_slug' => $project])}}">
            <thead>
            <tr>
                <th data-field="type" data-class="text-center wd-100">Type</th>
                <th data-field="title" data-class="text-center">Package</th>
                <th data-field="current_version" data-class="text-center">Current Version</th>
                <th data-field="latest_version" data-class="text-center">Latest Version</th>
                <th data-field="status" data-class="text-center">Status</th>
            </tr>
            </thead>
        </table>
    </section>
@endsection

