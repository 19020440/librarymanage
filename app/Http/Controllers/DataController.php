<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\Order\OrderRepository;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Repositories\Book\BookRepository;
use Carbon\Carbon;

class DataController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalBook = $this->bookRepository->getAll();
        $totalUser = $this->userRepository->getAll();
        $totalOrder = $this->orderRepository->getAll();
        $totalContact = Contact::get();
        $dateTo = Carbon::now();
        $dateForm = Carbon::now()->subMonth(1);

        return view('admin.manage_data.index', [
            'totalBook' => $totalBook,
            'totalUser' => $totalUser,
            'totalOrder' => $totalOrder,
            'totalContact' => $totalContact,
            'dateForm' => $dateForm->format('Y-m-d'),
            'dateTo' => $dateTo->format('Y-m-d')
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
        //
    }
}
