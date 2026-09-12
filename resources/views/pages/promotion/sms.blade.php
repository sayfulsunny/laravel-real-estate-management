@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Send Promotional SMS')
@section('content')

<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
         
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('send.promotion.sms') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                           <div class="col-md-6">
                          <div class="card bg-gradient-info text-white mb-4">
                            <div class="card-body">
                                <h5 class="mb-0">📲 SMS Balance</h5>
                                <h6 class="">{{ $smsBalance }}</h6>
                            </div>
                        </div>
                        </div>
                      
                    <div class="form-row">
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Select Customers</label>

                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-outline-success"
                                        onclick="selectAllCustomers()">Select All</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="deselectAllCustomers()">Deselect All</button>
                                </div>

                        <select multiple name="customers[]" id="customers-select" class="form-control selectpicker"  data-live-search="true" 
                                data-actions-box="true" 
                                data-size="14"  required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>

                                @if($errors->has('customers '))
                                <span class="invalid-feedback">{{ $errors->first('customers') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="sms">SMS Body </label>
                                <textarea name="sms" class="form-control {{ $errors->has('sms') ? 'is-invalid': '' }}"
                                    placeholder="Write your promotional message" required>{{ old('sms') }}</textarea>
                                @if($errors->has('sms'))
                                <span class="invalid-feedback">{{ $errors->first('sms') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-left">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-send"></i>
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

<script>
    $(document).ready(function() {
        $('#customers-select').select2({
            placeholder: "Select customers...",
            allowClear: true,
            width: '100%' // optional: makes it stretch full width
        });
    });

    function selectAllCustomers() {
        const select = $('#customers-select');
        select.find('option').prop('selected', true);
        select.trigger('change');
    }

    function deselectAllCustomers() {
        const select = $('#customers-select');
        select.val(null).trigger('change');
    }
</script>