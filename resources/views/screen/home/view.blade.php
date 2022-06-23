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


<div class="card shadow-sm p-3">
    <div class="card-body">

        <div class="bs-stepper">
            <div class="bs-stepper-header" role="tablist">
                <!-- your steps here -->
                <div class="step" data-target="#logins-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="logins-part"
                        id="logins-part-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">ข้อมูลทั่วไป</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#information-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part"
                        id="information-part-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">เอกสารแนบ</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#checked-part">
                    <button type="button" class="step-trigger" role="tab" aria-controls="checked-part"
                        id="checked-part-trigger">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">ตรวจสอบข้อมูล</span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <!-- your steps content here -->
                <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">

                    <!--  กรอกข้อมูลส่วนตัว -->

                    <form action={{route('profile_update_data')}} method="post">


                        {{ csrf_field() }}

                        <input type="hidden" name="profile_topic_id" value={{ $model->topic_id }} />

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>คำนำหน้า</label>
                                <input type="text" class="form-control" value="{{ $account->user_prename }}" readonly>
                            </div>
                            <div class="form-group col-md">
                                <label>ชื่อจริง - นามสกุล (ภาษาไทย)</label>
                                <input type="text" class="form-control" value="{{ $account->user_firstname_th }} {{ $account->user_lastname_th }}" readonly>
                            </div>
                            <div class="form-group col-md">
                                <label>ชื่อจริง - นามสกุล (ภาษาอังกฤษ)</label>
                                <input type="text" class="form-control" value="{{ $account->user_firstname_en }} {{ $account->user_lastname_en }}" readonly>
                            </div>
                        </div>

                        @php
                        $position_title = [
                        'ดร.',
                        'ผู้ช่วยศาสตราจารย์',
                        'รองศาสตราจารย์',
                        'ศาสตราจารย์',
                        'ผู้ช่วยศาสตราจารย์ ดร.',
                        'รองศาสตราจารย์ ดร.',
                        'ศาสตราจารย์ ดร.',
                        'อาจารย์',
                        'ไม่มี'
                        ];
                        @endphp

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label>ตำแหน่งทางวิชาการ</label>
                                <select class="custom-select" name="profile_position" required>
                                    @if (!$profile)
                                        <option value="" selected>เลือกตำแหน่งทางวิชาการ</option>
                                        @foreach ($position_title as $item)
                                            <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    @else
                                        <option value="">เลือกตำแหน่งทางวิชาการ</option>
                                        @foreach ($position_title as $item)
                                            <option value="{{$item}}" {{$profile->profile_position == $item ? "selected" : ""}}>{{$item}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md">
                                <label>สังกัด</label>
                                <input type="text" class="form-control" value="{{$profile ? $profile->profile_affiliation : $account->user_faculty  }}" name="profile_affiliation" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label>เบอร์โทรติดต่อ</label>
                                <input type="text" class="form-control" name="profile_tel" value="{{$profile ? $profile->profile_tel : ""  }}" required>
                            </div>
                            <div class="form-group col-md">
                                <label>Email</label>
                                <input type="text" class="form-control" name="profile_email" value="{{$profile ? $profile->profile_email : $account->user_email  }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-success">บันทึก</button>


                    </form>




                </div>
                <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">

                    <!--  การแนบไฟล์ข้อมูล -->
                    <center>
                        <p>ผู้สมัครเข้าร่วมโครงการต้องแนบร่างบทความวิจัยอย่างน้อยจำนวน 1 เรื่อง เพื่อเข้าร่วม Workshop
                            จึงจะถือว่าการลงทะเบียนของท่านเสร็จสมบูรณ์
                            หากท่านไม่มีบทความเข้าร่วมโครงการ สถาบันวิจัยและพัฒนาขอสงวนสิทธิ์ในการเข้าร่วมโครงการของท่าน <br>
                            <span style="color: red;" >** ทั้งนี้ใครที่ไม่แนบไฟล์ไม่อนุญาตให้ไปแถบเมนูต่อไป  (ถือว่าคุณลงทะเบียนไม่สมบูรณ์)</span>
                        </p>
                    </center>

                    <form action={{route('profile_upload_data')}} method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <input type="hidden" name="file_topic_id" value={{ $model->topic_id }} />

                        <div class="form-row">
                            <div class="form-group col-md">
                                <label>ชื่อไฟล์</label>
                                <input type="text" class="form-control" name="file_name" required>
                            </div>
                            <div class="form-group col-md">
                                <label>ไฟล์แนบ</label>
                                <input type="file" class="form-control" name="file_item" accept=".doc,.docx,.pdf" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block btn-success">เพิ่มไฟล์แนบ</button>

                    </form>



                    <hr>

                    <table class="table table-bordered" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ไฟล์แนบ</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fileJour as $index => $item)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td><a target="_blank" href={{asset("upload/$item->file_path")}} >{{$item->file_name}}</a></td>
                                <td><a href={{route('profile_delete_filejour_data' , ['id'=> $item->file_id ])}} onclick="return confirm('คุณยืนยันจะลบ ใช่หรือไม่ ?');">
                                        <button class="btn btn-block btn-danger"><i class="fas fa-trash"></i> ลบข้อมูล</button></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    @if (count($fileJour) > 0)
                        <a href={{route('profile_bypassfile_data' , ["id" => $model->topic_id])}}><button class="btn btn-block btn-success" >บันทึก</button></a>
                    @else
                        <button class="btn btn-block btn-success" disabled>บันทึก</button>
                    @endif

                </div>

                <div id="checked-part" class="content" role="tabpanel" aria-labelledby="checked-part-trigger">

                    <!--  ตรวจสอบข้อมูล -->

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>คำนำหน้า</label>
                            <input type="text" class="form-control" value="{{ $account->user_prename }}" readonly>
                        </div>
                        <div class="form-group col-md">
                            <label>ชื่อจริง - นามสกุล (ภาษาไทย)</label>
                            <input type="text" class="form-control" value="{{ $account->user_firstname_th }} {{ $account->user_lastname_th }}" readonly>
                        </div>
                        <div class="form-group col-md">
                            <label>ชื่อจริง - นามสกุล (ภาษาอังกฤษ)</label>
                            <input type="text" class="form-control" value="{{ $account->user_firstname_en }} {{ $account->user_lastname_en }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>ตำแหน่งทางวิชาการ</label>
                            <input type="text" class="form-control" value="{{$profile ? $profile->profile_position : ""  }}" readonly>
                        </div>
                        <div class="form-group col-md">
                            <label>สังกัด</label>
                            <input type="text" class="form-control" value="{{$profile ? $profile->profile_affiliation : $account->user_faculty  }}" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md">
                            <label>เบอร์โทรติดต่อ</label>
                            <input type="text" class="form-control" name="profile_tel" value="{{$profile ? $profile->profile_tel : ""  }}" readonly>
                        </div>
                        <div class="form-group col-md">
                            <label>Email</label>
                            <input type="text" class="form-control" name="profile_email" value="{{$profile ? $profile->profile_email : $account->user_email  }}" readonly>
                        </div>
                    </div>

                    <p>ไฟล์แนบทั้งหมด {{count($fileJour)}} ไฟล์</p>

                    <table class="table table-bordered" id="dataTable" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ไฟล์แนบ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fileJour as $index => $item)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td><a target="_blank" href={{asset("upload/$item->file_path")}} >{{$item->file_name}}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr />

                    <div class="row">
                        <div class="col">
                            <a href={{route('profile_backsteps_data' , ['id' => $model->topic_id])}}><button class="btn btn-block btn-primary">ย้อนกลับไป ข้อมูลทั่วไป</button></a>
                        </div>
                        <div class="col">
                            <a href={{route('profile_submission_data' , ['id' => $model->topic_id])}}
                                onclick="return confirm('หากคุณยืนยันลงทะเบียนแล้วจะไม่สามารถกลับมาแก้ไขข้อมูลได้อีก คุณยืนยันจะส่งข้อมูลชุดนี้ให้เจ้าหน้าที่ ใช่หรือไม่ ?');">
                                <button class="btn btn-block btn-success">ยืนยันลงทะเบียน</button></a>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</div>

@endsection


@section('script_footer')

<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>

<script>
    $(document).ready(function () {

    var page =  "{!! $profile ? $profile->profile_steps : 1 !!}"; 
    //console.log(page)   

    var stepper = new Stepper(document.querySelector('.bs-stepper'))
    stepper.to(page)

})
</script>

@endsection