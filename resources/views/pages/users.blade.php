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
        padding: 10px 0px 0px 0px !important;
    }
</style>
@section('content')

    <div class="page">
        <h1><i class="fas fa-user-friends"></i> Users</h1>
        <table class="layout display responsive-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
            <tr>
                <td class="organisationnumber">{{$user['id']}}</td>
                <td class="organisationnumber">{{$user['name']}}</td>
                <td class="organisationname">{{$user['email']}}</td>
                <td class="organisationname">{{$user['created_at']}}</td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>



@stop

@section('scripts')

<script>


</script>

@endsection