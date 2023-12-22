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
            <td align="left" valign="center">

                <div style="text-align:left; margin: 0px 20px; padding-bottom: 40px;margin-top: 35px; background-color:#ffffff; border-radius: 6px">
                    <a href="" rel="noopener" target="_blank">
                        <img alt="Logo" style="width: 100%;border-top-right-radius: 6px;border-top-left-radius: 6px" src="https://business.yousiness.com/storage/settings/mail_logo.png" />
                    </a>
                    <!--begin:Email content-->
                    <div style="text-align: center; font-weight: 700; font-size: 18px;padding: 25px">
                        {!! $data['message'] !!}
                    </div>
                    @if(isset($data['code']))
                        <div style="margin-top: 15px; text-align: center">
                            <h1 style="color: #d59c4b; font-size: 2.5rem">{{$data['code']}}</h1>
                        </div>
                    @endif

                    <!--end:Email content-->
                    <div style="padding-bottom: 10px;text-align: center">
                        <br>
                        <br>
                        <h3 style="background: -webkit-linear-gradient(184deg, #ddb06f 0%, #e8c490 21.897%, #e2c08e 77.24%, #ddb06f 100%);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;font-size: 1.9rem">{{config('settings.speed_site_title')}}</h3>
                    </div>
                </div>
            </td>
        <tr>
            <td align="center" valign="center"
                style="font-size: 13px; text-align:center;padding: 20px; color: #6d6e7c;">
                <p>{{config('settings.speed_address')}}</p>
                <p>Copyright © <a href="{{asset('/')}}" rel="noopener" target="_blank">{{config('settings.speed_site_title')}}</a>.</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
