<?php

namespace App\Http\Controllers;

use App\Repositories\Order\OrderRepository;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;

class ManageUserController extends Controller
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
        $name = '';
        $listUserYear = [];
        $listUserMonth = [];
        $listUserWeek = [];
        if ($request->get('name')) {
            $name = $request->get('name');
        }
        $listUser = $this->userRepository->getListUserByName($name);
        foreach ($listUser as $user) {
            $user['countOrder'] = count($user->orders()->get());
            if (Carbon::parse($user->created_at)->year == Carbon::now()->year) {
                $listUserYear[] = $user;
            }
            if (Carbon::parse($user->created_at)->month == Carbon::now()->month) {
                $listUserMonth[] = $user;
            }
            if (Carbon::parse($user->created_at)->weekOfYear == Carbon::now()->weekOfYear) {
                $listUserWeek[] = $user;
            }
        }
        return view('admin.manage_user.index', [
            'name' => $name,
            'listUserYear' => $listUserYear,
            'listUserMonth' => $listUserMonth,
            'listUserWeek' => $listUserWeek,
            'listUser' => $listUser
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return response()->json([
                'success' => 0
            ]);
        }
        $user->delete();
        return response()->json([
            'success' => 1
        ]);
    }
}
