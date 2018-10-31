@extends('layout.index')

@section('content')
<div class="container">
    <h1 class="text-center text-header">Send Money to anyone in Nigeria</h1>
        <p class="text-center p-header">Instant transfers from your card to any account in Nigeria</p>
        <div class="form-group">
            <div class="input-group mb-3 col-md-6 col-md-offset-3 input-div">
                <input type="number" class="form-control" id="amount" placeholder="Amount eg. 100">
                <div class="input-group-append">
                    <button disabled class="btn btn-info btn-lg btn-adjust" data-toggle="modal"  id="buttonAmount" data-target="#exampleModal" data-whatever="@mdo">Send</button>
                </div>
            </div>
        </div>
        <p class="text-center p-header"> You need to send at least ₦ 100.00 to the recipient.</p>

    {{-- payment modal --}}
    <div class="modal" id="exampleModal"> 
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Enter Recipient Details </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                 <form method="POST" action="{{ route('send') }}"> 
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="emailAddress" class="control-label">Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email"  placeholder="Enter Sender Email Address" required>
                    <div class="form-group">
                        <label class="col-form-label-lg" for="destinationbank">Select Destination Bank</label>   
                        <select class="form-control form-control-lg" id="accountbank" name="account_bank">
                            @foreach ($banks['body']['data'] as $bank)
                                <option value="{{$bank['code']}}">{{$bank['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="account_number" class="control-label">Account Number:
                        </label>
                        <input type="text" class="form-control" id="recipientaccount" name="recipientaccount"  placeholder="Enter recipient account number" required>
                        <span id="error_msg"></span>
                    </div>
                    <div class="form-group">
                            <label class="col-form-label-lg" for="accountname">Account Name</label> 
                            <input type="text" class="form-control" id="accountname" name="accountname" value=" " readonly>
                        </div>
                    <div class="form-group">
                            <label for="amount" class="control-label">Amount:
                            </label>
                            <input type="text" class="form-control" name="amount" id="modal_amount" placeholder="Amount" readonly required>
                        </div>
                    <div class="form-group">
                        <label for="narration" class="control-label" >Narration:</label>
                        <input type="text" class="form-control" id="narration" name="narration" placeholder="Narration" required>
                    </div>
                    <input type="hidden" name="currency" value="NGN" />
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id ="continue" class="btn btn-primary" disabled>Continue</button>
                </form>
            </div>
          </div>
        </div>
    </div>

</div>
@endsection