@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("home_index_page") ],
    [ "name" => "การอบรม" , "url" => route("topic_ad_index_page") ],
    [ "name" => "$model->topic_id" , "url" => null ],
    [ "name" => "ผู้ลงทะเบียนเข้าอบรม" , "url" => null ],
]

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->topic_title - ผู้ลงทะเบียนเข้าอบรม" , "breadcrumb" => $breadcrumb])

@endcomponent

@endsection


<!-- CONTENT -->

@section('content')

@if (session('alert'))


<div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@endif

<div class="card shadow p-3">
    <div class="card-body">

        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ - นามสกุล </th>
                    <th scope="col">สาขา</th>
                    <th scope="col">คณะ</th>
                    <th scope="col">วิทยาเขต</th>
                    <th scope="col">อีเมลล์</th>
                    <th scope="col">สถานะการลงทะเบียน</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>


@endsection


@section('script_footer')



@endsection