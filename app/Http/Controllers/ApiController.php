<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Null_;

class ApiController extends Controller
{
    public function createTodo(Request $request)
    {

        $array = ['error' => ''];

        $rules = [
            'title' => 'required|min:3|unique:todos'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->getMessageBag();
            return $array;
        }

        $title = $request->input('title');

        $todo = new Todo();
        $todo->title = $title;
        $todo->save();

        if($todo)
        {
            $array['success']  = 'Tarafefa Criada com Sucesso !';
            return $array;
        }
        
    }
    public function readAllTodos()
    {
        $array = ['error' => ''];

        //Paginato

        $todos = Todo::simplePaginate(1);

        //metodo antigo sem paginação
        //$array['listAllTodos'] = Todo::all();

        $array['listAllTodos'] = $todos;
        
        return $array;
    }
    public function readTodo($id)
    {
        $array = ['error' => ''];

        if(!empty($id) && intval($id)){

            $listTodo = Todo::find($id);

            if(!isset($listTodo) && empty($listTodo)){

                $array['error'] = 'Nenhum resultado foi econtrado !';
            }
            
            $array['listTodo'] = $listTodo; 
            
        }
        return $array;
    }
    public function updateTodo(Request $request, $id)
    {
        // array
        $array = ['error' => ''];

        // permissões
        $rules = [
            'title' => 'min:3',
            'done' => 'boolean'
        ];

        // criando uma instancia do validator
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            $array['error'] = $validator->getMessageBag();
            return $array;
        }

        if(!empty($id) && intval($id)){

            $title = $request->input('title');
            $done = $request->input('done');

            $todo = Todo::find($id);

            if(empty($todo)){
                $array['error'] = "Tarefa {$id} não exite, logo não pode ser editada !";
                return $array;
            }

            if($title){
                $todo->title = $title;
            }
            if($done != Null){
                $todo->done = $done;
            }

            $todo->save();

        }   
        
        return $array;
    }
    public function deleteTodo($id)
    {
        $array = ['error' => ''];

        if(empty($id)){
            $array['error'] = "Tarefa {$id} não exite, logo não pode ser deletada !";
            return $array;
        }

        $todo = Todo::destroy($id);

        return $array;
    }
}
