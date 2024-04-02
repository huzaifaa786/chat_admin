@extends('layout.admin')

@section('page_name')
    Create Song
@endsection

@section('content')
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Add New Song</h3>

                        </div>
                        <!--begin::Form-->
                        <form class="form" action="{{ route('admin.song.store') }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-lg-3">

                                    </div>
                                    <div class="col-lg-6 text-center">
                                        {{-- <label>Thumbnail Image:</label> --}}
                                        <div class="image-input image-input-outline" id="kt_image_1">
                                            <div class="image-input-wrapper"
                                                style="background-image: url(assets/media/users/100_1.jpg)"></div>

                                            <label
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="change" data-toggle="tooltip" title=""
                                                data-original-title="Change thumbnail">
                                                <i class="fa fa-pen icon-sm text-muted"></i>
                                                <input type="file" name="avatar_image_url" required accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="profile_avatar_remove" />
                                            </label>

                                            <span
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="cancel" data-toggle="tooltip" title="Cancel thumbnail">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">

                                    </div>


                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>Song Name:</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter song name" required />
                                        <span class="form-text text-muted">Please enter your song name</span>
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-9">
                                        <label>Music File:</label>
                                        <input type="file" name="music_file" accept=".mp3,.wav" required />
                                    </div>


                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-9">
                                        <label>Lyrics File:</label>
                                        <input type="file" name="lyrics_file" accept=".lrc" required />

                                    </div>


                                </div>


                                <!-- end: Example Code-->
                            </div>
                            <div class="card-footer">
                                <div class="row">

                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6 text-right">
                                        <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin/assets/js/pages/crud/file-upload/dropzonejs.js?v=7.0.3') }}"></script>

    <script>
        var avatar1 = new KTImageInput('kt_image_1');
    </script>
@endsection
