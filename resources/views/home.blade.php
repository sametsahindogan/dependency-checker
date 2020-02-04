@extends('layouts.app')

@section('pagetitle', 'Home')

@section('content')
    <section class="card card-default mb-3">

        <a href="{{ route('person.add') }}" data-toggle="modal" data-target="#modalsm" class="btn btn-sm btn-success"><i
                class="fa fa-plus"></i> <span class="hidden-xs-down">Kişi Ekle</span></a>

        <br>

        <a href="{{ route('person.edit',['id' => 1]) }}" data-toggle="modal" data-target="#modalsm"
           class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> <span class="hidden-xs-down">Kişi Güncelle</span></a>

        <br>

        <a href="{{ route('person.remove',['id' => 1]) }}" data-toggle="modal" data-target="#modalsm"
           class="btn btn-sm btn-danger"><i class="fa fa-times"></i> <span class="hidden-xs-down">Kişi Sil</span></a>

    </section>
@endsection

@section('css')
@endsection
@section('js')

@endsection
