@extends('layout.admin')


@section('page_name')
    All Songs
@endsection

@section('styles')
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.3') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">All Songs</h3>
                    </div>

                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Song Thumbnail</th>
                                <th>Song Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($songs as $key => $song)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ $song->thumbnail_image_url }}" height="50" width="50" alt="" srcset=""></td>
                                    <td>{{ $song->name }}</td>
                                    <td nowrap="nowrap"></td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <!--begin::Page Vendors(used by this page)-->
    <script src="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.3') }}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('admin/assets/js/pages/crud/datatables/advanced/multiple-controls.js?v=7.0.3') }}"></script>
    <!--end::Page Scripts-->
@endsection
