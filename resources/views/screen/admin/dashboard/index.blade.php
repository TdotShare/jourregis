@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("home_index_page") ],
    [ "name" => "แดชบอร์ด" , "url" => null ],
]

?>


@section('script_header')



@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "แดชบอร์ด" , "breadcrumb" => $breadcrumb])

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


<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ App\Models\Account::count() }} <sup style="font-size: 20px">คน</sup></h3>
                <p>ผู้ที่มาละเบียนใช้งานระบบ</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ App\Models\Topic::count() }} <sup style="font-size: 20px">โครงการ</sup></h3>
                <p>โครงการอบรมที่อยู่ในระบบ</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
        </div>
    </div>

</div>



@endsection


@section('script_footer')




@endsection