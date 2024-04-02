<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title> {{ config('app.name') }} | @yield('page_name')</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('admin/assets/plugins/global/plugins.bundle.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/assets/css/style.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset('admin/assets/css/themes/layout/header/base/light.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/assets/css/themes/layout/header/menu/light.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/assets/css/themes/layout/brand/dark.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('admin/assets/css/themes/layout/aside/dark.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset('admin/assets/media/logos/favicon.ico') }}" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/toastr.css')}}" type="text/css">

    @yield('styles')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    @include('layout.components.admin.header-mobile')
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            @include('layout.components.admin.sidebar')
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                @include('layout.components.admin.header')
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    @yield('content')
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('layout.components.admin.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
    @include('layout.components.admin.others')
    <!--end::Demo Panel-->
    <script>
        var HOST_URL = "https://keenthemes.com/metronic/tools/preview";
    </script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576,
                "md": 768,
                "lg": 992,
                "xl": 1200,
                "xxl": 1200
            },
            "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff",
                        "primary": "#3699FF",
                        "secondary": "#E5EAEE",
                        "success": "#1BC5BD",
                        "info": "#8950FC",
                        "warning": "#FFA800",
                        "danger": "#F64E60",
                        "light": "#F3F6F9",
                        "dark": "#212121"
                    },
                    "light": {
                        "white": "#ffffff",
                        "primary": "#E1F0FF",
                        "secondary": "#ECF0F3",
                        "success": "#C9F7F5",
                        "info": "#EEE5FF",
                        "warning": "#FFF4DE",
                        "danger": "#FFE2E5",
                        "light": "#F3F6F9",
                        "dark": "#D6D6E0"
                    },
                    "inverse": {
                        "white": "#ffffff",
                        "primary": "#ffffff",
                        "secondary": "#212121",
                        "success": "#ffffff",
                        "info": "#ffffff",
                        "warning": "#ffffff",
                        "danger": "#ffffff",
                        "light": "#464E5F",
                        "dark": "#ffffff"
                    }
                },
                "gray": {
                    "gray-100": "#F3F6F9",
                    "gray-200": "#ECF0F3",
                    "gray-300": "#E5EAEE",
                    "gray-400": "#D6D6E0",
                    "gray-500": "#B5B5C3",
                    "gray-600": "#80808F",
                    "gray-700": "#464E5F",
                    "gray-800": "#1B283F",
                    "gray-900": "#212121"
                }
            },
            "font-family": "Poppins"
        };
    </script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('admin/assets/plugins/global/plugins.bundle.js?v=7.0.3') }}"></script>
    <script src="{{ asset('admin/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.3') }}"></script>
    <script src="{{ asset('admin/assets/js/scripts.bundle.js?v=7.0.3') }}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('admin/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.3') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('admin/assets/js/pages/widgets.js?v=7.0.3') }}"></script>
    <!--end::Page Scripts-->
    <script src="{{asset('admin/assets/js/toastr.js')}}"></script>
    @yield('scripts')
</body>
<!--end::Body-->

</html>
