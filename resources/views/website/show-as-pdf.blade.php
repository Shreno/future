<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'examplefont', sans-serif;
        }
    </style>
    <title>بوليصة شحن</title>
</head>
<body dir="rtl" style="direction: rtl;float: right">
<table>
    <tr>
        <!--<img src="{{asset('storage/'.$webSetting->logo)}}" alt="">-->
    </tr>
</table>
<table style="border-spacing: 15px; direction: rtl;text-align: right">
    <tr>
        <td>
            <table style="border-spacing: 15px">
                <tr>
                    <td>
                        <img src="data:image/png;base64,
{!! base64_encode(QrCode::format('png')->errorCorrection('H')->size(150)->generate($order->order_id)) !!}" />
                    </td>
                </tr>
                <tr style="font-weight: bold">
                    <td>
                        رقم الشحنة: {{ $order->order_id }}</td>
                </tr>
                <tr>
                    <td><span style="font-weight: bold">رقم التتبع:</span>
                        {{ $order->tracking_id }}</td>
                </tr>
                <tr>
                    <td><span style="font-weight: bold">تاريخ الشحنة:</span>
                        {{ $order->created_at->toDateString() }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table style="border-spacing: 30px;border-style: solid">
                <tr>
                    <td style="font-weight: bold">اسم المتجر</td>
                    <td>{{ $order->sender_name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">رقم الجوال</td>
                    <td>{{ $order->sender_phone }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">العنوان</td>
                    <td>{{ $order->sender_address }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">الرقم المرجعى</td>
                    <td>{{ $order->reference_number }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">محتوى الطلب</td>
                    <td>{{ $order->order_contents }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">عدد القطع</td>
                    <td>{{ $order->number_count }}</td>
                </tr>
            </table>
        </td>
        <td>
            <table style="border-spacing: 30px;border-style: solid">
                <tbody>
                <tr>
                    <td style="font-weight: bold">اسم العميل</td>
                    <td>{{ $order->receved_name }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">رقم الجوال</td>
                    <td>{{ $order->receved_phone }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">المدينة</td>
                    <td>{{ $order->recevedCity->title }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">العنوان</td>
                    <td>{{ $order->receved_address }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold">تفاصيل العنوان</td>
                    <td>{{ $order->receved_address_2 }}</td>
                </tr>
                {{--                <tr>--}}
                {{--                    <td>مبلغ الدفع عند الاستلام</td>--}}
                {{--                    <td>{{ $order-> }}</td>--}}
                {{--                </tr>--}}
                </tbody>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
