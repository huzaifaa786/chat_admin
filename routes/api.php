<?php

use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SongController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DuetRequestController;
use App\Http\Controllers\Api\RecordingController;
use App\Http\Controllers\Api\SongQueueRequestController;
use App\Http\Controllers\Api\UserRelationshipController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'loginUser']);
Route::any('songs/all', [SongController::class, 'index']);
Route::any('room/create', [RoomController::class, 'createRoom']);
Route::any('room/update/count', [RoomController::class, 'updateRoomCount']);
Route::any('room/update/status', [RoomController::class, 'updateRoomStatus']);
// Duet Request
Route::any('duetrequest/create', [DuetRequestController::class, 'createDuetRequest']);
Route::any('duetrequest/pending', [DuetRequestController::class, 'pendingDuetRequest']);
Route::any('duetrequest/status/update', [DuetRequestController::class, 'updateStatus']);
Route::any('queuerequest/create', [SongQueueRequestController::class, 'store']);
Route::any('queuerequest/delete', [SongQueueRequestController::class, 'deleteRequest']);

Route::group(['middleware' => ['auth:sanctum', 'user']], function () {
    Route::get('user/details', [AuthController::class, 'userDetail']);
    // Follow a user
    Route::post('follow', [UserRelationshipController::class, 'follow']);
    // Unfollow a user
    Route::post('unfollow', [UserRelationshipController::class, 'unfollow']);
    // Check if the logged-in user is following a specific user
    Route::post('is-following', [UserRelationshipController::class, 'isFollowing']);

    Route::get('recording/get', [RecordingController::class, 'index']);
});


Route::get('followers/{userId}', [UserRelationshipController::class, 'followers']);
Route::get('followees/{userId}', [UserRelationshipController::class, 'followees']);

// CHAT ROOMS
Route::get('rooms/chat/all', [RoomController::class, 'getChatRooms']);

// RECORDING
Route::any('recording/store', [RecordingController::class, 'store']);


// CHAT APIS //

Route::group(['middleware' => ['auth:sanctum', 'user']], function () {
    Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
        /**
         * Authentication for pusher private channels
         */
        Route::post('/chat/auth', 'MessagesController@pusherAuth');

        /**
         *  Fetch info for specific id [user/group]
         */
        Route::post('/idInfo', 'MessagesController@idFetchData')->name('api.idInfo');

        /**
         * Send message route
         */
        Route::post('/sendMessage', 'MessagesController@send')->name('api.send.message');

        /**
         * Fetch messages
         */
        Route::post('/fetchMessages', 'MessagesController@fetch')->name('api.fetch.messages');

        /**
         * Download attachments route to create a downloadable links
         */
        Route::get('/download/{fileName}', 'MessagesController@download')->name('api.' . config('chatify.attachments.download_route_name'));

        /**
         * Make messages as seen
         */
        Route::post('/makeSeen', 'MessagesController@seen')->name('api.messages.seen');

        /**
         * Get contacts
         */
        Route::get('/getContacts', 'MessagesController@getContacts')->name('api.contacts.get');

        /**
         * Star in favorite list
         */
        Route::post('/star', 'MessagesController@favorite')->name('api.star');

        /**
         * get favorites list
         */
        Route::post('/favorites', 'MessagesController@getFavorites')->name('api.favorites');

        /**
         * Search in messenger
         */
        Route::get('/search', 'MessagesController@search')->name('api.search');

        /**
         * Get shared photos
         */
        Route::post('/shared', 'MessagesController@sharedPhotos')->name('api.shared');

        /**
         * Delete Conversation
         */
        Route::post('/deleteConversation', 'MessagesController@deleteConversation')->name('api.conversation.delete');

        /**
         * Delete Conversation
         */
        Route::post('/updateSettings', 'MessagesController@updateSettings')->name('api.avatar.update');

        /**
         * Set active status
         */
        Route::post('/setActiveStatus', 'MessagesController@setActiveStatus')->name('api.activeStatus.set');
    });
});




