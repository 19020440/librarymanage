<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Repositories\Order\OrderRepository;
use App\Models\Order;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\Http\Response;

class OrderAdminController extends Controller
{
    private $orderRepository;
    private $userRepository;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userIds = 1;
        $day_start = '2021-01-01';
        $day_end = Carbon::now()->addHours(7)->toDateString();
        $userFilter = '';
        if ($request->get('day_start')) {
            $day_start = $request->get('day_start');
        }
        if ($request->get('day_end')) {
            $day_end = $request->get('day_end');
        }
        if ($request->get('username')) {
            $userIds = [];
            $user = $this->userRepository->getUserByUserName($request->get('username'));
            $userIds[] = $user->id;
            $userFilter = $user->name;
        } elseif ($request->get('user')) {
            $userIds = [];
            $userFilter = $request->get('user');
            $listUser = $this->userRepository->getUserByName($request->get('user'));
            if ($listUser) {
                foreach ($listUser as $user) {
                    $userIds[] = $user->id;
                }
            }
        }
        $listOrder = $this->orderRepository->getListOrderByUser($userIds, $day_start, $day_end);
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
        return view('admin.manage_order.index', [
            'day_start' => $day_start,
            'day_end' => $day_end,
            'listOrder' => $listOrder,
            'userFilter' => $userFilter,
            'listOrderConfirm' => $listOrderConfirm,
            'listOrderOverdue' => $listOrderOverdue,
            'listOrderBorrowing' => $listOrderBorrowing,
            'listOrderBorrowed' => $listOrderBorrowed,
        ]);
    }

    public function editOrder(Request $request)
    {
        if ($request->id) {
            $order = $this->orderRepository->find($request->id);
            if ($order) {
                try {
                    if ($request->time_borrow) {
                        $time_borrow = Carbon::parse($request->time_borrow);
                        $order['time_borrow'] = $time_borrow;
                    }
                    if ($request->time_promise_pay) {
                        $time_promise_pay = Carbon::parse($request->time_promise_pay);
                        $order['time_promise_pay'] = $time_promise_pay;
                    }
                    if ($request->time_pay) {
                        $time_pay = Carbon::parse($request->time_pay);
                        $order['time_pay'] = $time_pay;
                    }
                    DB::beginTransaction();
                    try {
                        $order->update();
                        $order = $this->orderRepository->updateStatus($order);
                        DB::commit();
                        return Response()->json([
                            'success' => '1'
                        ]);
                    } catch (Exception $e) {
                        DB::rollBack();
                        return Response()->json([
                            'success' => '0'
                        ]);
                    }
                } catch (Exception $e) {
                    return Response()->json([
                        'success' => '2'
                    ]);
                }
            }
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function deleteOrder(Request $request)
    {
        if ($request->id) {
            $this->orderRepository->delete($request->id);
            return Response()->json([
                'success' => '1'
            ]);
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function changeStatusToBorrowing(Request $request)
    {
        if ($request->id && $request->type == 'one-to-three') {
            $order = $this->orderRepository->find($request->id);
            if ($order) {
                $order['status'] = Order::STATUS_BORROWING;
                $order->update();
                $alert = [
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'content' => 'Đơn mượn ĐH' . sprintf('%04d', $order->id) . ' của bạn đã được xác nhận.'
                ];
                Alert::create($alert);
                return Response()->json([
                    'success' => '1'
                ]);
            }
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function cancelOrder(Request $request)
    {
        if ($request->id && $request->type == 'cancel') {
            $order = $this->orderRepository->find($request->id);
            if ($order) {
                $order['status'] = Order::STATUS_CANCEL;
                $order->update();
                $alert = [
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'content' => 'Đơn mượn ĐH' . sprintf('%04d', $order->id) . ' của bạn đã bị hủy.'
                ];
                Alert::create($alert);
                $user = $this->userRepository->find($order->user_id);
                $user['is_borrow'] = 0;
                $user->update();
                return Response()->json([
                    'success' => '1'
                ]);
            }
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function dashBoardOfMonth(Request $request)
    {
        if ($request->type == 'month')
            return DB::table('orders')->select(DB::raw('CASE WHEN DAY(created_at) between 1 and 7 THEN 1
        WHEN DAY(created_at) between 8 and 15 THEN 2
        WHEN DAY(created_at) between 16 and 23 THEN 3
        ELSE 4
        END AS weeks'), DB::raw('count(id) as total'))->whereMonth('created_at', $request->month)->whereYear('created_at', $request->year)->groupBy('weeks')->get();

        else return DB::table('orders')->select(DB::raw('CASE WHEN Month(created_at) = 1  THEN 1
        WHEN Month(created_at) = 2  THEN 2
        WHEN Month(created_at) = 3  THEN 3
        WHEN Month(created_at) = 4  THEN 4
        WHEN Month(created_at) = 5  THEN 5
        WHEN Month(created_at) = 6  THEN 6
        WHEN Month(created_at) = 7  THEN 7
        WHEN Month(created_at) = 8  THEN 8
        WHEN Month(created_at) = 9  THEN 9
        WHEN Month(created_at) = 10  THEN 10
        WHEN Month(created_at) = 11  THEN 11
        ELSE 12
        END AS months'), DB::raw('count(id) as total'))->whereYear('created_at', $request->year)->groupBy('months')->get();
    }


    public function dashBoardFromTo(Request $request)
    {
        $type = $request->type;
        if ($type == 'month') {
            $datefrom = $request->valuefrom;
            $dateto = $request->valueto;
            return DB::table('orders')->selectRaw('count(*) as total, concat(year(created_at),"-",month(created_at)) as dates')
                ->whereBetween('created_at', [$datefrom, $dateto])
                ->groupBy('created_at')
                ->get();
        } else {
            $datefrom = $request->valuefrom;
            $distance = $request->value;
            return DB::table('orders')->selectRaw('count(*) as total, concat(year(created_at),"-",month(created_at),"-",day(created_at)) as days')
                ->whereRaw('created_at between ? and adddate(?, interval ? day)', [$datefrom, $datefrom, $distance])
                ->groupBy('created_at')
                ->get();
        }
    }
}
