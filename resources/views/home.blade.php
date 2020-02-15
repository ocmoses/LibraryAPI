@extends('layouts.app')

@section('content')
@include('partials.modals.confirm-modal')
@include('partials.modals.info-modal')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
                <div class="card">
                    <div class="card-header"><strong>Book Shelf</strong></div>

                    <div class="card-body" style="padding: 0px;">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Available</th>
                                    @if(!Auth::user()->isLibrarian())
                                        <th scope="col"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr id="{{ $book->id }}">
                                        <th scope="row">{{ $book->id }}</th>
                                        <td class="book-name">{{ $book->title }}</td>
                                        <td class="book-author">{{ $book->author }}</td>
                                        <td>{{ $book->total }}</td>
                                        <td>{{ $book->available }}</td>
                                        @if(!Auth::user()->isLibrarian())
                                        <td>
                                            <button id="{{$book->id . '-borrow'}}" @if($book->available == 0 || Auth::user()->alreadyRequestedBook($book->title)) disabled @endif class="btn btn-primary borrow">Borrow</button>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @if(Auth::user()->getUserType() == "Librarian")

                <div class="card" style="margin-top: 20px;">
                    <div class="card-header"><strong>Requests</strong></div>

                        @if(count($book_requests) == 0)
                            <div style="padding: 20px;">No requests at this moment</div>
                        @else

                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Borrower</th>
                                    <th scope="col">Book</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($book_requests as $book_request)
                                    <tr id="{{ $book_request->id }}">
                                        <th scope="row">{{ $book_request->id }}</th>
                                        <td class="borrower-name">{{ \App\User::find($book_request->borrower_id)->name }}</td>
                                        <td class="book-name">{{ \App\Book::find($book_request->book_id)->title }}</td>
                                        <td class="book-author">{{ \App\Book::find($book_request->book_id)->author }}</td>
                                        <td>{{ $book_request->status }}</td>
                                        <td>
                                            <button id="{{$book_request->id . '-request'}}" @if($book_request->status == 'Granted' || $book_request->status == 'Declined') disabled @endif class="btn btn-primary grant">Grant</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @endif

                    </div>
                </div>

            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
                
        $('.borrow').on('click', function(){
            //alert('clicked')
            let row = $(this).closest('tr');
            let id = $(row).attr('id');
            let bookName = $(row).find($('.book-name')).text();
            let bookAuthor = $(row).find($('.book-author')).text();

            showConfirmationDialog(`Are you sure you want to borrow <i><b>${bookName}</b></i> by <b>${bookAuthor}</b>?`, borrowBook.bind(this, id));
        });

        $('.grant').on('click', function(){
            //alert('clicked')
            let row = $(this).closest('tr');
            let id = $(row).attr('id');
            let bookName = $(row).find($('.book-name')).text();
            let bookAuthor = $(row).find($('.book-author')).text();
            let borrower = $(row).find($('.borrower-name')).text();

            showConfirmationDialog(`Are you sure you want to grant <i><b>${borrower}</b></i>'s request for <b>${bookName}</b>?`, grantRequest.bind(this, id));
        });
        
    });
</script>

@endsection
