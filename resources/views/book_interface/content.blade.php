@inject('BookModel', 'App\Models\Book')

<div id="content" class="content section container">
    <div class="breadcrumb">
        <a class="breadcrumb-item" href="{{ route('welcome') }}">Trang chủ</a>
        <a class="breadcrumb-item">{{ $book->type }}</a>
        <a class="breadcrumb-item">{{ $book->name }}</a>
    </div>
    <div class="single-book row">
        <div class="single-book-img col-xl-4 col-lg-4">
            <div class="book-main-img">
                <img src="{{ asset($book->images()->get()[0]->path) }}" alt="Mặt trước">
            </div>
            <div class="book-review-img">
                <img src="{{ asset($book->images()->get()[0]->path) }}" alt="Mặt trước" class="list-img active">
                <img src="{{ asset($book->images()->get()[1]->path) }}" alt="Mặt sau" class="list-img">
            </div>
        </div>
        <div class="book-main col-xl-8 col-lg-8">
            <form action="{{ route('user.add.cart') }}" method="POST">
                @csrf
                <h2 class="book-heading">{{ $book->name }}</h2>
                <h3 class="book-author">{{ $book->auth }}</h3>
                <div class="book-info">
                    <table>
                        <tbody>
                            <tr>
                                <td>Nhà xuất bản</td>
                                <td>{{ $book->publisher }}</td>
                            </tr>
                            <tr>
                                <td>Năm phát hành</td>
                                <td>{{ $book->year_start }}</td>
                            </tr>
                            <tr>
                                <td>Số lượng sách còn lại</td>
                                <td>{{ $book->quantity ? $book->quantity : 'Hết hàng' }}</td>
                            </tr>
                            <tr>
                                <td>Tên dịch giả</td>
                                <td>{{ $book->translator }}</td>
                            </tr>
                            <tr>
                                <td>Quốc gia</td>
                                <td>{{ $book->country }}</td>
                            </tr>
                            <tr>
                                <td><a href="http://www.thuvienhaiphu.com.vn/datafile1/tl_plddc/DC027106.htm"
                                        target="_blank">Mã DDC</a>
                                </td>
                                <td>{{ $book->category }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if ($book->quantity)
                    <div class="book-num">
                        <button type="button" class="book-btn-sub">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="book-icon-num bi bi-dash-lg" viewBox="0 0 16 16">
                                <path d="M0 8a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H1a1 1 0 0 1-1-1z" />
                            </svg>
                        </button>
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <input type="hidden" name="book_quantity" value="{{ $book->quantity }}">
                        <input type="text" class="book-num-input" name="quantity" value="1">
                        <button type="button" class="book-btn-add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="book-icon-num bi bi-plus-lg" viewBox="0 0 16 16">
                                <path
                                    d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
                            </svg>
                        </button>
                    </div>
                    @auth
                        @if (Auth::user()->is_borrow)
                            <div class="alert alert-danger">*Bạn đang có 1 đơn hàng mượn rồi, không thể mượn tiếp. Xin thông
                                cảm.</div>
                        @else
                            <button type="submit" class="add-cart">Thêm vào giỏ hàng</button>
                            <button type="button" class="view-cart">Xem giỏ hàng</button>
                        @endif
                    @endauth
                @else
                    <div class="alert alert-danger">*Sản phẩm đã hết hàng. Mong bạn quay lại sau.</div>
                @endif

                @guest
                    <div class="alert alert-danger">*Bạn chưa đăng nhập nên chưa có tính năng giỏ hàng.</div>
                @endguest
            </form>
        </div>
    </div>
    <div class="book-review">
        <h3 class="book-review-heading">Nội dung</h3>
        <div class="book-review-main">
            <p>{{ $book->content()->get()[0]->content_book }}</p>
        </div>
    </div>
    <div class="same-category">
        <h3 class="same-category-heading">Sách cùng thể loại</h3>
        <div class="same-category-list row">
            @if (count($listbook))
                @foreach ($listbook as $book)
                    <div class="book-wrapper col-xl-2 col-lg-2">
                        <div class="book-item">
                            <a href="{{ route('welcome.singlebook', $book->id) }}" class="book-item-link">
                                <div class="book-img"
                                    style="background-image: url({{ asset($book->images()->get()[0]->path) }});">
                                </div>
                                <h4 class="book-name">{{ $book->name }}</h4>
                            </a>
                            <div class="book-item-author">
                                <span class="book-author-name">{{ $book->auth }}</span>
                            </div>
                            <div class="book-item-action">
                                <p class="ddc-code">Mã DDC: <span>{{ $book->category }}</span></p>
                                <span
                                    class="book-sold">{{ $book->quantity > 0 ? 'SL: ' . $book->quantity : 'Hết hàng' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>Không có sách cùng thể loại.</h3>
            @endif
        </div>
    </div>
</div>
