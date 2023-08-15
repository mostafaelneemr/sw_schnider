
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report</title>
    <style>
        .root {
            height: 100%;
            width: 100%;
            background-color: #EBECF0;
            display: inline-block;
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }

        .main-container {
            height: 290px;
            width: 800px;
            display: inline-block;
        }

        .logo-container {
            height: 20%;
            width: 100%;
            display: inline-block;
        }

        .right-container {
            height: 5%;
            width: 30%;
            float:right;
            justify-content: right;
            display: inline-block;
        }

        .logo {
            margin-top: 8px;
            float: left;
            height: 100%;
        }

        .content-container {
            height: 82%;
            width: 100%;
            display: inline-flex;
        }

        .transparent {
            display:none
        }

        .info-container {
            height: 100%;
            width: 92%;
        }

        .reactangle-container {
            height: 20%;
            width: calc(100% - 8px);
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
            margin-top: 30px;
            display: block;
        }

        .footer {
            height: calc(10% - 18px);
            font-size: 14px;
            padding: 10px;
            color: darkgray;
        }

        .rectangle2 {
            height: 100%;
            width: 100%;
            display: table;
        }

        .font1 {
            vertical-align: middle;
            float:left;
            font-size: 12px;
            margin-left: 15px;
            margin-top: 15px;
        }

        .font2 {
            opacity: 3.0;
            vertical-align: middle;
            font-size: 12px;
            font-weight: bold;
            color: darkgray;
        }

    </style>
</head>
<body>
<div class="root">
    <div class="main-container">
        <div class="logo-container">
            <div class="logo">
                @if(!empty($site_logo = \App\Models\Setting::where('name','site_logo')->value('value')))
                    <img src="{{ url('public/storage/'.$site_logo)}}" title="{{setting('company_name') }}" alt=" {{setting('company_name') }}" style="height: 100px;width: 100%"/>
                @else
                    <img src="{{ url('public/logo/favicon.ico')}}" title="{{setting('company_name') }}" alt=" {{setting('company_name') }}" style="height: 100px;width: 100%"/>
                @endif
            </div>
        </div>
        <div class="right-container">
            <div class="font2">
                NEW REPORT
            </div>
        </div>

        <div class="content-container">
            <div class="info-container">
                <div class="reactangle-container">
                    <div class="rectangle2">
                        <div class="font1">
                            New report in the attachment.
                        </div>
                    </div>
                </div>
                <div class="footer">
                    You have received this e-mail because your e-mail address is in Our system database. Message has been generated automatically. Please do not answer it.
                    <div class="transparent">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
