<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Mail</title>
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

                <div style="text-align:center; margin: 0px 20px; padding-bottom: 40px;margin-top: 35px; background-color:#ffffff; border-radius: 6px">
                    <div style="background-color: #1d1d1b;width: 100%;border-top-right-radius: 6px;border-top-left-radius: 6px">
                        <img alt="Logo" style="width: 60%;border-top-right-radius: 6px;border-top-left-radius: 6px" src="https://business.yousiness.com/storage/settings/mail_logo.png" />
                    </div>
                    <!--begin:Email content-->
                    <div style="text-align: left; font-weight: 400; font-size: 15px;padding: 25px">
                        {!! $data['message'] !!}
                    </div>
                    @if(isset($data['code']))
                        <div style="margin-top: 15px; text-align: center">
                            <b style="background-color: #d59c4b;color: white; font-size: 2.5rem;padding: 15px;border-radius: 40px">{{$data['code']}}</b>
                        </div>
                    @endif

                    <!--end:Email content-->

                </div>
            </td>
        <tr>
            <td align="center" valign="center" style="font-size: 15px; text-align:center;padding: 20px; color: #6d6e7c;">
                <p style="padding: 20px;
                    background-color: white;
                    border-radius: 15px;
                    width: 100%;
                    line-height: 25px;
                    font-size: 15px;
                    font-weight: 600;">Die Nutzung der Yousiness Services und unserer Webseite ist Gegenstand unserer AGB und Datenschutzrichtlinien. <br>
                    YOUSINESS GROUP, Maximinstr. 12 – 66763 Dillingen/Saar, www.yousiness.com, info@yousiness.com, +49 6831 960 21 63, USt-IdNr DE323101197
                </p>
                <p>Copyright © <a href="{{asset('/')}}" rel="noopener" target="_blank">{{config('settings.speed_site_title')}}</a>.</p>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
