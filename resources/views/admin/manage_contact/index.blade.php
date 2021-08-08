@extends('admin.layouts.default')

@section('title', 'Manage contact')

@section('css')
    {{-- chèn thêm link css ở đây --}}
    <link rel="stylesheet" href="{{ asset('css/manage.contact.css') }}" type="text/css">
@endsection

@section('content')
    <div class="managecontact__content">
        <section class="managecontact__content-header col-md-12 2">
            <div class="managecontact__content-header-box">
                <h1 class="managecontact__content-header-box-ct">Manage contact</h1>
                <span><span>Home</span> / Contact</span>
            </div>
        </section>
        <section class="managecontact__content-dashboard">
            <div class="row managecontact__content-dashboard-margin pewpew">
                <div class="col-xl-3">
                    <button class="maincontainer__dashboard-typeImg-info-box ">
                        <div>
                            <img src="{{ asset('images/managecontact.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tổng tin nhắn
                            </span>
                            <span>
                                {{ count($listContact) }}
                            </span>
                        </div>
                    </button>
                </div>

                <div class="col-xl-3">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/managecontact1.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tin nhắn trong tuần
                            </span>
                            <span>
                                {{ count($listContactWeek) }}
                            </span>
                        </div>
                    </button>
                </div>

                <div class="col-xl-3">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/managecontact1.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tin nhắn trong tháng
                            </span>
                            <span>
                                {{ count($listContactMonth) }}
                            </span>
                        </div>
                    </button>
                </div>

                <div class="col-xl-3">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/managecontact1.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tin nhắn trong năm
                            </span>
                            <span>
                                {{ count($listContactYear) }}
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </section>
        @if (count($listContact))
            <section class="managecontact__content-content user__table">
                <div class="table__order managecontact__content-content-boxct">
                    <table class="table ">
                        <thead>
                            <tr class="row row-tb">
                                <th scope="col" class="per-5">STT</th>
                                <th scope="col" class="admin__order-col-listbook per-15">Họ tên</th>
                                <th scope="col" class="admin__order-col per-20">Email</th>
                                <th scope="col" class="admin__order-col per-10">Chủ đề</th>
                                <th scope="col" class="admin__order-col per-40">Message</th>
                                <th scope="col" class="per-10">Trạng thái</th>
                                <th scope="col" class="admin__order-col per-10">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($listContact as $contact)
                                <tr attr-id="{{ $contact->id }}" class=" {{ $contact->is_readed ? 'background-readed' : 'background-notRead' }}
                                            row row-tb">
                                    <td class="per-5" scope="row">{{ $i }}</td>
                                    <td class="per-15">{{ $contact->name }}</td>
                                    <td class="per-20">{{ $contact->email }}</td>
                                    <td class="per-10">{{ $contact->title }}</td>
                                    <td class="per-40">{{ $contact->message }}</td>
                                    <td class="per-10 col-status">{{ $contact->is_readed ? 'Đã đọc' : 'Chưa đọc' }}</td>
                                    <td class="per-10">
                                        @if ($contact->is_readed)
                                            <div class="admin__order-handle btn-delete" data-toggle="modal"
                                                data-target="#exampleModal">
                                                <span>Xóa</span>
                                            </div>
                                        @else
                                            <div class="admin__order-handle btn-readed" attr-id="{{ $contact->id }}">
                                                <span>Đánh dấu là đã đọc</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa dịch vụ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn xóa ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-delete">Xóa bỏ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/admin/manage_contact.js') }}"></script>
@endsection
