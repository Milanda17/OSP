<!DOCTYPE html>
<html>
<head>
    <title>Reference No:{{$data['ticket_reference_no']}} Reply Email</title>
</head>

<body>
    <h2>Hi, {{$data['name']}}</h2>
    <h3>Question : </h3><h5>{{$data['problem_description']}}</h5>
    <br/>
    <h3>Reply : </h3><<h4>{{$data['reply']}}</h4>
</body>

</html>
