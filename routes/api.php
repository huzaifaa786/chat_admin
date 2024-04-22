<?php

use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DuetRequestController;
use App\Http\Controllers\Api\UserRelationshipController;
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
Route::any('duetrequest/pending', [DuetRequestController::class, 'pendingDuetRequest']);
Route::any('duetrequest/status/update', [DuetRequestController::class, 'updateStatus']);

Route::group(['middleware' =>  ['auth:sanctum', 'user']], function () {
    Route::get('user/details',[AuthController::class,'userDetail']);
    // Follow a user
    Route::post('follow', [UserRelationshipController::class, 'follow']);
    // Unfollow a user
    Route::post('unfollow', [UserRelationshipController::class, 'unfollow']);
    // Check if the logged-in user is following a specific user
    Route::post('is-following', [UserRelationshipController::class, 'isFollowing']);
});

// Public routes
Route::get('followers/{userId}', [UserRelationshipController::class, 'followers']);
Route::get('followees/{userId}', [UserRelationshipController::class, 'followees']);
