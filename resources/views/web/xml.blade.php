
<all>
    <measurements type="list">
        @foreach($measurements as $measurement)
           @php
               $from_time = strtotime(date("Y-m-d H:i:s"));
               $to_time = strtotime($measurement->measured_at);
                $diff = round(abs($to_time - $from_time) / 60,2);
                if($diff >= $status_time ){
                    $status = 'offline';
                    $status_code = 0;
                }else{
                    $status = 'online';
                     $status_code = 1;
                }
           @endphp
        <serial_{{$measurement->serial_number}}_item type="dict">
            <serial_{{$measurement->serial_number}}_id type="str">{{$measurement->id}}</serial_{{$measurement->serial_number}}_id>
            <serial_{{$measurement->serial_number}}_serial type="str">{{$measurement->serial_number}}</serial_{{$measurement->serial_number}}_serial>
            <serial_{{$measurement->serial_number}}_status type="boolean">{{$status_code}}</serial_{{$measurement->serial_number}}_status>
            <serial_{{$measurement->serial_number}}_status_time type="int">{{$status_time}}</serial_{{$measurement->serial_number}}_status_time>
            <serial_{{$measurement->serial_number}}_response_handle type="int">{{$measurement->response_handle}}</serial_{{$measurement->serial_number}}_response_handle>
            <serial_{{$measurement->serial_number}}_battery type="str">{{$measurement->battery}}</serial_{{$measurement->serial_number}}_battery>
            <serial_{{$measurement->serial_number}}_signal type="int">{{$measurement->signal}}</serial_{{$measurement->serial_number}}_signal>
            <serial_{{$measurement->serial_number}}_measured_at type="str">{{$measurement->measured_at}}</serial_{{$measurement->serial_number}}_measured_at>
            <serial_{{$measurement->serial_number}}_measurement_interval type="int">{{$measurement->measurement_interval}}</serial_{{$measurement->serial_number}}_measurement_interval>
            <serial_{{$measurement->serial_number}}_next_measurement_at type="str">{{$measurement->next_measured_at}}</serial_{{$measurement->serial_number}}_next_measurement_at>
            <serial_{{$measurement->serial_number}}_params type="list">
                @foreach($measurement->params as $param)
                    @php
                    if($status_code){
    $value = $param->value;
}else{
    $value = $status;
}
                    @endphp
                <item type="dict">
                    <serial_{{$measurement->serial_number}}_channel type="int">{{$param->channel}}</serial_{{$measurement->serial_number}}_channel>
                    <serial_{{$measurement->serial_number}}_type type="str">{{$param->type}}</serial_{{$measurement->serial_number}}_type>
                    <serial_{{$measurement->serial_number}}_{{$param->type}} type="int">{{$value}}</serial_{{$measurement->serial_number}}_{{$param->type}}>
                </item>
                @endforeach
            </serial_{{$measurement->serial_number}}_params>
        </serial_{{$measurement->serial_number}}_item>
@endforeach
    </measurements>
</all>
