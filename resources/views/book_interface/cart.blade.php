<div class="cart-interface">
    <div class="your-cart">
        <h2 class="cart-heading">Giỏ Hàng</h2>
        @if (count($cart))
            <div class="cart-info">
                <table>
                    <tr class="row row-head">
                        <th class="col-xl-6 col-lg-6">Sản phẩm</th>
                        <th class="col-xl-3 col-lg-3">Thể loại</th>
                        <th class="col-xl-2 col-lg-2">Số lượng</th>
                        <th class="col-xl-1 col-lg-1"></th>
                    </tr>
                    @php $totalBook = 0; @endphp
                    @foreach ($cart as $item)
                        <tr class="row row-cart">
                            <td class="col-xl-6 col-lg-6">
                                <div class="cart-book-info">
                                    <img src="{{ asset($item->book->images()->get()[0]->path) }}" alt="">
                                    <div class="cart-book-main">
                                        <div class="cart-book-heading">
                                            <h5 class="cart-book-name">{{ $item->book->name }}</h5>
                                        </div>
                                        <div class="cart-book-body">
                                            <span class="cart-book-desc">{{ $item->book->auth }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="col-xl-3 col-lg-3">
                                <span class="cart-book-category">{{ $item->book->type }}</span>
                            </td>
                            <td class="col-xl-2 col-lg-2">
                                <div class="cart-book-num">
                                    <button class="btn-sub">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="icon-num bi bi-dash-lg" viewBox="0 0 16 16">
                                            <path d="M0 8a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1z" />
                                        </svg>
                                    </button>
                                    <input type="hidden" name='cart' value={{ $item->id }}>
                                    <input type="text" class="cart-num" value="{{ $item->quantity }}">
                                    <button class="btn-add">
                                        <input type="hidden" id="book_quantity" value={{ $item->book->quantity }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="icon-num bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                                        </svg>
                                    </button>
                                    <input type="hidden" name='cart' value={{ $item->id }}>
                                </div>
                            </td>
                            <td class="col-xl-1 col-lg-1">
                                <button class="btn-remove">Xóa</button>
                                <input type="hidden" name='cart' value={{ $item->id }}>
                            </td>
                        </tr>
                        @php $totalBook += $item->quantity; @endphp
                    @endforeach
                </table>
                <h4 class="cart-sum">Tổng mượn: <span id="sum-book">{{ $totalBook }}</span> quyển</h4>
            </div>
            <div class="no-cart">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f49e36beaf32db.png"
                    alt="" class="no-cart-img">
                <p class="no-cart-text">Chưa Có Sản Phẩm</p>
                <div class="cart-submit-wrapper-2">
                    <button class="cart-out btn-effect">Thoát</button>
                </div>
            </div>
            <form class="form" action="{{ route('user.save.order') }}" method="POST" onsubmit="return false;">
                @csrf
                <div class="form-submit">
                    <div class="cart-address">
                        <div class="input-address">
                            <label class="address-heading">Địa chỉ nhận:</label>
                            <input type="text" class="address-receive" placeholder="Nhập địa chỉ cụ thể" name="address"
                                value="{{ Auth::user()->address }}" readonly required>
                            <div class="alert alert-danger error-address">*Bạn chưa nhập địa chỉ.</div>
                        </div>
                        <div class="checkbox-address">
                            <input type="checkbox" class="checkbox" checked>
                            <input type="hidden" name="address-default" value="{{ Auth::user()->address }}">
                            <label class="address-heading">Địa chỉ mặc định</label>
                        </div>
                    </div>
                    <div class="cart-date">
                        <label class="date-heading">Ngày trả sách: <div class="alert alert-danger">*Giờ trả sách tương
                                đương với giờ mượn sách</div></label>
                        <input type="date" class="date-giveback" name="time_promise_pay"
                            value="{{ old('time_promise_pay') }}"
                            min='{{ date_format(now()->addHours(7), 'Y-m-d') }}'
                            max='{{ date_format(now()->addDays(30), 'Y-m-d') }}' required>
                        <div class="alert alert-danger error-date">*Ngày trả sách phải sau ngày mượn sách</div>
                    </div>
                    <div class="cart-mess">
                        <label class="mess-heading">Lời nhắn:</label>
                        <textarea type="text" class="mess-receive" placeholder="Để lại lời nhắn" rows="3" name="note"
                            value="{{ old('note') }}">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class=" cart-submit-wrapper">
                    <button type="submit" class="cart-submit btn-effect">Xác nhận</button>
                    <button type="button" class="cart-out btn-effect">Thoát</button>
                </div>
            </form>
        @else
            <div class="no-cart-2">
                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f49e36beaf32db.png"
                    alt="" class="no-cart-img">
                <p class="no-cart-text">Chưa Có Sản Phẩm</p>
                <div class="cart-submit-wrapper-2">
                    <button class="cart-out">Thoát</button>
                </div>
            </div>
        @endif
    </div>
    <div class="overlay"></div>
</div>
