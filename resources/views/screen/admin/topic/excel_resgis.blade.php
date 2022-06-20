<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('assets/fonts/THSarabunNew.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: Italic;
            font-weight: bold;
            src: url("{{ public_path('assets/fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('assets/fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('assets/fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }
        body {
            font-family: "THSarabunNew";
            font-size: 16px;
        }
        table,
        th,
        td {
            width: 100%;
            border: 1px solid black;
            text-align: center;
        }
        table.border_fix,
        tr.border_fix,
        td.border_fix {
            width: 100%;
            border: 1px solid black;
        }
        table.border_fix {
            border-collapse: collapse;
        }
        .ui-helper-center {
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <table class="table border_fix" style="width: 100%; text-align: center;">
        <thead>
            <tr class="border_fix">
                <th >คำนำหน้า</th>
                <th >ชื่อจริง (ภาษาไทย)</th>
                <th >ชื่อนามสกุล (ภาษาไทย)</th>
                <th >ชื่อจริง (ENG)</th>
                <th >ชื่อนามสกุล (ENG)</th>
                <th >คณะ</th>
                <th >ตำแหน่งทางวิชาการ</th>
                <th >เบอร์โทรติดต่อ</th>
                <th >Email</th>
                <th >สถานะการลงทะเบียน</th>
                <th >สถานะการตรวจสอบ</th>
                <th >เวลาที่ลงทะเบียน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $index => $item)
            <tr>
                <td>{{$item->user_prename}}</td>
                <td>{{$item->user_firstname_th}}</td>
                <td>{{$item->user_lastname_th}}</td>
                <td>{{$item->user_firstname_en}}</td>
                <td>{{$item->user_lastname_en}}</td>
                <td>{{$item->profile_affiliation}}</td>
                <td>{{$item->profile_position}}</td>
                <td>{{$item->profile_tel}}</td>
                <td>{{$item->profile_email}}</td>
                <td>@if ($item->profile_steps == 4 ) ลงทะเบียนสมบูรณ์ @else ลงทะเบียนไม่สมบูรณ์ @endif</td>
                <td>@if ($item->profile_status == 1 ) ตรวจสอบแล้ว @else ยังไม่ตรวจสอบ @endif</td>
                <td>{{$item->profile_create_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>