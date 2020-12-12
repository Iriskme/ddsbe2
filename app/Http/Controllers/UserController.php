<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\UserJob;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response; 
    use App\Traits\ApiResponser;
    use DB;

Class UserController extends Controller {
    use ApiResponser;
    private $request;

    public function __construct(Request $request){
    $this->request = $request;
    }

    public function getUsers(){
        $users = app('db') ->select ("SELECT * FROM users");
        return $this->successResponse($users);
    }

    function login()
    {
    return view('login');
    }

    public function test(Request $request)
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $users = app('db')->select("SELECT * FROM users WHERE username='$username' and password='$password'");

        if(!$users || !$password){
            return 'Invalid username & password!';
        }
        else{
            return 'Successfully Log-In!';
        }   
    }
    
    public function index()
    {
    $users = User::all();
    return response()->json($users);
    }

    public function create(Request $request ){
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'lastname' => 'required',
            'firstname' => 'required',
            'jobid' => 'required|numeric|min:1|not_in:0', 
        ];

        $this->validate( $request,$rules);
         
        $userjob = UserJob::findOrFail($request->jobid);
        $users = User::create($request->all());

        return $this->successResponse($users, Response::HTTP_CREATED);
    }

    public function search($id)
    {
        $users = User::find($id);
        return $this->successResponse($users);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'filled',
            'password' => 'filled',
            'lastname' => 'filled',
            'firstname' => 'filled',
            'jobid' => 'filled|numeric|min:1|not_in:0',     
         ]);

        $users = User::find($id);
        if($users->fill($request->all())->save()){

            return $this->successResponse(['status' => 'success',$users]);
        }

        return $this->errorResponse(['status' => 'failed','result' =>$users]);
    }

    public function delete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return $this->successResponse(['Deleted successfully!',$users]);
    }
}