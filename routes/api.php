<?php

use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DuetRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'loginUser']);
Route::any('songs/all', [SongController::class, 'index']);
Route::any('room/create', [RoomController::class, 'createRoom']);
Route::any('room/update/count', [RoomController::class, 'updateRoomCount']);
Route::any('room/update/status', [RoomController::class, 'updateRoomStatus']);
Route::any('rooms/multi/all', [RoomController::class, 'getMultiRooms']);
Route::any('rooms/solo/all', [RoomController::class, 'getSoloRooms']);
Route::any('duetrequest/create', [DuetRequestController::class, 'createDuetRequest']);
