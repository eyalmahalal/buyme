<?php

namespace App;

use Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = ['name', 'start', 'done', 'finish'];

    public function find($id) {
        if ($id == 0) {
            $results = DB::connection('mysql')->select('select * from tasks');
        }
        else {
            $results = DB::connection('mysql')->select('select * from tasks where id = :id', ['id' => $id]);
        }
        $tasks = array();
        $i = 0;
        foreach ($results as $key => $value) {
            $tasks[$i]['id'] = $value->id;
            $tasks[$i]['name'] = $value->name;
            $tasks[$i]['done'] = $value->done;
            $i++;
        }

        return Response::json([
            'data' => $tasks
          ],200);
    }

    public function addNewTask($args) {
        if (isset($args['task_name']) && $args['task_name'] != "") {
            $now = date("Y-m-d h:i:s", time());
            $result = DB::insert('insert into tasks (name, start) values (?, ?)', [$args['task_name'], $now]);
        }
        else {
            $result = false;
        }

        return Response::json([
            'success' => $result
          ],200);
    }

    public function removeTask($id) {
        $result = $this->find($id)->getData()->data;

        if (!empty($result)) {
            $deleteResult = DB::connection('mysql')->delete('delete from tasks where id = :id', ['id' => $result[0]->id]);
        }
        else {
            $deleteResult = 0;
        }

        return Response::json([
            'success' => $deleteResult
          ],200);
    }

    public function updateTask($id, $args) {
        $result = $this->find($id)->getData()->data;

        $success = false;

        if (!empty($result)) {
            $updateDetails = array();
            if (isset($args['new_name']) && $args['new_name'] != "") {
                $updateDetails['name'] = $args['new_name'];
            }
            if (isset($args['done'])) {
                if ($args['done'] == 'true') {
                    $updateDetails['done'] = true;
                    $updateDetails['finish'] = date("Y-m-d h:i:s", time());
                }
                else {
                    $updateDetails['done'] = false;
                    $updateDetails['finish'] = '0000-00-00 00:00:00';
                }
            }

            if (!empty($updateDetails)) {
                $result = DB::table('tasks')->where('id', $id)->update($updateDetails);
                $success = true;
            }
        }

        return Response::json([
            'success' => $success
          ],200);
    }
}
