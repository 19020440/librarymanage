@extends('admin.layouts.default')

@section('title', 'ManageBook')

@section('css')
    {{-- chèn thêm link css ở đây --}}
    <link rel="stylesheet" href="{{ asset('css/manage.book.css') }}" type="text/css">
@endsection

@section('content')
    <div class="addbook__content">
        <section class="addbook__content-header col-md-12 col-xl-12">
            <div class="addbook__content-header-box">
                <h1 class="addbook__content-header-box-ct">Add Book</h1>
                <span><a href="{{ route('admin.book.index') }}">Home</a> / Add Book</span>
            </div>
        </section>

        <section class="addbook__content-content">
            <div class="addbook__content-content-header">
            </div>
            <form class="addbook__content-content-boxct col-md-12 col-xl-12 col-sm-12 col-12" method="POST"
                action="{{ route('admin.book.store') }}" id="form-create-book">
                @csrf
                <div class="row">
                    <div class="col-md-3  col-xl-3 col-sm-12 col-12 maincontainer__thethird-col3">
                        <div class="row">
                            <div class="maincontainer__thethird-col3-boxct col-xl-12">
                                <div class="form-upload">
                                    <input class="link-img" name="image1" value="{{ old('image1') }}" readonly>
                                    <img src="{{ asset(old('image1')) }}" class="{{ old('image1') ? '' : 'hidden' }}">
                                    <input type="file" class="hidden">
                                    <div class="note">Ảnh mặt trước của sách</div>
                                    <div class="alert alert-upload">{{ $errors->first('image1') }}</div>
                                    <button type="button" class="btn btn-ct-primary btn-upload">Đăng ảnh</button>
                                </div>
                            </div>

                            <div class="maincontainer__thethird-col3-boxct1 col-xl-12">
                                <div class="form-upload">
                                    <input class="link-img" name="image2" value="{{ old('image2') }}" readonly>
                                    <img src="{{ asset(old('image2')) }}" class="{{ old('image2') ? '' : 'hidden' }}">
                                    <input type="file" class="hidden">
                                    <div class="note">Ảnh mặt sau của sách</div>
                                    <div class="alert alert-upload">{{ $errors->first('image2') }}</div>
                                    <button type="button" class="btn btn-ct-primary btn-upload">Đăng ảnh</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-12 col-md-9  col-xl-9  maincontainer__thethird-col8">

                        <div class="row no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Tác giả</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" name="auth"
                                        value="{{ old('auth') }}" maxlength="30"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Nhà xuất bản</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" name="publisher"
                                        value="{{ old('publisher') }}" maxlength="50"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                    <div class="alert alert-upload">{{ $errors->first('publisher') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="alert alert-danger">{{ $errors->first('auth') }}</div>
                            </div>
                        </div>
                        <div class=" row no-gutters">
                            <div class="col-sm-12 col-12 col-md-12 col-xl-12 ">
                                <div class="input-group input-group-lg aoaoao">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Tên sách</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Large"
                                        aria-describedby="inputGroup-sizing-sm" name="name" value="{{ old('name') }}"
                                        maxlength="50"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                        </div>
                        <div class="no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="alert alert-danger">{{ $errors->first('name') }}</div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Quốc
                                            gia</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" name="country"
                                        value="{{ old('country') }}" maxlength="30"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default"><a
                                                href="http://www.thuvienhaiphu.com.vn/datafile1/tl_plddc/DC027106.htm"
                                                target="_blank">Mã DDC</a></span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" name="category"
                                        value="{{ old('category') }}" maxlength="3"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                        </div>
                        <div class="no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="alert alert-danger">{{ $errors->first('category') }}</div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="input-group input-group-lg maincontainer__thethird-auther">
                                    <div class="grid">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Giá (VNĐ)</span>
                                    </div>
                                    <input type="text" aria-label="Large" aria-describedby="inputGroup-sizing-sm"
                                        name="price" value="{{ old('price') }}" data-type="currency" maxlength="9"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="input-group input-group-lg maincontainer__thethird-puslish">
                                    <div class="grid">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Số lượng (quyển)</span>
                                    </div>
                                    <input type="text" aria-label="Large" aria-describedby="inputGroup-sizing-sm"
                                        name="quantity" value="{{ old('quantity') }}" data-type="currency" maxlength="9"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                        </div>
                        <div class="no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="alert alert-danger">{{ $errors->first('price') }}</div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="alert alert-danger">{{ $errors->first('quantity') }}</div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Dịch
                                            giả</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" name="translator"
                                        value="{{ old('translator') }}" maxlength="30"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6  maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Năm xuất
                                            bản</span>
                                    </div>
                                    <input type="text" class="form-control" aria-label="Default"
                                        aria-describedby="inputGroup-sizing-default" name="year_start"
                                        value="{{ old('year_start') }}" maxlength="4" data-type="currency"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                </div>
                            </div>
                        </div>







                        <div class="no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="alert alert-danger"></div>
                            </div>
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="alert alert-danger">{{ $errors->first('year_start') }}</div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class=" col-sm-12 col-12 col-md-12 col-xl-12">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Nội dung</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"
                                        maxlength="4000"
                                        oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">{{ old('content') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters">
                            <div class="col-sm-12 col-12 col-md-3  col-xl-3 maincontainer__thethird-ISBN">
                                <div class="input-group mb-3 maincontainer__thethird-ISBN-input">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="ISBN"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                id="ISBN">Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="no-gutters">
                            <div class="col-sm-12 col-12 col-md-6  col-xl-6 ">
                                <div class="alert alert-danger">{{ $errors->first('content') }}</div>
                            </div>
                        </div>
                        <div class="aothatsuluon create-book">
                            <button type="button" class="btn btn-success addbook-button" data-toggle="modal"
                                data-target="#myModal-create-book">Thêm sách</button>
                        </div>
                        <div class="modal js-default-ok-popup modal-alert-create-book" id="myModal-create-book">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thêm sách</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn thật sự muốn thêm sách với thông tin đã nhập?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-create-book">Thêm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/admin/manage_book.js') }}"></script>
@endsection
