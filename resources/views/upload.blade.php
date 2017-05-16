<html>
    <head>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <h1>upload your file</h1>
    </head>
    <body class="container">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<form   class="form-inline " action="/uploadfile" method="post" onclick="loaddata()" id="form"enctype="multipart/form-data">

    {{ csrf_field() }}

    <div class="form-group">

        <label>Please select a file to upload</label>
        <input type="file" class="form-control"  name="data" id="fileUpload">

    </div>

    <input type="submit"  class="btn btn-default" id="submit" value="submit" name="submit">
</form>
<form action="/export">
    <input type="submit"  class="btn btn-default" id="submit" value="export" name="submit">


</form>
<div class="container">
<table class="table results">
    <thead>
        <tr>
            <th>day</th>
            <th>summary</th>
            <th>table</th>
            <th>data</th>  
              <th>action</th>  
        </tr>
        @foreach($dayes as $day)
        <tr>
            <td>{{$day->day_id}}</td>
            <td>{{$day->summary}}</td>
            <td>{{$day->table}}</td>
            <td>@foreach ((array)json_decode($day->data) as $newval)
                <ul>
                    <li> time:<b>{{\Carbon\Carbon::createFromTimestamp($newval->time)->format('d.m.Y')}}</b></li>
                    <li>summary:{{$newval->summary}}</li>
                    <li>icon:{{$newval->icon}}</li>
                    <li> sunrise Time:<b>{{\Carbon\Carbon::createFromTimestamp($newval->sunriseTime)->format('d.m.Y')}}</b></li>
                    <li>sunset Time:<b>{{\Carbon\Carbon::createFromTimestamp($newval->sunsetTime)->format('d.m.Y')}}</b></li>
                    <li>temperature Min:{{$newval->temperatureMin}}</li>
                    <li> temperature Min Time:<b>{{\Carbon\Carbon::createFromTimestamp($newval->temperatureMinTime)->format('d.m.Y')}}</b></li>
                    <li>temperature Max:{{$newval->temperatureMax}}</li>
                    <li> temperature MaxTime:<b>{{\Carbon\Carbon::createFromTimestamp($newval->temperatureMaxTime)->format('d.m.Y')}}</b></li>

                </ul>
                @endforeach
            </td> 
            <td>
            	 {!! Form::open(['method' => 'DELETE','url' => ['/delete', $day->id],'style'=>'display:inline' ,'class' =>'delete']) !!}
                         {!! Form::submit('Delete', ['class' => 'btn btn-danger' , 'id' =>'delete' , 'data-id' => "$day->id"]) !!}
            {!! Form::close() !!}

            </td>
        </tr>
        @endforeach
    </thead>
    <tbody></tbody>
</table>
</div>
<div class="col-md-6">


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script>



$(function () {
$('#submit').click(function (e) {

$.ajax({
    type: 'POST',
    url: '/uploadfile',
    data: {
        "file":$('#fileUpload').val(),
         "_token": "{{ csrf_token() }}"
    },
    success: function (data) {
   $("body").load('/');
    }
});
e.preventDefault();
});


});

$(function () {
$('#delete').click(function (e) {
e.preventDefault();
 var id = $(this).data("id");
$.ajax({
    type: 'delete',
    url: '/delete/'+id,
    data: $('.delete').serialize(),
    success: function (response , data) {
  if(response === 'true'){
      
    $("body").load('/');
  }
    }
});

});


});
    </script>
    
    </body>
    
</html>