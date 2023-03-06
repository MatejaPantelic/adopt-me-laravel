<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\TransferInterface;
use App\Models\Animal;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferRepository implements TransferInterface
{
    public function getTransfers()
    {
        return Transfer::GetTransferWithDetails()->get();
    }
    public function acceptRequest($transfer_id,$adopter_id,$animal_id)
    {
        Transfer::where('id','=',$transfer_id)->update(['status'=>'request_accepted']);
        Animal::where('id','=',$animal_id)->update([
            'user_id'=>$adopter_id,
            'status'=>'adopted'
        ]);
    }
    public function denyRequest($transfer_id,$adopter_id,$animal_id)
    {
        Transfer::where('id','=',$transfer_id)->update(['status'=>'request_denied']);
        Animal::where('id','=',$animal_id)->update([
            'status'=>'giving_away'
        ]);
    }
    public function deleteTransfer($transfer_id,$animal_id)
    {
        Transfer::where('id',$transfer_id)->delete();
        Animal::where('id','=',$animal_id)->update([
            'status'=>'giving_away'
        ]);
    }
}
