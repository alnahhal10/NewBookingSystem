<?php

namespace App;

interface RoomRepositoryInterface
{
 public function findAvailableRoom(int $id, $checkIn, $checkOut);
}

interface BookingRepositoryInterface {
    public function create(array $details);
    public function getForUser(int $userId);
}