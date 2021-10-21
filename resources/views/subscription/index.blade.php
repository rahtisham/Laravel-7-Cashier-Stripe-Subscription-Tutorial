<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body id="app-layout"><br>
<a href="subscription/create" class="btn btn-success">Add Subscription</a>
    <div class="container">
        <div class="row">
                     @if(\Session::has('success'))
                    <div class="alert alert-success">
                    <p><b>{{ \Session::get('success') }}</b></p>
                    </div>
                    @endif
            <div class="col-md-12 col-md-offset-0">
                <h2>Subscription Active Data</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Ammont</th>
                            <th>Interval</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($dataActive))
                            @foreach($dataActive->data as $key => $value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value->plan->interval }}</td>
                                    <td>${{ $value->plan->amount/100 }}</td>
                                    <td>{{ date('Y-m-d',$value->current_period_end) }}</td>
                                    <td><a class="btn btn-danger" href="">Cancel Subscription</a> </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>