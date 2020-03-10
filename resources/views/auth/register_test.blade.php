<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Alexis Saettler" />
    <!--
      This file is part of asbiin/laravel-webauthn project.

      @copyright Alexis SAETTLER © 2019
      @license MIT
    -->

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>


<?php
    dd($_GET);
?>

<script>
    console.log({{ json_encode($_GET) }});
</script>

    <script>
        var bufferDecode = function(value) {
            var t = window.atob(value);
            return Uint8Array.from(t, c => c.charCodeAt(0));
        };

        var credentialDecode = function(credentials) {
            return credentials.map(function(data) {
                return {
                    id: bufferDecode(base64Decode(data.id)),
                    type: data.type,
                    transports: data.transports,
                };
            });
        };

        var base64Decode = function(input) {
            // Replace non-url compatible chars with base64 standard chars
            input = input.replace(/-/g, '+').replace(/_/g, '/');

            // Pad out with standard base64 required padding characters
            const pad = input.length % 4;
            if (pad) {
                if (pad === 1) {
                    throw new Error('InvalidLengthError: Input base64url string is the wrong length to determine padding');
                }
                input += new Array(5-pad).join('=');
            }

            return input;
        };

        var publicKey = {
            "rp":
                {
                    "name":"Laravel",
                    "id":"localhost"
                },
            "pubKeyCredParams":
                [
                    {"type":"public-key","alg":-7},
                    {"type":"public-key","alg":-257}
                    ],
            "challenge":"KZC0xn5AVaQoh73MD62lYd8nC8vdyKfiBDLp73uJELg",
            "attestation":"none",
            "user":{"name":"n@naver.com","id":"Ng==","displayName":"n@naver.com"},
            "authenticatorSelection":{
                "requireResidentKey":false,
                "userVerification":"preferred"
            },
            "timeout":60000
        };

        console.log("=== publicKey ====");
        console.log(publicKey);

        let publicKeyCredential = Object.assign({}, publicKey);

        console.log("=== publicKeyCredential ==== Object.assign");
        console.log(publicKeyCredential);

        publicKeyCredential.user.id = bufferDecode(publicKey.user.id);
        publicKeyCredential.challenge = bufferDecode(base64Decode(publicKey.challenge));

        console.log("=== publicKeyCredential ==== user.id challenge");
        console.log(publicKeyCredential);

        if (publicKey.excludeCredentials) {
            publicKeyCredential.excludeCredentials = credentialDecode(publicKey.excludeCredentials);
        }

        console.log("=== publicKeyCredential ==== excludeCredentials");
        console.log(publicKeyCredential);

        var self = this;
        var result;
        navigator.credentials.create({
            publicKey: publicKeyCredential
        }).then(function(res) {
            result = res;
            console.log(result);
        });
        //     .then((data) => {
        //     self._registerCallback(data, callback);
        // }, (error) => {
        //     self._notify(error.name, error.message, false);
        // });
    </script>
</body>