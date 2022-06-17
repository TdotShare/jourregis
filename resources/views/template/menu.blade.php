<?php 

//  ["name" => "จองห้องประชุม", "menu" => null , "url" => route("reserveroom_index_page") , "icon" => "fas fa-door-closed" , "path" => "/reserveroom"] ,

$menuUser = [
    ["name" => "หน้าหลัก", "menu" => null , "url" => route("calendar_index_page") , "icon" => "fas fa-calendar" , "path" => "/calendar"] ,
];

$menuAdmin = [
    ["name" => "แดชบอร์ด", "menu" => null , "url" => route("dashboard_index_page") , "icon" => "fas fa-th" , "path" => "/dashboard"] ,
];
?>

<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src={{URL::asset("assets/image/mock/profile.png")}} class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ session("fullname") ? session("fullname") : "ผู้เยี่ยมชมระบบ" }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


            @foreach ($menuUser as $item)

            @if ($item["menu"] == null)


            <li class="nav-item">
                <a href={{$item["url"]}}
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                    </p>
                </a>
            </li>

            @else

            <li
                class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-item has-treeview  menu-open" : "nav-item has-treeview"  }}">
                <a href="#"
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                @foreach ($item["menu"] as $row)
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href={{$row["url"]}}
                            class="{{Request::path() == $row["path"] ? "nav-link active" : "nav-link" }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{$row["name"]}}</p>
                        </a>
                    </li>
                </ul>
                @endforeach

            </li>


            @endif

            @endforeach

            <li class="nav-item">
                <a target="_bank" href={{route("manual_user")}} class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        คู่มือการใช้งานระบบ
                    </p>
                </a>
            </li>

            @if (session('auth') == null)

            <li class="nav-item">
                <a href={{route("login_page")}} class="{{ Request::path() == "login" ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon fas fa-sign-in-alt"></i>
                    <p>
                        Login
                    </p>
                </a>
            </li>
                
            @else

            <li class="nav-item">
                <a href={{route("logout_data")}} class="{{ Request::path() == "logout" ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        Logout
                    </p>
                </a>
            </li>
                
            @endif




            @if (session("role") == "admin")

            <li class="nav-header">Admin</li>

            @foreach ($menuAdmin as $item)

            @if ($item["menu"] == null)

            <li class="nav-item">
                <a href={{$item["url"]}}
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                    </p>
                </a>
            </li>

            @else

            <li
                class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-item has-treeview  menu-open" : "nav-item has-treeview"  }}">
                <a href="#"
                    class="{{ Request::route()->getPrefix() == $item["path"] ? "nav-link active" : "nav-link"  }}">
                    <i class="nav-icon {{$item["icon"]}}"></i>
                    <p>
                        {{$item["name"]}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                @foreach ($item["menu"] as $row)
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href={{$row["url"]}}
                            class="{{Request::path() == $row["path"] ? "nav-link active" : "nav-link" }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{$row["name"]}}</p>
                        </a>
                    </li>
                </ul>
                @endforeach

            </li>

            @endif

            @endforeach

            @endif



        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>