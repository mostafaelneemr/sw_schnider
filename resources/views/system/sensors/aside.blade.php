<div class="w-100 px-5 mt-5 aside-content">

    <ul class="nav nav-tabs nav-tabs-line nav-fill">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#alarms">Alarms</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#table">Table</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#details">Details</a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade show active" id="alarms" role="tabpanel" aria-labelledby="alarms">
            <div class="datatable" id="alarms_datatable"></div>
        </div>
        <div class="tab-pane fade" id="table" role="tabpanel" aria-labelledby="table">
            <div class="datatable  datatable-head-custom" id="table_datatable"></div>
        </div>
        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details">

            <div id="slots">

            </div>
            <div class="datatable  datatable-head-custom" id="details_datatable"></div>

        </div>
    </div>
</div>

@push('js')

<style>
    .datatable-head {
        border-bottom: 1px solid #a5a5a5;
    }

    .datatable-cell.datatable-cell-sort i{
        font-size: 1rem !important;
    }

    .datatable.datatable-default>.datatable-table {
        background: transparent;
    }

    .datatable-head .datatable-cell-center.datatable-cell span {
        color: rgb(212, 213, 223) !important;
        font-weight: bold !important;
        font-size: 14px;
    }

    .datatable-body .datatable-cell-center.datatable-cell span:not(.label) {
        color: rgb(255, 255, 255) !important;

        font-size: 13px;
    }

    .datatable-body tr:nth-of-type(odd) {
        background-color: #1e202b;
    }

    .datatable.datatable-default>.datatable-pager {
        flex-direction: column;
    }

    .datatable.datatable-default>.datatable-pager>.datatable-pager-info {
        margin-top: 20px;
    }

