<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Response;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //poour avoir toute les projet et le total d anomalie pour chaque projet
        $total_anomalie =  DB::select(DB::raw(" SELECT mantis_project_table.id ,mantis_project_table.name ,COUNT(mantis_bug_table.project_id ) as total_anomalie
        from mantis_project_table  join mantis_bug_table
        on mantis_project_table.id = mantis_bug_table.project_id
        GROUP BY mantis_project_table.id"));

        for ($i = 0; $i < count($total_anomalie); $i++) {
            $total_anomalie[$i]->beug_resolu = 0;
            $total_anomalie[$i]->beug_encour = 0;
            $total_anomalie[$i]->amelioration_resolu = 0;
            $total_anomalie[$i]->amelioration_encour = 0;
        }

        //pour avoir les status des beug
        $beug_etat = DB::select(DB::raw("  SELECT mantis_project_table.id , mantis_project_table.name,mantis_bug_table.status,mantis_category_table.name ,COUNT(mantis_category_table.name ) as total
        from mantis_project_table  join mantis_bug_table
              on mantis_project_table.id = mantis_bug_table.project_id
              JOIN mantis_category_table
              on mantis_category_table.id = mantis_bug_table.category_id
              WHERE mantis_category_table.name ='bug'
              GROUP BY mantis_project_table.id , mantis_project_table.name,mantis_bug_table.status,mantis_category_table.name"));
        // //pour avoir les status des amilioration
        $amelioration_etat = DB::select(DB::raw("  SELECT mantis_project_table.id , mantis_project_table.name,mantis_bug_table.status,mantis_category_table.name ,COUNT(mantis_category_table.name ) as total
        from mantis_project_table  join mantis_bug_table
              on mantis_project_table.id = mantis_bug_table.project_id
              JOIN mantis_category_table
              on mantis_category_table.id = mantis_bug_table.category_id
              WHERE mantis_category_table.name ='amélioration'
              GROUP BY mantis_project_table.id ,mantis_bug_table.status
        "));
        //pour affecter a chaque projet leur statistique (beug resolu est en cour,amelioration resolu et en cour)
        foreach ($beug_etat as $item) {

            if ($item->status == 80 || $item->status == 90) {

                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->beug_resolu =  $value->beug_resolu + $item->total;
                    }
                }
            } else {
                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->beug_encour =  $value->beug_encour + $item->total;
                    }
                }
            }
        }
        foreach ($amelioration_etat as $item) {

            if ($item->status == 80 || $item->status == 90) {

                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->amelioration_resolu = $value->amelioration_resolu + $item->total;
                    }
                }
            } else {
                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->amelioration_encour = $value->amelioration_encour + $item->total;
                    }
                }
            }
        }


        return view('table', ['projects' => $total_anomalie]);
    }

    // c'est une fonction qui return resultat json pour le client avec Angular
    public function projects()
    {
        $total_anomalie =  DB::select(DB::raw(" SELECT mantis_project_table.id ,mantis_project_table.name ,COUNT(mantis_bug_table.project_id ) as total_anomalie
        from mantis_project_table  join mantis_bug_table
        on mantis_project_table.id = mantis_bug_table.project_id
        GROUP BY mantis_project_table.id"));

        for ($i = 0; $i < count($total_anomalie); $i++) {
            $total_anomalie[$i]->beug_resolu = 0;
            $total_anomalie[$i]->beug_encour = 0;
            $total_anomalie[$i]->amelioration_resolu = 0;
            $total_anomalie[$i]->amelioration_encour = 0;
        }

        //
        $beug_etat = DB::select(DB::raw("  SELECT mantis_project_table.id , mantis_project_table.name,mantis_bug_table.status,mantis_category_table.name ,COUNT(mantis_category_table.name ) as total
        from mantis_project_table  join mantis_bug_table
              on mantis_project_table.id = mantis_bug_table.project_id
              JOIN mantis_category_table
              on mantis_category_table.id = mantis_bug_table.category_id
              WHERE mantis_category_table.name ='bug'
              GROUP BY mantis_project_table.id , mantis_project_table.name,mantis_bug_table.status,mantis_category_table.name"));
        //
        $amelioration_etat = DB::select(DB::raw("  SELECT mantis_project_table.id , mantis_project_table.name,mantis_bug_table.status,mantis_category_table.name ,COUNT(mantis_category_table.name ) as total
        from mantis_project_table  join mantis_bug_table
              on mantis_project_table.id = mantis_bug_table.project_id
              JOIN mantis_category_table
              on mantis_category_table.id = mantis_bug_table.category_id
              WHERE mantis_category_table.name ='amélioration'
              GROUP BY mantis_project_table.id ,mantis_bug_table.status
        "));
        //
        foreach ($beug_etat as $item) {

            if ($item->status == 80 || $item->status == 90) {

                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->beug_resolu =  $value->beug_resolu + $item->total;
                    }
                }
            } else {
                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->beug_encour =  $value->beug_encour + $item->total;
                    }
                }
            }
        }
        foreach ($amelioration_etat as $item) {

            if ($item->status == 80 || $item->status == 90) {

                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->amelioration_resolu = $value->amelioration_resolu + $item->total;
                    }
                }
            } else {
                foreach ($total_anomalie as $value) {
                    if ($item->id == $value->id) {
                        $value->amelioration_encour = $value->amelioration_encour + $item->total;
                    }
                }
            }
        }

        return Response::json($total_anomalie);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
