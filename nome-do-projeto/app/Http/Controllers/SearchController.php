<?php 

function index(Request $request){
    $query = $request->get('q');
    $results = Car::where('model', 'like', "%{$query}%")->get();
    return response()->json($results);
}

?>