@inject('ModelBook', 'App\Models\Book')
@inject('ModelOrder', 'App\Models\Order')

@extends('admin.layouts.default')

@section('title', 'ManageOrder')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage.orderAdmin.css') }}" type="text/css">
@endsection

@section('content')
    <div class="addbook__content" id="list-order">
        <section class="addbook__content-header col-md-12 col-xl-12">
            <div class="addbook__content-header-box">
                <h1 class="addbook__content-header-box-ct">Order Book</h1>
                <span><span>Home</span> / Order book</span>
            </div>
        </section>
        <section class="orderbook__content-dashboard">
            <form action="{{ route('admin.order.index') }}" id='form-filter-order'>
                <div class="row selection">
                    <div class="col-sm-3">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Ngày mượn từ</label>
                            <input type="date" class="form-control" name="day_start" min="2021-01-01"
                                value="{{ $day_start }}">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                            <label class="control-label">Đến</label>
                            <input type="date" class="form-control" name="day_end" max="{{ now()->format('Y-m-d') }}"
                                value="{{ $day_end }}">
                        </div>
                    </div>
                    <div class=" col-sm-6 form-input-name">
                        <div class="form-search-book">
                            <input type="text" name="user" class="search-input" placeholder="Tìm kiếm theo tên người mượn"
                                value="{{ $userFilter }}">
                            <button class="btn-search">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke-width="6"
                                    fill="currentColor" class="icon-search bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row orderbook__content-dashboard-margin pewpew">
                <div class="col-xl-2">
                    <button class="maincontainer__dashboard-typeImg-info-box ">
                        <div>
                            <img src="{{ asset('images/manageordertotal.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tổng số đơn
                            </span>
                            <span>
                                {{ count($listOrder) }}
                            </span>
                        </div>
                    </button>
                </div>
                <div class="col-xl-2">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/manageorder.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tổng đơn chờ xác nhận
                            </span>
                            <span>
                                {{ count($listOrderConfirm) }}
                            </span>
                        </div>
                    </button>
                </div>
                <div class="col-xl-2">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/manageordercancel.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tổng đơn quá hạn trả
                            </span>
                            <span>
                                {{ count($listOrderOverdue) }}
                            </span>
                        </div>
                    </button>
                </div>
                <div class="col-xl-2">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/manageorderborrow.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tổng đơn đang mượn
                            </span>
                            <span>
                                {{ count($listOrderBorrowing) }}
                            </span>
                        </div>
                    </button>
                </div>
                <div class="col-xl-2">
                    <button class="maincontainer__dashboard-typeImg-info-box">
                        <div>
                            <img src="{{ asset('images/borrow2.png') }}" />
                        </div>
                        <div class="maincontainer__dashboard-typeImg-info-box-quantity">
                            <span>
                                Tổng đơn đã trả
                            </span>
                            <span>
                                {{ count($listOrderBorrowed) }}
                            </span>
                        </div>
                    </button>
                </div>
            </div>
        </section>
        @if (count($listOrder))
            <section class="addbook__content-content order__table">
                <div class="table__order addbook__content-content-boxct container-fluid">
                    <table class="table table-striped">
                        <thead>
                            <tr class="row row-tb">
                                <th scope="col" class="per-5">STT</th>
                                <th scope="col" class="per-5">UserId</th>
                                <th scope="col" class="admin__order-col-listbook per-15">ListBook</th>
                                <th scope="col" class="admin__order-col per-10">Ngày mượn</th>
                                <th scope="col" class="admin__order-col per-10">Ngày hẹn</th>
                                <th scope="col" class="admin__order-col per-10">Ngày trả</th>
                                <th scope="col" class="admin__order-col per-15">Địa chỉ</th>
                                <th scope="col" class="admin__order-col per-12">Note</th>
                                <th scope="col" class="admin__order-col per-8">Trạng thái</th>
                                <th scope="col" class="admin__order-col per-10">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($listOrder as $order)
                                @if ($order->status == $ModelOrder::STATUS_CONFIRM)
                                    <tr class="background-notBorrow row row-tb">
                                    @elseif ($order->status == $ModelOrder::STATUS_OVERDUE)
                                    <tr class="background-notPay row row-tb">
                                    @elseif ($order->status == $ModelOrder::STATUS_BORROWING)
                                    <tr class="background-borrowed row row-tb">
                                    @elseif ($order->status == $ModelOrder::STATUS_BORROWED)
                                    <tr class="background-payed row row-tb">
                                    @elseif ($order->status == $ModelOrder::STATUS_CANCEL)
                                    <tr class="background-cancel row row-tb">
                                @endif
                                <td scope="col" class="per-5">{{ $i }}</td>
                                <td scope="col" class="per-5">{{ $order->user_id }}</td>
                                <td scope="col" class="admin__order-col-listbook per-15">
                                    <div class="admin__order-listbook">
                                        <ul class="admin__order-list cot">
                                            @foreach ($order->orderdetails()->get() as $oderdetail)
                                                <li class="admin__order-item">
                                                    <span class="book">
                                                        {{ $ModelBook->getName($oderdetail->book_id) }}
                                                    </span>
                                                    <span class="color-red">x{{ $oderdetail->quantity }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td scope="col" class="admin__order-col per-10">
                                    <div class="admin__order-dateBorrow">
                                        <input type="text" disabled name="time_borrow" value="{{ $order->time_borrow }}">
                                    </div>
                                </td>
                                <td scope="col" class="admin__order-col per-10">
                                    <div class="admin__order-datePromise">
                                        <input type="text" disabled name="time_promise_pay"
                                            value="{{ $order->time_promise_pay }}">
                                    </div>
                                </td>
                                <td scope="col" class="admin__order-col per-10">
                                    <div class="admin__order-datePay">
                                        <input type="text" disabled name="time_pay" value="{{ $order->time_pay }}">
                                    </div>
                                </td>
                                <td scope="col" class="admin__order-col per-15">{{ $order->address }}</td>
                                <td scope="col" class="admin__order-col per-12 per-12-1">{{ $order->note }}</td>
                                @if ($order->status == $ModelOrder::STATUS_CONFIRM)
                                    <td scope="col" class="admin__order-col col-status per-8">Chờ xác nhận</td>
                                @elseif ($order->status == $ModelOrder::STATUS_OVERDUE)
                                    <td scope="col" class="admin__order-col col-status per-8">Quá hạn trả</td>
                                @elseif ($order->status == $ModelOrder::STATUS_BORROWING)
                                    <td scope="col" class="admin__order-col col-status per-8">Đang mượn</td>
                                @elseif ($order->status == $ModelOrder::STATUS_BORROWED)
                                    <td scope="col" class="admin__order-col col-status per-8">Đã trả</td>
                                @elseif ($order->status == $ModelOrder::STATUS_CANCEL)
                                    <td scope="col" class="admin__order-col col-status per-8">Đã hủy</td>
                                @endif
                                @if ($order->status == $ModelOrder::STATUS_CONFIRM)
                                    <td scope="col" class="admin__order-col per-10">
                                        <img class="btn-handle btn_confirm" src="{{ asset('images/confirm-btn.png') }}"
                                            attr-order="{{ $order->id }}">
                                        <img class="admin__order-button-cancel btn-handle"
                                            src="{{ asset('images/btn-cancel.png') }}" attr-order="{{ $order->id }}"
                                            data-toggle="modal" data-target="#exampleModalCancel" />
                                    </td>
                                @else
                                    <td scope="col" class="admin__order-col per-10">
                                        <div class="admin__order-handle">
                                            @if ($order->status == $ModelOrder::STATUS_BORROWING || $order->status == $ModelOrder::STATUS_OVERDUE)
                                                <img class="admin__order-button-save btn-handle"
                                                    src="https://img.icons8.com/ios-glyphs/32/000000/save--v1.png"
                                                    attr-order="{{ $order->id }}" />
                                                <img class="admin__order-button-edit btn-handle"
                                                    src="https://img.icons8.com/windows/32/000000/edit-product.png"
                                                    attr-order="{{ $order->id }}" />
                                            @endif
                                            @if ($order->status == $ModelOrder::STATUS_BORROWING)
                                                <img class="admin__order-button-cancel btn-handle"
                                                    src="{{ asset('images/btn-cancel.png') }}"
                                                    attr-order="{{ $order->id }}" data-toggle="modal"
                                                    data-target="#exampleModalCancel" />
                                            @endif
                                            @if ($order->status == $ModelOrder::STATUS_BORROWED || $order->status == $ModelOrder::STATUS_CANCEL)
                                                <img class="admin__order-button-delete btn-handle"
                                                    src="https://img.icons8.com/ios-filled/32/000000/delete-forever.png"
                                                    data-toggle="modal" data-target="#exampleModal"
                                                    attr-order="{{ $order->id }}" />
                                            @endif
                                        </div>
                                    </td>
                                @endif
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    {{ $listOrder->onEachSide(1)->links() }}
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xóa dịch vụ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc muốn xóa đơn ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-delete" data-dismiss="modal">Xóa
                                        bỏ</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModalCancel" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hủy đơn</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc muốn hủy đơn ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-cancel" data-dismiss="modal">Hủy
                                        đơn</button>
                                    <button type=" button" class="btn btn-secondary" data-dismiss="modal">Quay lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/admin/manage_order.js') }}"></script>

@endsection
