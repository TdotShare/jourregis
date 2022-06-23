@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("home_index_page") ],
    [ "name" => "ประชาสัมพันธ์" , "url" => route("home_index_page") ],
    [ "name" => "$model->topic_title" , "url" => null ],
]

?>


@section('script_header')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "$model->topic_title" , "breadcrumb" => $breadcrumb])

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
    <div class="card-body">

        <center>

            <h5>ระบบการลงทะเบียนเข้าร่วม่โครงการอบรมเชิงปฏิบัติการการเขียนบทความวิจัยเพื่อตีพิมพ์ลงในวารสาร<br>วิชาการระดับนานาชาติ: {{$model->topic_type == 1 ? 'ด้านมนุษยศาสตร์และสังคมศาสตร์' : 'ด้านวิศวกรรมศาสตร์และเทคโนโลยี' }}</h5>

            <hr>

            <div style="margin-bottom: 1%;"></div>

            ปิดรับสมัคร {{$model->topic_enddate}}

            <br />

            @if ($model->topic_image_lecturer)

            <a target="_blank" href={{asset("$model->topic_image_lecturer")}} >รูปวิทยากร</a>
                
            @endif

            <br>
            
            @if ($model->topic_cv_lecturer)

            <a target="_blank" href={{asset("$model->topic_cv_lecturer")}} >โปรไฟล์วิทยากร</a>
                
            @endif

        </center>


    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <b>เงื่อนไขการสมัครเข้าร่วมโครงการ</b>
    </div>
    <div class="card-body">
        <ul>
            <li>ผู้เข้าร่วมโครงการต้องเป็นบุคลากรของ มทร.อีสาน</li>
            <li>ผู้เข้าร่วมโครงการต้องมีบทความฉบับร่างที่ยื่นประกอบการสมัครเข้าร่วมโครงการ อย่างน้อย 1 เรื่อง</li>
            <li>ผู้เข้าร่วมโครงการบทความต้องส่งพิจารณาตีพิมพ์ (Submission) ในวารสารระดับนานาชาติ ฐาน SJR อย่างน้อยระดับ
                Q2 หลังจากเสร็จสิ้นโครงการอบรมภายใน 1 เดือน</li>
            <li>สถาบันวิจัยและพัฒนาเป็นผู้รับผิดชอบค่าที่พัก ค่าเดินทาง ให้กับผู้เข้าร่วมโครงการ</li>
            <li>นักวิจัยที่ผ่านการเข้าร่วมโครงการและได้รับการตีพิมพ์ จะได้ใบประกาศนียบัตรจากอธิการบดี และแสดงความยินดีใน
                Facebook Page
                ของมหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน และ Facebook Page ของสถาบันวิจัยและพัฒนา</li>
        </ul>

        <br />

        <a href={{route('home_view_page' , ["id" => $model->topic_id])}} ><button class="btn btn-block btn-primary">ลงทะเบียน</button></a>
    </div>
</div>



@endsection


@section('script_footer')


@endsection