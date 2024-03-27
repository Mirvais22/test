<?php 
 
namespace App\Http\Controllers; 
 
use Illuminate\Http\Request; 
use App\Models\Role; 
 
class RoleController extends Controller 
{ 
    public function GetAllRoles() {     
        $roles = Role::all(); 
        if ($roles)
            return Response()->json([$roles], 201);
        else
            return Response()->json([], 204);
    } 
 
    public function GetRoleById($id){ 
        $role = Role::find($id); 
        if ($role)
            return Response()->json([$role], 201);
        else
            return Response()->json([], 204);
    } 
 
    public function CreateRole(Request $request){ 
        $role = new Role(); 
        $role->name = $request->name; 
        $role->type = $request->type; 
        $role->save(); 
        return Response()->json([$role], 201);
    } 
}