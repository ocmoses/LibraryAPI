<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BookRequest;
use DB;
use App\Book;
use App\User;

class BookRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request, $id)
    {
        //
        try{

            $user = auth()->user();
            if($user && !$user->isLibrarian()){

                $book = Book::find($id);
                if($book){
                    
                    if($book->available > 0){

                        DB::beginTransaction();
                        $bookRequest = BookRequest::create([
                            'borrower_id' => $user->id,
                            'book_id' => $book->id
                        ]);

                        if($bookRequest){
                            DB::commit();
                            return response()->json(['status' => 'success', 'mssg' => 'Book requested  successfully'], 200);
                        }else{
                            DB::rollback();
                            return response()->json(['status' => 'error', 'mssg' => 'Error requesting book'], 206);
                        }


                    }else{
                        return response()->json(['status' => 'error', 'mssg' => 'Book unavailable'], 206);
                    }

                }else{
                    return response()->json(['status' => 'error', 'mssg' => 'Book not found'], 206);
                }


            }else{
                return response()->json(['status' => 'error', 'mssg' => 'Unauthorized'], 206);
            }

        }catch(\Exception $e){
            if(strstr($e->getMessage(), 'Duplicate entry')){
                return response()->json(['status' => 'error', 'mssg' => 'You have already requested this book'], 206);
            }
            return response()->json(['status' => 'error', 'mssg' => 'There was an error' . $e->getMessage()], 206);
        }

        
    }

    public function grant(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $user = auth()->user();
            if($user && $user->isLibrarian()){
                $bookRequest = BookRequest::find($id);
                if($bookRequest){

                    if($bookRequest->status == 'Granted'){
                        DB::rollback();
                        return response()->json(['status' => 'error', 'mssg' => 'Request already granted'], 206);
                    }else{
                        $book = Book::find($bookRequest->book_id);
                        $requester = User::find($bookRequest->borrower_id);
                        
                        if($requester->isTeacher()){
                            //just grant his request                            
                            $this->doGrant($book, $bookRequest);
                            return response()->json(['status' => 'success', 'mssg' => 'Request granted successfully'], 200);
                        }else{
                            //get all pending requests for this book
                            $requestsForBook = $bookRequest->getMatchingRequests();
                            if(count($requestsForBook) == 0){
                                //just grant request
                                $this->doGrant($book, $bookRequest);
                                return response()->json(['status' => 'success', 'mssg' => 'Request granted successfully'], 200);
                            }else{
                                $userType = User::find($bookRequest->borrower_id)->getUserType();
                                foreach($requestsForBook as $a_request){
                                    if($a_request->getRequesterType() == 'Teacher'){
                                        $this->doDecline($book, $bookRequest);
                                        return response()->json(['status' => 'privilege', 'mssg' => 'Sorry, a teacher also requested for this book'], 206);
                                    }else if($userType == 'Junior Student' && $a_request->getRequesterType() == 'Senior Student'){
                                        $this->doDecline($book, $bookRequest);
                                        return response()->json(['status' => 'privilege', 'mssg' => 'Sorry, a senior student also requested for this book'], 206);
                                    }else{
                                        $this->doGrant($book, $bookRequest);
                                        return response()->json(['status' => 'success', 'mssg' => 'Request granted successfully'], 200);
                                    }
                                }
                            }
                        }
                        

                    }
                    
                }else{
                     DB::rollback();
                    return response()->json(['status' => 'error', 'mssg' => 'Request not found'], 206);
                }


            }else{
                 DB::rollback();
                return response()->json(['status' => 'error', 'mssg' => 'Unauthorized'], 206);
            }
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(['status' => 'error', 'mssg' => 'There was an error' . $e->getMessage()], 206);
        }
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

    private function doGrant($book, $bookRequest){
        $bookRequest->status = 'Granted';
        $book->available = $book->available - 1;
        $bookRequest->save();
        $book->save();
        DB::commit();
    }

    private function doDecline($book, $bookRequest){
        $bookRequest->status = 'Declined';
        $bookRequest->save();
        DB::commit();
    }
}