</style>
<script defer>
    $(function () {
        window.disable_sidebar = true;

        $('#kt_aside_toggle').removeClass('brand-toggle ');



        $('#kt_aside_toggle').click(function(){

            $(this).toggleClass('brand-toggle ');

            $('body').toggleClass('aside-extension-minmized');
        })


        var params = {};

        var slots = [];

        var icons = {
                        temperature : "fa-thermometer-half",
                        humidity : "fa-tint"
                    };


        function parse_slots(data){

            slots = [];

            var i = 1;

            while(data.hasOwnProperty(`slot${i}_avg`)){

                if(data[`slot${i}_avg`] != false){
                    slots.push({
                     min: data[`slot${i}_min`],
                     max: data[`slot${i}_max`],
                     avg: data[`slot${i}_avg`],
                 })
                }


                 i++;
            }

            $("#slots").empty();

            slots.forEach((slot , i) => {
                var asd = 'C';
                if (i==1){
                    var asd = '%';
                }
                $("#slots").append(`

                     <h4 class="text-capatlize mb-2 font-weight-bold text-white"> Slot ${i + 1}</h4>
                     <p class="text-white"> Minimum: ${slot.min} ${asd} </p>
                     <p class="text-white"> Maximum: ${slot.max} ${asd} </p>
                     <p class="text-white mb-6"> Mean: ${slot.avg} ${asd} </p>
                `)
            })
        }

        var alarms_datatable = $('#alarms_datatable').KTDatatable({
            data: {
                type: 'remote',
                saveState: false,
                source: {
                    read: {
                        url: "{{ route('system.sensorDetailsAlarms' , $sensor_id) }}",
                        method: 'get',
                        params: params
                    },
                }
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
                class: "x",
                icons: {
                    rowDetail: {
                        expand: 'flaticon2-down',
                        collapse: 'flaticon2-right-arrow'
                    }
                }
            },

            pagination: true,
            sortable: false,

            // columns definition
            columns: [{
                width:100,
                field: 'created_at',
                title: 'Time',
                textAlign: 'center',
                template: function (row) {
                    var date = new Date(row.created_at);

                    return date.toLocaleString();
                }
            }, {
                width:100,

                field: 'cause',
                title: 'Cause',
                textAlign: 'center'
            }, {
                width:100,

                field: 'status',
                title: 'Status',
                textAlign: 'center',
                template: function (row) {

                    return `<span class="label font-weight-bold label-lg  label-primary label-inline">
                           ${row.status}</span>
                        `
                }
            }],

        });

        var details_datatable = $('#details_datatable').KTDatatable({
            data: {
                type: 'remote',
                saveState: false,
                source: {
                    read: {
                        url: "{{ route('system.sensorDetailsRules' , ['sensor' => $sensor_id]) }}",
                        method: 'get',
                        params: params,
                        map: function (raw) {

                            parse_slots(raw);

                            if(!Object.keys(raw).length) return [];

                            return raw.rules;
                        },
                    },

                }
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,
                icons: {
                    rowDetail: {
                        expand: 'flaticon2-down',
                        collapse: 'flaticon2-right-arrow'
                    }
                }
            },

            pagination: true,
            sortable: false,

            // columns definition
            columns: [{
                width:100,
                field: 'name',
                title: 'Name',
                textAlign: 'center'
            }, {
                width:100,
                field: 'condition_value',
                title: 'Condition',
                textAlign: 'center',
                template: function (row) {




                    return `<i class="fas mr-4 ${icons[row.condition_name]}"></i>${row.condition_name} ${row.condition_type} threshold ${row.condition_value} ${row.degree_value}`;
                }
            }],

        });
        var table_datatable = $('#table_datatable').KTDatatable({
            data: {
                type: 'remote',
                saveState: false,
                source: {
                    read: {
                        url: "{{ route('system.sensorDetailsMeasurements' , ['sensor' => $sensor_id]) }}",
                        method: 'get',
                        params: params,
                        map: function (raw) {
                            if(!Object.keys(raw).length) return [];

                            return raw.humidity.map((h, i) => {

                                return {
                                    created_at: h.created_at,
                                    humidity: h.value,
                                    temperature: raw.temperature[i].value
                                }
                            })
                        },
                    },

                },
                serverPaging: false,
                serverFiltering: false,
                serverSorting: false

            },

            // layout definition
            layout: {
                scroll: true,
                footer: false,
                icons: {
                    rowDetail: {
                        expand: 'flaticon2-down',
                        collapse: 'flaticon2-right-arrow'
                    }
                }
            },

            pagination: true,
            sortable: false,

            // columns definition
            columns: [{
                    field: 'created_at',
                    width:100,
                    title: 'Time',
                    textAlign: 'center',
                    template: function (row) {
                        var date = new Date(row.created_at);

                        return date.toLocaleString();
                    }

                }, {
                    field: 'temperature',
                    title: `<span  data-toggle="tooltip" data-theme="dark" title="Temperature"><i class="fas ${icons['temperature']}"></i></span>`,
                    textAlign: 'center',
                    template: function (row) {

                        return row.temperature + " C"
                    }
                },
                {
                    field: 'humidity',
                    title: `<span  data-toggle="tooltip" data-theme="dark" title="Humidity"><i class="fas ${icons['humidity']}"></i></span>`,
                    textAlign: 'center',
                    template: function (row) {

                        return row.humidity + "%"
                    }
                }
            ],

        });

        $('#range_picker').on('apply.daterangepicker', function (ev, picker) {

            params = {
                from: picker.startDate.format('YYYY-MM-DD'),
                to: picker.endDate.format('YYYY-MM-DD')
            }
            table_datatable.setDataSourceParam('from',picker.startDate.format('YYYY-MM-DD'));
            details_datatable.setDataSourceParam('from',picker.startDate.format('YYYY-MM-DD'));
            alarms_datatable.setDataSourceParam('from',picker.startDate.format('YYYY-MM-DD'));
            table_datatable.setDataSourceParam('to',picker.endDate.format('YYYY-MM-DD'));
            details_datatable.setDataSourceParam('to',picker.endDate.format('YYYY-MM-DD'));
            alarms_datatable.setDataSourceParam('to',picker.endDate.format('YYYY-MM-DD'));
            alarms_datatable.reload();
            details_datatable.reload();
            table_datatable.reload();


        });
    })

</script>
@endpush
