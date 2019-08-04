<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//We will use App\Todo to include Todos Model which will help us to communicate to the database.
use App\Todo;

class TodosController extends Controller
{
    //
    public function index() {
        //Fetch all todos from database. Todo model has equivalent table todos in database, so we can use this Todo Model
        // static object to access database and fetch the todos using Todo::all() function.

        //$todos = Todo::all();

        //with(key that we are going to access in view, variable $todos that we defined above that contains all todos)
        // with('todos',$todos)
        // another alternative is with('todos', Todo::all()). I am using alternate way here.
        return view('todos.index')->with('todos', Todo::all());
        // return view('todos/index')->with('todos',Todo::all());
        //what it does is Todo::all() function fetches all todos from database and send it to view todos/index
        // which has a key named 'todos'

    }


    public function show(Todo $todo) {
        // The $todoid is the {todo} which was passed in Route::get('todos/{todo}', 'TodosController@show');
        // in web.php function
       // $todo = Todo::find($todoid);
        return view('todos.show')->with('todo', $todo);


    }

    public function create() {
        return view('todos.create');
    }

    public function store() {
        $this->validate(request(), [
            'name' => 'required|min:6',
            'description' => 'required'
        ]);
        $data = request()->all();

        $todo = new Todo();
        $todo->name = $data['name'];
        $todo->description = $data['description'];
        $todo->completed = false;
        $todo->save();
        session()->flash('success', 'Todo created successfully');

        return redirect('/todos');

    }

    public function edit(Todo $todo) {

       // $todo =Todo::find($todoid);

        return view('todos.edit')->with('todo', $todo);

    }

    public function updatetodos(Todo $todo) {
        $this->validate(request(), [
            'name' => 'required|min:6',
            'description' => 'required'
        ]);

        $data = request()->all();

       // $todo =Todo::find($todoId);

        $todo->name = $data['name'];
        $todo->description = $data['description'];

        $todo->save();
        session()->flash('success', 'Todo updated successfully');

        return redirect('/todos');

    }

    public function destroy(Todo $todo) {
        //$todo = Todo::find($todoid);
        $todo->delete();
        session()->flash('success', 'Todo deleted successfully');
        return redirect('/todos');
    }

    public function complete(Todo $todo) {
        $todo->completed = true;
        $todo->save();
        session()->flash('success', 'Todo completed successfully');
        return redirect('/todos');
    }
}
