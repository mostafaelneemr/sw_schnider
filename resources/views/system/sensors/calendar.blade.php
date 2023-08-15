@extends('system.layout')

@section('header')
    <style>
        .fc-button-group button,
        .fc-today-button {
            color: black !important;
        }

        .fc-agendaDay-button {
            display: none;
        }

        .fc-unthemed td.fc-today {
            background: rgb(54 153 255 / 20%);
        }

        .datepicker-months thead,
        .datepicker-years thead {
            display: none;
        }

        .fc-unthemed .fc-event,
        .fc-unthemed .fc-event-dot {
        }

    </style>
@endsection
@section('content')
    @php setLocale(LC_TIME, 'en'); @endphp
    <div class="modal fade text-xs-left" id="change-location-modal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <label class="modal-title text-text-bold-600"
                           style="margin: 0 auto">{{__('Change Location')}}</label>
                </div>
                {!! Form::open(['id'=>'updateLocationForm']) !!}
                <div class="modal-body">

                    <div class="card-body">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        {{ Form::label('location_id',__('Location:')) }}
                                        {!! Form::select('location_id',[__('Select Location')]+$locations,null,['class'=>'form-control']) !!}
                                    </fieldset>
                                </div>
                                <input type="hidden" id="sensor_id" name="sensor_id" value="{{$id}}">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal"
                           value="{{__('Close')}}">
                    <input type="submit" class="btn btn-outline-primary btn-md" value="{{__('Update')}}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="modal fade text-xs-left" id="change-name-modal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <label class="modal-title text-text-bold-600" style="margin: 0 auto">{{__('Rename')}}</label>
                </div>
                {!! Form::open(['id'=>'updateNameForm']) !!}
                <div class="modal-body">

                    <div class="card-body">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        {{ Form::label('location_id',__('Name:')) }}
                                        {!! Form::text('name',$sensor->name,['class'=>'form-control','id'=>'sensor_name']) !!}
                                    </fieldset>
                                </div>
                                <input type="hidden" id="sensor_id" name="sensor_id" value="{{$id}}">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal"
                           value="{{__('Close')}}">
                    <input type="submit" class="btn btn-outline-primary btn-md" value="{{__('Update')}}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="modal fade text-xs-left" id="generate-report-modal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <label class="modal-title text-text-bold-600"
                           style="margin: 0 auto">{{__('Generate report')}}</label>
                </div>
                {!! Form::open(['id'=>'sendExcelToEmail']) !!}
                <div class="modal-body">

                    <div class="card-body">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <label
                                            class="form-label font-weight-bolder">{{__('Select what your report will contain')}}</label>
                                    {!! Form::select('report_contain[]',['Measurements'=>'Measurements','Alarms'=>'Alarms','Technical details'=>'Technical details'],null,['class'=>'form-control select report_contain','style'=>'width:100%','id'=>'report_contain-form-input','multiple'=>'multiple']) !!}
                                    <div class="invalid-feedback" id="report_contain-form-error"></div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label font-weight-bolder">{{__('Choose extension of your report')}}</label>
                                    {!! Form::select('report_extension',['PDF'=>'PDF Table','chart'=>'PDF Chart','CSV'=>'CSV'],null,['class'=>'form-control','style'=>'width:100%','id'=>'report_extension-form-input']) !!}
                                    <div class="invalid-feedback" id="report_extension-form-error"></div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label font-weight-bolder">{{__('Select start and finish dates of the time range, from which the report will be generated')}}</label>
                                    <input name="date" class="form-control" id="range_picker2" readonly="readonly"
                                           placeholder="Select time" type="text"
                                           style="color: #D4D5DF;background-color: #272935;">
                                    <div class="invalid-feedback" id="report_extension-form-error"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-outline-secondary btn-md" data-dismiss="modal" value="{{__('Close')}}">
                    <input type="submit" class="btn btn-outline-primary btn-md generateBtn" value="{{__('Generate')}}">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <!--begin::Row-->
    <div class="card card-custom gutter-b">
        <div class="card-header align-items-center justify-content-center">
            <div class="ml-5">
                <input class="form-control" id="range_picker" readonly="readonly" placeholder="Select time" type="text"
                       style="color: #D4D5DF;background-color: #272935;">
            </div>

            <button class="btn" id="switch-btn" data-state="charts" style="color: #D4D5DF;background-color: #272935;margin:10px;">Calendar View </button>

            <button class="btn" title="Generate report" href="javascript:;" data-toggle="modal" data-target="#generate-report-modal" style="color: #D4D5DF;background-color: #272935;margin:10px;"> Generate report </button>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="color: #D4D5DF;background-color: #272935;;margin:10px;">
                    Edit Sensor
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a data-sensor_id="{{$id}}" data-location_id="{{$sensor->location_id}}" class="dropdown-item" title="Change Location" href="javascript:;" data-toggle="modal" data-target="#change-location-modal">Change Location</a>

                    <a data-sensor_id="{{$id}}" data-location_id="{{$sensor->location_id}}" class="dropdown-item" title="Rename" href="javascript:;" data-toggle="modal" data-target="#change-name-modal">Rename</a>

                    @if ($sensor->status == 'active')

                        <a id="status" onclick="changeSensorStatus('{{route('sensor.update-status', $id)}}')" href="javascript:;" class="dropdown-item">Disable</a>
                    @else

                        <a id="status" onclick="changeSensorStatus('{{route('sensor.update-status', $id)}}')" href="javascript:;" class="dropdown-item">Enable</a>
                    @endif

                        <a class="dropdown-item" onclick="deleteSensor('{{route('system.sensor.destroy',$id)}}')" href="javascript:void(0);">Delete</a>

                </div>
            </div>

        </div>
        <div class="form-group ">
            <label class="col-3 col-form-label rules_div" style="display:none;">Show/Hide rules</label>
            <div class="col-3 rules_div" style="display:none;">
                   <span class="switch switch-outline switch-icon switch-info">
                    <label>
                     <input type="checkbox" checked="checked" class="remove_rules">
                     <span></span>
                    </label>
                   </span>
            </div>
            <div class="card-body b-l calender-sidebar">

                <div id="calendar" style="display:none;"></div>

                <div id="charts">
                    <div class="d-flex justify-content-center full-width">
                        <div class="spinner spinner-primary"></div>
                    </div>

                    <div class="content">

                    </div>
                </div>


            </div>

            <!-- end:: Content Body -->
        </div>
        <!-- end:: Content -->
        @endsection

        @push('aside-extensions')
            @include('system.sensors.aside',['sensor_id'=>$id])
        @endpush

        @section('footer')
            <script src="{{asset('public/new-files/node_modules/calendar/dist/fullcalendar.min.js?v=1')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

            <script>

                $('#updateLocationForm').submit(function (e) {
                    e.preventDefault();
                    $("#btnSubmit").attr("disabled", true);
                    var formData = new FormData(this);
                    $.post('{{route('sensor.update-location')}}', $('#updateLocationForm').serialize(), function (out) {
                        $('.validation_error_msg').remove();
                        $('.product_row').css('border-color', '#aaa');
                        if (out.status == false) {
                            toastr.error(out.msg, 'Error', {"closeButton": true});
                        } else {
                            $('#change-location-modal').modal('hide');
                            toastr.success(out.msg, 'Success', {"closeButton": true});
                        }
                    }, 'json')
                });

                $('#updateNameForm').submit(function (e) {
                    e.preventDefault();
                    $("#btnSubmit").attr("disabled", true);
                    var formData = new FormData(this);
                    $.post('{{route('sensor.update-name')}}', $('#updateNameForm').serialize(), function (out) {
                        $('.validation_error_msg').remove();
                        $('.product_row').css('border-color', '#aaa');
                        if (out.status == false) {
                            toastr.error(out.msg, 'Error', {"closeButton": true});
                        } else {
                            $('#change-name-modal').modal('hide');
                            toastr.success(out.msg, 'Success', {"closeButton": true});
                            $('#sensor_name').val(out.name)
                        }
                    }, 'json')
                });

                $('#sendExcelToEmail').submit(function (e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $(".generateBtn").attr("disabled", true);
                    $(".generateBtn").prop('value', 'Loading....');
                    $.get('{{route('system.GenerateReport',$sensor->id)}}', $('#sendExcelToEmail').serialize(), function (out) {
                        if (out.status == false) {
                            toastr.error(out.msg, 'Error', {"closeButton": true});
                            $(".generateBtn").attr("disabled", false);
                            $(".generateBtn").prop('value', 'Generate');
                        } else {
                            $('#generate-report-modal').modal('hide');
                            $('#generate-report-modal')
                                .find("textarea,select")
                                .val('')
                                .end();
                            $("#generate-report-modal").find('select').prop('selectedIndex', -1);
                            $('.report_contain').val(null).trigger('change');
                            toastr.success(out.msg, 'Success', {"closeButton": true});
                            $(".generateBtn").attr("disabled", false);
                            $(".generateBtn").prop('value', 'Generate');
                        }
                    }, 'json')
                });

                function changeSensorStatus($routeName, $reload) {

                    if (!confirm("Do you want to Change this ?")) {
                        return false;
                    }

                    if ($reload == undefined) {
                        $reload = 3000;
                    }

                    $.post(
                        $routeName,
                        {
                            '_method': 'POST',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        function (response) {
                            console.log(response);
                            if (isJSON(response)) {
                                $data = response;
                                if ($data.status == true) {
                                    $('#status').text($data.status_text);
                                    toastr.success($data.msg, 'Success !', {"closeButton": true});
                                } else {
                                    toastr.error($data.msg, 'Error !', {"closeButton": true});
                                }
                            }
                        }
                    )
                }

                function deleteSensor($routeName, $reload) {

                    if (!confirm("Do you want to delete this Sensor?")) {
                        return false;
                    }
                    addLoading();

                    $.post(
                        $routeName,
                        {
                            '_method': 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        function (response) {
                            removeLoading();
                            if (isJSON(response)) {
                                $data = response;
                                if ($data.status == true) {
                                    toastr.success($data.message, 'Success !', {"closeButton": true});
                                    window.location.replace('{{route('system.dashboard')}}');
                                } else {
                                    toastr.error($data.message, 'Error !', {"closeButton": true});
                                }
                            }
                        }
                    )
                }

            </script>
            <script>

                $(".select").select2();

                !function ($) {
                    "use strict";

                    $('body')
                        .removeClass('aside-minimize-hoverable aside-fixed ')
                        .addClass('aside-minimize aside-extension')

                    $('#range_picker').daterangepicker();
                    // $('#range_picker2').daterangepicker(
                    // );

                    $('#range_picker2').daterangepicker({
                        buttonClasses: ' btn',
                        applyClass: 'btn-primary',
                        cancelClass: 'btn-secondary',

                        timePicker: true,
                        timePickerIncrement: 30,
                        locale: {
                            format: 'MM/DD/YYYY H:mm '
                        }
                    }, function (start, end, label) {
                        $('#range_picker2').val(start.format('MM/DD/YYYY H:m') + ' / ' + end.format('MM/DD/YYYY H:m'));
                    });

                    $('#range_picker').on('apply.daterangepicker', function (ev, picker) {

                        chart_data = {
                            from: picker.startDate.format('YYYY-MM-DD'),
                            to: picker.endDate.format('YYYY-MM-DD')
                        }

                        load_chart();

                    });
                    $(".remove_rules").change(function () {
                        var ischecked = $(this).is(':checked');
                        var show_rule = '';
                        if (ischecked) {
                            load_chart(show_rule = true);
                        } else {
                            load_chart(show_rule = false);
                        }
                    });
                    var events = JSON.parse('{!! $result !!}');

                    var chart_loaded = false;

                    var chart_data = {};


                    $('body').click(function () {
                        $('.alert').remove();
                    });

                    $('#switch-btn').click(function () {

                        const state = this.dataset.state;

                        if (state == 'calendar') {
                            $('#calendar').fadeOut();
                            $('#charts').fadeIn();
                            $('#range_picker').show();

                            load_chart();
                        }

                        if (state == 'charts') {
                            $('.rules_div').hide();
                            $('#charts').fadeOut();
                            $('#calendar').fadeIn();
                            $('#range_picker').hide();

                            $.CalendarApp.init();
                        }

                        $(this)
                            .text(state == 'calendar' ? 'Calendar View' : 'Charts View')
                            .attr('data-state', state == 'calendar' ? 'charts' : 'calendar');
                    });


                    function load_chart($show_rule = true) {

                        $('#charts .content').empty();
                        $('#charts .spinner').show();
                        $.ajax({
                            url: "{{ route('system.sensorChart',$id) }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: chart_data,
                            success: function (data) {


                                $('#charts .spinner').hide();

                                if (!Object.keys(data.measurements).length) {
                                    $('#charts .content').html(`
                <div class="text-center border mb-4">
                <i class="flaticon-signs-2 d-block my-3 font-size-h1 text-warning"></i>
                <p class="font-size-h4">No Enough Data</p>
                </div>`);
                                    return;

                                }
                                $('.rules_div').show();
                                Object.keys(data.measurements).forEach(c => {

                                    view_chart(c, data.measurements[c], data.rule, data[c + '_min'], data[c + '_max'], $show_rule);
                                });


                            }
                        })

                    }

                    load_chart();

                    function view_chart(title, data, rules, min, max, show_rule) {


                        var options = {
                            chart: {
                                type: 'line',
                                animations: {
                                    enabled: false
                                },
                                defaultLocale: "en",
                                height: 300,
                                id: "second",
                                stacked: false,
                                width: "100%",
                                zoom: {
                                    type: "x",
                                    enabled: true
                                },
                            },
                            annotations: {
                                yaxis: rules.map(function (r) {
                                    if (show_rule) {
                                        var color = 'blue';
                                        if (r.condition_type == 'Above') {
                                            var color = 'red';
                                        }
                                        return {
                                            y: r.condition_value,
                                            borderColor: color,
                                            label: {
                                                borderColor: 'white',
                                                style: {
                                                    color: color,
                                                    background: 'white'
                                                },
                                                text: `${r.name} ( ${r.condition_value} ${r.degree_value})`
                                            }
                                        }
                                    }
                                })
                            },
                            series: [{
                                name: title,
                                data: data.map(d => [new Date(d.created_at).getTime(), d.value])
                            }],
                            stroke: {
                                curve: "straight",
                                show: true,
                                width: 2
                            },
                            grid: {
                                borderColor: "#ACACAC",
                                column: {
                                    colors: ["#FFFFFF"],
                                    opacity: 0.5,
                                },
                                row: {
                                    colors: ["#FFFFFF", "#F5F5F7"],
                                    opacity: 0.5
                                },
                                xaxis: {
                                    lines: {
                                        show: true
                                    }
                                }
                            },
                            xaxis: {
                                type: "datetime",
                                axisTicks: {
                                    color: "#78909C",
                                    height: 6,
                                    offsetX: 0,
                                    offsetY: 0,
                                    show: true,
                                },

                                stroke: {
                                    colors: undefined,
                                    curve: "straight",
                                    dashArray: 0,
                                    lineCap: "butt",
                                    show: true,
                                    width: 2,
                                },
                                tickPlacement: "on",
                                floating: false,
                                hideOverlappingLabels: true,
                                labels: {
                                    datetimeUTC: false
                                },
                                tooltip: {
                                    enabled: false
                                },
                                crosshairs: {
                                    position: "front",
                                    show: true,
                                    stroke: {
                                        color: "#b6b6b6",
                                        width: 1,
                                        dashArray: 0
                                    }
                                },
                            },
                            yaxis: {
                                crosshairs: {
                                    position: "front",
                                    show: true,
                                    stroke: {
                                        color: "#b6b6b6",
                                        width: 1,
                                        dashArray: 0
                                    }
                                },
                                min: parseInt(min) - 10,
                                max: parseInt(max) + 15,
                                floating: false,
                                forceNiceScale: true,
                                logarithmic: false,
                                show: true,
                                showAlways: false,
                                title: {
                                    text: title
                                },

                            },
                            tooltip: {
                                followCursor: false,
                                x: {
                                    format: "dd.MM.yyyy HH:mm:ss"
                                }
                            },

                        }

                        const id = "chart_" + title;

                        $('#charts .content').append($(`<div id="${id}"></div>`))

                        if (data.length) {
                            var chart = new ApexCharts(document.querySelector('#' + id), options);

                            chart.render();
                        } else {
                            $('#' + id).html(`
                <div class="text-center border mb-4">
                <i class="flaticon-signs-2 d-block my-3 font-size-h1 text-warning"></i>
                <p class="font-size-h4">No Enough Data</p>
                </div>`)
                        }



        }

        var CalendarApp = function () {
            this.$body = $("body")
            this.$calendar = $('#calendar'),
                this.$event = ('#calendar-events div.calendar-events'),
                this.$categoryForm = $('#add-new-event form'),
                this.$extEvents = $('#calendar-events'),
                this.$modal = $('#my-event'),
                this.$saveCategoryBtn = $('.save-category'),
                this.$calendarObj = null
        };
        /* on drop */
        CalendarApp.prototype.onDrop = function (eventObj, date) {
                var $this = this;
                // retrieve the dropped element's stored Event Object
                var originalEventObject = eventObj.data('eventObject');
                var $categoryClass = eventObj.attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                if ($categoryClass)
                    copiedEventObject['className'] = [$categoryClass];
                // render the event on the calendar
                $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    eventObj.remove();
                }
            },
            /* on click on event */
            CalendarApp.prototype.onEventClick = function (calEvent, jsEvent, view) {
                var $this = this;
                var form = $("<form></form>");
                form.append("<label>Change event name</label>");
                form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title +
                    "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>"
                );
                $this.$modal.modal({
                    backdrop: 'static'
                });
                $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body')
                    .empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                        $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                            return (ev._id == calEvent._id);
                        });
                        $this.$modal.modal('hide');
                    });
                $this.$modal.find('form').on('submit', function () {
                    calEvent.title = form.find("input[type=text]").val();
                    $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                    $this.$modal.modal('hide');
                    return false;
                });
            },
            /* on select */
            CalendarApp.prototype.onSelect = function (start, end, allDay) {
                var $this = this;
                $this.$modal.modal({
                    backdrop: 'static'
                });
                var form = $("<form></form>");
                form.append("<div class='row'></div>");
                form.find(".row")
                    .append(
                        "<div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>"
                    )
                    .append(
                        "<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>"
                    )
                    .find("select[name='category']")
                    .append("<option value='bg-danger'>Danger</option>")
                    .append("<option value='bg-success'>Success</option>")
                    .append("<option value='bg-purple'>Purple</option>")
                    .append("<option value='bg-primary'>Primary</option>")
                    .append("<option value='bg-pink'>Pink</option>")
                    .append("<option value='bg-info'>Info</option>")
                    .append("<option value='bg-warning'>Warning</option></div></div>");
                $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body')
                    .empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                        form.submit();
                    });
                $this.$modal.find('form').on('submit', function () {
                    var title = form.find("input[name='title']").val();
                    var beginning = form.find("input[name='beginning']").val();
                    var ending = form.find("input[name='ending']").val();
                    var categoryClass = form.find("select[name='category'] option:checked").val();
                    if (title !== null && title.length != 0) {
                        $this.$calendarObj.fullCalendar('renderEvent', {
                            title: title,
                            start: start,
                            end: end,
                            allDay: false,
                            className: categoryClass
                        }, true);
                        $this.$modal.modal('hide');
                    } else {
                        alert('You have to give a title to your event');
                    }
                    return false;

                });
                $this.$calendarObj.fullCalendar('unselect');
            },
            CalendarApp.prototype.enableDrag = function () {
                //init events
                $(this.$event).each(function () {
                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    };
                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);
                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 999,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    });
                });
            }
        /* Initializing */
        CalendarApp.prototype.init = function () {
                this.enableDrag();
                /*  Initialize the calendar  */
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var form = '';
                var today = new Date($.now());

                var defaultEvents = events.map(function (event) {
                    return {
                        title: event.cause,
                        start: event.created_at,
                        className: 'bg-warning large',
                        ...event
                    }
                });


                var EventColor = [{
                        eventColor: '#000000'

                    }


                ];
                var $this = this;
                $this.$calendarObj = $this.$calendar.fullCalendar({
                    slotDuration: '00:15:00',
                    /* If we want to split day time each 15minutes */
                    minTime: '08:00:00',
                    maxTime: '19:00:00',
                    defaultView: 'month',
                    handleWindowResize: true,
                    locale: "{{ cLang() }}",
                    direction: $('html').attr('direction'),

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    viewRender: function (view, element) {
                        if (jQuery.isReady) {
                            $('.months,.years').datepicker('setDate', new Date(view.intervalStart));
                        }
                    },
                    buttonIcons: false,
                    events: defaultEvents,
                    eventColor: EventColor,


                    eventLimit: true, // allow "more" link when too many events
                    selectable: true,
                    // viewRender: function(view, element){
                    //     $('.fc-event-container').click(function(event){

                    //         event.stopPropagation();
                    //     });
                    // },
                    eventClick: function (calEvent, jsEvent, view, date) {

                        jsEvent.stopPropagation();

                        $('.alert').remove();

                        $('#calendar').append(tooltip(calEvent));






                        const x = document.querySelector('.alert');

                        $(x).click(e => e.stopPropagation());

                        new Popper(jsEvent.currentTarget, x);


                    }

                });

                //on new event
                this.$saveCategoryBtn.on('click', function () {
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                        $this.$extEvents.append('<div class="calendar-events" data-class="bg-' + categoryColor +
                            '" style="position: relative; color: #000000;"><i class="fa fa-circle text-' +
                            categoryColor + '"></i>' + categoryName + '</div>')
                        $this.enableDrag();
                    }

                });
            },

            //init CalendarApp
            $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp


        function tooltip(calEvent) {
            return ` <div class="alert alert-dark rounded-xl position-absolute" style="width:450px;z-index:9;" >

       <div class="row">
           <div class="col-md-6 ">
               <p>${calEvent.created_at}</p>
           </div>
           <div class="col-md-6 text-right" >
                <h6>${calEvent.status}</h6>
           </div>
       </div>
       <div class="row" style="align-items: flex-end;">
           <div class="col-md-6 d-flex align-items-center">
               <div ><svg xml:space="preserve" width="50mm" height="50mm"
                   viewBox="0 0 5000 5000" fill="white"
                   style="min-height: 30px; min-width: 30px; height: 30px; width: 32px;">
                   <defs>
                       <style type="text/css"></style>
                   </defs>
                   <g id="Warstwa_x0020_1">
                       <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                       <path class="fil0"
                           d="M3073 2810l0 -1351c0,-297 -242,-538 -539,-538 -296,0 -538,242 -538,538l0 1351c-132,135 -211,318 -211,520 0,413 336,749 749,749 413,0 749,-336 749,-749 0,-202 -79,-385 -210,-520zm-539 -2685c656,0 1250,266 1679,696 430,429 696,1023 696,1679 0,656 -266,1250 -696,1679 -429,430 -1023,696 -1679,696 -656,0 -1250,-266 -1679,-696 -430,-429 -696,-1023 -696,-1679 0,-656 266,-1250 696,-1679 429,-430 1023,-696 1679,-696zm1620 755c-414,-415 -987,-672 -1620,-672 -633,0 -1206,257 -1620,672 -415,414 -672,987 -672,1620 0,633 257,1206 672,1620 414,415 987,672 1620,672 633,0 1206,-257 1620,-672 415,-414 672,-987 672,-1620 0,-633 -257,-1206 -672,-1620zm-1447 2148l0 -818 -346 0 0 818c-107,60 -175,173 -175,302 0,193 156,349 348,349 193,0 348,-156 348,-349 0,-129 -68,-242 -175,-302zm-173 844c-299,0 -541,-243 -541,-542 0,-175 81,-330 212,-429l0 -857 234 0c38,0 69,-32 69,-71 0,-38 -31,-70 -69,-70l-234 0 0 -171 234 0c38,0 69,-30 69,-68 0,-38 -31,-68 -69,-68l-234 0 0 -137c0,-182 147,-330 329,-330 183,0 329,148 329,330l0 1444c132,99 211,254 211,427 0,299 -242,542 -540,542z">
                       </path>
                   </g>
               </svg></div>
           <p  style="margin: 8px;">${calEvent.cause}</p>
           </div>
           <div class="col-md-6 text-right">
               <p >Duration: ${calEvent.measurement_interval} minute</p>

           </div>

</div>
</div>`;
        }

                }(window.jQuery)


            </script>

@endsection
