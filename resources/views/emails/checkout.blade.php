@component('mail::message')
# Order Confirmation

Hey {{ $order->customer_name }}, <br>
We've got your order! 

<center>
# ORDER NO. {{ $order->order_no }}
</center>

#### ITEMS ORDERED
@component('mail::table')
| Product                                                   | Size                          | Quantity                     | Price  |
| --------------------------------------------------------- |:-----------------------------:| ----------------------------:| ------:|
@foreach ($order->details as $index=>$item)
| {{ $item->product->name }} - {{ $item->color->name }}      | {{ $item->size->name }}  | {{ $item->quantity }}     | {{ money($item->product->after_discount * $item->quantity) }}      |
@endforeach
|                                                            |                          | **Total**                  | {{ money($order->price) }}                                         | 
@endcomponent

#### BILLING INFO <br>
Name: {{ $order->customer_name }} <br>
Mobile: {{ $order->customer_phone }} <br>
Adress: {{ $order->customer_address }}, Ward {{ $order->ward->name }}, District {{ $order->district->name }}, Province {{ $order->province->name }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
