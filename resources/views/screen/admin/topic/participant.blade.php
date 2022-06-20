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

<a href={{route('excel_ad_participant_data' , ['id' => $model->topic_id])}} > <button class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</button></a>

<div style="padding-bottom: 1%;"></div>

<div class="card shadow p-3">
    <div class="card-body">

        <table class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ชื่อ - นามสกุล </th>
                    <th scope="col">สังกัด</th>
                    {{-- <th scope="col">วิทยาเขต</th> --}}
                    {{-- <th scope="col">เบอร์ติดต่อ</th> --}}
                    <th scope="col">อีเมลล์</th>
                    <th scope="col">เอกสารแนบ</th>                  
                    <th scope="col">สถานะการลงทะเบียน</th>
                    <th scope="col">สถานะการตรวจสอบ</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participant as $index => $item)

                @php
                    $dataFiles = App\Models\FileJour::where('file_profile_uid' , $item->user_uid )->where('file_topic_id' , $item->profile_topic_id )->get();
                @endphp

                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$item->user_prename}}{{$item->user_firstname_th}} {{$item->user_lastname_th}}</td>
                    <td>{{$item->profile_affiliation}}</td>
                    {{-- <td>{{$item->user_campus}}</td> --}}
                    {{-- <td>{{$item->profile_tel}}</td> --}}
                    <td>{{$item->profile_email}}</td>
                    <td>
                        <ul>
                        @foreach ($dataFiles as $el)
                            <li><a target="_blank" href={{asset("upload/$el->file_path")}} >{{$el->file_name}}</a></li>
                        @endforeach
                        </ul>
                    </td>

                    @if ($item->profile_steps == 4)
                    <td class="bg-success" ><i class="fas fa-check-circle"></i> ลงทะเบียนสมบูรณ์</td>          
                    @else
                    <td class="bg-danger"><i class="fas fa-times-circle"></i> ลงทะเบียนไม่สมบูรณ์</td>           
                    @endif
                 
                    @if ($item->profile_status == 1)
                        <td class="bg-success" ><i class="fas fa-check-circle"></i> ตรวจสอบแล้ว</td>     
                    @else
                        <td class="bg-danger"><i class="fas fa-times-circle"></i> ยังไม่ตรวจสอบ</td>       
                    @endif
                
                    <td><a href={{route('profile_ad_status_data' , ['id' => $item->profile_id ])}} ><button class="btn btn-block btn-primary"><i class="fas fa-redo"></i> เปลี่ยนสถานะการตรวจสอบ</button></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>


@endsection


@section('script_footer')
<script>
    $(function () {
      $("#dataTable").DataTable({
        "responsive": true,
      });
    });
</script>
@endsection