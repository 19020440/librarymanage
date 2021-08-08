@extends('admin.layouts.default')

@section('title', 'ManageBook')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/manage.list.book.css') }}" type="text/css">
@endsection

@section('content')
    <div class="listbook__content">
        <section class="listbook__content-header col-md-12 col-xl-12">
            <div class="listbook__content-header-box">
                <h1 class="listbook__content-header-box-ct">List Book</h1>
                <span><span>Home</span> / List book</span>
            </div>
        </section>

        <section class="listbook__content-content">
            <div class="listbook__content-content-header">
                <a href="{{ route('admin.book.create') }}" class="btn btn-dark">Thêm sách </a>
            </div>

            <div class="listbook__content-content-boxct col-md-12 col-xl-12 col-sm-12 col-12">
                <div id="content" class="section container slideanim sec-act">
                    <h2 class="content-heading">TỦ SÁCH</h2>
                    <p class="content-desc">Danh mục hàng hóa phong phú, nhiều sản phẩm độc quyền,
                        được chọn lọc kỹ càng đã tạo nên sự khác biệt của Nhà Sách Hoàng Gia Chelsea
                        và tạo dựng được lòng tin yêu từ khách hàng</p>
                    <div class="content-shelf row">
                        <div class="content-shelf-sidebar col-xl-2-4 col-lg-3 col-md-3 col-sm-12">
                            <ul class="sidebar-list">
                                <form action="{{ route('admin.book.index') }}">
                                    <button type="submit"
                                        class="sidebar-item {{ (isset($category) && $category == -1) || !isset($category) ? 'active' : '' }}"
                                        name='category' value='-1'>Tất cả</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 0 ? 'active' : '' }}"
                                        name='category' value='0'>Tổng quát</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 1 ? 'active' : '' }}"
                                        name='category' value='1'>Triết học</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 2 ? 'active' : '' }}"
                                        name='category' value='2'>Tôn giáo</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 3 ? 'active' : '' }}"
                                        name='category' value='3'>Khoa học xã hội</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 4 ? 'active' : '' }}"
                                        name='category' value='4'>Ngôn ngữ</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 5 ? 'active' : '' }}"
                                        name='category' value='5'>Toán học và khoa học tự nhiên</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 6 ? 'active' : '' }}"
                                        name='category' value='6'>Kỹ thuật</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 7 ? 'active' : '' }}"
                                        name='category' value='7'>Nghệ thuật</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 8 ? 'active' : '' }}"
                                        name='category' value='8'>Văn học</button>
                                    <button type="submit"
                                        class="sidebar-item {{ isset($category) && $category == 9 ? 'active' : '' }}"
                                        name='category' value='9'>Địa lý lịch sử</button>
                                </form>
                            </ul>
                        </div>
                        <div class="content-shelf-main col-xl-9-6 col-lg-9 col-md-9 col-sm-12">
                            <div class="book-filter row">
                                <div class="book-filter-search col-xl-9-6 col-lg-9 col-md-8 col-sm-9">
                                    <form action="{{ route('admin.book.index') }}" class="form-search-book"
                                        autocomplete="off">
                                        <input type="hidden" name='category'
                                            value="{{ isset($category) ? $category : '' }}">
                                        <input type="text" name="info" class="search-input"
                                            placeholder="Nhập vào để tìm kiếm" value="{{ $info }}">
                                        <div class="select-wrapper">
                                            <select name="choose" class="select-filter-book"
                                                style="background-image: url({{ asset('./images/funnel-fill.svg') }});">
                                                <option value="name" {{ $choose == 'name' ? 'selected' : '' }}>Tìm theo
                                                    tên sách
                                                </option>
                                                <option value="auth" {{ $choose == 'auth' ? 'selected' : '' }}>Tìm theo
                                                    tên tác giả
                                                </option>
                                                <option value="publisher" {{ $choose == 'publisher' ? 'selected' : '' }}>
                                                    Tìm theo nhà
                                                    xuất bản</option>
                                                <option value="category" {{ $choose == 'category' ? 'selected' : '' }}>
                                                    Tìm theo mã
                                                    DDC
                                                </option>
                                                <option value="translator"
                                                    {{ $choose == 'translator' ? 'selected' : '' }}>Tìm theo
                                                    tên
                                                    dịch giả</option>
                                                <option value="country" {{ $choose == 'country' ? 'selected' : '' }}>Tìm
                                                    theo quốc
                                                    gia
                                                </option>
                                            </select>
                                        </div>
                                        <button class="btn-search">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" stroke-width="6"
                                                fill="currentColor" class="icon-search bi bi-search" viewBox="0 0 16 16">
                                                <path
                                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <div class="filter-sort-wrapper col-xl-2-4 col-lg-3 col-md-4 col-sm-3">
                                    <div class="book-filter-sort">
                                        @if ($sort == -1)
                                            <span class="book-sort-to">Sắp xếp</span>
                                        @elseif ($sort == 1)
                                            <span class="book-sort-to"> Từ A tới Z </span>
                                        @else
                                            <span class="book-sort-to"> Từ Z tới A </span>
                                        @endif
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="sort-icon bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                        </svg>
                                        <ul class="sort-by">
                                            <form action="{{ route('admin.book.index') }}" class="form-list-book">
                                                <input type="hidden" name='category' value="{{ $category }}">
                                                <input type="hidden" name="info" value="{{ $info }}">
                                                <input type="hidden" name="choose" value="{{ $choose }}">
                                                <button type="submit" name='sort' value='1' class="sort-by-name AtoZ"
                                                    {{ $sort == 1 ? 'disabled' : '' }}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="sort-by-icon bi bi-sort-alpha-down"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z" />
                                                        <path
                                                            d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z" />
                                                    </svg>
                                                    <span> Từ A tới Z </span>
                                                </button>
                                                <button type="submit" name='sort' value='0' class="sort-by-name ZtoA"
                                                    {{ $sort == 0 ? 'disabled' : '' }}>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="sort-by-icon bi bi-sort-alpha-down-alt"
                                                        viewBox="0 0 16 16">>
                                                        <path
                                                            d="M12.96 7H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V7z" />
                                                        >
                                                        <path fill-rule="evenodd"
                                                            d="M10.082 12.629 9.664 14H8.598l1.789-5.332h1.234L13.402 14h-1.12l-.419-1.371h-1.781zm1.57-.785L11 9.688h-.047l-.652 2.156h1.351z" />
                                                        >
                                                        <path
                                                            d="M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z" />
                                                    </svg>
                                                    <span> Từ Z tới A</span>
                                                </button>
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if (count($books))
                                <div class="book-list row">
                                    @foreach ($books as $book)
                                        <div class="book-wrapper col-xl-2-4 col-lg-3 col-md-4 col-sm-6">
                                            <div class="book-item">
                                                <a href="{{ route('admin.book.edit', $book->id) }}" class="book-item-a">
                                                    <img src="https://img.icons8.com/bubbles/50/000000/edit.png" />
                                                </a>
                                                <a href="{{ route('admin.book.edit', $book->id) }}"
                                                    class="book-item-link">
                                                    <div class="book-img"
                                                        style="background-image: url({{ asset($book->images()->get()[0]->path) }});">
                                                    </div>
                                                    <h4 class="book-name">{{ $book->name }}</h4>
                                                </a>
                                                <div class="book-item-author">
                                                    <span class="book-author-name">Author: {{ $book->auth }}</span>
                                                </div>
                                                <div class="book-item-action">
                                                    <p class="ddc-code">Mã DDC: <span>{{ $book->category }}</span></p>
                                                    <span class="book-sold">SL:
                                                        {{ $book->quantity ? $book->quantity : 'Hết hàng' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{ $books->withQueryString()->onEachSide(1)->links() }}
                            @else
                                <h3 class="note">Không có sách nào phù hợp!</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/admin/manage_book.js') }}"></script>
@endsection
