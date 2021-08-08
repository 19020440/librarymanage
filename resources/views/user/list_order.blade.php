@inject('ModelBook', 'App\Models\Book')
@inject('ModelOrder', 'App\Models\Order')

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Book Page</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/footer.welcome.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/book_interface.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/navbar.book.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/content.book.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slider-view-img.book.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/manage.orderAdmin.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/order.user.css') }}" type="text/css">
</head>

<body>
    <input type="hidden" name="success" value="{{ session('msg') ? 1 : '' }}">
    <div class="overlay" id="overlay"></div>
    <div id="popup" class="popup">
        <div class="container">
            <div class="content-popup">
                <strong>{{ session('msg') }}</strong>
            </div>
            <div class="clearfix">
                <a role="button" class="submitbtn">OK</a>
            </div>
        </div>
    </div>
    @include('book_interface.navbar')
    <div class="addbook__content" id="list-order">
        <section class="addbook__content-header col-md-12 col-xl-12">
            <div class="addbook__content-header-box">
                <h1 class="addbook__content-header-box-ct">ĐƠN MƯỢN</h1>
            </div>
        </section>
        <section class="orderbook__content-dashboard">
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
        <section class="addbook__content-content order__table">
            <div class="orderbook__content-noOrder">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f49e36beaf32db.png"
                    alt="" class="no-order-img">
                <p class="no-order-text">Bạn chưa có đơn hàng nào</p>
            </div>
            @if (count($listOrder))
                <div class="table__order addbook__content-content-boxct container-fluid">
                    <table class="table table-striped">
                        <thead>
                            <tr class="row row-tb">
                                <th scope="col" class="per-5">STT</th>
                                <th scope="col" class="admin__order-col-listbook per-20">Sách</th>
                                <th scope="col" class="admin__order-col per-10">Ngày mượn</th>
                                <th scope="col" class="admin__order-col per-10">Ngày hẹn/trả</th>
                                <th scope="col" class="admin__order-col per-20">Địa chỉ</th>
                                <th scope="col" class="admin__order-col per-20">Ghi chú</th>
                                <th scope="col" class="admin__order-col per-10">Trạng thái</th>
                                <th scope="col" class="admin__order-col per-5"></th>
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
                                <td scope="col" class="admin__order-col-listbook per-20">
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
                                        <input type="text" disabled name="dateborrow"
                                            value="{{ $order->time_borrow }}">
                                    </div>
                                </td>
                                <td scope="col" class="admin__order-col per-10">
                                    <div class="admin__order-datePromise">
                                        @if ($order->status == $ModelOrder::STATUS_CONFIRM)
                                            <input type="text" disabled name="datepromise"
                                                value="{{ $order->time_promise_pay }}">
                                        @elseif ($order->status == $ModelOrder::STATUS_OVERDUE)
                                            <input type="text" disabled name="datepromise"
                                                value="{{ $order->time_promise_pay }}">
                                        @elseif ($order->status == $ModelOrder::STATUS_BORROWING)
                                            <input type="text" disabled name="datepromise"
                                                value="{{ $order->time_promise_pay }}">
                                        @elseif ($order->status == $ModelOrder::STATUS_BORROWED)
                                            <input type="text" disabled name="datepromise"
                                                value="{{ $order->time_pay }}">
                                        @elseif ($order->status == $ModelOrder::STATUS_CANCEL)
                                            <input type="text" disabled name="datepromise"
                                                value="{{ $order->updated_at }}">
                                        @endif
                                    </div>
                                </td>
                                <td scope="col" class="admin__order-col per-20">{{ $order->address }}</td>
                                <td scope="col" class="admin__order-col per-20">{{ $order->note }}</td>
                                @if ($order->status == $ModelOrder::STATUS_CONFIRM)
                                    <td scope="col" class="admin__order-col per-10">Chờ xác nhận</td>
                                @elseif ($order->status == $ModelOrder::STATUS_OVERDUE)
                                    <td scope="col" class="admin__order-col per-10">Quá hạn trả</td>
                                @elseif ($order->status == $ModelOrder::STATUS_BORROWING)
                                    <td scope="col" class="admin__order-col per-10">Đang mượn</td>
                                @elseif ($order->status == $ModelOrder::STATUS_BORROWED)
                                    <td scope="col" class="admin__order-col per-10">Đã trả</td>
                                @elseif ($order->status == $ModelOrder::STATUS_CANCEL)
                                    <td scope="col" class="admin__order-col per-10">Đã hủy</td>
                                @endif
                                @if ($order->status == $ModelOrder::STATUS_CONFIRM)
                                    <td scope="col" class="admin__order-col per-5">
                                        <div class="admin__order-handle open-modal-cancel" attr-id={{ $order->id }}>
                                            <span>Hủy</span>
                                        </div>
                                    </td>
                                @elseif ($order->status == $ModelOrder::STATUS_OVERDUE)
                                    <td scope="col" class="admin__order-col per-5">
                                        <div class="admin__order-handle open-modal-pay">
                                            <span>Trả sách</span>
                                        </div>
                                    </td>
                                @elseif ($order->status == $ModelOrder::STATUS_BORROWING)
                                    <td scope="col" class="admin__order-col per-5">
                                        <div class="admin__order-handle open-modal-pay">
                                            <span>Trả sách</span>
                                        </div>
                                    </td>
                                @endif
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    {{ $listOrder->onEachSide(1)->links() }}
                    <div class="modal" id="modal-cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hủy dịch vụ</h5>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc muốn hủy đơn mượn ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="submit-cancel">Hủy đơn
                                        mượn</button>
                                    <button type="button" class="btn btn-secondary" id="btn-modal-cancel">Quay
                                        lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="modal-pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Trả sách</h5>
                                </div>
                                <div class="modal-body">
                                    <h5>Bạn vui lòng gọi đến số tiện thoại: <div class="color-red">
                                            {{ $ModelOrder::PHONE_DEFAULT }}</div> để liên
                                        hệ
                                        trả sách.
                                        Cảm ơn bạn.</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-modal-pay">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="modal-pay-again" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Đặt lại đơn</h5>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc muốn đặt lại đơn ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" id="submit-again">Đặt lại</button>
                                    <button type="button" class="btn btn-secondary" id="btn-modal-again">Quay
                                        lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
    @include('layouts.footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin/manage_order.js') }}"></script>
</body>

</html>
