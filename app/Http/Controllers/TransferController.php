<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TransferRepository;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    protected $transferRepository;

    public function __construct(TransferRepository $transferRepository)
    {
        $this->transferRepository = $transferRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers=$this->transferRepository->getTransfers();
        return view('transfers.index')
            ->with('transfers',$transfers);
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
    public function destroy($id,$animal_id)
    {
        $this->transferRepository->deleteTransfer($id,$animal_id);
        return redirect()
            ->back()
            ->withSuccess('The transfer was cancelled successful!');
    }
    public function accept($transfer_id,$adopter_user_id,$animal_id)
    {
        $this->transferRepository->acceptRequest($transfer_id,$adopter_user_id,$animal_id);
        return redirect()
            ->back()
            ->withSuccess('Transfer successfully completed. The animal now has a new owner!');
    }
    public function deny($transfer_id,$adopter_user_id,$animal_id)
    {
        $this->transferRepository->denyRequest($transfer_id,$adopter_user_id,$animal_id);
        return redirect()
            ->back()
            ->withSuccess('The transfer was denied!');
    }
}
