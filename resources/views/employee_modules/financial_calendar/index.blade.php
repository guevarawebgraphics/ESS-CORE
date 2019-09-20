@extends('layouts.master')

@section('crumb')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Financial Calendar</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#">Financial Calendar</a>
            </li>
            <li class="breadcrumb-item active-financialcalendary text-secondary">Index</li>
        </ol>
    </div>
</div>
@endsection
@section('content')
@php
if(Session::get('financial_calendar') == 'all'){
    $add = '';
    $edit = '';
    $delete = '';
}
elseif(Session::get('financial_calendar') == 'view'){
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('financial_calendar') == 'add'){
    $add = '';
    $edit = 'disabled';
    $delete = 'disabled';
}
elseif(Session::get('financial_calendar') == 'edit'){
    $add = '';
    $edit = '';
    $delete = 'disabled';
}
elseif(Session::get('financial_calendar') == 'delete'){
    $add = '';
    $edit = 'disabled';
    $delete = '';
}else{
    $add = 'disabled';
    $edit = 'disabled';
    $delete = 'disabled';
}                   
@endphp
@section('content')
<div class="container-fluid">
    <div class="card card-custom-blue card-outline">
        <div class="card-header">
            <center><strong>Financial Calendar</strong></center>
        </div>
        <div class="card-body">
            {{-- Row --}}
            <div class="row">
                {{-- Col --}}
                <div class="col-md-12">
                    <div class="card-body p-0">
                        <br />
                        <a data-toggle="modal" href="#modal-action-show" class="btn btn-outline-primary btn-flat" id="btn_cash_now" data-toggle="modal" data-target="#cash_now_modal" style="margin-right: 5px;"><i class="fa fa-money"></i><span> CashNow</span></a>
                        <a data-toggle="modal" href="#modal-action-collection" class="btn btn-outline-secondary btn-flat" id="btn_collection" data-toggle="modal" data-target="#collection_modal" style="margin-right: 5px;"><i class="fa fa-money"></i><span> Collection</span></a>
                        <a data-toggle="modal" href="#modal-action-payment" class="btn btn-outline-info btn-flat" id="btn_payment" data-toggle="modal" data-target="#payment_modal" style="margin-right: 5px;" ><i class="fa fa-money"></i><span> Payment</span></a>
                        <!-- THE CALENDAR -->
                        {{-- Calendar --}}
                        <div id="calendar"></div>
                    </div>
                    {{-- /. Card --}}
                </div>
            </div> 
            {{-- /. Row--}}
        </div> 
        {{-- /. Card body--}}
    </div>      
</div>


<!-- Modal For Add Cash Now-->
<div class="modal fade" id="cash_now_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cash Now</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="cash_now_form">
                @csrf
                <input type="text" name="event_id" id="event_id" hidden="true">
                <div class="form-group row">
                
                <div class="col-md-12">
                            
                    <div class="input-group mb-3">
                        <label class="custom-flat-label">Description</label>
                        <input id="cash_now_description" type="text" class="form-control custom-flat-input-modal" name="cash_now_description" placeholder="Description">
                    </div>
                    <p class="text-danger" id="error_cash_now_description"></p>
                </div>
                
                <div class="col-md-12">
                            
                    <div class="input-group mb-3">
                        <label class="custom-flat-label">Amount</label>
                        <input id="cash_now_amount" type="number" class="form-control custom-flat-input-modal" name="cash_now_amount" placeholder="0.00">
                    </div>
                    <p class="text-danger" id="error_cash_now_amount"></p>
                </div>
                
                <div class="col-md-12">
                            
                    <div class="input-group mb-3">
                        <label class="custom-flat-label">Date</label>
                        <input id="cash_now_date" type="text" class="form-control fc-date custom-flat-input-modal" name="cash_now_date" placeholder="MM/DD/YYYY">
                    </div>
                    <p class="text-danger" id="error_cash_now_date"></p>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-flat" id="btn_save_cash_now">Confirm <i id="spinner_cash_now" class=""></i></button>
        </div>
      </div>
    </div>
</div>


<!-- Modal For Add Collection-->
<div class="modal fade" id="collection_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Collection</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="collection_form">
                @csrf
                <input type="text" name="collection_event_id" id="collection_event_id" hidden="true">
                <div class="form-group row">
                    
                    <div class="col-md-12">
                                
                        <div class="input-group mb-3">
                            <label class="custom-flat-label">Cash Source</label>
                            <input id="collection_cash_source" type="text" class="form-control custom-flat-input-modal" name="collection_cash_source" placeholder="Cash Source">
                        </div>
                        <p class="text-danger" id="error_collection_cash_source"></p>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="custom-flat-label">Collection Amount</label>     
                        <div class="input-group mb-3">
                            <input id="collection_amount" type="number" class="form-control custom-flat-input-modal" name="collection_amount" placeholder="0.00">
                        </div>
                        <p class="text-danger" id="error_collection_amount"></p>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="custom-flat-label">Date</label>            
                        <div class="input-group mb-3">
                            <input id="collection_date" type="text" class="form-control fc-date custom-flat-input-modal" name="collection_date" placeholder="MM/DD/YYYY">
                        </div>
                        <p class="text-danger" id="error_collection_date"></p>
                    </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-flat" id="btn_save_collection">Confirm <i id="spinner_collection" class=""></i></button>
        </div>
      </div>
    </div>
