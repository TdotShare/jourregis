@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("home_index_page") ],
    [ "name" => "การอบรม" , "url" => route("topic_ad_index_page") ],
    [ "name" => $model->topic_id , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "การอบรม - $model->topic_id" , "breadcrumb" => $breadcrumb])

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


        <form action={{route('topic_ad_update_data')}} method="post" enctype="multipart/form-data" >

            {{ csrf_field() }}

            <h4>ข้อมูลการเปิดอบรม</h4>

            <hr />

            <input type="hidden" name="topic_id" class="form-control float-right" value="{{$model->topic_id}}" id="topic_id">

            <input type="hidden" name="topic_enddate" class="form-control float-right" value="{{$model->topic_enddate}}" id="topic_enddate" >

            <div class="form-row">
                <div class="form-group col-md">
                    <label>หัวข้อการอบรม</label>
                    <input type="text" class="form-control" value="{{$model->topic_title}}" name="topic_title" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label>วันที่ปิดรับสมัคร</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input type="text" name="topic_select_enddate" class="form-control float-right" id="topic_select_enddate">
                    </div>


                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label>ด้านการอบรม</label>
                    <select class="custom-select" name="topic_type" required>
                        <option value="1" {{$model->topic_type == 1 ? 'selected' : ''}}>ด้านมนุษยศาสตร์และสังคมศาสตร์</option>
                        <option value="2" {{$model->topic_type == 2 ? 'selected' : ''}}>ด้านวิศวกรรมศาสตร์และเทคโนโลยี</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label>รายละเอียด (note)</label>
                    <input type="text" class="form-control" value="{{$model->topic_note}}" name="topic_note" required>
                </div>
            </div>

            <h4>ข้อมูลการวิทยากร</h4>

            <hr />

            <div class="form-row">
                <div class="form-group col-md">
                    <label>ไฟล์ CV วิทยาการ
                        @if ($model->topic_cv_lecturer) 

                        <span style="color: green;">(<a target="_blank" href={{asset("$model->topic_cv_lecturer")}} >ไฟล์ปัจจุบัน</a>)</span> 
                        
                        @else

                        <span style="color: red;">ยังไม่ได้อัปโหลดไฟล์</span> 
                        
                        @endif
                    </label>
                    <input type="file" class="form-control" name="topic_cv_lecturer" accept="application/pdf">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md">
                    <label>ไฟล์รูปประจำตัววิทยากร
                        
                        @if ($model->topic_image_lecturer) 

                        <span style="color: green;">(<a target="_blank" href={{asset("$model->topic_image_lecturer")}} >ไฟล์ปัจจุบัน</a>)</span> 
                        
                        @else

                        <span style="color: red;">ยังไม่ได้อัปโหลดไฟล์</span> 
                        
                        @endif


                    </label>
                    <input type="file" class="form-control" name="topic_image_lecturer" accept="image/jpeg,image/jpg,image/png">
                </div>
            </div>

            <button type="submit" class="btn btn-block btn-success">แก้ไขข้อมูล</button>
        </form>

    </div>
</div>


@endsection


@section('script_footer')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

    let strtime =  new Date("{!! $model->topic_enddate !!}");

    $('input[name="topic_select_enddate"]').daterangepicker({
        startDate : strtime ,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 30,
        singleDatePicker: true,
        locale: {
            format: 'MM/DD/YYYY H:mm'
        },
    }, function(start, end, label) { 
        document.getElementById("topic_enddate").value = start.format('YYYY-MM-DD H:mm:ss');
    });
</script>

@endsection