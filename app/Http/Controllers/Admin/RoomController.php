<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Room;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Requests\StoreRoomRequest;


class RoomController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('room_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rooms = Room::all();

        return view('admin.room.index', compact('rooms'));
    }

    public function show(Room $room)
    {
        abort_if(Gate::denies('room_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.room.show', compact('room'));
    }

    public function create()
    {
        abort_if(Gate::denies('room_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.room.create');
    }

    public function store(StoreRoomRequest $request)
    {
        $room = Room::create($request->all());

        return redirect()->route('admin.room.index');
    }

    public function edit(Room $room)
    {
        abort_if(Gate::denies('room_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.room.edit', compact('room'));
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->all());

        return redirect()->route('admin.room.index');
    }

    public function destroy(Room $room)
    {
        abort_if(Gate::denies('room_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $room->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoomRequest $request)
    {
        Room::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}