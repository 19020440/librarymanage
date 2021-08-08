<div id="header" class="header">
    <nav class="nav container">
        <a href="{{ route('welcome') }}" class="logo"><img src="{{ asset('images/logo.png') }}"></a>
        <div class="nav-search">
            <form action="{{ route('welcome') }}" class="form-search-book" autocomplete="off">
                <input type="text" name="info" class="search-input" placeholder="Nhập vào để tìm kiếm">
                <div class="select-wrapper">
                    <select name="choose" class="select-filter-book"
                        style="background-image: url({{ asset('./images/funnel-fill.svg') }});">
                        <option value="name">Tìm theo tên sách
                        </option>
                        <option value="auth">Tìm theo tên tác giả
                        </option>
                        <option value="publisher">Tìm theo nhà
                            xuất bản</option>
                        <option value="category">Tìm theo mã
                            DDC
                        </option>
                        <option value="translator">Tìm theo
                            tên
                            dịch giả</option>
                        <option value="country">Tìm theo quốc
                            gia
                        </option>
                    </select>
                </div>
                <button class="btn-search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke-width="6" fill="currentColor"
                        class="icon-search bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </button>
            </form>
        </div>
        @auth
            <div class="nav-logged-in">
                <div class="header__navbar-item header__navbar-item--notify">
                    <div class="header_nofi-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="header_navbar-icon-link bi bi-bell-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                        </svg>
                    </div>
                    @if ($countAlert)
                        <span class="nav-nofi-notice" id='count-alert'>{{ $countAlert }}</span>
                    @endif
                    <div class="header__notify">
                        <header class="header__notify-header">
                            <h3>Thông báo mới nhận</h3>
                            @if ($countAlert)
                                <span id="readed" attr-id={{ Auth::user()->id }}>Đánh dấu đã xem</span>
                            @endif
                        </header>
                        <ul class="header__notify-list">
                            @foreach ($alerts as $alert)
                                <li class="header__notify-item {{ $alert->is_readed ? 'bg-readed' : 'bg-not-read' }}">
                                    <div class="header__notify-link">
                                        <img src="https://cf.shopee.vn/file/b8ae87c9b51fb3b795eba17051a891b5" alt=""
                                            class="header__notify-img">
                                        <div class="header__notify-info">
                                            <span class="header__notify-name">{{ $alert->content }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <footer class="header__notify-footer">
                            <a class="header__notify-footer-btn"></a>
                        </footer>
                    </div>
                </div>
                <div class="nav-cart">
                    <div class="header_cart-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="icon-cart bi bi-cart-plus-fill" viewBox="0 0 16 16">
                            <path
                                d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z" />
                        </svg>
                    </div>
                    <span class="nav-cart-notice">{{ count($cart) }}</span>
                    <div class="nav-cart-list">
                        <div class="nav-no-cart">
                            <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f49e36beaf32db.png"
                                alt="" class="nav-cart--no-cart-img">
                            <p class="nav-cart--no-cart-text">Chưa Có Sản Phẩm</p>
                        </div>
                        @if (count($cart))
                            <h3 class="nav-cart-heading">Sản phẩm đã thêm</h3>
                            <ul class="nav-cart-list-item">
                                @foreach ($cart as $item)
                                    <li class="nav-cart-item">
                                        <img src="{{ asset($item->book->images()->get()[0]->path) }}" alt=""
                                            class="nav_cart-item-img">
                                        <div class="nav-cart-item-info">
                                            <div class="nav-cart-item-heading">
                                                <h5 class="nav-cart-item-name">
                                                    {{ $item->book->name }}
                                                </h5>
                                            </div>
                                            <div class="nav-cart-item-body">
                                                <span class="nav-cart-item-desc">{{ $item->book->auth }}</span>
                                                <span class="nav-cart-item-remove">Xóa</span>
                                                <input type="hidden" name='cart' value={{ $item->id }}>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="btn-primary nav-cart-view">Xem giỏ hàng</button>
                        @else
                            <div class="nav-no-cart-2">
                                <img src="https://deo.shopeemobile.com/shopee/shopee-pcmall-live-sg/cart/9bdd8040b334d31946f49e36beaf32db.png"
                                    alt="" class="nav-cart--no-cart-img">
                                <p class="nav-cart--no-cart-text">Chưa Có Sản Phẩm</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="nav-user">
                    <img src="{{ asset(Auth::user()->images) }}" alt="" class="nav-user-img">
                    <span class="nav-user-name">{{ Auth::user()->name }}</span>
                    <ul class="nav-user-menu">
                        <li class="nav-user-item">
                            <a href="{{ route('user.profile') }}">Thông tin cá nhân</a>
                        </li>
                        <li class="nav-user-item">
                            <a href=" {{ route('user.order') }}">Đơn mượn</a>
                        </li>
                        <li class="nav-user-item">
                            <a href="{{ route('user.logout') }}">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        @endauth
        @guest
            <a class="login nav-not-logged-in" href="{{ route('user.login') }}">ĐĂNG NHẬP</a>
        @endguest
    </nav>
</div>
