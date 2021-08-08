<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Alert;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Book\BookRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Order\OrderRepository;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\DB;

class ShowBookController extends Controller
{
    protected $maxBook = 5;
    private $bookRepository;
    private $userRepository;
    private $cartRepository;
    private $orderRepository;

    public function __construct(
        BookRepository $bookRepository,
        UserRepository $userRepository,
        CartRepository $cartRepository,
        OrderRepository $orderRepository
    ) {
        $this->bookRepository = $bookRepository;
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
    }

    public function welcome(Request $request)
    {
        if (Auth::user()) {
            $user = $this->userRepository->find(Auth::user()->id);
            $listOrder = $user->orders()->paginate(8);
            if ($listOrder) {
                foreach ($listOrder as $order) {
                    $order = $this->orderRepository->updateStatus($order);
                }
            }
        }
        $category = -1;
        $info = '';
        $choose = 'name';
        $sort = -1;
        $filter = [];
        if ($request->get('category') != -1 && $request->get('category') != null) {
            $filter['category'] = $request->get('category');
            $category = $request->get('category');
        }
        if ($request->get('info')) {
            $filter['info'] = $request->get('info');
            $filter['filter'] = $request->get('choose');
            $info = $request->get('info');
            $choose = $request->get('choose');
        }
        if ($request->get('sort') != null) {
            $filter['sort'] = $request->get('sort');
            $sort = $request->get('sort');
        }
        $books = $this->bookRepository->getListBook($filter);
        $cart = [];
        $countAlert = 0;
        $alerts = [];
        if (Auth::user()) {
            $userId = Auth::user()->id;
            $user = $this->userRepository->find($userId);
            $cart = $user->carts()->get();
            foreach ($cart as $item) {
                $item['book'] = $this->bookRepository->find($item->book_id);
                $item['book']['type'] = $this->bookRepository->getTextCategory($item['book']->category);
            }
            $alerts = $user->alerts()->orderByDesc('created_at')->limit(10)->get();
            if ($alerts) {
                foreach ($alerts as $alert) {
                    if (!$alert->is_readed) {
                        $countAlert++;
                    }
                }
            }
        }
        return view('welcome', [
            'books' => $books,
            'category' => $category,
            'info' => $info,
            'sort' => $sort,
            'choose' => $choose,
            'cart' => $cart,
            'countAlert' => $countAlert,
            'alerts' => $alerts
        ]);
    }

    public function singlebook(Request $request, $id)
    {
        $book = $this->bookRepository->find($id);
        if (!$book) {
            return abort(404);
        }
        if (Auth::user()) {
            $user = $this->userRepository->find(Auth::user()->id);
            $listOrder = $user->orders()->paginate(10);
            if ($listOrder) {
                foreach ($listOrder as $order) {
                    $order = $this->orderRepository->updateStatus($order);
                }
            }
        }
        $book = $this->bookRepository->find($id);
        $book['type'] = $this->bookRepository->getTextCategory($book->category);
        if (!$book) {
            return abort(404);
        }
        $listbook = $this->bookRepository->getListBookByCategory($book->category);
        $cart = [];
        $countAlert = 0;
        $alerts = [];
        if (Auth::user()) {
            $userId = Auth::user()->id;
            $user = $this->userRepository->find($userId);
            $cart = $user->carts()->get();
            foreach ($cart as $item) {
                $item['book'] = $this->bookRepository->find($item->book_id);
                $item['book']['type'] = $this->bookRepository->getTextCategory($item['book']->category);
            }
            $alerts = $user->alerts()->orderByDesc('created_at')->limit(10)->get();
            if ($alerts) {
                foreach ($alerts as $alert) {
                    if (!$alert->is_readed) {
                        $countAlert++;
                    }
                }
            }
        }
        return view('book_interface.book_interface', [
            'book' => $book,
            'listbook' => $listbook,
            'cart' => $cart,
            'countAlert' => $countAlert,
            'alerts' => $alerts
        ]);
    }

