@extends('main')

@section('title')

@section('stylesheets')

@endsection
<style>
    .container{
        font-family: 'Raleway' !important;
    }
    body{
        /*background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAAHCAYAAADEUlfTAAAAQElEQVQIW2P89OvDfwYo+PHjJ4zJwMHBzsAIk0SXAKkCS2KTAEu++vQSbizIKGQAl0SXAJkGlsQmAbcT2Shk+wH0sCzAEOZW1AAAAABJRU5ErkJggg==);*/
    }
    a{
        color: #739931;
    }
    .page{
        max-width: 100em;
        margin: 0 auto;
    }
    table th,
    table td{
        text-align: left;
    }
    table.layout{
        width: 100%;
        border-collapse: collapse;
    }
    table.display{
        margin: 1em 0;
    }
    table.display th,
    table.display td{
        border: 1px solid #B3BFAA;
        padding: .5em 1em;
    }

    table.display th{ background: #D5E0CC; }
    table.display td{ background: #fff; }

    table.responsive-table{
        box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 30em){
        table.responsive-table{
            box-shadow: none;
        }
        table.responsive-table thead{
            display: none;
        }
        table.display th,
        table.display td{
            padding: .5em;
        }

        table.responsive-table td:nth-child(1):before{
            content: 'Number';
        }
        table.responsive-table td:nth-child(2):before{
            content: 'Name';
        }
        table.responsive-table td:nth-child(1),
        table.responsive-table td:nth-child(2){
            padding-left: 25%;
        }
        table.responsive-table td:nth-child(1):before,
        table.responsive-table td:nth-child(2):before{
            position: absolute;
            left: .5em;
            font-weight: bold;
        }

        table.responsive-table tr,
        table.responsive-table td{
            display: block;
        }
        table.responsive-table tr{
            position: relative;
            margin-bottom: 1em;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.2);
        }
        table.responsive-table td{
            border-top: none;
        }
        table.responsive-table td.organisationnumber{
            background: #D5E0CC;
            border-top: 1px solid #B3BFAA;
        }
        table.responsive-table td.actions{
            position: absolute;
            top: 0;
            right: 0;
            border: none;
            background: none;
        }
    }

    .page{
        margin-bottom: 40px;
    }

    .actions{
        text-align: center;
    }

    .status{
        color: red;
    }

    .foodlist{
        min-width: 230px;
        padding: 0px !important;
    }

    .rthead{
        font-size: 15px;
    }
</style>
@section('content')

    <div class="page">
        <h1><i class="fas fa-hamburger"></i> Pending Order</h1>
        <table class="layout display responsive-table">
            <thead class="rthead">
            <tr>
                <th>ID</th>
                <th>User-ID</th>
                <th>Total Meal</th>
                <th>Total Items</th>
                <th>Total Price</th>
                <th>Foods</th>
                <th>Order Time</th>
                <th>Expected Delivery</th>
                <th>Status</th>
                <th>Deliver</th>
            </tr>
            </thead>
            <tbody>

            @foreach($order as $or)
            <tr id="order-{{$or['purchaseID']}}">
                <td class="organisationnumber">{{$or['purchaseID']}}</td>
                <td class="organisationnumber">{{$or['user_id']}}</td>
                <td class="organisationname">{{$or['total_meal']}}</td>
                <td class="organisationname">{{$or['total_items']}}</td>
                <td class="organisationname">$ {{$or['total_price']}}</td>
                <td class="organisationname foodlist">
                    <ul>
                        @foreach($or['items'] as $item)
                            <li>{{$item->name}}  x {{$item->qty}} </li>
                        @endforeach
                    </ul>
                </td>
                <td class="organisationname">{{$or['datetime']}}</td>
                <td class="organisationname">{{$or['waiting']}}</td>
                <td class="organisationname">
                    <b class="status">{{$or['status']}}</b>
                </td>

                <td class="actions">
                    <button type="button" class="btn btn-primary" onclick="deliver({{$or['purchaseID']}})" data-toggle="tooltip" title="Click to confirm">Confirm Deliver</button>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>




@stop

@section('scripts')

<script>


function deliver(id) {

    var con = confirm("Sure to deliver?");
    if (con) {
        //call update API to handle deliver
        $.ajax({
            url: 'admin/purchase/'+ id,
            async: false,
            type: 'GET',
            data: {
                //no form data submit in GET request
            },
            dataType: 'JSON',
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                $("#order-"+id+" .status").html("DONE");
                $("#order-"+id+" .status").css("color","green");

                $("#order-"+id).css("opacity","0.2");
            }
        });

    }
}

</script>

@endsection