</div> 

<!-- Modal For Add Payment-->
<div class="modal fade" id="payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content card-custom-blue card-outline">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="payment_form">
                @csrf
                <input type="text" name="payment_event_id" id="payment_event_id" hidden="true">
                <div class="form-group row">
                    
                    <div class="col-md-12">
                        <label>Payment Source</label>            
                        <div class="input-group mb-3">
                            <input id="payment_source" type="text" class="form-control custom-flat-input-modal" name="payment_source" placeholder="Payment Source">
                        </div>
                        <p class="text-danger" id="error_payment_source"></p>
                    </div>
                    
                    <div class="col-md-12">
                        <label>Payment Amount</label>                     
                        <div class="input-group mb-3">
                            <input id="payment_amount" type="number" class="form-control custom-flat-input-modal" name="payment_amount" placeholder="0.00">
                        </div>
                        <p class="text-danger" id="error_payment_amount"></p>
                    </div>
                    
                    <div class="col-md-12">
                        <label>Date</label>        
                        <div class="input-group mb-3">
                            <input id="payment_date" type="text" class="form-control fc-date custom-flat-input-modal" name="payment_date" placeholder="MM/DD/YYYY">
                        </div>
                        <p class="text-danger" id="error_payment_date"></p>
                    </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary btn-flat" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline-primary btn-flat" id="btn_save_payment">Confirm <i id="spinner_payment" class=""></i></button>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        // Config Restriction for Pass Date
        var date = new Date();
        date.setDate(date.getDate());
        $('.fc-date').datepicker({
            autoclose: true,
            startDate: date
        });
        // Config Restriction for Pass Date
        var date = new Date();
        date.setDate(date.getDate());
        $('.fc-date').datepicker({
            autoclose: true,
            startDate: date
        });
        /* initialize the external events
         -----------------------------------------------------------------*/
         function init_events(ele) {
            ele.each(function () {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                });

            });
        }

        init_events($('#external-events div.external-event'));

          /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
        $('#calendar').fullCalendar({
            aspectRatio: 2.3,
            handleWindowResize: true,
            eventLimit: true,
            plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
            header: {
                left: 'prev,next today',
                center: '',
                right: 'title'
            },
            // buttonText: {
            //     today: 'today',
            //     month: 'month',
            //     week: 'week',
            //     day: 'day'
            // },
            eventRender: function (event, element) {
                if (event.color == 'red') {
                    element.css({ 'background-color': '#FF0266', 'border-color': '#FF0266' });
                } else if (event.color == 'blue') {
                    element.css({ 'background-color': '#0336FF', 'border-color': '#0336FF' });
                }
                else if(event.color =="cyan"){
                    element.css({ 'background-color': '#17A2B8', 'border-color': '#17A2B8' });
                }
               
            },
            eventSources: [

                // your event source
                // Get Cash Now
                {
                events: function(start, end, timezone, callback) {
                    $.get('/financialcalendar/get_events', function(data) {
                        var events = [];
                            var i;
                            for(i=0; i<data.length; i++){
                                events.push({
                                    event_id: data[i].id,
                                    title: data[i].cash_now_description,
                                    start: data[i].cash_now_date,
                                    end: data[i].cash_now_date,
                                    amount: data[i].cash_now_amount,
                                    backgroundColor: data[i].cash_now_theme_color,
                                    // backgroundColor: '#f56954', //red
                                    borderColor    : data[i].cash_now_theme_color,
                                    textColor: '#fff'
                                });
                            }
                            callback(events);
                    }, 'json');
                }
                },
                // Get collection
                {
                    events: function(start, end ,timezone, callback) {
                            $.get('/financialcalendar/get_collection', function(data) {
                                var events = [];
                                var i;
                                for(i=0; i<data.length; i++){
                                    events.push({
                                        event_id: data[i].id,
                                        title: data[i].collection_cash_source,
                                        start: data[i].collection_date,
                                        end: data[i].collection_date,
                                        amount: data[i].collection_amount,
                                        backgroundColor: data[i].collection_theme_color,
                                        // backgroundColor: '#f56954', //red
                                        borderColor    : data[i].collection_theme_color,
                                        textColor: '#fff'
                                    });
                                }
                                callback(events);
                        }, 'json' );
                    }
                }, 
                // Get collection
                {
                    events: function(start, end ,timezone, callback) {
                            $.get('/financialcalendar/get_payment', function(data) {
                                var events = [];
                                var i;
                                for(i=0; i<data.length; i++){
                                    events.push({
                                        event_id: data[i].id,
                                        title: data[i].payment_source,
                                        start: data[i].payment_date,
                                        end: data[i].payment_date,
                                        amount: data[i].payment_amount,
                                        backgroundColor: data[i].payment_theme_color,
                                        // backgroundColor: '#f56954', //red
                                        borderColor    : data[i].payment_theme_color,
                                        textColor: '#fff'
                                    });
                                }
                                callback(events);
                        }, 'json' );
                    }
                } 
           

                // any other sources...

            ],


            // Update The Calendar
            eventClick: function (calEvent, jsEvent) {
                // Get Cash Now
                if(calEvent.backgroundColor == '#007BFF'){
                    $('#cash_now_modal').modal('show');
                    $('#event_id').val(calEvent.event_id);
                    $('#cash_now_description').val(calEvent.title);
                    $('#cash_now_amount').val(calEvent.amount);
                    $('#cash_now_date').val(moment(calEvent.start).format('MM/DD/YYYY'));
                    $('#cash_now_form').attr('action', '/financialcalendar/update_cash_now');
                }
                // Get Collection
                if(calEvent.backgroundColor == '#6C757D'){
                    $('#collection_modal').modal('show');
                    $('#collection_event_id').val(calEvent.event_id);
                    $('#collection_cash_source').val(calEvent.title);
                    $('#collection_amount').val(calEvent.amount);
                    $('#collection_date').val(moment(calEvent.start).format('MM/DD/YYYY'));
                    $('#collection_form').attr('action', '/financialcalendar/update_collection');
                }
                if(calEvent.backgroundColor == '#17A2B8'){
                    $('#payment_modal').modal('show');
                    $('#payment_event_id').val(calEvent.event_id);
                    $('#payment_source').val(calEvent.title);
                    $('#payment_amount').val(calEvent.amount);
                    $('#payment_date').val(moment(calEvent.start).format('MM/DD/YYYY'));
                    $('#payment_form').attr('action', '/financialcalendar/update_payment');
                }
            },
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.backgroundColor = $(this).css('background-color');
                copiedEventObject.borderColor = $(this).css('border-color');

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            }
        });

        /*
         * @ Add Cash Now
         */
        $('#btn_cash_now').click(function (){
            $('#cash_now_form').attr('action', '/financialcalendar/save_cash_now');
        });
        

        /*
        * @ Save Cash Now
        */
        $('#btn_save_cash_now').click(function (e) {
            e.preventDefault();
            let data = $('#cash_now_form').serialize();
            let url = $("#cash_now_form").attr('action');
            $("#spinner_cash_now").addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: $('#event_id').val(),
                    cash_now_amount: $('#cash_now_amount').val(),
                    cash_now_description: $('#cash_now_description').val(),
                    cash_now_date: $('#cash_now_date').val()
                },
                success: function(data) {
                    if(data.status == 200){
                       
                        // Display a success toast, with a title
                        toastr.success(data.message)
                        RemoveErrors();
                        // Modal hide
                        setTimeout(function (){
                            $('#cash_now_modal').modal('hide');
                            $('#cash_now_form')[0].reset();
                        }, 500);
                        setTimeout(function (){
                            $("#spinner_cash_now").removeClass('fa fa-refresh fa-spin');
                        }, 1500);
                        //Refresh The Full Calendar
                        $('#calendar').fullCalendar('refetchEvents');
                    }
                },
                error: function(data){
                    console.log(data);
                    if(data.status == 422) {
                        setTimeout(function (){
                            $("#spinner_cash_now").removeClass('fa fa-refresh fa-spin');
                        }, 100);
                    }
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(i, errors) {
                        if(errors.cash_now_description){
                            $('#error_cash_now_description').html('Description Field is required');
                            $('#cash_now_description').addClass('is-invalid');
                            $('#error_cash_now_description').removeAttr('hidden');
                        }
                        if(errors.cash_now_amount){
                            $('#error_cash_now_amount').html('Amount Field is required');
                            $('#cash_now_amount').addClass('is-invalid');
                            $('#error_cash_now_amount').removeAttr('hidden');
                        }
                        if(errors.cash_now_date){
                            $('#error_cash_now_date').html('Date Field is required');
                            $('#cash_now_date').addClass('is-invalid');
                            $('#error_cash_now_date').removeAttr('hidden');
                        }
                    });
                }
            });
        });


       /*
        * @ Add Collection
        */
        $('#btn_collection').click(function() {
            $('#collection_form').attr('action', '/financialcalendar/save_collection');
        });


        /*
         * @ Save Collection
         */
         $('#btn_save_collection').click(function (e) {
            e.preventDefault();
            let url = $("#collection_form").attr('action');
            $("#spinner_collection").addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: $('#collection_event_id').val(),
                    collection_cash_source: $('#collection_cash_source').val(),
                    collection_amount: $('#collection_amount').val(),
                    collection_date: $('#collection_date').val()
                },
                success: function(data) {
                    if(data.status == 200){
                         // Display a success toast, with a title
                         toastr.success(data.message)
                        RemoveErrors();
                        // Modal hide
                        setTimeout(function (){
                            $('#collection_modal').modal('hide');
                            $('#collection_form')[0].reset();
                        }, 500);
                        setTimeout(function (){
                            $("#spinner_collection").removeClass('fa fa-refresh fa-spin');
                        }, 1500);
                    }
                    //Refresh The Full Calendar
                    $('#calendar').fullCalendar('refetchEvents');
                },
                error: function(data) {
                    if(data.status == 422) {
                        setTimeout(function (){
                            $("#spinner_collection").removeClass('fa fa-refresh fa-spin');
                        }, 100);
                    }
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(i, errors) {
                        if(errors.collection_cash_source){
                            $('#error_collection_cash_source').html('Cash Source Field is required');
                            $('#collection_cash_source').addClass('is-invalid');
                            $('#error_collection_cash_source').removeAttr('hidden');
                        }
                        if(errors.collection_amount){
                            $('#error_collection_amount').html('Collection Amount Field is required');
                            $('#collection_amount').addClass('is-invalid');
                            $('#error_collection_amount').removeAttr('hidden');
                        }
                        if(errors.collection_date){
                            $('#error_collection_date').html('Date Field is required');
                            $('#collection_date').addClass('is-invalid');
                            $('#error_collection_date').removeAttr('hidden');
                        }
                    });
                }
            });
         });
         
              /*
        * @ Add Collection
        */
        $('#btn_payment').click(function() {
            $('#payment_form').attr('action', '/financialcalendar/save_payment');
        }); 
        $('#btn_save_payment').click(function (e) {
            e.preventDefault();
            let url = $("#payment_form").attr('action');
            $("#spinner_payment").addClass('fa fa-refresh fa-spin');
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: $('#payment_event_id').val(),
                    payment_source: $('#payment_source').val(),
                    payment_amount: $('#payment_amount').val(),
                    payment_date: $('#payment_date').val()
                },
                success: function(data) {
                    if(data.status == 200){
                         // Display a success toast, with a title
                         toastr.success(data.message)
                        RemoveErrors();
                        // Modal hide
                        setTimeout(function (){
                            $('#payment_modal').modal('hide');
                            $('#payment_form')[0].reset();
                        }, 500);
                        setTimeout(function (){
                            $("#spinner_payment").removeClass('fa fa-refresh fa-spin');
                        }, 1500);
                    }
                    //Refresh The Full Calendar
                    $('#calendar').fullCalendar('refetchEvents');
                },
                error: function(data) {
                    if(data.status == 422) {
                        setTimeout(function (){
                            $("#spinner_payment").removeClass('fa fa-refresh fa-spin');
                        }, 100);
                    }
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(i, errors) {
                        if(errors.payment_source){
                            $('#error_payment_source').html('Payment Source Field is required');
                            $('#payment_source').addClass('is-invalid');
                            $('#error_payment_source').removeAttr('hidden');
                        }
                        if(errors.payment_amount){
                            $('#error_payment_amount').html('Payment Amount Field is required');
                            $('#payment_amount').addClass('is-invalid');
                            $('#error_payment_amount').removeAttr('hidden');
                        }
                        if(errors.payment_date){
                            $('#error_payment_date').html('Date Field is required');
                            $('#payment_date').addClass('is-invalid');
                            $('#error_payment_date').removeAttr('hidden');
                        }
                    });
                }
            });
         });


        /*Remove Errors*/
        $('#cash_now_modal').on('hidden.bs.modal', function(e) {
            $('#cash_now_form')[0].reset();
            $('#cash_now_form').removeAttr('action');
            RemoveErrors();
        });

        $('#collection_modal').on('hidden.bs.modal', function(e) {
            $('#collection_form')[0].reset();
            $('#collection_form').removeAttr('action');
            RemoveErrors();
        });
        
        $('#payment_modal').on('hidden.bs.modal', function(e) {
            $('#payment_form')[0].reset();
            $('#payment_form').removeAttr('action');
            RemoveErrors();
        });


        /*Function to Remove Errors*/
        function RemoveErrors(){
            $('.form-control').each(function(i, obc){
                $('.form-control').removeClass('is-invalid');
                $('.text-danger').attr('hidden', true);
            });
        }



    });
</script>   
@endsection