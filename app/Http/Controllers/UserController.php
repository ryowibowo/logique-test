<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPhoto;
use App\Models\UserCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;


class UserController extends Controller
{



    /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */

     

    public function index(Request $request)
    {
        // $users = User::with('photo')->with('credit')->get();

        $sort 		= $request->sb != null || $request->sb != '' ? $request->sb : 'asc';
    	$orderBy	= $request->ob != null || $request->ob != '' ? $request->ob : 'name';
        $keyword = $request->q != null || $request->q != '' ? $request->q : '';
        
        $limit    = $request->limit != null || $request->limit != '' ? $request->limit : '';
        if ($limit == '') {
            $page = "";
        } else {
            $page    = $request->page != null || $request->page != '' ? ($request->page * $limit) - $limit  : "";
        }
        try {
            $users = User::with('photo:user_id,photo')
            ->with('credit:user_id,creditcard_type,creditcard_number,creditcard_name,creditcard_expired,creditcard_cvv')
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', "%$keyword%");
            })
            ->when($page, function ($query, $page) {
                return $query->offset($page);
            })
            ->when($limit, function ($query, $limit) {
                return $query->limit($limit);
            })
            ->orderBy($orderBy, $sort)
            ->get();

            if(!$users){
                return response()->json(['metaData' => ['code' => 500, 'message' => 'Internal Server Eror']], 500);
            }else{
                return response()->json(['metaData' => ['code' => 200, 'message' => 'Data Found'], 'response' => $users], 200);
            }

        } catch (\Throwable $th) {
            throw $th->getMessage();;
        }
        

        
    }

    /**
     * Pour recupérer tous les utilsateurs de la BD
     * @return \Illuminate\Http\JsonResponse
     */
    public function test()
    {

        return response()->json(['isSuccess' => true, 'message' => 'Ok'], 200);
    }

    /**
     * pour enregistrer un nouvel utilisateur dans la base de données
     * @param Request $request
     */
    public function create(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'creditcard_type' => 'required',
                'creditcard_number' => 'required',
                'creditcard_name' => 'required',
                'creditcard_expired' => 'required',
                'creditcard_cvv' => 'required',
            ]);
        
            if ($validator->fails()) {
                return $validator->errors();
            }
                
            $user = new User();

            $user->name = $request->input('name');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            
            $getId = $user->id;
            
            $credit = UserCredit::create([
                'user_id' => $getId,
                'creditcard_type' => $request->creditcard_type,
                'creditcard_number' => $request->creditcard_number,
                'creditcard_name'	=> $request->creditcard_name,
                'creditcard_expired'	=> $request->creditcard_expired,
                'creditcard_cvv'   => $request->creditcard_cvv,
            ]);

            if(!$request->hasFile('photo')) {
                return response()->json(['required file image'], 400);
            }
        
            $allowedfileExtension=['jpg','png'];
            $files = $request->file('photo'); 
            $errors = [];
        
            foreach ($files as $file) {      
                $extension = $file->getClientOriginalExtension();
        
                $check = in_array($extension,$allowedfileExtension);
        
                if($check) {
                    foreach($request->photo as $mediaFiles) {
                        $media = new UserPhoto();
                        $media_ext = $mediaFiles->getClientOriginalName();
                        $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                        $mFiles = $media_no_ext . '-' . uniqid() . '.' . $extension;
                        $mediaFiles->move(public_path().'/images/', $mFiles);
                        $media->photo = $mFiles;
                        $media->user_id = $getId;
                        $media->save();
                    }
                } 
                DB::commit();
                return response()->json(['metaData' => ['code' => 200, 'message' => 'Success Add User'],'user_id' => $getId], 200);
            }
            
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }
       
    }


    /**
     * On renvoit l'individu dans la BD
     * correspondant à l'id spécifié
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        try {
            
            $data = User::with('photo:user_id,photo')
            ->with('credit:user_id,creditcard_type,creditcard_number,creditcard_name,creditcard_expired,creditcard_cvv')
            ->where('id', $id)
            ->get();

            return response()->json(['metaData' => ['code' => 200, 'message' => 'Data Found'], 'response' => $data], 200);

        } catch (\Throwable $th) {
            return response()->json(['metaData' => ['code' => 500, 'message' => $th->getMessage()]], 500);
        }
       
    }

    /**
     * Mettre à jour les informations sur un utilisateur de la BD
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {   
        // dd($request->all());
        DB::beginTransaction();
        try {
           
            $user = User::where('id',$request->user_id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->address = $request->address;
            if($user->save()) {

                // $profile = UserDetail::find($id);
                $credit = UserCredit::where('user_id',$user->id)->first();
                $credit->creditcard_type = $request->creditcard_type;
                $credit->creditcard_number = $request->creditcard_number;
                $credit->creditcard_name = $request->creditcard_name;
                $credit->creditcard_expired = $request->creditcard_expired;
                $credit->creditcard_cvv = $request->creditcard_cvv;
                $credit->save();

                    
                // if(!$request->hasFile('photo')) {
                //     return response()->json(['required file image'], 400);
                // }
            
                // $allowedfileExtension=['jpg','png'];
                // $files = $request->file('photo'); 
                // $errors = [];
            
                // foreach ($files as $file) {      
                //     $extension = $file->getClientOriginalExtension();
            
                //     $check = in_array($extension,$allowedfileExtension);
            
                //     if($check) {
                //         foreach($request->photo as $mediaFiles) {
                //             // $media = new UserPhoto();
                //             $media = UserPhoto::where('user_id', $user->id)->get(); 
                //             $media_ext = $mediaFiles->getClientOriginalName();
                //             $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                //             $mFiles = $media_no_ext . '-' . uniqid() . '.' . $extension;
                //             $mediaFiles->move(public_path().'/images/', $mFiles);
                //             $media->photo = $mFiles;
                //             $media->save();
                //         }
                //     } 
                //     DB::commit();
                //     return response()->json(['metaData' => ['code' => 200, 'message' => 'Success Add User']], 200);
                // }
            }
            DB::commit();
            return response()->json(['metaData' => ['code' => 200, 'success' => 'true']], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['metaData' => ['code' => 500, 'message' => $e->getMessage()]], 200);
        }
    }


}