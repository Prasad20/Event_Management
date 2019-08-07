@extends('log')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<h1> Register </h1>

<form method="POST" action="\event" >
    @csrf


    <input name="uname" placeholder="Full name" type="text">


    <input name="email" placeholder="Email address" type="email">


    <input name="pno" placeholder="Phone number" type="text">



    <input name="pwd" placeholder="Create password" type="password">


    {{--                    <input class="form-control" name="con_pwd" placeholder="Repeat password" type="password">--}}


    <button type="submit"> Create Account  </button>

</form>

<h1> Login </h1>


<form method="Post" action="\login">
    {{csrf_field()}}

    <input type="text" placeholder="Enter Username" name="uname" required>


    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>

</form>














