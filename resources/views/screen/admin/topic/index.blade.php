@extends('template.index')


<?php 

$breadcrumb = [ 
    [ "name" => "หน้าหลัก" , "url" => route("home_index_page") ],
    [ "name" => "การอบรม" , "url" => null ],
]

?>


@section('script_header')



@endsection

@section('breadcrumb')

@component('common.breadcrumb' , [ "name" => "การอบรม" , "breadcrumb" => $breadcrumb])

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

<a href="{{route("topic_ad_create_page")}}"><button class="btn btn-primary">สร้างหัวข้อการอบรม</button></a>

<div style="margin-bottom:1%;"></div>

<div class="card shadow-sm p-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">หัวข้อการอบรม</th>
                        <th scope="col">ด้านการอบรม</th>
                        <th scope="col">วันที่ปิดรับสมัคร</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">แก้ไขล่าสุด</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $index => $item )
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>{{$item->topic_title}}</td>
                        <td>{{$item->topic_type == 1 ? 'ด้านมนุษยศาสตร์และสังคมศาสตร์' : 'ด้านวิศวกรรมศาสตร์และเทคโนโลยี' }}</td>
                        <td>{{$item->topic_enddate}}</td>
                        
                        @if ($item->topic_status == 1)
                        <td class="bg-success" ><i class="fas fa-check-circle"></i> เปิดการใช้งาน</td>          
                        @else
                        <td class="bg-danger"><i class="fas fa-times-circle"></i> ปิดการใช้งาน</td>           
                        @endif
                        
                        <td>{{$item->topic_update_by}}</td>
                        <td><a href={{route('topic_ad_status_data' , ['id' => $item->topic_id])}} ><button class="btn btn-block btn-primary"><i class="fas fa-redo"></i> เปลี่ยนสถานะ</button></a></td>
                        <td><a href={{route('topic_ad_participant_page' , ['id' => $item->topic_id])}}><button class="btn btn-block btn-primary"><i class="fas fa-users"></i> ผู้ลงทะเบียนเข้าอบรม</button></a></td>
                        <td><a href={{route('topic_ad_update_page' , ['id' => $item->topic_id])}}><button class="btn btn-block btn-primary"><i class="fas fa-edit"></i> แก้ไขข้อมูล</button></a></td>
                        <td><a href={{route('topic_ad_delete_data' , ['id' => $item->topic_id])}} onclick="return confirm('หากคุณลบข้อมูลการอบรมนี้ ข้อมูลผู้สมัครทั้งหมดจะถูกลบ คุณยืนยันจะลบ ใช่หรือไม่ ?');">
                            <button class="btn btn-block btn-danger"><i class="fas fa-trash"></i> ลบข้อมูล</button></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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