<?php

namespace App\Http\Interfaces;


interface TransferInterface {

    public function getTransfers();
    public function acceptRequest($transfer_id,$adopter_id,$animal_id);
    public function denyRequest($transfer_id,$adopter_id,$animal_id);
    public function deleteTransfer($transfer_id,$animal_id);
}
