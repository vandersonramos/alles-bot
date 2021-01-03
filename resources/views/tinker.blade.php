<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BotMan Studio</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >

</head>
<body>
<div class="container">
    <div class="content" id="app">
        <botman-tinker api-endpoint="/botman"></botman-tinker>
    </div>
    <div class="commands">
        <h5>List of available commands </h5>

        <table>
            <thead>
            <tr>
                <th>Command</th>
                <th>Description</th>
                <th>Example</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Hi / Hello / Hey</td>
                <td>To start a conversation</td>
                <td>Hi</td>
            </tr>
            <tr>
                <td>Login</td>
                <td>To log in</td>
                <td>Login</td>
            </tr>
            <tr>
                <td>Logout</td>
                <td>To log out</td>
                <td>Logout</td>
            </tr>
            <tr>
                <td>Register</td>
                <td>To create an account</td>
                <td>Register</td>
            </tr>
            <tr>
                <td>Available currencies</td>
                <td>List all currencies available</td>
                <td>Available currencies</td>
            </tr>
            <tr>
                <td>Convert {valueFrom} {currencyFrom} to {currencyTo} </td>
                <td>Perform currency exchange of any amount of money between two currencies.</td>
                <td>Convert 100 USD to BRL</td>
            </tr>
            <tr>
                <td>My currency is {currency}</td>
                <td>Defines the default currency to be used among transactions</td>
                <td>My currency is BRL</td>
            </tr>
            <tr>
                <td>Deposit {value}</td>
                <td>Performs the deposit action</td>
                <td>Deposit 100 BRL</td>
            </tr>
            <tr>
                <td>Withdraw {value}</td>
                <td>Performs the withdraw action</td>
                <td>Withdraw 100 BRL</td>
            </tr>
            <tr>
                <td>Show account balance</td>
                <td>Show the account balance</td>
                <td>Show account balance</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="/js/app.js"></script>
</body>
</html>
