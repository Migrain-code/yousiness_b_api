<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-mail</title>
</head>
<body>

<style>html, body {
        padding: 0;
        margin: 0;
    }</style>
<div
        style="font-family:Arial,Helvetica,sans-serif; line-height: 1.5; font-weight: normal; font-size: 15px; color: #2F3044; min-height: 100%; margin:0; padding:0; width:100%; background-color:#edf2f7">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
           style="border-collapse:collapse;margin:0 auto; padding:0; max-width:600px">
        <tbody>
        <tr>
            <td align="center" valign="center" style="text-align:center; padding: 40px">
                <a href="" rel="noopener" target="_blank">
                    <img alt="Logo" style="width: 250px;" src="{{image(setting('bussiness_mail_logo'))}}" />
                </a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="center">
                <div
                        style="text-align:left; margin: 0 20px; padding: 40px; background-color:#ffffff; border-radius: 6px">
                    <!--begin:Email content-->
                    <div style="text-align: center; font-weight: 700; font-size: 18px">
                        {!! $data['message'] !!}
                    </div>
                    @if(isset($data['code']))
                        <div style="margin-top: 15px; text-align: center">
                            <h1 style="color: #d59c4b">{{$data['code']}}</h1>
                        </div>
                    @endif

                    <!--end:Email content-->
                    <div style="padding-bottom: 10px">
                        <br>
                        <br>
                        {{setting('speed_site_title')}}
                    </div>
                </div>
            </td>
        <tr>
            <td align="center" valign="center"
                style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                <p>{{setting('speed_address')}}</p>
                <p>Copyright © <a href="{{asset('/')}}" rel="noopener" target="_blank">{{setting('speed_site_title')}}</a>.</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
