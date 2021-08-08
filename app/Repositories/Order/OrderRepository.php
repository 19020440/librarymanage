<?php

namespace App\Repositories\Order;

use App\Models\Alert;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Exception;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected $perPage = 10;

    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    public function getListOrderByUser($userIds, $day_start, $day_end)
    {
        if ($userIds === 1) {
            return $this->model->whereRaw('substring(time_borrow,1,10) >= ?', $day_start)
                ->whereRaw('substring(time_borrow,1,10) <= ?', $day_end)
                ->orderBy('status')->paginate($this->perPage);
        }
        return $this->model->whereIn('user_id', $userIds)
            ->whereRaw('substring(time_borrow,1,10) >= ?', $day_start)
            ->whereRaw('substring(time_borrow,1,10) <= ?', $day_end)
            ->orderBy('status')->paginate($this->perPage);
    }

    public function updateStatus($order)
    {
        if ($order->status == Order::STATUS_BORROWING && $order->time_promise_pay <= Carbon::now()->addHours(7)->toDateTimeString()) {
            $order->status = Order::STATUS_OVERDUE;
            $alert = [
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'content' => 'Đơn mượn ĐH' . sprintf('%04d', $order->id) . ' của bạn đã quá hẹn trả mong liên hệ lại với chúng tôi để trả lại sách. Cảm ơn bạn.'
            ];
            DB::beginTransaction();
            try {
                Alert::create($alert);
                $order->update();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }
        } elseif ($order->status == Order::STATUS_OVERDUE && $order->time_promise_pay > Carbon::now()->addHours(7)->toDateTimeString()) {
            $order->status = Order::STATUS_BORROWING;
            $order->update();
        } elseif (($order->status == Order::STATUS_OVERDUE || $order->status == Order::STATUS_BORROWING) && $order->time_pay) {
            $order->status = Order::STATUS_BORROWED;
            $alert = [
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'content' => 'Đơn mượn ĐH' . sprintf('%04d', $order->id) . ' của bạn đã trả thành công. Cảm ơn bạn.'
            ];
            DB::beginTransaction();
            try {
                $user = User::find($order->user_id);
                $user['is_borrow'] = 0;
                $order->update();
                Alert::create($alert);
                $user->update();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }
        }
        return $order;
    }
}
