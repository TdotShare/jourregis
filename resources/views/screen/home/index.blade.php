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
    <div class="card-body">

        <center>

            <h5>ระบบการลงทะเบียนเข้าร่วม่โครงการอบรมเชิงปฏิบัติการการเขียนบทความวิจัยเพื่อตีพิมพ์ลงในวารสาร<br>วิชาการระดับนานาชาติ:
                ด้านวิศวกรรมศาสตร์และเทคโนโลยี</h5>

            <hr>

            <span>ระหว่างวันที่ 2-5 สิงหาคม 2565 ณ อำเภอปากช่อง จังหวัดนครราชสีมา</span>
            <div style="margin-bottom: 1%;"></div>

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
    </div>
</div>


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
                    $dateData = new DateTime($item->topic_enddate);
                    $date = strtotime($item->topic_enddate);
                    $remaining = $date - time();
                    $days_remaining = floor($remaining / 86400);
                    @endphp
                    
                    <tr>
                        <td>{{$item->topic_title}}</td>
                        <td>{{$item->topic_enddate}} | <span style="color: red;"> เหลือเวลาอีก {{ $days_remaining }} วัน </span></td>
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