    public function addCart(Request $request)
    {
        if (!$request->book_id || !$request->quantity) {
            return abort(404);
        }
        $cart = $this->cartRepository->getCartByUserAndBook($request->book_id, Auth::user()->id);
        if ($cart) {
            $cart['quantity'] += $request->quantity;
            if ($cart['quantity'] > $this->maxBook) {
                return redirect()->back()->with('msg', "Trong giỏ hàng đã có cuốn sách này, mỗi cuốn sách bạn chỉ được mượn tối đa 5 quyển.");
            }
            $cart->update();
        } else {
            $cart['book_id'] = $request->book_id;
            $cart['quantity'] = $request->quantity;
            $cart['user_id'] = Auth::user()->id;

            $this->cartRepository->create($cart);
        }

        $book = $this->bookRepository->find($request->book_id);
        $book['quantity'] -= $request->quantity;
        $book->update();

        return redirect()->back()->with('msg', 'Thêm vào giỏ hàng thành công!');
    }

    public function deleteCart(Request $request)
    {
        if ($request->id) {
            $cart = $this->cartRepository->find($request->id);
            $book = $this->bookRepository->find($cart->book_id);
            $book['quantity'] += $cart->quantity;
            $book->update();
            $cart->delete();
            $userId = Auth::user()->id;
            $sum = $this->cartRepository->getTotalBookOfUser($userId);
            $user = $this->userRepository->find($userId);
            $cart = $user->carts()->get();
            return Response()->json([
                'success' => 1,
                'sumBook' => $sum,
                'countCast' => count($cart)
            ]);
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function changeCart(Request $request)
    {
        if ($request->id) {
            $cart = $this->cartRepository->find($request->id);
            if (!$cart) {
                return abort(404);
            }
            $book = $this->bookRepository->find($cart->book_id);
            if ($book->quantity == 0) {
                return redirect()->back()->with('msg', "Cuốn sách này đang tạm thời hết hàng. Vui lòng quay lại sau.");
            }
            if ($request->type == 'add') {
                $cart['quantity'] += 1;
                $book['quantity'] -= 1;
                $book->update();
                $cart->update();
            }
            if ($request->type == 'sub') {
                $cart['quantity'] -= 1;
                $book['quantity'] += 1;
                if ($cart['quantity'] == 0) {
                    $cart->delete();
                } else {
                    $cart->update();
                }
                $book->update();
            }
            $userId = Auth::user()->id;
            $sum = $this->cartRepository->getTotalBookOfUser($userId);
            $user = $this->userRepository->find($userId);
            $cart = $user->carts()->get();
            return Response()->json([
                'success' => 1,
                'sumBook' => $sum,
                'countCast' => count($cart)
            ]);
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function saveOrder(OrderRequest $request)
    {
        $time_promise_pay = Carbon::parse($request->time_promise_pay);
        $time_promise_pay = $time_promise_pay->addHours(Carbon::now()->addHours(7)->hour)->addMinutes(Carbon::now()->minute);
        $order = [
            'user_id' => Auth::user()->id,
            'time_borrow' => Carbon::now()->addHours(7),
            'time_promise_pay' => $time_promise_pay,
            'status' => Order::STATUS_CONFIRM,
            'address' => $request->address,
            'note' => $request->note
        ];
        $orderNew = $this->orderRepository->create($order);
        $user = $this->userRepository->find(Auth::user()->id);
        foreach ($user->carts()->get() as $item) {
            $orderdetails[] = [
                'order_id' => $orderNew->id,
                'book_id' => $item->book_id,
                'quantity' => $item->quantity
            ];
        }
        Orderdetail::insert($orderdetails);
        $user['is_borrow'] = User::BORROWING;
        $user->update();
        $this->cartRepository->deleteAllCart(Auth::user()->id);

        return redirect()->back()->with('msg', 'Gửi yêu cầu mượn sách thành công. Vui lòng để ý đến đơn hàng.');
    }
}
