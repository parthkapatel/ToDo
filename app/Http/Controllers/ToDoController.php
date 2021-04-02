<?php

namespace App\Http\Controllers;


use App\Interfaces\ToDoRepositoryInterface;
use App\Models\ToDo;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class ToDoController extends Controller
{
    private $todoRepository;

    public function __construct(ToDoRepositoryInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return $this->todoRepository->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "title" => "required"
        ]);
        $data = [
            "title" => $request->title,
            "start_date" => $request->startDate,
            "due_date" => $request->dueDate,
            "notes" => $request->notes
        ];
        $data = $this->todoRepository->save($data);
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param ToDo $toDo
     * @param Request $request
     * @return Response
     */
    public function show(ToDo $toDo,Request $request)
    {
        return $this->todoRepository->searchDataByString($request->search);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return array
     */
    public function edit(Request $request)
    {
        return $this->todoRepository->getDataById($request->route("id"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $data = [
            "title" => $request->title,
            "start_date" => $request->startDate,
            "due_date" => $request->dueDate,
            "notes" => $request->notes
        ];
        $data = $this->todoRepository->update($data,$request->route("id"));
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function destroy(Request $request)
    {
        $data = $this->todoRepository->delete($request->route("id"));
        $todo = $this->todoRepository->all();
        return  view("lists",compact("todo"));
    }

    public function updateMarkAsFavorite(Request $request){
        $data = $this->todoRepository->updateMarkAsFavorite($request->route("id"));
        return $data;
    }

    public function updateMarkAsRead(Request $request){
        $data = $this->todoRepository->updateMarkAsRead($request->route("id"));
        return $data;
    }

    public function arrangeOrder(Request $request){
        $data = $this->todoRepository->updateTaskOrder($request->orders);
        return $request->orders;
    }
}
