<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\Order;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PasswordRequest;
use App\Models\Alert;
use App\Repositories\Book\BookRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EditProfileRequest;

class UserController extends Controller
{
    private $orderRepository;
    private $userRepository;
    private $bookRepository;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository, BookRepository $bookRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->bookRepository = $bookRepository;
    }

    public function viewProfile()
    {
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
        return view('user.profile', [
            'cart' => $cart,
            'alerts' => $alerts,
            'countAlert' => $countAlert
        ]);
    }

    public function editProfile(EditProfileRequest $request)
    {
        $user = $request->only([
            'name',
            'images',
            'birth',
            'phone',
            'email',
            'address',
            'sex'
        ]);
        $this->userRepository->update(Auth::user()->id, $user);
        return redirect()->route('user.profile')->with('msg', "Chúc mừng bạn đã thay đổi thông tin thành công.");
    }

    public function viewChangePassword()
    {
        return view('user.change_password');
    }

    public function postChangePassword(PasswordRequest $request)
    {
        $user = $this->userRepository->find(Auth::user()->id);
        $user['password'] = Hash::make($request->password);
        $user->update();
        return redirect()->route('user.profile.view.changepass')->with('msg', "Chúc mừng bạn đã thay đổi mật khẩu thành công. Vui lòng đăng nhập lại.");
    }

    public function viewListOrder(Request $request)
    {
        $user = $this->userRepository->find(Auth::user()->id);
        $listOrder = $user->orders()->orderBy('status')->orderByDesc('updated_at')->paginate(5);
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
        $listOrderConfirm = [];
        $listOrderOverdue = [];
        $listOrderBorrowing = [];
        $listOrderBorrowed = [];
        if ($listOrder) {
            foreach ($listOrder as $order) {
                $order = $this->orderRepository->updateStatus($order);
                if ($order->status == Order::STATUS_CONFIRM) {
                    $listOrderConfirm[] = $order;
                }
                if ($order->status == Order::STATUS_OVERDUE) {
                    $listOrderOverdue[] = $order;
                }
                if ($order->status == Order::STATUS_BORROWING) {
                    $listOrderBorrowing[] = $order;
                }
                if ($order->status == Order::STATUS_BORROWED) {
                    $listOrderBorrowed[] = $order;
                }
            }
        }
        return view('user.list_order', [
            'listOrder' => $listOrder,
            'users' => $user,
            'listOrderConfirm' => $listOrderConfirm,
            'listOrderOverdue' => $listOrderOverdue,
            'listOrderBorrowing' => $listOrderBorrowing,
            'listOrderBorrowed' => $listOrderBorrowed,
            'cart' => $cart,
            'alerts' => $alerts,
            'countAlert' => $countAlert
        ]);
    }

    public function cancelOrder(Request $request)
    {
        if ($request->id) {
            $order = $this->orderRepository->find($request->id);
            $order['status'] = Order::STATUS_CANCEL;
            $order->update();
            $user = $this->userRepository->find($order->user_id);
            $user['is_borrow'] = 0;
            $user->update();
            return Response()->json([
                'success' => 1
            ]);
        }
        return Response()->json([
            'success' => 0
        ]);
    }

    public function showLoginForm()
    {
        Auth::logout();
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $e = $request->only('username', 'password');
        if (Auth::attempt($e)) {
            return redirect()->route('home');
        }
        return redirect()->route('user.login')->with('not_success', 1);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerPost(RegisterUserRequest $request)
    {
        $user = $request->only([
            'name',
            'username',
            'images',
            'birth',
            'phone',
            'email',
            'address',
            'is_borrow'
        ]);
        $user['password'] = Hash::make($request->password);
        $user['images'] = 'images/avatar-default.png';
        $user = $this->userRepository->create($user);
        $alert = [
            'user_id' => $user->id,
            'content' => 'Chúc mừng bạn đã đăng kí thành công. Chào mừng bạn đến với thư viện mini.'
        ];
        Alert::create($alert);
        return redirect()->route('user.register')->with('success', 1);
    }

    public function viewForgetPassword()
    {
        return view('user.forget_password');
    }

    public function postForgetPassword(PasswordRequest $request)
    {
        $user = $this->userRepository->getUserByUserName($request->username);
        $user['password'] = Hash::make($request->password);
        $user->update();
        return redirect()->route('user.forgetpass')->with('msg', "Chúc mừng bạn đã thay đổi mật khẩu thành công. Vui lòng đăng nhập lại.");
    }

    public function changeAlert(Request $request)
    {
        if ($request->id) {
            $user = $this->userRepository->find($request->id);
            $alerts = $user->alerts()->get();
            foreach ($alerts as $alert) {
                $alert['is_readed'] = 1;
                $alert->update();
            }
            return Response()->json([
                'success' => '1'
            ]);
        }
        return Response()->json([
            'success' => '0'
        ]);
    }
}
