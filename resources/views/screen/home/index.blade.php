@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("home_index_page") ],
    [ "name" => "ประชาสัมพันธ์" , "url" => null ],
]

?>


@section('script_header')


@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "ประชาสัมพันธ์" , "breadcrumb" => $breadcrumb])

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


<div class="card shadow-sm">
    <div class="card-header">
        <b>หัวข้อการอบรมที่เปิดรับ</b>
    </div>
    <div class="card-body">

        @if (count($model) == 0)

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            ยังไม่พบโครงการที่เปิดรับสมัคร
        </div>

        @else

        <div class="table-responsive">
            <table class="table" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">หัวข้อการอบรม</th>
                        <th scope="col">วันที่ปิดรับสมัคร</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )

                    @php
                    $d1 = new DateTime('now');
                    $d2 = new DateTime($item->topic_enddate);
                    $result = $d2->diff($d1);
                    @endphp
                    
                    <tr>
                        <td><a href={{route('home_detail_page' , ["id" => $item->topic_id])}}>{{$item->topic_title}}</a></td>
                        <td>{{$item->topic_enddate}} | <span style="color: red;"> เหลือเวลาอีก {{ $result->d }} วัน {{$result->h}} ชั่วโมง {{$result->i}} นาที </span></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            @endif
        </div>
    </div>


    @endsection


    @section('script_footer')




    @endsection